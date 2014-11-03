<?php

define('J_ADD', 1, TRUE);
define('J_EDIT', 2, TRUE);
define('J_DEL', 4, TRUE);
define('J_PRINT', 8, TRUE);
define('J_GL', 't', TRUE);
define('J_SL', 'f', TRUE);

class Journal
{
	var $title;
	var $data_id;
	var $trans_type_id;
	
	var $listSource;
	var $formSource;
	var $controlTarget;
	var $actionTarget;
	var $counter_id;
	var $print_url;	
	var $print_visible;	
	var $is_readonly;
	var $enable_add;
	function Journal($params = array())
	{	
		$this->data_id = 0;
		$this->counter_id = 0;
		$this->trans_type_id = 0;
		$this->title = '';
		$this->is_readonly = 0;
		$this->listSource = 'journalcrud/journal_loader';
		$this->formSource = 'journalcrud/journal_form';
		$this->controlTarget = 'journalcrud/journal_control';
		$this->actionTarget = 'journalcrud/journal_action';
		$this->print_visible = 1;
		$this->enable_add = 0;
	}
	function set_loader($url = '')
	{	
		$this->listSource = $url;
	}
	function set_title($title = '')
	{	
		$this->title = $title;
	}
	
	function set_action_target($url = '')
	{	
		$this->actionTarget = $url;
	}
	
	function set_data_id($id)
	{	
		$this->data_id = $id;
	}
	
	function set_transacsion_type($id)
	{	
		$this->trans_type_id = $id;
	}
	
	function set_params($data_id, $trans_type_id, $title = '')
	{	
		$this->data_id = $data_id;
		$this->trans_type_id = $trans_type_id;
		$this->title = $title;
	}
	
	function show2()
	{
		$ci = & get_instance();
		$ci->load->model('global_model');
		$data_journal = $ci->global_model->journal_loader($this->data_id,$ci->trans_type_id);
		if($data_journal)
		{
			$data['data_journal'] = $data_journal;
			$ci->render->add_view('common/journal',$data);
			$ci->render->build($this->title);
		}			
	}
	
