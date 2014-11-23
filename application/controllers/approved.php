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
	
	
	function form($id = 0)
	{
		$data = array();
		if($id==0){
		
			
			$data['row_id'] = '';
			$data['approved_date']			= date('d/m/Y');
			$data['approved_id'] = '';
			$data['approved_name'] = '';

			$data['approved_description'] = '';
			$data['approved_phone'] = '';
			$data['approved_addres'] = '';	
		
		}else{
			$result = $this->approved_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['approved_date'] = format_new_date($data['approved_date']);
		
			
			}
		}
		
		$this->load->helper('form');
			
		$this->render->add_form('app/approved/form', $data);
		$this->render->build('approved');
		
		$this->render->add_view('app/approved/transient_list');
		$this->render->build('product type');
		
	
		
		$this->render->add_view('app/approved/transient_list2');
		$this->render->build('product type');
		
		$this->render->add_form('app/approved/form_save', $data);
		$this->render->build('approved');
		
		$this->render->show('approved');
	}
	

}
