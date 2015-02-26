<?php

class Salary_report_detail_model extends CI_Model{

	function __construct(){
		
	}
	
	


	function detail_list_loader2($date_1,$date_2,$employee_group_id)
	{
		// buat array kosong
		$result = array(); 	
		$where='';
		if($date_1 != 0 and $date_2 !=0){$where .= "WHERE d.registration_date between '".$date_1."'  AND '".$date_2."'";}
		if($employee_group_id !=0){$where .= "AND c.employee_group_id= '".$employee_group_id."'";}
			$sql = "
				select  a.transaction_total,c.employee_group_name, d.registration_date 
				from transactions a 
				JOIN employee_groups c ON c.employee_group_id = a.employee_group_id
				JOIN registrations d ON d.registration_id = a.registration_id
				".$where."  ORDER BY registration_date";
		
		
		
		$query = $this->db->query($sql); //debug();
		//query();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	function report($date_1,$date_2,$employee_group_id)
	{		
		
		$result = array(); 	
		$where='';
		if($date_1 != 0 and $date_2 !=0){$where .= "WHERE d.registration_date between '".$date_1."'  AND '".$date_2."'";}
		if($employee_group_id !=0){$where .= "AND c.employee_group_id= '".$employee_group_id."'";}
			
			
			$query = "
				select  a.transaction_total,c.employee_group_name, d.registration_date 
				from transactions a 
				JOIN employee_groups c ON c.employee_group_id = a.employee_group_id
				JOIN registrations d ON d.registration_id = a.registration_id
				".$where."  ORDER BY registration_date";
		
		
		
		$query = $this->db->query($query);		
	   	if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
	}
	
}