<?php

class Gl_model extends CI_Model 
{

	//var $branch_id;
	var $message;
	var $module_id = 300;
	function Gl_model()
	{
	
		//parent::Model();
		//$this->branch_id = $this->access->user_state('branch_id');
	
	}// end of function 

	function _gl_renderer($data)
	{
		$data['transaction_date'] = format_epoch($data['transaction_date']);
		return format_html($data);
		
	}// end of function 
	
	function get_trans_type($showall=1)
	{
		$this->db->select('transaction_type_id,transaction_type_name');
		$this->db->where('transaction_type_id = 100' );
		$this->db->order_by('transaction_type_id desc');	

		$query = $this->db->get('transaction_types');	
				//query();	
		$data = array();
		foreach($query->result_array() as $row)
		{
			$data[$row['transaction_type_id']] = $row['transaction_type_name'];
		}
		return $data;
	}
	
	function get_city($showall=1)
	{
		$this->db->select('city_id, city_name');
		$this->db->order_by('city_name');	
		$query = $this->db->get('cities');	
				//query();	
		$data = array();
		foreach($query->result_array() as $row)
		{
			$data[$row['city_name']] = $row['city_name'];
		}
		return $data;
	}
	
	function gl_list_controller()
	{
		$where 		= '';
		$params 	= get_datatables_control();
		$limit 		= $params['limit'];
		$offset 	= $params['offset'];
		$category 	= $params['category'];
		$keyword 	= $params['keyword'];
	
		$columns['code']		= 'transaction_code';
		$columns['name']		= 'transaction_description';
		$columns['period']		= 'transaction_date';
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'transaction_id';
		$order_by_column[] = 'k.period_id';
		$order_by_column[] = 't.transaction_date';
		$order_by_column[] = 'transaction_code';
		$order_by_column[] = 'transaction_type_name';
		$order_by_column[] = 'transaction_description';
		$order_by_column[] = 'debit';
		$order_by_column[] = 'kredit';
		$order_by_column[] = 'transaction_is_approved';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;

	
		if(array_key_exists($category,$columns) && strlen($keyword)>0)
		{		
			$this->db->start_cache();
			if($columns[$category] == 'transaction_date')
			{
				$key = explode("/", $keyword);
				if(count($key) > 1)
				{
				$bulan = $key[0];
				$tahun = $key[1];
				$where = "period_month = ".$bulan." and period_year = ".$tahun;
				
				
				$this->db->where($where);
				}
			
			} else {
				$this->db->like($columns[$category],$keyword);
				$this->db->stop_cache();
			}
				/*$split_date 			= explode("/", $keyword);
				if(count($split_date) > 1)
				{
					$bulan				= $split_date[0];
					$tahun				= $split_date[1];
					$bulan = (intval($bulan) > 9) ? intval($bulan) : '0'.intval($bulan);
					$keyword = "$bulan/$tahun";
					$this->db->where("to_char(transaction_date,'MM/YYYY')='$keyword'");
				}
			}
			else
				$this->db->like($columns[$category],$keyword);
				$this->db->stop_cache();*/	
		}
	
		$this->db->select('count(DISTINCT(t.transaction_id)) AS total',1);
		$this->db->from('transactions_sl t');
		$this->db->join('journals_sl j', 'j.transaction_id = t.transaction_id','left');
		$this->db->join('periods k', 'k.period_id = t.period_id','left');
		$this->db->where('transaction_type_id = 100');
		$query 	= $this->db->get();
		
		$row 	= $query->row_array();
		$total 	= $row['total'];
		
		$this->db->select('
			t.transaction_id,
			t.transaction_code,
			m.transaction_type_name,
			t.transaction_date,
			t.transaction_description,
			k.period_id,
			k.period_month,
			k.period_year, 
			transaction_is_approved,
			sum(j.journal_debit) as debit, 
			sum(j.journal_credit) as kredit', 1);
		$this->db->select('UNIX_TIMESTAMP(t.transaction_date) AS transaction_date', 1); 
		$this->db->from('transactions_sl t');
		$this->db->join('journals_sl j', 'j.transaction_id = t.transaction_id','left');
		$this->db->join('periods k', 'k.period_id = t.period_id','left');
		$this->db->join('transaction_types m', 'm.transaction_type_id = t.transaction_type_id');
		$this->db->where('t.transaction_type_id = 100');
		$this->db->order_by($order_by);
		$this->db->group_by('
			t.transaction_id,
			t.transaction_code,
			m.transaction_type_name,
			t.transaction_date,
			t.transaction_description,
			k.period_month,
			k.period_year,k.period_id,transaction_is_approved');
		$this->db->limit($limit, $offset);
		//$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		//query();
		$data = array(); 
		
		$tempGroup = '';
		foreach($query->result_array() as $row)
		{
			$kode = $row['transaction_id'];
			$periode = $row['period_month']."/".$row['period_year'];
			$row = $this->_gl_renderer($row);
			$data[]	= array(
			
				$kode,
				$periode,
				$row['transaction_date'],
				$row['transaction_code'],
				$row['transaction_type_name'],
				$row['transaction_description'],
				$row['debit'],
				$row['kredit'],
			);
			
		}// end foreach
		
		return make_datatables_control($params, $data, $total,array(5,6));
	}// end function 
	
	function gl_read_id($id)
	{		
		$this->db->select('t.*,tt.module_id,sum(journal_debit) as journal_debit,sum(journal_credit) as journal_credit', 1); // ambil seluruh data
		$this->db->select('UNIX_TIMESTAMP(transaction_date) AS transaction_date', 1); 
		$this->db->from('transactions_sl t');
		$this->db->join('transaction_types tt', 'tt.transaction_type_id = t.transaction_type_id');
		$this->db->join('journals_sl u', 'u.transaction_id = t.transaction_id');
		$this->db->where('t.transaction_id', $id);
		$query = $this->db->get(); // parameter limit harus 1
		//query($query);
		$result = null; //echo $this->db->last_query();exit;
		foreach($query->result_array() as $row)	$result = $this->_gl_renderer($row);
		return $result; 
	}// end of function 
	
	function transient_loader($transaction_id)
	{		
		// buat array kosong
		$result = array(); 
		
		$this->db->select('a.*, c.coa_hierarchy,c.coa_name,b.market_id,b.market_code,b.market_name', 1); // ambil seluruh data
		//$this->db->select('case when (journal_debit>0) then 1 else 0 end as debit_asc', false);
		// konversikan seluruh DATE ke EPOCH, agar bisa digunakan oleh seluruh fungsi tanggal PHP
		$this->db->from('journals_sl a');
		$this->db->join('coas c', 'a.coa_id = c.coa_id');	// join table untuk mengambil tipe buku	
		$this->db->join('markets b', 'a.market_id = b.market_id');
		//$this->db->join('jobs j', 'a.job_id = j.job_id');
		//$this->db->order_by('debit_asc DESC');
		$this->db->order_by('a.journal_index ASC'); // urutkan data dari yang terbaru
		
		$this->db->where('transaction_id', $transaction_id); // where trial_book_warehouse_id = $warehouse_id
		//$this->db->where('a.branch_id', $this->branch_id); // pastikan data dari branch id saat ini
		
		$query = $this->db->get(); // karena menggunakan from, maka get tidak diberi parameter
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row); // render dulu dunk!
		}
		return $result;
	}
	
