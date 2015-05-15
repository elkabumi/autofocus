<?php

class Material_model extends CI_Model{

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
		
		$columns['material_name'] 			= 'material_name';
		$columns['unit_name'] 				= 'unit_name';
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'material_id';
		$order_by_column[] = 'material_name';
		$order_by_column[] = 'unit_name';
		$order_by_column[] = 'material_desc';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = "AND ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		SELECT a.*,b.unit_name 
		FROM materials a
		JOIN unit b ON a.unit_id = b.unit_id
		WHERE 	material_type_id = 1 $where  $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		//query();
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$data[] = array(
				$row['material_id'],
				$row['material_name'], 
				$row['unit_name'],
				$row['material_desc']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id){
		$this->db->select('*', 1);
		$this->db->where('material_id', $id);
		$query = $this->db->get('materials', 1);
		$result = null;
		foreach($query->result_array() as $row)
		{
			$result = format_html($row);
		}
		return $result;
	}
	
	function create($data){
		$this->db->trans_start();
		$this->db->insert('materials', $data);
		$id = $this->db->insert_id();
				
		$this->access->log_insert($id, "material [".$data['material_name']."]");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function update($id, $data){
		$this->db->trans_start();
		$this->db->where('material_id', $id);
		$this->db->update('materials', $data);
		$this->access->log_update($id, "material[".$data['material_name']."]");
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function delete($id){
		$this->db->trans_start();
		
		$this->db->where('material_id', $id);
		$this->db->delete('materials');
		
		$this->access->log_delete($id, "Customers");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
}