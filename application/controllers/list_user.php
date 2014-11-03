<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_user extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('user_model');
		$this->load->library('access');
		$this->access->set_module('dashboard.list User On');
	}
	
	function index(){
		
		$this->render->add_view('app/user_list/list');
		$this->render->build('List user On');
		$this->render->show('List User On');
	}
	
	function table_controller(){
		
		$data = $this->user_model->user_on_controller(get_datatables_control());
		send_json($data); 
	}
}
?>