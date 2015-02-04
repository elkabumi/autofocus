<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class product extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('product_model');
		$this->load->library('access');
		$this->access->set_module('master.product');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/product/list');
		$this->render->build('Item');
		$this->render->show('item');
	}
	
	function table_controller(){
		$data = $this->product_model->list_controller();
		send_json($data);
	}
	
	function form($id = 0){
		$data = array();
		if($id==0){
			$data['row_id']					= '';
			$data['product_code']			= format_code('products','product_code','P',7);
			$data['product_name']			= '';
			$data['insurance_id'] 			= '';
			$data['product_category_id']	= '';
			$data['product_description']	= '';
			$data['product_price']			= '';
			$data['product_date']			= date('d/m/Y');
		}else{
			$result = $this->product_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['product_date'] = format_new_date($data['product_date']);
			}
		}

		$this->load->helper('form');
		$this->render->add_form('app/product/form', $data);
		$this->render->build('Item');
		$this->render->show('Item');
		//$this->access->generate_log_view($id);
	}
	
	function form_action($is_delete = 0){
		
		$id = $this->input->post('row_id');
			
		if($is_delete){
			$is_proses_error = $this->product_model->delete($id);
			
			send_json_action($is_proses_error, "Data telah dihapus");
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('i_code','Item Code', 'trim|required|max_length[15]');
		$this->form_validation->set_rules('i_name','Item Name', 'trim|required|max_length[200]');
		
		$this->form_validation->set_rules('i_insurance_id','Asuransi', 'trim|required');
		$this->form_validation->set_rules('i_date','Create Date', 'trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_description','Description', 'trim|max_length[100]');
	
		
		if($this->form_validation->run() == FALSE) send_json_validate();
		
		$data['product_code'] 				= $this->input->post('i_code');
		$data['insurance_id'] 				= $this->input->post('i_insurance_id');
		//$data['product_price'] 				= $this->input->post('i_price');
		$data['product_name'] 				= $this->input->post('i_name');
		$data['product_category_id'] 		= 0;
		$data['product_qty'] 				= '';
		
		$data['product_description'] 		= $this->input->post('i_description');
		$data['product_date'] 				= $this->input->post('i_date');
		
		
		if(empty($id)){
		
			$data['product_active_status']	= 1;
			$data['created_by_id']			=  $this->access->info['employee_id'];
			
			$this->load->model('global_model');
			$check_code = $this->global_model->check_code('products', 'product_code', $data['product_code']);
			if($check_code){
				send_json_error("Simpan gagal. Code ".$data['product_code']." sudah ada, isi dengan code yang lain");
			}
			
			
			
			$error = $this->product_model->create($data);
			
			
			
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}else{
			$error = $this->product_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
		
	}
	function active(){
		$id = $this->input->post('row_id');
		
		$is_proses_error = $this->product_model->active($id);
			
		send_json_action($is_proses_error, "Data telah diaktifkan");
	}
}