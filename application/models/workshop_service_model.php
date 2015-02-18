<?php

class Workshop_service_model extends CI_Model{

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
		
		$columns['workshop_service_name'] 			= 'workshop_service_name';
	
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'workshop_service_id';
		
		$order_by_column[] = 'workshop_service_name';
		$order_by_column[] = 'workshop_service_price';
		$order_by_column[] = 'workshop_service_job_price';
		$order_by_column[] = 'workshop_service_date';
		$order_by_column[] = 'workshop_service_active_status';
		$order_by_column[] = 'workshop_service_active_status';
		
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
		from workshop_services a
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
			$workshop_service_date = format_new_date($row['workshop_service_date']);
			$active = show_checkbox_status($row['workshop_service_active_status']);
				
			if($row['workshop_service_active_status'] == 0){
				
				
				$div1 = "<span class='inactive'>";
				$div2 = "</div>";
				$row['workshop_service_id'] = $row['workshop_service_id'];
				
				$row['workshop_service_name'] = $div1.$row['workshop_service_name'].$div2;
				
				$workshop_service_date = $div1.$workshop_service_date.$div2;
				$active	=$div1.$active.$div2;
				$status = $div1."Inactive by ".$row['inactive_name'].$div2;	
			
			}
			
			$data[] = array(
				$row['workshop_service_id'], 
				$row['workshop_service_name'],
				tool_money_format($row['workshop_service_price']),
				tool_money_format($row['workshop_service_job_price']),
				$workshop_service_date,
				$active,
				$status
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id){
		$this->db->select('*', 1);
		$this->db->where('workshop_service_id', $id);
		$query = $this->db->get('workshop_services', 1);
		$result = null;
		foreach($query->result_array() as $row)
		{
			$result = format_html($row);
		}
		return $result;
	}
	
	function create($data){
		$this->db->trans_start();
		$this->db->insert('workshop_services', $data);
		$id = $this->db->insert_id();
		
		
		
		$this->access->log_insert($id, "produk [".$data['workshop_service_name']."]");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function update($id, $data){
		$this->db->trans_start();
		$this->db->where('workshop_service_id', $id);
		$this->db->update('workshop_services', $data);
		$this->access->log_update($id, "produk[".$data['workshop_service_name']."]");
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function delete($id){
		$this->db->trans_start();
		
		$data['workshop_service_active_status'] = 0;
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		
		$this->db->where('workshop_service_id', $id);
		$this->db->update('workshop_services', $data);
		
		$this->access->log_delete($id, "Produk");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function active($id){
		$this->db->trans_start();
		
		$data['workshop_service_active_status'] = 1;
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		
		$this->db->where('workshop_service_id', $id);
		$this->db->update('workshop_services', $data);
		
		$this->access->log_update($id, "Produk");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}


	function get_use_stock($id)
	{
		$sql = "SELECT workshop_service_category_use_stock from workshop_service_categories where workshop_service_category_id = $id";
		$query = $this->db->query($sql);
		//query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result['workshop_service_category_use_stock'];
		
	}
	
	
	
}