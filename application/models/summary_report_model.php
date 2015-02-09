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
	
	function detail_list_loader2($date_1,$date_2)
	{
		// buat array kosong
		$result = array(); 	
		if($date_1 != 0 and $date_2 !=0){
			$where = "WHERE a.registration_date between '".$date_1."'  AND '".$date_2."'";
		}else{
			$where = '';
		}
		$sql = "
		select a.* , c.customer_name, d.car_nopol, e.insurance_name, f.transaction_total,
		f.transaction_progress,
		f.transaction_material_total
		from registrations a
		left join customers c on a.customer_id = c.customer_id
		left join cars d on a.car_id = d.car_id
		left join insurances e on a.insurance_id = e.insurance_id
		left join transactions f on f.registration_id = a.registration_id
		".$where."";
		
		
		
		$query = $this->db->query($sql); //debug();
		//query();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	
	
	
function report($where)
	{		
		
		$query = "
				select a.* , c.customer_name, d.car_nopol, e.insurance_name,f.*
				from registrations a
				left join customers c on a.customer_id = c.customer_id
				left join cars d on a.car_id = d.car_id
				left join insurances e on a.insurance_id = e.insurance_id
				left join transactions f on a.registration_id = f.registration_id
				".$where."";
		
		$query = $this->db->query($query);		
	   	if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
	}
	
}

	

	
	

	
	

#