	function sum_item($transaction_id)
	{		
		// buat array kosong
		$result = array(); 
		
		$this->db->select('sum(a.journal_debit) as debit,sum(a.journal_credit) as credit', 1); // ambil seluruh data
		
		// konversikan seluruh DATE ke EPOCH, agar bisa digunakan oleh seluruh fungsi tanggal PHP
		$this->db->from('journals_sl a');
		$this->db->where('transaction_id', $transaction_id); // where trial_book_warehouse_id = $warehouse_id
		//$this->db->where('branch_id', $this->branch_id); // pastikan data dari branch id saat ini
		
		$query = $this->db->get(); // karena menggunakan from, maka get tidak diberi parameter
		$data = array('debit' => 0, 'credit' => 0);
		if($query->num_rows > 0)
		{
			$row = $query->row_array();
			$data['debit'] = format_money($row['debit']);
			$data['credit'] = format_money($row['credit']);
		}
		return $data;
	}
	
	var $insert_id = NULL;
	
	function create_transaction($data, $items, $sum_kredit, $gl_code)
	{
	
		$this->db->trans_start();
		
		/*$this->load->library('authority');
		$this->authority->set($this->access->module_id, $data['transaction_description'], $sum_kredit, $data['transaction_date'],$data['period_id']);
		if($this->authority->is_error())
		{
			$this->message = $this->authority->error_message;
			return FALSE;
		}
		*/
		$this->db->insert('transactions_sl', $data);
		$id = $this->db->insert_id();
		$this->insert_id = $id;
		
		//$this->db->update('transactions_sl', array('transaction_data_id' => $id), array('transaction_id' => $id));
		//$this->db->update('gl_code', array('value' => $gl_code));	

		$index = 0;
		foreach($items as $row)
		{			
			$row['transaction_id'] = $id;
			//$row['branch_id'] = $this->branch_id;
			$row['journal_index'] = $index;
			$this->db->insert('journals_sl', $row); 
			$index++;
		}
		//$this->authority->kill($id);
		//$this->authority->blast($id);
		$this->access->log_insert($id, 'Jurnal umum');
		$this->db->trans_complete();
		
		return $this->db->trans_status();
		
	}// end of function 
	/*
	function copy_transaction($data, $items, $sum_kredit)
	{
		$this->db->trans_start();
		$this->db->insert('transactions', $data);
		$id = $this->db->insert_id();
		$this->insert_id = $id;
		
		$this->db->update('transactions', array('transaction_data_id' => $id), array('transaction_id' => $id));
		$index = 0;
		foreach($items as $row)
		{			
			$row['transaction_id'] = $id;
			//$row['branch_id'] = $this->branch_id;
			$row['journal_index'] = $index;
			$this->db->insert('journals', $row); 
			$index++;
		}
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	*/
	
