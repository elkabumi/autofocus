<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class warehouse extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('warehouse_model');
		$this->load->library('access');
		$this->access->set_module('inventory.warehouse');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/warehouse/list');
		$this->render->build('Gudang');
		$this->render->show('Gudang');
		
	}

	
	function table_controller(){
		$data = $this->warehouse_model->list_controller();
		send_json($data);
	}
	
	
	function form($id = 0){
		$data = array();
		if($id==0){
		
			
			$data['row_id'] = '';
			$data['name'] = '';
			$data['qty'] = '';
			$data['received'] = '';
			$data['date'] = '';
			$data['desc'] = '';
		
		}else{
			$result = $this->warehouse_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
			
			}
		}
		
		$this->load->helper('form');
			
		$this->render->add_form('app/warehouse/form', $data);
		$this->render->build('Gudang');
		
		$this->render->add_view('app/deposit/transient_list');
		$this->render->build('history');
		
		$this->render->build('Gudang');
		$this->render->show('Gudang');
	}
	function detail_list_loader($id=0)
	{
		if($id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->warehouse_model->detail_list_loader($id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		switch($value['tpdh_type']){
			case '1':
				$type = 'Create PO'; 
			break;
			case '2':
				$type = 'Received';
			break;
			case '3':
				$type = 'Pemasangan';
			break;
		}
		$data[$key] = array(
				
				form_transient_pair('transient_history_date', $value['tpdh_date']),
				form_transient_pair('transient_history_type', $type,$value['tpdh_type']),
				form_transient_pair('transient_history_qty',$value['tpdh_qty']),
		);
		
		
		
		}		
		send_json(make_datatables_list($data)); 
	}
	
	
}
