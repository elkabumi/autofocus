<?php

class car_model_model extends CI_Model{

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
		
		$columns['car_model_merk'] 			= 'car_model_merk';
		$columns['car_model_name'] 			= 'car_model_name';
		$columns['car_model_description'] 			= 'car_model_description';
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'car_model_id';
		$order_by_column[] = 'car_model_merk';
		$order_by_column[] = 'car_model_name';
		$order_by_column[] = 'car_model_description';
		
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
		from car_models 
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
				$row['car_model_id'],
				$row['car_model_merk'], 
				$row['car_model_name'],
				$row['car_model_description']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id){
		$this->db->select('*', 1);
		$this->db->where('car_model_id', $id);
		$query = $this->db->get('car_models', 1);
		$result = null;
		foreach($query->result_array() as $row)
		{
			$result = format_html($row);
		}
		return $result;
	}
	
	function create($data){
		$this->db->trans_start();
		$this->db->insert('car_models', $data);
		$id = $this->db->insert_id();
				
		$this->access->log_insert($id, "car_model [".$data['car_model_name']."]");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function update($id, $data){
		$this->db->trans_start();
		$this->db->where('car_model_id', $id);
		$this->db->update('car_models', $data);
		$this->access->log_update($id, "car_model[".$data['car_model_name']."]");
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function delete($id){
		$this->db->trans_start();
		
		$this->db->where('car_model_id', $id);
		$this->db->delete('car_models');
		
		$this->access->log_delete($id, "car_models");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function active($id){
		$this->db->trans_start();
		
		$data['product_active_status'] = 1;
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		
		$this->db->where('product_id', $id);
		$this->db->update('products', $data);
		
		$this->access->log_update($id, "Produk");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}


	
	
	
	
}