<?php 

class Pkb extends CI_Controller 
{	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('pkb_model');
		$this->load->library('render');
		
		// set kode module ini .. misal usr
		$this->access->set_module('transaction.registration');
		// default access adalah User
		$this->load->library('access');
		
	
	}
	function index(){
		
		$this->render->add_view('app/price/list');
		$this->render->build('Price');
		$this->render->show('Price');
	}
	function report($id = 0){
	
	if($id){
	   $this->load->model('global_model');
	   
	   $result = $this->pkb_model->read_id($id);
			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data = $result;
				$data['row_id'] = $id;		
				$data['car_nopol'] = $result['car_nopol'];	
				$data['customer_name'] = ($result['customer_name']) ? $result['customer_name'] : "-";
				
			}
			
		$data_detail = $this->pkb_model->get_data_detail($id);
		$data_sperpart = $this->pkb_model->get_data_sperpart($id);
	   
	   $this->global_model->create_report_pkb('Surat Perintah Kerja', 'report/pkb_report.php', $data, $data_detail, $data_sperpart,'header.php');
	}
	}
	
}
