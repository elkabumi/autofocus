<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class car extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('car_model');
		$this->load->library('access');
		$this->access->set_module('master.car');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/car/list');
		$this->render->build('Data Mobil');
		$this->render->show('Data Mobil');
	}
	
	function table_controller(){
		$data = $this->car_model->list_controller();
		send_json($data);
	}
	
	function form($id = 0){
		$data = array();
		if($id==0){
			$data['row_id']				= '';
			$data['car_nopol']			= '';
			$data['car_model_id']		= '';
			$data['car_no_machine']		= '';
			$data['car_no_rangka']		= '';
			$data['car_color']			= '';
			$data['car_type']			= '';
			$data['car_year']			= '';
			$data['car_description']	= '';
		}else{
			$result = $this->car_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
			}
		}
		
		$this->load->helper('form');
		$this->render->add_form('app/car/form', $data);
		$this->render->build('Mobil');
		$this->render->show('Mobil');
		//$this->access->generate_log_view($id);
	}
	
	function form_action($is_delete = 0){
		
		$id = $this->input->post('row_id');
			
		if($is_delete){
			$is_proses_error = $this->car_model->delete($id);
			
			send_json_action($is_proses_error, "Data telah dihapus");
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('i_nopol','Nopol', 'trim|required|max_length[15]');
		$this->form_validation->set_rules('i_car_model_id','Model', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('i_no_machine','No Mesin', 'trim|required');
		$this->form_validation->set_rules('i_no_rangka','No Rangka', 'trim|required');
		$this->form_validation->set_rules('i_color','Warna', 'trim|required');
		$this->form_validation->set_rules('i_type','Tipe Mobil', 'trim|required');
		$this->form_validation->set_rules('i_year','Tahun', 'trim|required');
		$this->form_validation->set_rules('i_description','Description', 'trim');
	
		
		if($this->form_validation->run() == FALSE) send_json_validate();
		
		$data['car_nopol'] 				= $this->input->post('i_nopol');
		$data['car_model_id']	 		= $this->input->post('i_car_model_id');
		$data['car_no_machine'] 		= $this->input->post('i_no_machine');
		$data['car_no_rangka'] 			= $this->input->post('i_no_rangka');
		$data['car_color'] 				= $this->input->post('i_color');
		$data['car_type'] 				= $this->input->post('i_type');
		$data['car_year'] 				= $this->input->post('i_year');
		$data['car_description'] 		= $this->input->post('i_description');
		
		
		if(empty($id)){			
			$error = $this->car_model->create($data);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}else{
			$error = $this->car_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
		
	}
}