<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary_report extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('salary_report_model');
		$this->load->library('access');
		$this->access->set_module('report.salary');
	}
	
	function index(){
		
		$data = array();
			$data['row_id']					= '';
			$data['date_1']			= date('d/m/y');
			$data['date_2']			= date('d/m/y');
			$data['transaction_type_name'] 		= array('0' => 'Semua', '1' => 'Pembelian', '2' => 'Penjualan');
								
		$this->load->helper('form');
		$this->render->add_form('app/salary_report/form',$data);
		$this->render->build('Laporan Penggajian');
		$this->render->show('Laporan Penggajian');
	}
	
	function report($date1,$date2){
	
	  $this->load->model('global_model');
	  //echo $trans;
	   $day 	= substr($date1, 0,2); 
	   $month 	= substr($date1, 2,2);
	   $year 	= substr($date1, 4,4);
	  
	   $day2 	= substr($date2, 0,2); 
	   $month2 	= substr($date2, 2,2);
	   $year2 	= substr($date2, 4,4);
	   
	   $date_1	= $year."/".$month."/".$day;
	   $date_2	= $year2."/".$month2."/".$day2;
	   
	   $data = $this->salary_report_model->read_date($date_1,$date_2);
	   $total = $this->salary_report_model->get_total($date_1,$date_2);
	  
	  		$this->global_model->create_salary_report('Laporan Transaksi','report/salary_report.php', $data,$total,'header.php');
	}
	
}
