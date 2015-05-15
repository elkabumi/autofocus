<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class warehouse_material extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('warehouse_material_model');
		$this->load->library('access');
		$this->access->set_module('inventory.warehouse_material');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/warehouse_material/list');
		$this->render->build('Gudang Bahan');
		$this->render->show('Gudang Bahan');
		
	}

	
	function table_controller(){
		$data = $this->warehouse_material_model->list_controller();
		send_json($data);
	}
	
	
	function form($id = 0){
		$data = array();
		if($id==0){
		
			
			$data['row_id'] = '';
			$data['material_id'] = '';
			$data['stand_id'] = '';
			$data['material_stock_qty'] = '';
			$data['unit_name'] = '';
		
		}else{
			$result = $this->warehouse_material_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
		
			}
		}
		
		$this->load->helper('form');
			
		$this->render->add_form('app/warehouse_material/form', $data);
		$this->render->build('Gudang');
		$this->render->show('Gudang');
	}
	function form_action($is_delete = 0){
		
		$id = $this->input->post('row_id');
			
		if($is_delete){
			$is_proses_error = $this->warehouse_material_model->delete($id);
			
			send_json_action($is_proses_error, "Data telah dihapus");
		}
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('i_material_id','Nama Bahan', 'trim|required');
		$this->form_validation->set_rules('i_stand_id','Nama stand', 'trim|required');
		$this->form_validation->set_rules('i_qty','QTY', 'trim|required|numeric|min_value[1]');
	
		
		if($this->form_validation->run() == FALSE) send_json_validate();
		
		$data['material_id'] 				= $this->input->post('i_material_id');
		$data['stand_id'] 					= $this->input->post('i_stand_id');
		$data['material_stock_qty'] 		= $this->input->post('i_qty');
		
		$cek_gudang=$this->warehouse_material_model->cek_gudang($data['material_id'],$data['stand_id']);
		if($cek_gudang == '1'){
			send_json_error("Bahan sudah ada");
		}
		
		if(empty($id)){
			
			$error = $this->warehouse_material_model->create($data);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}else{
			$error = $this->warehouse_material_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
		
	}
	function load_satuan()
	{
		$id 	= $this->input->post('id');
		
		$query = $this->warehouse_material_model->load_satuan($id);
		$data = array();
		
		foreach($query->result_array() as $row)
		{
		
			$data['unit_name'] 		= $row['unit_name'];
		
			
		}
		send_json_message('Satuan', $data);
	}
	
	
}
