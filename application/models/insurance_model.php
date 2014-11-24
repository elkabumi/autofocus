<?php
class insurance_model extends CI_Model 
{
	var $trans_type = 5;
	var $insert_id = NULL;
	
	function __construct()
	{
		//parent::Model();
		//$this->sek_id = $this->access->sek_id;
	}
	function list_controller()
	{		
		$where = '';
		$params 	= get_datatables_control();
		$limit 		= $params['limit'];
		$offset 	= $params['offset'];
		$category 	= $params['category'];
		$keyword 	= $params['keyword'];
		
		// map value dari combobox ke table
		// daftar kolom yang valid
		
		$columns['insurance_name'] 			= 'insurance_name';
		$columns['insurance_addres'] 			= 'insurance_addres';
		$columns['insurance_phone']	= 'insurance_phone';
		$columns['insurance_date']			= 'insurance_date';
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'insurance_id';
		$order_by_column[] = 'insurance_name';
		$order_by_column[] = 'insurance_addres';
		$order_by_column[] = 'insurance_phone';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.* , c.employee_name as created_name, d.employee_name as inactive_name
		from insurances a
		
		left join employees c on a.created_by_id = c.employee_id
		left join employees d on a.inactive_by_id = d.employee_id
		$where  $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		//query();
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$status = "Created by ".$row['created_name'];	
			$insurance_date = format_new_date($row['insurance_date']);
			$active = show_checkbox_status($row['insurance_active_status']);
				
			if($row['insurance_active_status'] == 0){
				
				
				$div1 = "<span class='inactive'>";
				$div2 = "</div>";
				$row['insurance_id'] = $row['insurance_id'];
				$row['insurance_name'] = $div1.$row['insurance_name'].$div2;
				$row['insurance_addres'] = $div1.$row['insurance_addres'].$div2;
				$row['insurance_phone '] = $div1.$row['insurance_phone'].$div2;
				$product_date = $div1.$insurance_date.$div2;
				$active	=$div1.$active.$div2;
				$status = $div1."Inactive by ".$row['inactive_name'].$div2;	
			
			}
			
			$data[] = array(
				$row['insurance_id'], 
				$row['insurance_name'],
				$row['insurance_addres'],
				$row['insurance_phone'],
				$insurance_date,
				$active,
				$status
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id)
	{
		$this->db->select('a.*', 1); // ambil seluruh data
		$this->db->where('insurance_id', $id);
		$query = $this->db->get('insurances a', 1); // parameter limit harus 1
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}
	function delete($id)
	{
		$this->db->trans_start();
		$data['insurance_active_status'] = '0';
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		$this->db->where('insurance_id', $id); // data yg mana yang akan di update
		$this->db->update('insurances', $data);
	
		$this->access->log_delete($id, 'PO Received');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	function create($data, $items,$item2)
	{
		$this->db->trans_start();
		$this->db->insert('insurances', $data);
		$id = $this->db->insert_id();
		
		//Insert items
		$index = 0;
		foreach($items as $row)
		{			
			$row['insurance_id'] = $id;
			$this->db->insert('product_types', $row);
			$index++;
		}
		
		$index2 = 0;
		foreach($item2 as $row2)
		{			
			$row2['insurance_id'] = $id;
			$this->db->insert('product_sub_type', $row2);
			$index2++;
		}
		
		$this->insert_id = $id;//create transaction
	//	$this->insert_transaction($id, $data);
		
		$this->access->log_insert($id, 'PO Received');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 
	function update($id, $data, $items,$item2)
	{
		$this->db->trans_start();
		$this->db->where('insurance_id', $id); // data yg mana yang akan di update
		$this->db->update('insurances', $data);
		
		//Insert items
		$this->db->where('insurance_id', $id);
		$this->db->delete('product_types');
		$index = 0;
		foreach($items as $row)
		{			
			$row['insurance_id'] = $id;
			$this->db->insert('product_types', $row); 
			$index++;
		}
		
		$this->db->where('insurance_id', $id);
		$this->db->delete('product_sub_type');
		$index = 0;
		$index2 = 0;
		foreach($item2 as $row2)
		{			
			$row2['insurance_id'] = $id;
			$this->db->insert('product_sub_type', $row2);
			$index2++;
		}
		$this->access->log_update($id, 'PO Received');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function insert_transaction($data_id, $datatrans, $update_mode = 0) {
	$id = 0;

	if ($update_mode) {
	    $query = $this->db->get_where('transactions_sl', array('transaction_data_id' => $data_id, 'transaction_type_id' => $this->trans_type), 1);
	    if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$id = $row['transaction_id'];
		//update transaction
		$data['transaction_date'] = $datatrans['transaction_date'];
		$data['transaction_description'] = $datatrans['transaction_description'];
		$this->db->update('transactions_sl', $data, array('transaction_id' => $id));
		$this->db->where('transaction_id', $id);
		$this->db->delete('journals_sl');
	    }
	    else
		$update_mode = 0;
	}
	if (!$update_mode) {
	    $data['transaction_date'] = $datatrans['transaction_date'];
	    $data['transaction_description'] = $datatrans['transaction_description'];
	    $data['transaction_type_id'] = $this->trans_type;
	    $data['transaction_code'] = $datatrans['transaction_code'];
	    $data['transaction_data_id'] = $data_id;
	    $data['period_id'] = 1;
	    $this->db->insert('transactions_sl', $data);
	    $id = $this->db->insert_id();
		//$this->db->update('transactions_sl', array('transaction_data_id' => $id), array('transaction_id' => $id));
	}
	if ($id == 0)
	    return;
	$index = 0;

	$i = 0;
	$journal_items['transaction_id'] = $id;
	$journal_items['market_id'] =  $datatrans['stand_id'];
	
	//pembayaran cash
	if($datatrans['transaction_payment_method_id'] == 1){
	
	$debit = 3; $kredit = 30;
	
	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['transaction_description'];
	$journal_items['journal_debit'] = $datatrans['transaction_final_total_price'];
	$journal_items['journal_credit'] = 0;
	$journal_items['coa_id'] = $debit;
	$this->db->insert('journals_sl', $journal_items);
	
	if($datatrans['transaction_sent_price'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['transaction_description'];
		$journal_items['journal_debit'] = 0;
		$journal_items['journal_credit'] = $datatrans['transaction_sent_price'];
		$journal_items['coa_id'] = 32;
		$this->db->insert('journals_sl', $journal_items);
	}

	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['transaction_description'];
	$journal_items['journal_debit'] = 0;
	$journal_items['journal_credit'] = $datatrans['transaction_total_price'];
	$journal_items['coa_id'] = $kredit;
	$this->db->insert('journals_sl', $journal_items);
	
	//pembayaran kredit
	}else if($datatrans['transaction_payment_method_id'] == 2){
		$debit = 8; $kredit = 30;
	
	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['transaction_description'];
	$journal_items['journal_debit'] = $datatrans['transaction_final_total_price'] - $datatrans['transaction_down_payment'];
	$journal_items['journal_credit'] = 0;
	$journal_items['coa_id'] = $debit;
	$this->db->insert('journals_sl', $journal_items);
	
	if($datatrans['transaction_down_payment'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['transaction_description'];
		$journal_items['journal_debit'] = $datatrans['transaction_down_payment'];
		$journal_items['journal_credit'] = 0;
		$journal_items['coa_id'] = 3;
		$this->db->insert('journals_sl', $journal_items);
	}
	
	if($datatrans['transaction_sent_price'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['transaction_description'];
		$journal_items['journal_debit'] = 0;
		$journal_items['journal_credit'] = $datatrans['transaction_sent_price'];
		$journal_items['coa_id'] = 32;
		$this->db->insert('journals_sl', $journal_items);
	}

	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['transaction_description'];
	$journal_items['journal_debit'] = 0;
	$journal_items['journal_credit'] = $datatrans['transaction_total_price'];
	$journal_items['coa_id'] = $kredit;
	$this->db->insert('journals_sl', $journal_items);
	
	}else{
	
	$debit = 5; $kredit = 30;
	
	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['transaction_description'];
	$journal_items['journal_debit'] = $datatrans['transaction_final_total_price'];
	$journal_items['journal_credit'] = 0;
	$journal_items['coa_id'] = $debit;
	$this->db->insert('journals_sl', $journal_items);
	
	if($datatrans['transaction_sent_price'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['transaction_description'];
		$journal_items['journal_debit'] = 0;
		$journal_items['journal_credit'] = $datatrans['transaction_sent_price'];
		$journal_items['coa_id'] = 32;
		$this->db->insert('journals_sl', $journal_items);
	}

	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['transaction_description'];
	$journal_items['journal_debit'] = 0;
	$journal_items['journal_credit'] = $datatrans['transaction_total_price'];
	$journal_items['coa_id'] = $kredit;
	$this->db->insert('journals_sl', $journal_items);
		
	}
	
		return $id;
    }
	
	function detail_list_loader($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*, b.*', 1);
		$this->db->from('insurances a');
		$this->db->join('product_types b','b.insurance_id = a.insurance_id');
	
		$this->db->where('a.insurance_id', $id);
		$query = $this->db->get();
		
		debug();
	
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	
	
	function detail_list_loader2($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*', 1);
		$this->db->from('product_sub_type a');
		$this->db->where('a.insurance_id', $id);
		$query = $this->db->get();
		//query($query);
		
		debug();
	
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	function get_debit_name($id)
	{
		$data = '';		
		$this->db->select('coa_name',1);
		$this->db->from('coas');
		$this->db->where('coa_id', $id);
		$query = $this->db->get();
		
		if($query->num_rows>0)
		{
			$row = $query->row_array();
			$data = $row['coa_name'];
		}
		return $data;
	}
	function get_credit_name($id)
	{
		$data = '';		
		$this->db->select('coa_name',1);
		$this->db->from('coas');
		$this->db->where('coa_id', $id);
		$query = $this->db->get();
		
		if($query->num_rows>0)
		{
			$row = $query->row_array();
			$data = $row['coa_name'];
		}
		return $data;
	}
	
	function load_product_stock($id)
	{
		$sql = "
			select 
			a.*, b.product_code
			from product_stocks a 
			join products b on b.product_id = a.product_id
			where product_stock_id = $id
		";
		
		
		$query = $this->db->query($sql); 
		//query();	
		return $query;
	}
	
	
	
	function check_po_received($id)
	{
		$sql = "select * from transactions where transaction_sent_id = $id
				";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{		
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function active($id){
		$this->db->trans_start();
		
		$this->db->trans_start();
		$data['transaction_active_status'] = '1';
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		$this->db->where('transaction_id', $id); // data yg mana yang akan di update
		$this->db->update('transactions', $data);
	
		$this->access->log_update($id, 'PO Received');
		$this->db->trans_complete();

		return $this->db->trans_status();
	
	}
}
#
