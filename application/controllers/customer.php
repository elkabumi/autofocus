<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('customer_model');
		$this->load->library('access');
		$this->access->set_module('master.customer');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/customer/list');
		$this->render->build('Item');
		$this->render->show('item');
	}
	
	function table_controller(){
		$data = $this->customer_model->list_controller();
		send_json($data);
	}
	
	function form($id = 0){
		$data = array();
		if($id==0){
			$data['row_id']					= '';
			$data['customer_ktp_number']			= '';
			$data['customer_name']			= '';
			$data['customer_addres']	= '';
			$data['customer_phone_number']	= '';
			$data['customer_description']			= '';
		}else{
			$result = $this->customer_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
			}
		}

		$this->load->helper('form');
		$this->render->add_form('app/customer/form', $data);
		$this->render->build('Item');
		$this->render->show('Item');
		//$this->access->generate_log_view($id);
	}
	
	function form_action($is_delete = 0){
		
		$id = $this->input->post('row_id');
			
		if($is_delete){
			$is_proses_error = $this->customer_model->delete($id);
			
			send_json_action($is_proses_error, "Data telah dihapus");
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('i_code','Item Code', 'trim|required|max_length[15]');
		$this->form_validation->set_rules('i_name','Item Name', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('i_category_id','Item Category', 'trim|required');
		$this->form_validation->set_rules('i_date','Create Date', 'trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_description','Description', 'trim|max_length[100]');
	
		
		if($this->form_validation->run() == FALSE) send_json_validate();
		
		$data['customer_code'] 				= $this->input->post('i_code');
		$data['insurance_id'] 				= $this->input->post('i_insurance_id');
		//$data['customer_price'] 				= $this->input->post('i_price');
		$data['customer_name'] 				= $this->input->post('i_name');
		$data['customer_category_id'] 		= $this->input->post('i_category_id');
		$data['customer_qty'] 				= '';
		$data['customer_category_id'] 		= $this->input->post('i_category_id');
		$data['customer_description'] 		= $this->input->post('i_description');
		$data['customer_date'] 				= $this->input->post('i_date');
		
		
		if(empty($id)){
		
			$data['customer_active_status']	= 1;
			$data['created_by_id']			=  $this->access->info['employee_id'];
			
			$this->load->model('global_model');
			$check_code = $this->global_model->check_code('customers', 'customer_code', $data['customer_code']);
			if($check_code){
				send_json_error("Simpan gagal. Code ".$data['customer_code']." sudah ada, isi dengan code yang lain");
			}
			
			$error = $this->customer_model->create($data);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}else{
			$error = $this->customer_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
		
	}
	function active(){
		$id = $this->input->post('row_id');
		
		$is_proses_error = $this->customer_model->active($id);
			
		send_json_action($is_proses_error, "Data telah diaktifkan");
	}
}