<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Approved extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('approved_model');
		$this->load->library('access');
		$this->access->set_module('master.approved');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/approved/list');
		$this->render->build('Data Registrasi');
		$this->render->show('Data Registrasi');
	}
	
	function table_controller(){
		$data = $this->approved_model->list_controller();
		send_json($data);
	}
	
	
	function form_approved($id = 0)
	{
		$data = array();
		
			$result = $this->approved_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = '';//$id;
				$data['row2_id'] = $id;
				$data['check_in'] = format_new_date($data['check_in']);
				$data['transaction_estimation_date'] = format_new_date($data['transaction_estimation_date']);
		
			
			}
		
		
		$this->load->helper('form');
			
		$this->render->add_form('app/approved/form', $data);
		$this->render->build('Transaksi Penjualan User');
		
		$this->render->add_view('app/approved/transient_list', $data);
		$this->render->build('Data Panel');
		
		$this->render->show('approved');
	}
	
	function form_report($id = 0)
	{
		$data = array();
		
			$result = $this->approved_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['row2_id'] = $id;
				$data['check_in'] = format_new_date($data['check_in']);
				$data['transaction_estimation_date'] = format_new_date($data['transaction_estimation_date']);
		
			
			}
		
		
		$this->load->helper('form');
			
		$this->render->add_form('app/approved/form_report', $data);
		$this->render->build('Registrasi');
		
		$this->render->add_view('app/approved/transient_list_report', $data);
		$this->render->build('Data Panel');
		
		$this->render->show('Cetak Laporan');
	}
	
	function detail_list_loader($transaction_id=0)
	{
		if($transaction_id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->approved_model->detail_list_loader($transaction_id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		
		$data[$key] = array(
				form_transient_pair('transient_product_id', $value['product_code'], $value['product_id']),
				form_transient_pair('transient_product_name', $value['product_name']),
				form_transient_pair('transient_transaction_detail_price', tool_money_format($value['detail_transaction_price']), $value['detail_transaction_price']),
				form_transient_pair('transient_transaction_detail_qty', $value['detail_transaction_qty'], $value['detail_transaction_qty']),
				form_transient_pair('transient_transaction_detail_total_price', tool_money_format($value['detail_transaction_total_price']), $value['detail_transaction_total_price'])
		);
		
		
		
		}		
		send_json(make_datatables_list($data)); 
	}
	
	function form_approved_action($is_delete = 0){
		
		$id = $this->input->post('row2_id');
			
	
			$error = $this->approved_model->approved($id);
			send_json_action($error, "Simpan Berhasil, Data telah disetujui", "Data gagal direvisi");
		
		
	}

}
