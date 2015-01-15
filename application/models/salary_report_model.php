<?php

class Salary_report_model extends CI_Model{

	function __construct(){
		
	}
	
	
	function read_date($date1,$date2){
		
		$sql = "select a.*,b.transaction_detail_date,transaction_detail_total,e.employee_group_name,d.employee_name 
				from transactions a 
				join transaction_details b on b.transaction_id = a.transaction_id 
				join employee_group_items c on c.employee_group_id = a.employee_group_id  
				join employees d on d.employee_id = c.employee_id
				join employee_groups e on e.employee_group_id = a.employee_group_id 
				where b.transaction_detail_date between '$date1' and '$date2'
				group by b.transaction_detail_id";
		
		$query = $this->db->query($sql);
		//query($query);
		if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        return $data;
	}
	
	function get_total($date1,$date2){
		
		$sql = "select a.*,b.transaction_detail_date,sum(transaction_detail_total) as total,c.*,d.*
				from transactions a
				join transaction_details b on b.transaction_id = a.transaction_id
				join employee_group_items c on c.employee_group_id = a.employee_group_id
				join employees d on d.employee_id = c.employee_id
				where b.transaction_detail_date between '$date1' and '$date2'";
		
		$query = $this->db->query($sql);
		//query($query);
		if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
	}
	
	
}