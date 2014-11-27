<?php

class Customer_model extends CI_Model{

	function __construct(){
		
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
		
		$columns['customer_ktp_number'] 			= 'customer_ktp_number';
		$columns['customer_name'] 					= 'customer_name';
		$columns['customer_addres']					= 'customer_addres';
		$columns['customer_phone_number']			= 'customer_phone_number';
		$columns['customer_hp']						= 'customer_hp';
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'customer_id';
		$order_by_column[] = 'customer_ktp_number';
		$order_by_column[] = 'customer_name';
		$order_by_column[] = 'customer_addres';
		$order_by_column[] = 'customer_phone_number';
		$order_by_column[] = 'customer_hp';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select * 
		from customers 
		$where  $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		//query();
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$data[] = array(
				$row['customer_id'],
				$row['customer_ktp_number'], 
				$row['customer_name'],
				$row['customer_addres'],
				$row['customer_phone_number'],
				$row['customer_hp']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id){
		$this->db->select('*', 1);
		$this->db->where('customer_id', $id);
		$query = $this->db->get('customers', 1);
		$result = null;
		foreach($query->result_array() as $row)
		{
			$result = format_html($row);
		}
		return $result;
	}
	
	function create($data){
		$this->db->trans_start();
		$this->db->insert('customers', $data);
		$id = $this->db->insert_id();
				
		$this->access->log_insert($id, "customer [".$data['customer_name']."]");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function update($id, $data){
		$this->db->trans_start();
		$this->db->where('customer_id', $id);
		$this->db->update('customers', $data);
		$this->access->log_update($id, "customer[".$data['customer_name']."]");
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function delete($id){
		$this->db->trans_start();
		
		$this->db->where('customer_id', $id);
		$this->db->delete('customers');
		
		$this->access->log_delete($id, "Customers");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
}