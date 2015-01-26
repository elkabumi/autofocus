<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class price extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('price_model');
		$this->load->library('access');
		$this->access->set_module('master.price');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/price/list');
		$this->render->build('Price');
		$this->render->show('Price');
		
	}
	
	function table_controller(){
		$data = $this->price_model->list_controller();
		send_json($data);
	}
	
	
	function form($id = 0)
	{
		$data = array();
			$result = $this->price_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
			
		}
		$list = $this->price_model->get_kolom_price($id);
		$data_product = $this->price_model->load_product($id);
		
		$this->load->helper('form');
			
		$this->render->add_form('app/price/form', $data);
		$this->render->build('Price ');
		
		$this->render->add_view('app/price/transient_list',  array('list' => $list, 'data_product' => $data_product));
		$this->render->build('Price');
		
		$this->render->add_form('app/price/form_save', $data);
		$this->render->build('Price');
		
		$this->render->show('Price');
	}
	
	function form_proses($product_id = 0)
	{
		$data = array();
			
				$list = $this->price_model->get_price($product_id);
				
				$no = 0;
				foreach($list as $item): 
          			
					$data['subject_id'][$no] = $item['product_price_id'];
					$data['subject_name'][$no] = $item['product_type_name']." (".$item['pst_name'].")";
					$data['subject_type'][$no] = $item['product_type_id'];
					$data['subject_sub_type'][$no] = $item['pst_id'];
					$data['subject_value'][$no] = $item['product_price'];
    				$no++;
					
			 	endforeach; 
				$data['no'] = $no;
				$data['row_id'] = $product_id;
				
				$get_insurance = $this->price_model->get_insurance($product_id);
				
				$data['insurance_id'] = $get_insurance;
				
					
		$this->load->helper('form');
		$this->render->add_form('app/price/form_proses', $data);
		$this->render->build('Edit Harga');
		$this->render->show('Edit Harga');
		
	}
	
	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation'); // selalu ada di _action()
		$id = $this->input->post('row_id');
		
		// cek dulu data yang masuk
		$no = $this->input->post('i_no');
		
		for($i=0; $i<$no; $i++){
		$this->form_validation->set_rules('i_subject_value'.$i, 'Harga '.($i+1), 'trim|required|is_numeric'); // gunakan selalu trim di awal
		}
		
		for($u=0; $u<$no; $u++){
			$items['subject_id'][$u] = $this->input->post('i_subject_id'.$u);
			$items['subject_value'][$u] = $this->input->post('i_subject_value'.$u);
		}
		
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); // bila input tidak valid, exit dan kirim kesalahan
			
		
			$error = $this->price_model->update($id, $items, $no);
			send_json_action($error, "Data telah direvisi", "Data telah direvisi", $this->input->post('i_insurance_id'));
		
		
	}
	
	
	
	
	
	
	function active(){
		$id = $this->input->post('row_id');
		
		$is_proses_error = $this->price_model->active($id);
			
		send_json_action($is_proses_error, "Data telah diaktifkan");
	}

}
