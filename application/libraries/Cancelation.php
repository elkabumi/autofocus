<?php 

class Cancelation
{
	var $module_id; // module cancel
	var $doc_module_id;
	var $trans_type;
	var $reason;
	var $data_id;
	var $code;
	var $cancelation_id;
	var $loa_cc;
	var $budget_type;
	var $loa_desc;
	var $message;
	var $cancel_trans_type = 127;
	
	function set_module($module)
	{	
		$this->module_id = $module_id;
	}
	function create_code($prefix_code)
	{
		$ci = &get_instance();
		$pre_code = $prefix_code.'.'.$ci->access->branch_code.'.'.date('ym');
		$ci->db->select('cancelation_code',1);
		$ci->db->like('cancelation_code',$pre_code);
		$ci->db->order_by('cancelation_id DESC');
		$query = $ci->db->get('cancelation',1);
		$new_num = 1;
		if ($query->num_rows() > 0)
		{
			$data = $query->row_array();
			$last_code = trim($data['cancelation_code']);
			if(strlen($last_code)>4)
			{
				$max = substr($last_code,-4);
				if(is_numeric($max))
					$new_num = $max + 1;
			}
		}
		$code = $pre_code.'.'.format_zero_padding($new_num,4);
		$this->code = $code;
		return $code;
	}
	
	#MEMBUAT PEMBATALAN
	#-INSERT KE TABEL CANCELATION
	#-KIRIM LOA (JIKA DOKUMEN DISETUJUI)
	#-BUAT JURNAL PEMBALIK (JIKA DOKUMEN DISETUJUI)
	#-HAPUS LOA DOKUMEN (JIKA DOKUMEN BELUM DISETUJUI)
	function create($c_module_id, $cc, $b_type, $amount, $trans_type, $is_approved = 0)
	{
		$ci = &get_instance();
		$ci->load->library('form_validation');
		
		$ci->form_validation->set_rules('i_kode', 'Alasan', 'trim|required'); 
		$ci->form_validation->set_rules('i_deskripsi', 'Alasan', 'trim|required'); 
		$ci->form_validation->set_rules('i_tanggal', 'Tanggal', 'trim|valid_date|sql_date|required'); 
		
		if ($ci->form_validation->run() == FALSE) send_json_validate(); 
		
		$this->data_id = $ci->input->post('data_id');
		$this->reason = $ci->input->post('i_deskripsi');
				
		/* begin transaction */
		#$ci->db->trans_start();
		$query = $ci->db->get_where('cancelation', array('module_id' => $ci->access->module_id, 'cancelation_data_id' => $this->data_id));
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			$ci->db->delete('transactions_sl', 
			array('transaction_data_id' => $row['cancelation_id'], 'transaction_type_id' => $this->cancel_trans_type));
		}
		
		$ci->db->delete('cancelation', 
			array('cancelation_data_id' => $this->data_id, 'module_id' => $ci->access->module_id));
			
		$data['branch_id'] 			= $ci->access->user_state('branch_id');
		$data['cancelation_code']		= $this->code;
		$data['cancelation_reason']		= $this->reason;
		$data['employee_id']			= $ci->access->user_state('employee_id');
		$data['cancelation_data_id']		= $this->data_id;
		$data['module_id']			= $ci->access->module_id;
		$data['cancelation_date'] 		= $ci->input->post('i_tanggal');
		$data['cancelation_data_code']		= $ci->input->post('i_kode');
		$data['cancelation_is_approved']	= $is_approved ? 'f' : 't';
		
		$ci->db->insert('cancelation', $data);
		$id = $ci->db->insert_id();
		$this->cancelation_id = $id;
		