	function generate($is_gl = 0)
	{
		$ci = & get_instance();
		$ci->load->model('global_model');
		if($is_gl == J_GL)
			$trans = $ci->global_model->get_transaction_id($this->data_id,$this->trans_type_id, 1);
		else $trans = $ci->global_model->get_transaction_id($this->data_id,$this->trans_type_id);
		if($trans)
		{
			$id = $trans['transaction_id'];
			$data['transaction_id'] = $id;
			$data['transaction_code'] = $trans['transaction_code'];
			$data['transaction_date'] = $trans['transaction_date'];
			$data['data_id'] = $this->data_id;
			$data['module_id'] = $ci->access->module_id;
			$data['listSource'] = $this->listSource . '/' . $id;
			$data['formSource'] = $this->formSource . '/' . $id;
			$data['controlTarget'] = $this->controlTarget;
			$data['actionTarget'] = $this->actionTarget . '/' . $id;
			$data['print_url'] = $this->print_url ? $this->print_url . '/' . $id : '';
			if($this->print_url)$data['print_url'] = $this->print_url . '/' . $id;
			else
			{
				if($this->print_visible)$data['print_url'] = 'gl/print_jurnal_sl/' . $id;
				else $data['print_url'] = '';
			}
			$this->print_url='';
			$data['readonly'] = $this->is_readonly;
			$data['enable_add'] = $this->enable_add;
			$data['counter_id'] = $this->counter_id++;
			$data['is_gl'] = 1;
			$ci->render->add_view('common/journal_view2',$data);
			$ci->render->build($this->title);
		}			
	}
	function show($readonly = 0)
	{
		$ci = & get_instance();
		$ci->load->model('global_model');
		$trans = $ci->global_model->get_transaction_id($this->data_id,$this->trans_type_id);
		if($trans)
		{
			if($readonly)$this->is_readonly = $readonly;
			$id = $trans['transaction_id'];
			$data['transaction_id'] = $id;
			$data['transaction_code'] = $trans['transaction_code'];
			$data['transaction_date'] = $trans['transaction_date'];
			$data['data_id'] = $this->data_id;
			$data['module_id'] = $ci->access->module_id;
			$data['listSource'] = $this->listSource . '/' . $id;
			$data['formSource'] = $this->formSource . '/' . $id;
			$data['controlTarget'] = $this->controlTarget;
			$data['actionTarget'] = $this->actionTarget . '/' . $id;
			$data['print_url'] = $this->print_url ? $this->print_url . '/' . $id : '';
			if($this->print_url)$data['print_url'] = $this->print_url . '/' . $id;
			else
			{
				if($this->print_visible)$data['print_url'] = 'gl/print_jurnal_sl/' . $id;
				else $data['print_url'] = '';
			}
			$this->print_url='';
			$data['readonly'] = $this->is_readonly;
			$data['enable_add'] = $this->enable_add;
			$data['counter_id'] = $this->counter_id++;
			$data['is_gl'] = 1;
			$ci->render->add_view('common/journal_view',$data);
			$ci->render->build($this->title);
		}			
	}
	function show_gl($readonly = 0)
	{
		$ci = & get_instance();
		$ci->load->model('global_model');
		$trans = $ci->global_model->get_transaction_id($this->data_id,$this->trans_type_id, 1);
		if($trans)
		{
			if($readonly)$this->is_readonly = $readonly;
			$id = $trans['transaction_id'];
			$data['transaction_id'] = $id;
			$data['transaction_code'] = $trans['transaction_code'];
			$data['transaction_date'] = $trans['transaction_date'];
			$data['data_id'] = $this->data_id;
			$data['module_id'] = $ci->access->module_id;
			$data['listSource'] = 'journalcrud/journal_loader_gl' . '/' . $id;
			$data['formSource'] = $this->formSource . '/' . $id;
			$data['controlTarget'] = $this->controlTarget;
			$data['actionTarget'] = 'journalcrud/journal_gl_action' . '/' . $id;
			//$data['print_url'] = $this->print_url ? $this->print_url . '/' . $id : '';
			if($this->print_url)$data['print_url'] = $this->print_url . '/' . $id;
			else
			{
				if($this->print_visible)$data['print_url'] = 'gl/print_jurnal/' . $id.'/1';
				else $data['print_url'] = '';
			}
			$this->print_url='';
			$data['readonly'] = $this->is_readonly;
			$data['enable_add'] = $this->enable_add;
			$data['counter_id'] = $this->counter_id++;
			$data['is_gl'] = 1;
			$ci->render->add_view('common/journal_view',$data);
			$ci->render->build($this->title);
		}			
	}
	function set_params_cancel($data_id, $trans_type, $title = '')
	{
		$ci = & get_instance();
		$ci->db->select('cancelation_id');
		$ci->db->from('cancelation c');
		$ci->db->join('transaction_types t', 'c.module_id = t.module_id');
		$ci->db->where('t.transaction_type_id', $trans_type);
		$ci->db->where('c.cancelation_data_id', $data_id);
		$query = $ci->db->get();
		debug('cancel jurnal : '.$ci->db->last_query());
		if($query->num_rows() > 0)
		{
			$row = $query->row_array();
			//$this->show($row['cancelation_id'], 127); //cancelation
			$this->data_id = $row['cancelation_id'];
			$this->trans_type_id = 127;
			$this->title = $title;
		}
	}
	function update($is_gl = 0)
	{	
		$ci = & get_instance();
		$id 		= $ci->input->post('i_transaction_id');
		$data_id 	= $ci->input->post('i_data_id');
		$module_id 	= $ci->input->post('i_module_id');
		$ci->access->set_module_id($module_id);
		
		$ci->load->library('form_validation');		
		 
		$ci->form_validation->set_rules('transient_account[]', 'Account', 'trim|required'); 
		$ci->form_validation->set_rules('transient_market[]', 'Pasar', 'trim|required'); 
		//$ci->form_validation->set_rules('transient_cc[]', 'Cost Center', 'trim|required');
		//$ci->form_validation->set_rules('transient_job[]', 'Job', 'trim|required'); 
		$ci->form_validation->set_rules('transient_desc[]', 'Keterangan', 'trim'); 
		$ci->form_validation->set_rules('transient_debit[]', 'Debit', 'trim|numeric|required'); 
		$ci->form_validation->set_rules('transient_kredit[]', 'Kredit', 'trim|numeric|required');		
		// cek data berdasarkan kriteria
		if ($ci->form_validation->run() == FALSE) send_json_validate();
		
		
		// nilai post yang kirim adalah array karena terdiri dari banyak row. perhatikan tanpa[].
		$list_coa_id 	=$ci->input->post('transient_account');
		//$list_cc_id 	=$ci->input->post('transient_cc');
		//$list_job_id	=$ci->input->post('transient_job');
		$list_debit 	=$ci->input->post('transient_debit');
		$list_kredit 	=$ci->input->post('transient_kredit');
		$list_desc 	=$ci->input->post('transient_desc');
		$list_market 	=$ci->input->post('transient_market');
		// ubah input array ke data
		$data = array();
		$sum_kredit 	= 0;
		$sum_debit 	= 0;
		foreach($list_coa_id as $key => $value)
		{
			$data[] = array(
				'coa_id'  => $list_coa_id[$key],
				'market_id'  => $list_market[$key],
				//'cc_id'  => $list_cc_id[$key],
				//'job_id'  => $list_job_id[$key],
				'journal_description' => $list_desc[$key],
				'journal_debit' => $list_debit[$key],
				'journal_credit' => $list_kredit[$key]
			);
			$sum_kredit += $list_kredit[$key];
			$sum_debit += $list_debit[$key];
		}//send_json_action(true, "Jurnal telah direvisi2", "Jurnal gagal disimpan");
		//echo count($list_coa_id);exit;
		if($sum_kredit != $sum_debit) send_json_error('Jumlah debit harus sama dengan jumlah kredit');
		$ci->load->model('global_model');
		$error =$ci->global_model->update_journal($id, $data, $data_id, $is_gl);
		send_json_action($error, "Jurnal telah direvisi", "Jurnal gagal disimpan");
		
	}// end of function 
	function set_print_url($url)
	{
		$this->print_url = $url;
	}
	function set_print_visible($status)
	{
		$this->print_visible = $status;
	}
	function set_enable_add($status)
	{
		$this->enable_add = $status;
	}
	function get($transaction_id=0)
	{
		if($transaction_id == 0)send_json(make_datatables_list(null)); 
		$ci = & get_instance();
		$ci->load->model('gl_model');	
		$data = $ci->gl_model->transient_loader_sl($transaction_id);
		foreach($data as $key => $value) 
		{	
			$debit = $value['journal_debit']==0?'':tool_money_format($value['journal_debit']);
			$credit = $value['journal_credit']==0?'':tool_money_format($value['journal_credit']);
			
			$data[$key] = array(
				form_transient_pair('transient_account', $value['coa_hierarchy'], $value['coa_id'],null,$value['coa_name']), 
				form_transient_pair('transient_cc', $value['cc_hierarchy'], $value['cc_id'], null, $value['cc_name']),
				form_transient_pair('transient_job', $value['job_code'], $value['job_id'], null, $value['job_name']), 
				form_transient_pair('transient_desc',$value['journal_description']),
				form_transient_pair('transient_debit', $debit, $value['journal_debit']), 
				form_transient_pair('transient_kredit', $credit, $value['journal_credit'])
			);
		}
		
		send_json(make_datatables_list($data)); 
	}
}

# -- end file -- #
