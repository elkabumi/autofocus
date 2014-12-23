<?php
class Employee_group_model extends CI_Model 
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
		
		$columns['employee_group_name'] 			= 'employee_group_name';
		$columns['employee_group_description'] 			= 'employee_group_description';
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'employee_group_id';
		$order_by_column[] = 'employee_group_name';
		$order_by_column[] = 'employee_group_description';
		
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
		from employee_groups
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
				$row['employee_group_id'], 
				$row['employee_group_name'],
				$row['employee_group_description']
				); 
							
			}

		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id)
	{
		$this->db->select('a.*', 1); // ambil seluruh data
		$this->db->where('employee_group_id', $id);
		$query = $this->db->get('employee_groups a', 1); // parameter limit harus 1
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}
	function delete($id)
	{
		$this->db->trans_start();
		$this->db->where('employee_group_id', $id); // data yg mana yang akan di update
		$this->db->delete('employee_groups');
	
		$this->access->log_delete($id, 'Employee Group');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	function create($data, $items)
	{
		$this->db->trans_start();
		$this->db->insert('employee_groups', $data);
		$id = $this->db->insert_id();
		
		//Insert items
		$index = 0;
		foreach($items as $row)
		{			
			$row['employee_group_id'] = $id;
			$this->db->insert('employee_group_items', $row);
			$index++;
		}
				
		$this->insert_id = $id;//create transaction
	//	$this->insert_transaction($id, $data);
		
		$this->access->log_insert($id, 'Employee Group');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 
	function update($id, $data, $items)
	{
		$this->db->trans_start();
		$this->db->where('employee_group_id', $id); // data yg mana yang akan di update
		$this->db->update('employee_groups', $data);
		
		//Insert items
		$this->db->where('employee_group_id', $id);
		$this->db->delete('employee_group_items');
		$index = 0;
		foreach($items as $row)
		{			
			$row['employee_group_id'] = $id;
			$this->db->insert('employee_group_items', $row); 
			$index++;
		}
		
		$this->access->log_update($id, 'Employee Group');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	
	function detail_list_loader($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*, b.*', 1);
		$this->db->from('employees a');
		$this->db->join('employee_group_items b','b.employee_id = a.employee_id');
	
		$this->db->where('b.employee_group_id', $id);
		$query = $this->db->get();
		
		debug();
	
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	
		
	function load_employee($id)
	{
		$sql = "
			select * from employees 
			where employee_id = $id
		";
		
		
		$query = $this->db->query($sql); 
		//query();	
		return $query;
	}
}
#
