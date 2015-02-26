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
		

	/*function detail_list_loader3($date_1,$date_2)
	{
		// buat array kosong
		$result = array(); 	
		if($date_1 != 0 and $date_2 !=0){
			$where = "WHERE d.registration_date between '".$date_1."'  AND '".$date_2."'";
		}else{
			$where = '';
		}
			$sql = "
				select  a.transaction_total,c.employee_group_name 
				from transactions a 
				JOIN employee_groups c ON c.employee_group_id = a.employee_group_id
				JOIN registrations d ON d.registration_id = a.registration_id
				".$where."";
		
		
		
		$query = $this->db->query($sql); //debug();
		//query();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}*/
	
	
	function detail_list_loader2($date_1,$date_2)
	{
		// buat array kosong
		$result = array(); 	
		if($date_1 != 0 and $date_2 !=0){
			$where = "WHERE z.registration_date between '".$date_1."'  AND '".$date_2."'";
		}else{
			$where = '';
		}
			$sql = "
				select a.employee_group_name,b.employee_group_id,b.registration_date
				from employee_groups a 
				JOIN (select max(transaction_id) as transaction_id,employee_group_id,z.registration_date 
						from transactions h 
						JOIN registrations z ON z.registration_id = h.registration_id
						".$where."						
						group by employee_group_id) as b 
					on b.employee_group_id = a.employee_group_id
				";

		
		$query = $this->db->query($sql); //debug();
		//query();
		foreach($query->result_array() as $row)
		{
			$row['get_total_payment'] = $this->get_total_payment($row['employee_group_id'],$date_1,$date_2);
			$result[] = format_html($row);
		}
		return $result;
	}
	function report($date_1,$date_2)
	{		
		if($date_1 != 0 and $date_2 !=0){
			$where = "WHERE z.registration_date between '".$date_1."'  AND '".$date_2."'";
		}else{
			$where = '';
		}
		$query = "
				select a.employee_group_name,b.employee_group_id,b.registration_date
				from employee_groups a 
				JOIN (select max(transaction_id) as transaction_id,employee_group_id,z.registration_date 
						from transactions h 
						JOIN registrations z ON z.registration_id = h.registration_id
						".$where."						
						group by employee_group_id) as b 
					on b.employee_group_id = a.employee_group_id
				";
		
		$query = $this->db->query($query);		
	   	
		if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         		$row['get_total_payment'] = $this->get_total_payment($row['employee_group_id'],$date_1,$date_2);
				
				$result[] = format_html($row);	
        }
        return $result;
	}
		
	function get_total_payment($id,$date_1,$date_2){
		$where = "WHERE b.registration_date between '".$date_1."'  AND '".$date_2."' AND a.employee_group_id = ".$id."";
		$sql = "SELECT SUM(a.transaction_total) AS total_payment
					FROM transactions a
				JOIN registrations b ON a.registration_id = b.registration_id
				".$where."
				";

		$query = $this->db->query($sql);
		//query();
		$result = null;
		foreach ($query->result_array() as $row)
			$result = format_html($row);
		
		return $result['total_payment'];
	}
	
	
	
}