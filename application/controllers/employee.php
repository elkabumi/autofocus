<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('employee_model');
		$this->load->library('access');
		$this->access->set_module('master.employee');
	}
	
	function index(){
		
		$this->render->add_view('app/employee/list');
		$this->render->build('Data Pegawai');
		$this->render->show('Pegawai');
	}
	
	function table_controller(){
		$data = $this->employee_model->list_controller();
		send_json($data);
	}
	
	function form($id = 0){
		$data = array();
		if($id==0){
			$data['row_id']					= '';
			$data['employee_nip']			= format_code('employees','employee_nip','E',7);
			$data['employee_name']			= '';
			$data['employee_birth']			= '';
			$data['employee_gender']		= '';
			$data['employee_position_id']	= '';
			$data['employee_ktp']			= '';
			$data['employee_address']		= '';
			$data['employee_phone']			= '';
			$data['employee_email']			= '';
			$data['employee_bank_number']	= '';
			$data['employee_bank_name']		= '';
			$data['employee_bank_beneficiary']	= '';
		
		}else{
			$result = $this->employee_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['employee_birth'] = date('d/m/Y', strtotime($data['employee_birth']));
			}
		}

		$this->load->helper('form');
		$this->render->add_form('app/employee/form', $data);
		$this->render->build('Pegawai');
		$this->render->show('Pegawai');
		//$this->access->generate_log_view($id);
	}
	
	function form_action($is_delete = 0){
		
		$id = $this->input->post('row_id');
			
		if($is_delete){
			$is_proses_error = $this->employee_model->delete($id);
			send_json_action($is_proses_error, "Data telah dihapus");
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('i_nip','NIK', 'trim|min_length[3]|max_length[50]|required');
		$this->form_validation->set_rules('i_name','Nama', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('i_birth','Tanggal Lahir', 'trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_gender','Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('i_position_id','Jabatan', 'trim|required');
		$this->form_validation->set_rules('i_ktp','KTP', 'trim|required');
		$this->form_validation->set_rules('i_phone','No Telepon', 'trim|required');
		$this->form_validation->set_rules('i_email','Email', 'trim|required');
		$this->form_validation->set_rules('i_address','Alamat', 'trim|required');
		$this->form_validation->set_rules('i_bank_number','Rekening Bank', 'trim|required');
		$this->form_validation->set_rules('i_bank_name','Nama Bank', 'trim|required');
		$this->form_validation->set_rules('i_bank_beneficiary','Atas Nama', 'trim|required');
		
		if($this->form_validation->run() == FALSE) send_json_validate();
		
		$data['employee_nip'] 					= $this->input->post('i_nip');
		$data['employee_name'] 					= $this->input->post('i_name');
		$data['employee_birth'] 				= $this->input->post('i_birth');
		$data['employee_gender'] 				= $this->input->post('i_gender');
		$data['employee_position_id'] 			= $this->input->post('i_position_id');
		$data['employee_ktp'] 					= $this->input->post('i_ktp');
		$data['employee_address'] 				= $this->input->post('i_address');
		$data['employee_phone'] 				= $this->input->post('i_phone');
		$data['employee_email'] 				= $this->input->post('i_email');
		$data['employee_bank_number'] 			= $this->input->post('i_bank_number');
		$data['employee_bank_name'] 			= $this->input->post('i_bank_name');
		$data['employee_bank_beneficiary'] 		= $this->input->post('i_bank_beneficiary');
		


		
		if(empty($id)){
			$data['employee_active_status'] 					= 1;
			//$data['employee_nip']			= format_code('employees','employee_nip','E',7);
			$error = $this->employee_model->create($data);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}else{
			$error = $this->employee_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
		
	}
	
	
	
}
