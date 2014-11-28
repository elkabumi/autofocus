<?php

class car_model extends CI_Model{

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
		
		$columns['car_nopol'] 			= 'car_nopol';
		$columns['car_model_merk'] 		= 'car_model_merk';
		$columns['car_model_name'] 		= 'car_model_name';
		$columns['car_no_machine']		= 'car_no_machine';
		$columns['car_no_rangka']		= 'car_no_rangka';
		$columns['car_year']			= 'car_year';
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'car_id';
		$order_by_column[] = 'car_nopol';
		$order_by_column[] = 'car_model';
		$order_by_column[] = 'car_no_machine';
		$order_by_column[] = 'car_no_rangka';
		$order_by_column[] = 'car_color';
		$order_by_column[] = 'car_type';
		$order_by_column[] = 'car_year';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.*, concat(b.car_model_merk, ' - ', b.car_model_name) as car_model
		from cars a
		join car_models b on b.car_model_id = a.car_model_id
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
				
			$data[] = array(
				$row['car_id'], 
				$row['car_nopol'],
				$row['car_model'],
				$row['car_no_machine'],
				$row['car_no_rangka'],
				$row['car_color'],
				$row['car_type'],
				$row['car_year']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id){
		$this->db->select('*', 1);
		$this->db->where('car_id', $id);
		$query = $this->db->get('cars', 1);
		$result = null;
		foreach($query->result_array() as $row)
		{
			$result = format_html($row);
		}
		return $result;
	}
	
	function create($data){
		$this->db->trans_start();
		$this->db->insert('cars', $data);
		$id = $this->db->insert_id();
		
		
		$this->access->log_insert($id, "produk [".$data['car_nopol']."]");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function update($id, $data){
		$this->db->trans_start();
		$this->db->where('car_id', $id);
		$this->db->update('cars', $data);
		$this->access->log_update($id, "produk[".$data['car_nopol']."]");
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function delete($id){
		$this->db->trans_start();
		
		$data['car_active_status'] = 0;
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		
		$this->db->where('car_id', $id);
		$this->db->update('cars', $data);
		
		$this->access->log_delete($id, "Produk");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function active($id){
		$this->db->trans_start();
		
		$data['car_active_status'] = 1;
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		
		$this->db->where('car_id', $id);
		$this->db->update('cars', $data);
		
		$this->access->log_update($id, "Produk");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}


	
	
	
	
}