<?php
class Summary_report_model extends CI_Model 
{
	var $trans_type = 5;
	var $insert_id = NULL;
	
	function __construct()
	{
		//parent::Model();
		//$this->sek_id = $this->access->sek_id;
	}
	
	
	
	
	function detail_list_loader()
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*, b.*, c.product_code, c.product_name, c.product_description, d.uom_name, e.product_category_name, f.phase_name, g.project_name, h.employee_name as create_by_name, i.employee_name as inactive_by_name', 1);
		$this->db->from('transaction_details a');
		$this->db->join('transactions b','b.transaction_id = a.transaction_id');
		$this->db->join('products c','c.product_id = a.product_id');
		$this->db->join('uom d','d.uom_id = a.uom_id');
		$this->db->join('product_categories e','e.product_category_id = b.transaction_product_category_id');
		$this->db->join('phase f','f.phase_id = b.phase_id');
		$this->db->join('projects g','g.project_id = b.project_id');
		$this->db->join('employees h','h.employee_id = b.create_by_id', 'left');
		$this->db->join('employees i','i.employee_id = b.inactive_by_id', 'left');
		$this->db->where('b.transaction_type_id', 1);
		$query = $this->db->get(); debug();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	
	function detail_list_loader2($phase_id, $project_id, $material_type, $transaction_id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*,
							 e.product_category_name, 
							 f.phase_name, 
							 g.project_name, 
							 h.employee_name as create_by_name, 
							 i.employee_name as inactive_by_name', 1);
		$this->db->from('transactions a');
		$this->db->join('product_categories e','e.product_category_id = a.transaction_product_category_id');
		$this->db->join('phase f','f.phase_id = a.phase_id');
		$this->db->join('projects g','g.project_id = a.project_id');
		$this->db->join('employees h','h.employee_id = a.create_by_id', 'left');
		$this->db->join('employees i','i.employee_id = a.inactive_by_id', 'left');
		$this->db->where('a.transaction_type_id', 1);
		
		if($phase_id != 0){
			$this->db->where('a.phase_id', $phase_id);
		}
		
		if($project_id != 0){
			$this->db->where('a.project_id', $project_id);
		}
		
		if($material_type != 0){
			$this->db->where('a.transaction_product_category_id', $material_type);
		}
		
		if($transaction_id != 0){
			$this->db->where('a.transaction_id', $transaction_id);
		}
		
		
		$query = $this->db->get(); debug();
		foreach($query->result_array() as $row)
		{
			$row['get_total_qty'] = $this->get_total_qty($row['transaction_id']);
			$row['get_total_ordered'] = $this->get_total_ordered($row['transaction_id']);
			//send_json($row['get3']);
			$result[] = format_html($row);
			
		}
		return $result;
	}
	function get_total_qty($transaction_id){
		
				$sql = "SELECT SUM( a.transaction_detail_qty ) AS total
						FROM transaction_details a
						JOIN transactions b ON b.transaction_id = a.transaction_id

				
				where a.transaction_id = $transaction_id
				
				";

		$query = $this->db->query($sql);
		//query();
		$result = null;
		foreach ($query->result_array() as $row)
		 $result = format_html($row);
		return $result['total'];
	}
	function get_total_ordered($transaction_id){
		
				$sql = "SELECT SUM( a.transaction_detail_ordered) AS total
						FROM transaction_details a
						JOIN transactions b ON b.transaction_id = a.transaction_id

				
				where a.transaction_id = $transaction_id
				
				";

		$query = $this->db->query($sql);
		//query();
		$result = null;
		foreach ($query->result_array() as $row)
		 $result = format_html($row);
		return $result['total'];
	}
}
	

	
	

	
	

#
