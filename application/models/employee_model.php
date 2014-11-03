<?php

class Employee_model extends CI_Model{

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
		
		$columns['employee_nip'] 			= 'employee_nip';
		$columns['employee_name'] 			= 'employee_name';
		$columns['employee_position_name']	= 'employee_position_name';
		$columns['stand_name']				= 'stand_name';
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'employee_id';
		$order_by_column[] = 'employee_nip';
		$order_by_column[] = 'employee_name';
		$order_by_column[] = 'employee_position_name';
		$order_by_column[] = 'stand_name';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " and ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.* , b.employee_position_name
		from employees a
		left join employee_positions b on b.employee_position_id = a.employee_position_id
	
		where employee_id <> 1 and employee_active_status = '1'
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
				$row['employee_id'], 
				$row['employee_nip'],
				$row['employee_name'],
				$row['employee_position_name'],
				
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id){
		$this->db->select('*', 1);
		$this->db->where('employee_id', $id);
		$query = $this->db->get('employees', 1);
		$result = null;
		foreach($query->result_array() as $row)
		{
			$result = format_html($row);
		}
		return $result;
	}
	
	function create($data){
		$this->db->trans_start();
		$this->db->insert('employees', $data);
		$id = $this->db->insert_id();
		$this->access->log_insert($id, "Pegawai [".$data['employee_name']."]");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function update($id, $data){
		$this->db->trans_start();
		$this->db->where('employee_id', $id);
		$this->db->update('employees', $data);
		$this->access->log_update($id, "Pegawai[".$data['employee_name']."]");
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function delete($id){
		$this->db->trans_start();
		/*$this->db->where('employee_id', $id);
		$this->db->delete('employees');
		*/
		$data['employee_active_status'] = 0;
		$this->db->where('employee_id', $id);
		$this->db->update('employees', $data);
		
		$this->access->log_delete($id, "Pegawai");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	
	
	
}