	function create_code_prefix()
	{
	
		$this->db->select('em.employee_initial', 1);		
		$this->db->from('users u');
		$this->db->join('employees em', 'em.employee_id = u.employee_id');		
		$this->db->where('u.user_id', $this->access->user_id);
		
		$query = $this->db->get();
		$data = $query->row_array();
		$user_initial = $data['employee_initial'];
		return $user_initial;
		
	}
	
	function get_announcer()
	{		
		$this->db->select('*', 1);
		$this->db->select('UNIX_TIMESTAMP(closing_date) AS closing_date', 1); 
		$query = $this->db->get('announcements', 1); // parameter limit harus 1
		$result = null; 
		foreach($query->result_array() as $row)	
		{
		$result = $row;
		$result['closing_date'] = format_epoch($result['closing_date']);
		}
		return $result; 
	}// end of function 
	
	function period_list($param) {
	
		// map parameter ke variable biasa agar mudah digunakan
		$limit = $param['limit'];
		$offset = $param['offset'];
		$category = $param['category'];
		$keyword = $param['keyword'];
		
		// map value dari combobox ke table
		// daftar kolom yang valid
		$columns['m'] = 'period_month';
		$columns['y'] = 'period_year';
		$columns['d'] = 'period_desc';
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'period_month DESC';
		$order_by_column[] = 'period_year DESC';
		$order_by_column[] = 'period_desc DESC';
		$order_by_column[] = 'period_closed DESC';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		// check apakah parameter search dari client valid, bila tidak anggap ambil semua data
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			// daftarkan kriteria search ke seluruh query
			$this->db->start_cache();
			if (($category == 'm') || ($category == 'y')) {
				if (empty($keyword) || !is_int($keyword)) $keyword = '0'; else
				$this->db->where($columns[$category], $keyword);
			} else {
				$this->db->like($columns[$category], $keyword);
			}
			$this->db->stop_cache();
			// bila query Anda tidak menggunakan ini, hapus dengan $this->db->flush_cache();
		}
		
		$this->db->start_cache();
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get(); 

		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];		
		
		// proses query sesuai dengan parameter
				
		// konversikan seluruh DATE ke EPOCH, agar bisa digunakan oleh seluruh fungsi tanggal PHP				
		$this->db->order_by($order_by ? $order_by : 'period_month DESC, period_year_DESC');
		
		// bila menggunakan paging gunakan limiter dan offseter
		if ($limit > 0) $this->db->limit($limit, $offset);
		$query = $this->db->get('periods');
		
