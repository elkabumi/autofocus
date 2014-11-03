<?php

class Dashboard_model extends CI_Model{

	function __construct(){
		
	}
	
	
	function ex() {
		
		$date = date("Y-m-d");
		$query = "select count(transaction_id) from transactions where transaction_type_id = '1' and transaction_date = '$date'";
		
        $query = $this->db->query($query);
       // query();
        if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
    }
	
	
	
	
	
	
	function get_data_po_received()
	{
		$date = date("Y-m-d");
		$sql = "select count(transaction_id) as total_po_received from transactions where transaction_type_id = '1' and transaction_date = '$date'";
		$query = $this->db->query($sql);
		//	query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['total_po_received'];	
	}
	
	function get_data_po_reservation()
	{
		$date = date("Y-m-d");
		$sql = "select count(transaction_id) as total_po_reservation from transactions where transaction_type_id = '2' and transaction_date = '$date'";
		$query = $this->db->query($sql);
		//	query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['total_po_reservation'];	
	}
	
	function get_data_po_retur()
	{
		$date = date("Y-m-d");
		$sql = "select count(transaction_id) as total_po_retur from transactions where transaction_type_id = '3' and transaction_date = '$date'";
		$query = $this->db->query($sql);
		//	query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['total_po_retur'];	
	}
	function get_user_on()
	{
		$date = date("Y-m-d");
		$sql = "SELECT COUNT( user_id ) AS total_user_on
					FROM users
				WHERE user_is_login =  '1'";
		$query = $this->db->query($sql);
		//	query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['total_user_on'];	
	}

	function get_year()
	{
		
		$year1 = date("Y");
		

		return array($year1);	
	}

	function get_data_po($month, $year)
	{
		
		$sql = "SELECT sum( transaction_detail_qty ) AS total_value
					FROM transaction_details a
					JOIN transactions b on b.transaction_id = a.transaction_id
				WHERE transaction_type_id =  '1' 
				and MONTH(transaction_date) = '$month' 
				and YEAR(transaction_date) = '$year'";
		$query = $this->db->query($sql);
			//query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['total_value'];	
	}
	
	function get_data_re($month, $year)
	{
		
		$sql = "SELECT sum( transaction_detail_ordered ) AS total_value
					FROM transaction_details a
					JOIN transactions b on b.transaction_id = a.transaction_id
				WHERE transaction_type_id =  '2' 
				and MONTH(transaction_date) = '$month' 
				and YEAR(transaction_date) = '$year'";
		$query = $this->db->query($sql);
		//query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['total_value'];	
	}
	
	
	
	
	
	
	
	
	
}