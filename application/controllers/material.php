<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Material extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('material_model');
		$this->load->library('access');
		$this->access->set_module('master.material');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/material/list');
		$this->render->build('Bahan');
		$this->render->show('Bahan');
	}
	
	function table_controller(){
		$data = $this->material_model->list_controller();
		send_json($data);
	}
	
	function form($id = 0){
		$this->load->model('global_model');
		$data = array();
		if($id==0){
			$data['row_id']				= '';
			$data['unit_id']			= '';
			
			$data['material_name']		= '';
			$data['material_type_id']	= '';
			$data['material_desc']		= '';
		}else{
			$result = $this->material_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
			}
		}
		$data['unit'] 				= $this->global_model->get_unit(1);
		$this->load->helper('form');
		$this->render->add_form('app/material/form', $data);
		$this->render->build('Bahan');
		$this->render->show('Bahan');
		//$this->access->generate_log_view($id);
	}
	
	function form_action($is_delete = 0){
		
		$id = $this->input->post('row_id');
			
		if($is_delete){
			$is_proses_error = $this->material_model->delete($id);
			
			send_json_action($is_proses_error, "Data telah dihapus");
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_name','Nama Cat', 'trim|required|max_length[200]');
	
		
		if($this->form_validation->run() == FALSE) send_json_validate();
		
		$data['material_name'] 				= $this->input->post('i_name');
		$data['unit_id'] 					= $this->input->post('i_unit_id');
		$data['material_desc'] 				= $this->input->post('i_description');
		$data['material_type_id'] 			= 1;
		
		
		if(empty($id)){
			
			$error = $this->material_model->create($data);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}else{
			$error = $this->material_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
		
	}
	function active(){
		$id = $this->input->post('row_id');
		
		$is_proses_error = $this->material_model->active($id);
			
		send_json_action($is_proses_error, "Data telah diaktifkan");
	}
}