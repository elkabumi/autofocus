<?php
class Po_reservation_summary_report_model extends CI_Model 
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
		$this->db->select('a.*, b.product_code, b.product_name, c.stand_name', 1);
		$this->db->from('product_stocks a ');
		$this->db->join('products b ',' b.product_id = a.product_id');
		$this->db->join('stands c','a.stand_id = c.stand_id');

		$query = $this->db->get(); debug();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	

	
	function detail_list_loader2($stand_id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*, b.product_code, b.product_name, c.stand_name', 1);
		$this->db->from('product_stocks a ');
		$this->db->join('products b ',' b.product_id = a.product_id');
		$this->db->join('stands c','a.stand_id = c.stand_id');
		if($stand_id != 0){
			$this->db->where('a.stand_id', $stand_id);
		}
		$query = $this->db->get(); debug();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	##stock report
	function report_stock($where)
	{		
		
		$query = "SELECT a.*, b.product_code, b.product_name, c.stand_name
					from product_stocks a 
					join products b on b.product_id = a.product_id
					join stands c on a.stand_id = c.stand_id
					$where";
		$query = $this->db->query($query);		
	   	if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
	}
}
	


?>