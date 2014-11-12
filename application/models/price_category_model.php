<?php
class price_category_model extends CI_Model 
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
		$columns['product_item_name'] 			= 'product_item_name';
		$columns['product_item_desc']	= 'product_item_desc';
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'insurance_name';
		$order_by_column[] = 'product_item_name';
		$order_by_column[] = 'product_item_desc';;
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.* ,b.*
		from insurances a 
		JOIN product_types b ON a.insurance_id = b.insurance_id
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		//query();
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			
				
		
			
			$data[] = array(
				$row['product_item_id'], 
				$row['insurance_name'],
				$row['product_item_name'],
				$row['product_item_desc'],

			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id)
	{
		$this->db->select('a.*,b.*', 1);
		$this->db->from('product_types a');
		$this->db->join('insurances b','b.insurance_id = a.insurance_id');
		$this->db->where('product_item_id', $id);
		
		$query = $this->db->get(); debug();// parameter limit harus 1
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}
	function delete($id)
	{
		$this->db->trans_start();
		$data['price_category_active_status'] = '0';
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		$this->db->where('price_category_id', $id); // data yg mana yang akan di update
		$this->db->update('price_categorys', $data);
	
		$this->access->log_delete($id, 'PO Received');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	function create($data, $items)
	{
		$this->db->trans_start();
		$this->db->insert('price_categorys', $data);
		$id = $this->db->insert_id();
		
		//Insert items
		$index = 0;
		foreach($items as $row)
		{			
			$row['price_category_id'] = $id;
			$this->db->insert('product_types', $row);
			$index++;
		}
		
		$this->insert_id = $id;
		
		//create transaction
	//	$this->insert_transaction($id, $data);
		
		$this->access->log_insert($id, 'PO Received');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 
	function update($id, $items)
	{
		$this->db->trans_start();
	
		
		//Insert items
		$this->db->where('product_item_id', $id);
		$this->db->delete('product_item_sub_type');
		$index = 0;
		foreach($items as $row)
		{			
			$row['product_item_id'] = $id;
			$this->db->insert('product_item_sub_type', $row); 
			$index++;
		}
		
		$this->access->log_update($id, 'PO Received');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	
	
	function detail_list_loader($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*', 1);
		$this->db->from('product_item_sub_type a');
		$this->db->where('a.product_item_id', $id);
		$query = $this->db->get();
		
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
