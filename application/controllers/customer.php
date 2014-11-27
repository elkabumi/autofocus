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
		$this->render->build('Pelanggan');
		$this->render->show('Pelanggan');
	}
	
	function table_controller(){
		$data = $this->customer_model->list_controller();
		send_json($data);
	}
	
	function form($id = 0){
		$data = array();
		if($id==0){
			$data['row_id']					= '';
			$data['customer_ktp_number']	= '';
			$data['customer_name']			= '';
			$data['customer_addres']		= '';
			$data['customer_phone_number']	= '';
			$data['customer_hp']			= '';
			$data['customer_description']	= '';
		}else{
			$result = $this->customer_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
			}
		}

		$this->load->helper('form');
		$this->render->add_form('app/customer/form', $data);
		$this->render->build('Customer');
		$this->render->show('Customer');
		//$this->access->generate_log_view($id);
	}
	
	function form_action($is_delete = 0){
		
		$id = $this->input->post('row_id');
			
		if($is_delete){
			$is_proses_error = $this->customer_model->delete($id);
			
			send_json_action($is_proses_error, "Data telah dihapus");
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('i_ktp','Nomor Ktp', 'trim|required|max_length[15]');
		$this->form_validation->set_rules('i_name','Nama Pelanggan', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('i_addres','Alamat', 'trim|required');
		$this->form_validation->set_rules('i_phone','No Telepon', 'trim|required|is_numeric');
		$this->form_validation->set_rules('i_hp','No Handphone', 'trim|required|is_numeric');
		$this->form_validation->set_rules('i_description','Keterangan', 'trim|max_length[100]');
	
		
		if($this->form_validation->run() == FALSE) send_json_validate();
		
		$data['customer_ktp_number'] 				= $this->input->post('i_ktp');
		$data['customer_name'] 						= $this->input->post('i_name');
		$data['customer_addres'] 					= $this->input->post('i_addres');
		$data['customer_phone_number'] 				= $this->input->post('i_phone');
		$data['customer_hp']		 				= $this->input->post('i_hp');
		$data['customer_description'] 				= $this->input->post('i_description');
		
		
		if(empty($id)){
			
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