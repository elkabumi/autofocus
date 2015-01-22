<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Transaction_status extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('transaction_status_model');
		$this->load->library('access');
		$this->access->set_module('master.transaction_status');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/transaction_status/list');
		$this->render->build('Data Status');
		$this->render->show('Data Status');
	}
	
	function table_controller(){
		$data = $this->transaction_status_model->list_controller();
		send_json($data);
	}
	
	
	function form_transaction_status($id = 0)
	{
		$data = array();
		
			$result = $this->transaction_status_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = '';//$id;
				$data['row2_id'] = $id;
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
		
			
			}
		
		
		$this->load->helper('form');
			
		$this->render->add_form('app/transaction_status/form', $data);
		$this->render->build('Transaksi Penjualan User');
		
		$this->render->add_view('app/transaction_status/transient_list', $data);
		$this->render->build('Data Panel');
		
		$this->render->show('transaction_status');
	}
	
	function form_report($id = 0)
	{
		$data = array();
		
			$result = $this->transaction_status_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['row2_id'] = $id;
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
		
			
			}
		
		
		$this->load->helper('form');
			
		$this->render->add_form('app/transaction_status/form_report', $data);
		$this->render->build('Registrasi');
		
		$this->render->add_view('app/transaction_status/transient_list_report', $data);
		$this->render->build('Data Panel');
		
		$this->render->show('Cetak Laporan');
	}
	
	function detail_list_loader($registration_id=0)
	{
		if($registration_id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->transaction_status_model->detail_list_loader($registration_id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		
		$data[$key] = array(
				form_transient_pair('transient_product_id', $value['product_code'], $value['product_id']),
				form_transient_pair('transient_product_name', $value['product_name']),
				form_transient_pair('transient_registration_detail_price', tool_money_format($value['detail_registration_price']), $value['detail_registration_price']),
				form_transient_pair('transient_registration_detail_qty', $value['detail_registration_qty'], $value['detail_registration_qty']),
				form_transient_pair('transient_registration_detail_total_price', tool_money_format($value['detail_registration_total_price']), $value['detail_registration_total_price'])
		);
		
		
		
		}		
		send_json(make_datatables_list($data)); 
	}
	
	function form_transaction_status_action($is_delete = 0){
		
		$id = $this->input->post('row2_id');
			
	
			$error = $this->transaction_status_model->transaction_status($id);
			send_json_action($error, "Simpan Berhasil, Data telah disetujui", "Data gagal direvisi");
		
		
	}

}