#		debug($this->db->last_query());
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			foreach($row as $key => $value) $row[$key] = safe_html($value);
			
			$data[] = array(
				$row['period_month'],
				$row['period_year'],
				$row['period_description'],
				$row['period_closed'] == 'f' || !$row['period_closed'] ? '---' : 'TUTUP'
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total, array(2));
	}
	
	function update_announcer($data)
	{		
		$this->db->trans_start();
		$this->db->delete('announcements', array('announce_id'=>1));
		$data['announce_id']=1;			
		if($data['aktif'])
		{
			$this->access->log_update(1, 'Closing Announcement');
		}
		else
		{
			$this->access->log_delete(1, 'Delete Closing Announcement');	
		}
		unset($data['aktif']);
		$this->db->insert('announcements', $data);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 
	
	function commit_journal_old($data_id, $trans_type)
	{
		//$query = $this->db->get_where('transactions_sl', array('transaction_data_id' => $data_id,'transaction_type_id' => $trans_type), 1);
		$this->db->where('transaction_data_id', $data_id);
		$this->db->where('transaction_type_id', $trans_type);
		$this->db->order_by('transaction_id desc');
		$query   = $this->db->get('transactions_sl');
		
		if ($query->num_rows() == 0)return false;
		
		$row = $query->row_array();	
		$id_sl = $row['transaction_id'];
		unset($row['transaction_id']);
		$row['transaction_is_approved'] = 't';
		//remove
		$this->db->delete('transactions_sl', array('transaction_data_id' => $data_id,'transaction_type_id' => $trans_type));
		
		$this->db->insert('transactions_sl', $row);
		$id = $this->db->insert_id();
		
		$query2 = $this->db->get_where('journals_sl', array('transaction_id' => $id_sl));
		foreach($query2->result_array() as $row2)
		{
			$row2['transaction_id'] = $id;
			unset($row2['journal_id']);
			$this->db->insert('journals_sl', $row2);
		}
	}
	
	function commit_journal($data_id, $trans_type)
	{
		//$query = $this->db->get_where('transactions_sl', array('transaction_data_id' => $data_id,'transaction_type_id' => $trans_type), 1);
		
		$this->db->where('transaction_data_id', $data_id);
		$this->db->where('transaction_type_id', $trans_type);
		$this->db->order_by('transaction_id desc');
		$query   = $this->db->get('transactions_sl');
		//query($query);
		
		if ($query->num_rows() == 0)return false;
		
		$row = $query->row_array();	
		$id_sl = $row['transaction_id'];
	//	unset($row['transaction_id']);
		$row['transaction_is_approved'] = 't';
		
		$this->db->where('transaction_id', $id_sl);
		$data_approve['transaction_is_approved'] = 't';
		$this->db->update('transactions_sl', $data_approve);
		//remove
		//$this->db->delete('transactions_sl', array('transaction_data_id' => $data_id,'transaction_type_id' => $trans_type));
		
		$query3 = $this->db->insert('transactions', $row);
		//query($qury3);
		//$id = $this->db->insert_id();
		
		$query2 = $this->db->get_where('journals_sl', array('transaction_id' => $id_sl));
		//query($query2);
		foreach($query2->result_array() as $row2)
		{
			//$row2['transaction_id'] = $id;
			//unset($row2['journal_id']);
			$this->db->insert('journals', $row2);
		}
	}
	
	function transient_loader_sl($transaction_id)
	{		
		// buat array kosong
		$result = array(); 
		
		$this->db->select('a.*, c.coa_hierarchy,c.coa_name,b.market_id,b.market_code,b.market_name', 1); // ambil seluruh data
		//$this->db->select('case when (journal_debit>0) then 1 else 0 end as debit_asc', false);
		
		// konversikan seluruh DATE ke EPOCH, agar bisa digunakan oleh seluruh fungsi tanggal PHP
		$this->db->from('journals_sl a');
		$this->db->join('coas c', 'a.coa_id = c.coa_id');	// join table untuk mengambil tipe buku	
		$this->db->join('markets b', 'a.market_id = b.market_id');
		//$this->db->join('jobs j', 'a.job_id = j.job_id');
		//$this->db->order_by('debit_asc DESC');
		$this->db->order_by('a.journal_debit DESC'); // urutkan data dari yang terbaru
		
		$this->db->where('transaction_id', $transaction_id); // where trial_book_warehouse_id = $warehouse_id
		//$this->db->where('a.branch_id', $this->branch_id); // pastikan data dari branch id saat ini
		
		$query = $this->db->get(); // karena menggunakan from, maka get tidak diberi parameter
		
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row); // render dulu dunk!
		}
		return $result;
	}
	
	function transient_loader_sl_not_approved($transaction_id)
	{		
		// buat array kosong
		$result = array(); 
		
		$this->db->select('a.*, c.coa_hierarchy,c.coa_name,b.market_id,b.market_code,b.market_name', 1); // ambil seluruh data
		//$this->db->select('case when (journal_debit>0) then 1 else 0 end as debit_asc', false);
		
		// konversikan seluruh DATE ke EPOCH, agar bisa digunakan oleh seluruh fungsi tanggal PHP
		$this->db->from('journals_tmp a');
		$this->db->join('coas c', 'a.coa_id = c.coa_id');	// join table untuk mengambil tipe buku	
		$this->db->join('markets b', 'a.market_id = b.market_id');
		//$this->db->join('jobs j', 'a.job_id = j.job_id');
		//$this->db->order_by('debit_asc DESC');
		$this->db->order_by('a.journal_debit DESC'); // urutkan data dari yang terbaru
		
		$this->db->where('transaction_id', $transaction_id); // where trial_book_warehouse_id = $warehouse_id
		//$this->db->where('a.branch_id', $this->branch_id); // pastikan data dari branch id saat ini
		
		$query = $this->db->get(); // karena menggunakan from, maka get tidak diberi parameter
		
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row); // render dulu dunk!
		}
		return $result;
	}
	
	function update_transaction($id, $data, $items, $sum_kredit)
	{
		
		$this->db->trans_start();
		
		$this->load->library('authority');
		$this->authority->set($this->access->module_id, $data['transaction_description'], $sum_kredit, $data['transaction_date'],$data['period_id']);
		if($this->authority->is_error())
		{
			$this->message = $this->authority->error_message;
			return FALSE;
		}
		//Insert to parent
		$this->db->where('transaction_id', $id);
		$this->db->delete('journals_sl');
		
		$this->db->where('transaction_id', $id);
		$this->db->update('transactions_sl', $data);
		

		//Insert items
		$index = 0;
		foreach($items as $row)
		{			
			$row['transaction_id'] = $id;
			//$row['branch_id'] = $this->branch_id;
			$row['journal_index'] = $index;
			$this->db->insert('journals_sl', $row); 
			$index++;
		}
		$this->authority->kill($id);
		$this->authority->blast($id);
		$this->access->log_update($id, 'Jurnal umum');
		$this->db->trans_complete();		
		return $this->db->trans_status();
		
	}// end of function function
	 
	function delete($id)
	{		
		$this->db->trans_start();
		//Hapus data approval voter
		$approval_voter = $this->get_approval_voters($id);
		$this->db->where('approval_id', $approval_voter); // data yg mana yang akan di hapus
		$this->db->delete('approval_voters');
		//Hapus data approval
		$this->db->where('approval_data_id', $id); // data yg mana yang akan di hapus
		$this->db->delete('approvals');
		//hapus data jurnal
		$this->db->where('transaction_id', $id); // data yg mana yang akan di hapus
		$this->db->delete('journals_sl');
		//hapus data transaksi
		$this->db->where('transaction_id', $id); // data yg mana yang akan di happus
		$this->db->delete('transactions_sl');
		
		$this->access->log_delete($id, 'Jurnal umum');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}	
	
	function get_approval_voters($id){
		$this->db->select('*', 1);
		$this->db->where('approval_data_id', $id);		
		$query = $this->db->get('approvals');
		
		$result = null;
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result['approval_id'];
	}
	
	function approve($data_id, $trans)
	{
		$this->db->trans_start();
		
		$this->db->where('transaction_id', $data_id);
		$this->db->update('transactions_sl', array('transaction_is_approved' => 't'));
		
		//copykan ke transcations dan journals 
		$ci = get_instance();
		$ci->gl_model->commit_journal($data_id, '1');
		$this->db->trans_complete();
		return $this->db->trans_status();
		
		
		
		/*$this->db->trans_start();
		
		$this->db->where('ap_id', $data_id);
		$this->db->update('account_payables', array('ap_is_approved' => 't'));
		//simpan ke jurnal
		$ci = get_instance();
		$ci->load->model('gl_model');
		$ci->gl_model->commit_journal($data_id, $this->trans_type);
		
		$this->db->trans_complete();
		return $this->db->trans_status();*/
	}
	
	function lihat_gl()
	{
		$result = array(); 
		
		$this->db->select('a.*'); // ambil seluruh dat
		$this->db->order_by('transaction_id desc');
		$query   = $this->db->get('transactions_sl');
		
	
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row); // render dulu dunk!
		}
		//$result = $query->result_array();
		return $result;
	}
	
	function create_gl($transaction_desc, $sum_kredit, $transaction_date, $period_id){
		$this->db->trans_start();
		
		$this->load->library('authority');
		$this->authority->set($this->access->module_id, $transaction_desc, $sum_kredit, $data['transaction_date'],$data['period_id']);
		if($this->authority->is_error())
		{
			$this->message = $this->authority->error_message;
			return FALSE;
		}
		
		$this->authority->kill($id);
		$this->authority->blast($id);
		
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	function check_approved($id)
	{
		$this->db->select('*', 1);
		$this->db->where('transaction_id', $id);		
		$query = $this->db->get('transactions_sl');
		
		$result = null;
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		
		if ($result['transaction_is_approved']=='t')
		{		
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	
}// end of class 
