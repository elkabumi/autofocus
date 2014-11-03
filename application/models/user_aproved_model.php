<?php

class user_aproved_model extends CI_Model{

	var $branch_id;
	function __construct(){
		
	}
		function user_list_controller($param)
	{
		//$ci = & get_instance();
		$this->branch_id = $this->access->branch_id;
		
		$limit = $param['limit'];
		$offset = $param['offset'];
		$category = $param['category'];
		$keyword = $param['keyword'];
		
		$columns['login'] 			= 'user_login';
		$columns['nama'] 			= 'user_name';
		$columns['email']			= 'user_email';
		$columns['phone']			= 'user_phone';
		$columns['job_title']		= 'job_title';
		$columns['company'] 		= 'company';
		$columns['expired_date']	= 'expired_date';
		
		
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'user_login';
		$order_by_column[] = 'user_name';
		$order_by_column[] = 'user_email';
		$order_by_column[] = 'user_phone';
		
		$order_by_column[] = 'job_title';
		$order_by_column[] = 'company';
		$order_by_column[] = 'expired_date';
		
		$order_by = $order_by_column[!$sort_column_index ? 0 : $sort_column_index] . $sort_dir;
		
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			$this->db->start_cache();
			$this->db->like($columns[$category], $keyword);
			$this->db->stop_cache();
		}

		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->from('users a');
		//$this->db->join('groups b', 'a.user_group_id = b.group_id');	// join table untuk mengambil tipe buku	
		$this->db->join('employees c','a.employee_id = c.employee_id');
		//$this->db->join('emp_positions d','d.position_id = c.position_id');
		$this->db->where('a.user_id <> 1');
		$this->db->where('a.user_is_active','1');		
		$query	= $this->db->get(); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	

		$this->db->select('a.*', 1); 
		$this->db->from('users a');
		//$this->db->join('groups b', 'a.user_group_id = b.group_id');	
		$this->db->join('employees c','a.employee_id = c.employee_id');
		//$this->db->join('emp_positions d','d.position_id = c.position_id');
		$this->db->where('a.user_id <> 1');
		$this->db->where('a.user_is_active','1');		
		$this->db->order_by($order_by);
		if ($limit > 0) $this->db->limit($limit, $offset);
		$query = $this->db->get();
	 
		$data = array();
		foreach($query->result_array() as $row) {
			
			$row = $this->_user_renderer($row);
			
			$data[] = array(
				$row['user_id'], 
				$row['user_login'], 
				$row['user_name'],
				$row['user_email'], 
				$row['user_phone'], 
				$row['job_title'], 
				$row['company'],
				format_new_date($row['expired_date']) 
				//$row['position_name']
			); 
		}
		
		return make_datatables_control($param, $data, $total);
	}


}
?>