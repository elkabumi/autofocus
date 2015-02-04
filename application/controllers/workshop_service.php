<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workshop_service extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('workshop_service_model');
		$this->load->library('access');
		$this->access->set_module('master.workshop_service');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/workshop_service/list');
		$this->render->build('Harga Borongan');
		$this->render->show('Harga Borongan');
	}
	
	function table_controller(){
		$data = $this->workshop_service_model->list_controller();
		send_json($data);
	}
	
	function form($id = 0){
		$data = array();
		if($id==0){
			$data['row_id']							= '';
			$data['workshop_service_name']			= '';
			$data['workshop_service_price']			= '';
			$data['workshop_service_job_price']		= '';
			$data['workshop_service_description']	= '';
			$data['workshop_service_price']			= '';
			$data['workshop_service_date']			= date('d/m/Y');
		}else{
			$result = $this->workshop_service_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['workshop_service_date'] = format_new_date($data['workshop_service_date']);
			}
		}

		$this->load->helper('form');
		$this->render->add_form('app/workshop_service/form', $data);
		$this->render->build('Harga Borongan');
		$this->render->show('Harga Borongan');
		//$this->access->generate_log_view($id);
	}
	
	function form_action($is_delete = 0){
		
		$id = $this->input->post('row_id');
			
		if($is_delete){
			$is_proses_error = $this->workshop_service_model->delete($id);
			
			send_json_action($is_proses_error, "Data telah dihapus");
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('i_name','Item Name', 'trim|required|max_length[200]');
		
		$this->form_validation->set_rules('i_price','Harga', 'trim|required|is_numeric');
		$this->form_validation->set_rules('i_job_price','Harga Borongan', 'trim|required|is_numeric');
		//$this->form_validation->set_rules('i_date','Create Date', 'trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_description','Description', 'trim|max_length[100]');
	
		
		if($this->form_validation->run() == FALSE) send_json_validate();
		
		
		
		$data['workshop_service_price'] 			= $this->input->post('i_price');
		$data['workshop_service_job_price'] 			= $this->input->post('i_job_price');
		$data['workshop_service_name'] 				= $this->input->post('i_name');
		
		$data['workshop_service_description'] 		= $this->input->post('i_description');
		$data['workshop_service_date'] 				= date("Y-m-d");//$this->input->post('i_date');
		
		
		if(empty($id)){
		
			$data['workshop_service_active_status']	= 1;
			$data['created_by_id']			=  $this->access->info['employee_id'];
			
			
			$error = $this->workshop_service_model->create($data);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}else{
			$error = $this->workshop_service_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
		
	}
	function active(){
		$id = $this->input->post('row_id');
		
		$is_proses_error = $this->workshop_service_model->active($id);
			
		send_json_action($is_proses_error, "Data telah diaktifkan");
	}
}