		/* jika dokumen belum diapprove maka tidak prlu mengirim loa */
		$ci->load->library('authority');
		if($is_approved)
		{
		$this->module_id = $c_module_id;
		$this->loa_cc = $cc;
		$this->budget_type = $b_type;
		$this->loa_desc = $data['cancelation_reason'].' '.$this->code;
		$this->amount = $amount;
		
		# set module id secara manual, karena pembuatannya ikut permission AP
		$is_loa = $ci->authority->test($this->module_id, $this->loa_cc, $this->budget_type, $this->loa_desc, $this->amount); 
		if($is_loa) 
		{	
			$this->message = $is_loa;
			send_json_error($is_loa);
			return false;
		}		
		$ci->authority->kill($this->module_id, $this->data_id);
		$ci->authority->blast($this->module_id, $this->data_id, $this->loa_cc, $this->budget_type, $this->loa_desc, $this->amount, 0, FALSE);
		
		$this->create_journal_sl($this->data_id, $data, $trans_type);
		
		}
		else{
			# LOA DOKUMEN LANGSUNG DIHAPUS
			$ci->authority->kill($ci->access->module_id, $this->data_id);
			debug('cancel directly');
		}
		#$ci->db->trans_complete();
		/* end transaction */		
		#return $ci->db->trans_status();
	}
	
	function approve($data_id, $trans_type, $doc_module_id = 0)
	{
		/* update cancel document */
		$ci = &get_instance();
		$status = 0;
		$query = $ci->db->get_where('transaction_types', array('transaction_type_id' => $trans_type));
		if ($query->num_rows() == 0)
		{
			debug('Module dokumen tidak ditemukan.');
			return;
		}
		$row = $query->row_array();
		$this->doc_module_id = $row['module_id'];
		$ci->db->update('cancelation', array('cancelation_is_approved' => 't'), 
			array('module_id' => $this->doc_module_id, 'cancelation_data_id' => $data_id));
		
		$status = $this->create_journal($data_id, $trans_type);
		$ci->load->library('authority');
		$ci->authority->kill($this->doc_module_id, $data_id);
		debug('cancel approved');
		return $status;		
	}
	function reject($data_id, $trans_type, $doc_module_id = 0)
	{
		/* update cancel document */
		/* begin transaction */
		$ci = &get_instance();
		$status = 0;
		$query = $ci->db->get_where('transaction_types', array('transaction_type_id' => $trans_type));
		if ($query->num_rows() == 0)
		{
			debug('Module dokumen tidak ditemukan.');
			return;
		}
		$row = $query->row_array();
		$this->doc_module_id = $row['module_id'];
		//$ci->db->trans_start();
		$ci->db->update('cancelation', array('cancelation_is_approved' => 'f', 'cancelation_is_rejected' => 't'), 
			array('module_id' => $this->doc_module_id, 'cancelation_data_id' => $data_id));
		
		$query = $ci->db->get_where('cancelation', array('module_id' => $this->doc_module_id, 'cancelation_data_id' => $data_id));
		if ($query->num_rows() == 0)
		{
			debug('data cancelation tidak ditemukan[rejected].');
			return;
		}
		$row = $query->row_array();
		$ci->db->delete('transactions_sl', 
			array('transaction_data_id' => $row['cancelation_id'], 'transaction_type_id' => $this->cancel_trans_type));
		debug('cancel rejected');
		return $status;
		/* update module document */	
	}
	
	function create_journal($data_id)
	{
		// buat jurnal pembalik
		
		$ci = &get_instance();
		$ci->load->model('gl_model');
		$query = $ci->db->get_where('cancelation', array('module_id' => $this->doc_module_id, 'cancelation_data_id' => $data_id));
		if ($query->num_rows() == 0)
		{
			debug('data cancelation tidak ditemukan[approved].');
			return;
		}
		$row = $query->row_array();
		$ci->gl_model->commit_journal($row['cancelation_id'], $this->cancel_trans_type);
		/*
		# query dokument cancelation
		$ci->db->select('*',1);
		$ci->db->from('cancelation');
		$ci->db->where('cancelation_data_id', $data_id);
		$ci->db->where('module_id', $this->doc_module_id);	
		$ci->db->order_by('cancelation_id DESC');	
		$query = $ci->db->get();
		if($query->num_rows() == 0)
		{debug("jurnal cancelation gagal created. ". $ci->db->last_query());return FALSE;}
		$row = $query->row_array();
		
		$data1['transaction_description'] 		= $row['cancelation_reason'];
		$data1['transaction_type_id'] 			= $this->cancel_trans_type;
		$data1['transaction_code'] 			= $row['cancelation_code'];
		$data1['transaction_data_id'] 			= $row['cancelation_id'];
		$ci->db->insert('transactions',$data1);
		$id = $ci->db->insert_id();
		
		//journal
		$ci->db->select('c.*',1);
		$ci->db->from('transactions b');
		$ci->db->join('journals c','c.transaction_id = b.transaction_id');
		$ci->db->where('b.transaction_data_id', $data_id);
		$ci->db->where('b.transaction_type_id', $trans_type);
		$ci->db->order_by('c.journal_credit','DESC');
		$ci->db->order_by('c.journal_index','ASC');		
		$query = $ci->db->get();
		
		#debug($ci->db->last_query());
		
		$result = null; 
		$index = 0;
		foreach($query->result_array() as $row)
		{
			$row2['transaction_id'] = $id;
			$debit = $row['journal_debit'];
			$kredit = $row['journal_credit'];
			
			$row2['journal_description'] = $row['journal_description'].":Dibatalkan";
			$row2['journal_debit'] = $kredit;
			$row2['journal_credit'] = $debit;
			$row2['journal_index'] = $index;
			$row2['coa_id'] = $row['coa_id'];
			$row2['cc_id'] = $row['cc_id'];
			$row2['job_id'] = $row['job_id'];
			$row2['branch_id'] = $row['branch_id'];
			$ci->db->insert('journals',$row2);
			$index++;
		}
		if($index == 0)debug('tidak ada jurnal yang dibalik');	
		else debug('jurnal sudah dibalik');	
		return 1;
		*/
	}
	
	# MEMBUAT JURNAL PEMBALIK SEMENTARA SAAT MEMBUAT PEMBATALAN
	
	function create_journal_sl($data_id, $data, $trans_type)
	{
		$ci = &get_instance();
		$data1['transaction_description'] 		= $data['cancelation_reason'];
		$data1['transaction_type_id'] 			= $this->cancel_trans_type;
		$data1['transaction_code'] 			= $data['cancelation_code'];
		$data1['transaction_data_id'] 			= $this->cancelation_id;
		$ci->db->insert('transactions_sl',$data1);
		$id = $ci->db->insert_id();
		
		//journal
		$ci->db->select('c.*',1);
		$ci->db->from('transactions b');
		$ci->db->join('journals c','c.transaction_id = b.transaction_id');
		$ci->db->where('b.transaction_data_id', $data_id);
		$ci->db->where('b.transaction_type_id', $trans_type);
		$ci->db->order_by('c.journal_credit','DESC');
		$ci->db->order_by('c.journal_index','ASC');		
		$query = $ci->db->get();
		
		#debug($ci->db->last_query());
		
		$result = null; 
		$index = 0;
		foreach($query->result_array() as $row)
		{
			$row2['transaction_id'] = $id;
			$debit = $row['journal_debit'];
			$kredit = $row['journal_credit'];
			
			$row2['journal_description'] = $row['journal_description'].":Dibatalkan";
			$row2['journal_debit'] = $kredit;
			$row2['journal_credit'] = $debit;
			$row2['journal_index'] = $index;
			$row2['coa_id'] = $row['coa_id'];
			$row2['cc_id'] = $row['cc_id'];
			$row2['job_id'] = $row['job_id'];
			$row2['branch_id'] = $row['branch_id'];
			$ci->db->insert('journals_sl',$row2);
			$index++;
		}
	}
	function remove_journal($data_id, $trans_type)
	{
		// delete jurnal_sl / sementara
		
		$ci = &get_instance();
		
		/* query dokument cancelation */
		$ci->db->update('cancelation', array('cancelation_is_rejected' => 't'), 
			array('module_id' => $this->doc_module_id, 'cancelation_data_id' => $data_id));
		$ci->db->delete('transactions_sl', 
			array('transaction_data_id' => $data_id, 'transaction_type_id' => $trans_type));
		debug('jurnal sl dihapus : '.$ci->db->last_query());	
		return 2;
	}
	
}

# -- end file -- #
