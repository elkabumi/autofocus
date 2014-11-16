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
		$data['detail'] = $this->price_model->get_kolom_price($id);
		
		$this->load->helper('form');
			
		$this->render->add_form('app/price/form', $data);
		$this->render->build('Price ');
		
		$this->render->add_view('app/price/transient_list',$data);
		$this->render->build('Price');
		
		$this->render->add_form('app/price/form_save', $data);
		$this->render->build('Price');
		
		$this->render->show('Price');
	}
	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if($is_delete)
		{
			$this->load->model('price_model');
			$id = $this->input->post('row_id');
			
			$check_used = $this->price_model->check_price($id);
			$fail = "PO Received tidak dapat dinonaktifkan karena ada Reservasi";
			if($check_used){
				$is_process_error = FALSE;
				
			} else {
				$is_process_error = $this->price_model->delete($id);
			}
			
			send_json_action($is_process_error, "Data telah dihapus", $fail);
		}
		
		
		$id = $this->input->post('row_id');

		
		$list_ist_name		= $this->input->post('transient_ist_name');
		$list_ist_description	= $this->input->post('transient_ist_description');
		
		
		

		$items = array();
		if($list_ist_name){
		foreach($list_ist_name as $key => $value)
		{
			
			$items[] = array(				
				'ist_name'  => $list_ist_name[$key],
				'ist_description'  => $list_ist_description[$key]

			);
			
			
			
		}
		}

		


		
	
		

			$error = $this->price_model->update($id, $items);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi", $id);
		
	}
	
	
	function detail_list_loader($row_id=0)
	{
		if($row_id == 0)
	
		
		
		
		
		
		send_json(make_datatables_list(null)); 
				
		$data = $this->price_model->detail_list_loader($row_id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		$data[$key] = array(
				form_transient_pair('transient_ist_name', $value['pst_name']),
				form_transient_pair('transient_ist_description', $value['pst_description']),
				
		);
		
		
	
		}		
		send_json(make_datatables_list($data)); 
	}
	
	
	
	function detail_form($transaction_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{		
		$this->load->library('render');
		$index = $this->input->post('transient_index');
		if (strlen(trim($index)) == 0) {
					
			// TRANSIENT CREATE - isi form dengan nilai default / kosong
			$data['index']			= '';
			$data['transient_ist_name'] 	= '';
			$data['product_category_id'] 	= '';
			
			$data['transient_ist_description'] 	= '';
		} else {
			
			$data['index']			= $index;
			$data['transient_ist_name'] 	= array_shift($this->input->post('transient_ist_name'));
			$data['transient_ist_description'] = array_shift($this->input->post('transient_ist_description'));
		}		
		
		$this->load->helper('form');
		
	
		$this->render->add_form('app/price/transient_form', $data);
		$this->render->show_buffer();
	}
	function detail_form_action()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_ist_name', 'Material', 'trim|max_length[100]');
	
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
	
		
		$no 		= $this->input->post('i_index');
		
		$i_ist_name	= $this->input->post('i_ist_name');
		$i_ist_description	= $this->input->post('i_ist_description');
		
		

		$data = array(
	
				form_transient_pair('transient_ist_name', $i_ist_name, $i_ist_name),
				form_transient_pair('transient_ist_description', $i_ist_description,$i_ist_description)
		);
		 
		send_json_transient($index, $data);
	}
	

	
	
	
	function active(){
		$id = $this->input->post('row_id');
		
		$is_proses_error = $this->price_model->active($id);
			
		send_json_action($is_proses_error, "Data telah diaktifkan");
	}

}
