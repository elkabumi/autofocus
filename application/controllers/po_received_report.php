<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Po_received_report extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('po_received_report_model');
		$this->load->library('access');
		$this->access->set_module('master.transaction_status');
		$this->access->user_page();
	}
		
	function index(){
		
		$this->render->add_view('app/po_received_report/list');
		$this->render->build('Laporan Detail Per Mobil');
		$this->render->show('Laporan Detail Per Mobil');
	}
	
	function table_controller(){
		$data = $this->po_received_report_model->list_controller();
		send_json($data);
	}
	
	
	function form($registration_id = 0)
		{
			$data = array();
			if($registration_id == 0){
				$data['row_id'] = '';
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
				$data['transaction_id'] = '';
				$data['employee_group_id'] = '';
				$data['transaction_type_id'] = '';
				$data['transaction_plain_first_date'] = date('d/m/Y');
				$data['transaction_plain_last_date'] = date('d/m/Y');
				$data['transaction_actual_date'] = date('d/m/Y');
				$data['transaction_target_date'] = date('d/m/Y');
				$data['transaction_detail_description'] = '';
			}else{
				$result = $this->po_received_report_model->read_id($registration_id);
			if($result){
				$data = $result;
				$data['row_id'] = $registration_id;
				$data['transaction_id'] = $result['transaction_id'];
				$data['employee_group_id'] = $result['employee_group_id'];
				$data['transaction_plain_first_date'] = $result['transaction_plain_first_date'];
				$data['transaction_plain_last_date'] = $result['transaction_plain_last_date'];
				$data['transaction_actual_date'] = $result['transaction_actual_date'];
				$data['transaction_target_date'] = $result['transaction_target_date'];
				$data['transaction_komponen'] =$result['transaction_komponen'];
				$data['transaction_lasketok'] = $result['transaction_lasketok'];
				$data['transaction_dempul'] = $result['transaction_dempul'];
				$data['transaction_cat'] = $result['transaction_cat'];
				$data['transaction_poles'] = $result['transaction_poles'];
				$data['transaction_rakit'] = $result['transaction_rakit'];
			}
				}
			$this->load->helper('form');
			$this->render->add_form('app/po_received_report/form', $data);
			$this->render->build('Registrasi');
			$this->render->add_view('app/po_received_report/transient_list', $data);
			$this->render->build('Data Panel');
			
			$this->render->show('Laporan Detail Per Mobil');
		}
		function detail_list_loader($registration_id=0)
			{
				if($registration_id == 0)send_json(make_datatables_list(null));
					$data = $this->po_received_report_model->detail_list_loader($registration_id);
					$sort_id = 0;
				foreach($data as $key => $value)
				{
				$data[$key] = array(
					form_transient_pair('transient_detail_registration_id', $value['product_name'],$value['detail_registration_id'],
				array(
						'transient_product_name' => $value['product_name'])),
						form_transient_pair('transient_transaction_detail_bongkar_komponen',show_checkbox_status($value['transaction_detail_bongkar_komponen']),$value['transaction_detail_bongkar_komponen']),
						form_transient_pair('transient_transaction_detail_lasketok',show_checkbox_status($value['transaction_detail_lasketok']),$value['transaction_detail_lasketok']),
						form_transient_pair('transient_transaction_detail_dempul', show_checkbox_status($value['transaction_detail_dempul']),$value['transaction_detail_dempul']),
						form_transient_pair('transient_transaction_detail_cat', show_checkbox_status($value['transaction_detail_cat']),$value['transaction_detail_cat']),
						form_transient_pair('transient_transaction_detail_poles', show_checkbox_status($value['transaction_detail_poles']),$value['transaction_detail_poles']),
						form_transient_pair('transient_transaction_detail_rakit', show_checkbox_status($value['transaction_detail_rakit']),$value['transaction_detail_rakit']),
						/*form_transient_pair('transient_transaction_detail_plain_first_date', $value['transaction_detail_plain_first_date']),
						form_transient_pair('transient_transaction_detail_plain_last_date', $value['transaction_detail_plain_last_date']),
						form_transient_pair('transient_transaction_detail_actual_date', $value['transaction_detail_actual_date']),
						form_transient_pair('transient_transaction_detail_target_date', $value['transaction_detail_target_date']),*/
						form_transient_pair('transient_transaction_detail_date', format_new_date($value['transaction_detail_date'])),
						form_transient_pair('transient_transaction_detail_description', $value['transaction_detail_description']),
						form_transient_pair('transient_transaction_detail_total', tool_money_format($value['transaction_detail_total']),$value['transaction_detail_total'])
					);
				}
				send_json(make_datatables_list($data));
			}
		
		
	
	function report($id = 0){
	
		if($id){
	   $this->load->model('global_model');
	   
	  	$data = $this->po_received_report_model->read_id($id);
		$data_detail = $this->po_received_report_model->detail_list_loader($id);
	   
	   $this->global_model->create_report_per_mobil('Laporan Detail Per Mobil', 'report/report_per_mobil.php', $data, $data_detail, 'header.php');
	}
	}

}
