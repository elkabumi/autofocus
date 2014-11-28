<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class car_model extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('car_model_model');
		$this->load->library('access');
		$this->access->set_module('master.car_model');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/car_model/list');
		$this->render->build('Model Mobil');
		$this->render->show('Model Mobil');
	}
	
	function table_controller(){
		$data = $this->car_model_model->list_controller();
		send_json($data);
	}
	
	function form($id = 0){
		$data = array();
		if($id==0){
			$data['row_id']					= '';
			$data['car_model_merk']			= '';
			$data['car_model_name']			= '';
			$data['car_model_description']	= '';
		}else{
			$result = $this->car_model_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
			}
		}

		$this->load->helper('form');
		$this->render->add_form('app/car_model/form', $data);
		$this->render->build('Model Mobil');
		$this->render->show('Model Mobil');
		//$this->access->generate_log_view($id);
	}
	
	function form_action($is_delete = 0){
		
		$id = $this->input->post('row_id');
			
		if($is_delete){
			$is_proses_error = $this->car_model_model->delete($id);
			
			send_json_action($is_proses_error, "Data telah dihapus");
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('i_merk','Vendor Mobil', 'trim|required');
		$this->form_validation->set_rules('i_name','Model Mobil', 'trim|required');
		
		if($this->form_validation->run() == FALSE) send_json_validate();
		
		$data['car_model_merk'] 						= $this->input->post('i_merk');
		$data['car_model_name'] 						= $this->input->post('i_name');
		$data['car_model_description'] 					= $this->input->post('i_description');
		
		
		if(empty($id)){
			
			$error = $this->car_model_model->create($data);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}else{
			$error = $this->car_model_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
		
	}
	function active(){
		$id = $this->input->post('row_id');
		
		$is_proses_error = $this->car_model_model->active($id);
			
		send_json_action($is_proses_error, "Data telah diaktifkan");
	}
}