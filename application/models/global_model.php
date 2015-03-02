<?php

class Global_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function check_code($table, $column, $data, $parameter = '')
	{
		$sql = "select $column from $table where $column = '$data' 
				";
		if($parameter){
			$sql .= " and $parameter";
		} 
		
		$query = $this->db->query($sql);
		//query();
		if ($query->num_rows() > 0)
		{		
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function get_uom()
	{
		$this->db->select('*');
		$this->db->order_by('uom_id','ASC');
		$query = $this->db->get('uom');	

		$data = array();
		foreach($query->result_array() as $row)
		{
			$data[$row['uom_id']] = $row['uom_name'];
		}
		return $data;
	}
	
	function get_projects($id)
	{		
		$query = $this->db->get_where('projects', array('project_id' => $id));	
		$data = array();
		$index = 1;
			$data[0][0] = '';
			$data[0][1] = '--PILIH SEMUA--';
		foreach($query->result_array() as $row)
		{
			$data[$index][0] = $row['project_id'];
			$data[$index][1] = $row['project_name'];
			$index++;
		}
		return $data;
	}
	
	function get_customers()
	{		
		$this->db->select('customer_id,customer_name');
		$query = $this->db->get('customers');		
		$data = array();
		
		$index = 1;
			$data[0][0] = '';
			$data[0][1] = '--PILIH SEMUA--';
			
		foreach($query->result_array() as $row)
		{
			$data[$index][0] = $row['customer_id'];
			$data[$index][1] = $row['customer_name'];
			$index++;
		}
		return $data;
	}
	
	
	function get_unit()
	{
		$this->db->select('*');
		$this->db->order_by('unit_id','ASC');
		$query = $this->db->get('units');	

		$data = array();
		foreach($query->result_array() as $row)
		{
			$data[$row['unit_id']] = $row['unit_name'];
		}
		return $data;
	}
	function get_transaction_payment_method()
	{
		$this->db->select('*');
		$this->db->order_by('transaction_payment_method_id','ASC');
		$query = $this->db->get('transaction_payment_methods');	

		$data = array();
		foreach($query->result_array() as $row)
		{
			$data[$row['transaction_payment_method_id']] = $row['transaction_payment_method_name'];
		}
		return $data;
	}
	
	function get_active_period()
	{
		$sql = "select period_id, period_name from periods where period_closed = 1";
		$query = $this->db->query($sql);
		//query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return array($result['period_id'], $result['period_name']);
		
	}
	
	
	function get_coa($id)
	{
		$query = $this->db->get_where('coas', array('coa_id' => $id), 1);
		$data = array();
		if ($query->num_rows() > 0)
		{
			$data = $query->row_array();
			return $data;
		}
		return $data;
	}
	
	function get_market_value($id)
	{
		$this->db->select('market_id,market_code,market_name', 1);		
		$this->db->from('markets');
		$this->db->where('market_id', $id);
		
		$query = $this->db->get();
		return $query->row_array();
	}	
	function get_product_categories()
	{		
		$this->db->select('product_category_id,product_category_name');
		$query = $this->db->get('product_categories');		
		$data = array();
		$data[0] = "--Pilih Semua--";
		foreach($query->result_array() as $row)
		{
				$data[$row['product_category_id']] = $row['product_category_name'];
		}
		return $data;
	}
	function get_type_photo()
	{		
		$this->db->select('photo_type_id,photo_type_name');
		$this->db->where('photo_type_id', 3);
		$this->db->or_where('photo_type_id', 4);
		$query = $this->db->get('photo_types');		
		$data = array();
		foreach($query->result_array() as $row)
		{
				$data[$row['photo_type_id']] = $row['photo_type_name'];
		}
		return $data;
	}
	
	function get_stand()
	{		
		$this->db->select('stand_id,stand_name');
		$query = $this->db->get(' stands');		
		$data = array();
		$data[0] = "--Pilih Semua--";
		foreach($query->result_array() as $row)
		{
				$data[$row['stand_id']] = $row['stand_name'];
		}
		return $data;
	}
		function get_po_number()
	{		
		$this->db->select('transaction_code');
		$query = $this->db->get('transactions');		
		$data = array();
		$data[0] = "--Pilih Semua--";
		foreach($query->result_array() as $row)
		{
				$data[$row['transaction_code']] = $row['transaction_code'];
		}
		return $data;
	}
	
	
	function get_customer()
	{
		$this->db->select('customer_id,customer_name');
		$query = $this->db->get('customers');		
		$data = array();
		$data[0] = "--Pilih Semua--";
		foreach($query->result_array() as $row)
		{
				$data[$row['customer_id']] = $row['customer_name'];
		}
		return $data;
	}
	
	function get_counter($id)
	{
		$sql = "SELECT value from counter where code = $id";
		$query = $this->db->query($sql);
		//query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		if(strlen($result['value'])== 1){
			$result['value']="0".$result['value'];
		}
		return $result['value'];
		
	}
	
	
	function get_user_group()
	{		
		$this->db->select('group_id,group_name');
		$this->db->where('group_id >', 1);
		$query = $this->db->get('groups');		
		$data = array();
		
		
			
		foreach($query->result_array() as $row)
		{
		
			$data[$row['group_id']] = $row['group_name'];
		
		}
		return $data;
	}
	
	function report_header(){
		$query = "select * from company";
        $query = $this->db->query($query);
       // query();
        if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
	}
	
	
	
	function create_report($title, $content, $data = '', $data_detail = '') {
		
				$data['format'] =	header("Pragma: public");
									header("Expires: 0");
									header("Cache-Control : must-revalidate, post-check=0, pre-check=0");
									header("Content-type: application/force-download");
								    header("Content-type: application/octet-stream");
									header("Content-type: application/download");
								    header("Content-Disposition: attachment; filename=$title.xls");
								    header("Content-transfer-encoding: binary");

	  							$this->load->view($content, $data);
		
		 /*if($type == 'pdf')
		{
			$this->load->library('html2pdf');
		
	    	$this->html2pdf->folder('report_new/');
	    
	   		 //Set the filename to save/download as
	  	 	$this->html2pdf->filename($title.'.pdf');
	    
	   		//Set the paper defaults
			if($size == 'l'){
	    		$this->html2pdf->paper( 'A4', 'landscape');
			}
			else{
				$this->html2pdf->paper( 'A4', 'potrait');
			}
	    	$data['format']='';
	   	

	    	$mydata = $this->load->view('header.php',$data,TRUE) ;
	    	$mydata .= $this->load->view($content, array('data' => $data, 'data_detail' => $data_detail) ,TRUE) ;
	    	$mydata .= $this->load->view('footer.php',$data,TRUE) ;
	    	//Load html view
	    	$this->html2pdf->html($mydata);
	    
	    	if($this->html2pdf->create('save')) {
	    		header('Content-type: application/pdf');
				readfile('report_new/'.$title.'.pdf');
	    	}
		}*/
	}
	
	
	function create_report_per_mobil($title, $content, $data = '', $data_detail = '', $header){
		
	    $this->load->library('html2pdf');
	    $this->html2pdf->folder('report_new/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename($title.'.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper( 'A4', 'Portrait');
	    
	   	

	    $mydata  = $this->load->view($header,$data,TRUE) ;
	    $mydata .= $this->load->view($content, array('data' => $data, 'data_detail' => $data_detail) ,TRUE) ;
	    $mydata .= $this->load->view('footer.php',$data,TRUE) ;
	    //Load html view
	    $this->html2pdf->html($mydata);
	    
	    if($this->html2pdf->create('save')) {
	    	header('Content-type: application/pdf');
			readfile('report_new/'.$title.'.pdf');
	    }
	}
	function create_report_registration($title, $content, $data = '', $data_detail = '',$data_sperpart ='', $header){
		
	    $this->load->library('html2pdf');
	    $this->html2pdf->folder('report_new/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename($title.'.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper( 'A4', 'Portrait');
	    
	   	

	    $mydata = $this->load->view($header,$data,TRUE) ;
	    $mydata .= $this->load->view($content, array('data' => $data, 'data_detail' => $data_detail,'data_sperpart' => $data_sperpart) ,TRUE) ;
	    $mydata .= $this->load->view('footer.php',$data,TRUE) ;
	    //Load html view
	    $this->html2pdf->html($mydata);
	    
	    if($this->html2pdf->create('save')) {
	    	header('Content-type: application/pdf');
			readfile('report_new/'.$title.'.pdf');
	    }
	}
	
	function create_report_pkb($title, $content, $data = '', $data_detail = '',$data_sperpart ='', $header){
		
	    $this->load->library('html2pdf');
	    $this->html2pdf->folder('report_new/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename($title.'.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper( 'A4', 'Portrait');
	    
	   	

	    $mydata = $this->load->view($header,$data,TRUE) ;
	    $mydata .= $this->load->view($content, array('data' => $data, 'data_detail' => $data_detail,'data_sperpart' => $data_sperpart) ,TRUE) ;
	    $mydata .= $this->load->view('footer.php',$data,TRUE) ;
	    //Load html view
	    $this->html2pdf->html($mydata);
	    
	    if($this->html2pdf->create('save')) {
	    	header('Content-type: application/pdf');
			readfile('report_new/'.$title.'.pdf');
	    }
	}
	
	function create_salary_report($title, $content, $data = '', $total = '', $header){
		
	    $this->load->library('html2pdf');
	    $this->html2pdf->folder('report_new/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename($title.'.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper( 'A4', 'Portrait');
	    
	   	

	    $mydata = $this->load->view($header,$data,TRUE) ;
	    $mydata .= $this->load->view($content, array('data' => $data, 'total' => $total) ,TRUE) ;
	    $mydata .= $this->load->view('footer.php',$data,TRUE) ;
	    //Load html view
	    $this->html2pdf->html($mydata);
	    
	    if($this->html2pdf->create('save')) {
	    	header('Content-type: application/pdf');
			readfile('report_new/'.$title.'.pdf');
	    }
	}
	
	function create_report_detail_mobil($title, $content, $data = '', $data_detail = '',$data_sperpart ='',$data_jasa ='',$data_cat ='', $header){
		
	    $this->load->library('html2pdf');
	    $this->html2pdf->folder('report_new/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename($title.'.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper( 'A4', 'Portrait');
	    
	   	

	    $mydata = $this->load->view($header,$data,TRUE) ;
	    $mydata .= $this->load->view($content, array('data' => $data, 'data_detail' => $data_detail,'data_sperpart' => $data_sperpart,'data_jasa' =>$data_jasa,'data_cat' => $data_cat, 'title' => $title) ,TRUE) ;
	    $mydata .= $this->load->view('footer.php',$data,TRUE) ;
	    //Load html view
	    $this->html2pdf->html($mydata);
	    
	    if($this->html2pdf->create('save')) {
	    	header('Content-type: application/pdf');
			readfile('report_new/'.$title.'.pdf');
	    }
	}
	
	function create_report_kwitansi($title, $content, $data = '',$header){
		
	    $this->load->library('html2pdf');
	    $this->html2pdf->folder('report_new/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename($title.'.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper( 'A5', 'landscape');
	    
	   	

	    $mydata = $this->load->view($content,$data,TRUE) ;
	     
		//$mydata .= $this->load->view('footer.php',$data,TRUE) ;
		
		//Load html view
	    $this->html2pdf->html($mydata);
	    
	    if($this->html2pdf->create('save')) {
	    	header('Content-type: application/pdf');
			readfile('report_new/'.$title.'.pdf');
	    }
	}
}

# -- end file -- #
