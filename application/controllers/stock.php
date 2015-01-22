<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('stock_model');
		$this->load->library('access');
		$this->access->set_module('master.stock_product');
		
	}
	
	function index(){
		
		$this->render->add_view('app/stock/list');
		$this->render->build('Data Stok');
		$this->render->show('Data Stok');
	}
	
	function table_controller(){
		$data = $this->stock_model->list_controller();
		send_json($data);
	}
	
	function form($id = 0){
		$data = array();
		if($id==0){
			$data['row_id'] = '';
			$data['product_code']		= format_code('product_stocks','product_stock_kode','P',5);
			$data['product_stock_name']		= '';
			$data['product_stock_jumlah']		= '';
			$data['product_stock_description']			= '';
		}else{
			$result = $this->stock_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				
			}
		}
		
		$this->load->helper('form');
		$this->render->add_form('app/stock/form', $data);
		$this->render->build('Stok');
		$this->render->show('Stok');
		//$this->access->generate_log_view($id);
	}
	
	function form_action($is_delete = 0){
		
		$id = $this->input->post('row_id');
			
		if($is_delete){
			$is_proses_error = $this->stock_model->delete($id);
			
			send_json_action($is_proses_error, "Data telah dihapus");
		}
		
		$this->load->library('form_validation');
		
		
		$this->form_validation->set_rules('i_qty','Jumlah', 'trim|required|numeric');
	
		
		if($this->form_validation->run() == FALSE) send_json_validate();
		
		
		$data['product_stock_qty'] 			= $this->input->post('i_qty');
		
		
		if(empty($id)){			
			$error = $this->stock_model->create($data);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}else{
			$error = $this->stock_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
		
	}
}