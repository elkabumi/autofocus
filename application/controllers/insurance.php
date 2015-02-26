<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class insurance extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('insurance_model');
		$this->load->library('access');
		$this->access->set_module('master.insurance');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/insurance/list');
		$this->render->build('insurance');
		$this->render->show('insurance');
	}
	
	function table_controller(){
		$data = $this->insurance_model->list_controller();
		send_json($data);
	}
	
	
	function form($id = 0)
	{
		$data = array();
		if($id==0){
		
			
			$data['row_id'] = '';
			$data['insurance_date']			= date('d/m/Y');
			$data['insurance_id'] = '';
			$data['insurance_name'] = '';

			$data['insurance_description'] = '';
			$data['insurance_phone'] = '';
			$data['insurance_pph'] = '';
			$data['insurance_addres'] = '';	
		
		}else{
			$result = $this->insurance_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['insurance_date'] = format_new_date($data['insurance_date']);
		
			
			}
		}
		
		$this->load->helper('form');
			
		$this->render->add_form('app/insurance/form', $data);
		$this->render->build('Insurance');
		
		$this->render->add_view('app/insurance/transient_list');
		$this->render->build('product type');
		
	
		
		$this->render->add_view('app/insurance/transient_list2');
		$this->render->build('product type');
		
		$this->render->add_form('app/insurance/form_save', $data);
		$this->render->build('Insurance');
		
		$this->render->show('Insurance');
	}
	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if($is_delete)
		{
			$this->load->model('insurance_model');
			$id = $this->input->post('row_id');
			
			$check_used = $this->insurance_model->check_insurance($id);
			$fail = "PO Received tidak dapat dinonaktifkan karena ada Reservasi";
			if($check_used){
				$is_process_error = FALSE;
				
			} else {
				$is_process_error = $this->insurance_model->delete($id);
			}
			
			send_json_action($is_process_error, "Data telah dihapus", $fail);
		}
		
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
	
		// definisikan kriteria data
		
		$this->form_validation->set_rules('i_name','name','trim|required');
		$this->form_validation->set_rules('i_addres','Addres','trim|required');
		$this->form_validation->set_rules('i_phone','Phone','trim|required');
		$this->form_validation->set_rules('i_date','Date','trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_description','Description','trim|max_length[100]');
		$this->form_validation->set_rules('i_pph', 'PPh', 'trim|required|numeric');
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		
		
		$id = $this->input->post('row_id');
		$data['insurance_name'] 			= $this->input->post('i_name');
		$data['insurance_pph'] 			= $this->input->post('i_pph');
		$data['insurance_addres'] 			= $this->input->post('i_addres');	
		$data['insurance_phone']			= $this->input->post('i_phone');
		$data['insurance_date']				= $this->input->post('i_date');
		$data['insurance_description']			= $this->input->post('i_description');
	
		$data['created_by_id']				= $this->access->info['employee_id'];	
		
		
		$list_product_type_name		= $this->input->post('transient_product_type_name');
		$list_product_type_desc	= $this->input->post('transient_product_type_desc');
		
		$list_pst_name		= $this->input->post('transient_pst_name');
		$list_pst_description	= $this->input->post('transient_pst_description');
		
		
		



		$items = array();
		if($list_product_type_name){
		foreach($list_product_type_name as $key => $value)
		{
			
			$items[] = array(				
				'product_type_name'  => $list_product_type_name[$key],
				'product_type_desc'  => $list_product_type_desc[$key]

			);
			
			
			
		}
		}

		$item2 = array();
		if($list_pst_name){
		foreach($list_pst_name as $key => $value)
		{
			
			$item2[] = array(				
				'pst_name'  => $list_pst_name[$key],
				'pst_description'  => $list_pst_description[$key]

			);
			
			
			
		}
		}


		
	
		
		if(empty($id)) // jika tidak ada id maka create
		{ 
			
			$data['insurance_active_status'] 	= 1;
			$data['inactive_by_id'] 			= 0;
			$data['insurance_date'] 				= date("Y-m-d");
			$error = $this->insurance_model->create($data, $items,$item2);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$error = $this->insurance_model->update($id, $data, $items,$item2);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}		
	}
	
	
	function detail_list_loader($row_id=0)
	{
		if($row_id == 0)
		
		send_json(make_datatables_list(null)); 
				
		$data = $this->insurance_model->detail_list_loader($row_id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		$data[$key] = array(
				form_transient_pair('transient_product_type_name', $value['product_type_name']),
				form_transient_pair('transient_product_type_desc', $value['product_type_desc']),
				
		);
		
		
	
		}		
		send_json(make_datatables_list($data)); 
	}
	
	
	
	function detail_list_loader2($row_id=0)
	{
		if($row_id == 0)
		
		send_json(make_datatables_list(null)); 
				
		$data = $this->insurance_model->detail_list_loader2($row_id);
		
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		$data[$key] = array(
				form_transient_pair('transient_pst_name', $value['pst_name']),
				form_transient_pair('transient_pst_description', $value['pst_description']),
				
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
			$data['transaction_product_type_name'] 	= '';
			$data['transaction_product_type_desc'] 	= '';
		} else {
			
			$data['index']			= $index;
			$data['transaction_product_type_name'] 	= array_shift($this->input->post('transient_product_type_name'));
			$data['transaction_product_type_desc'] = array_shift($this->input->post('transient_product_type_desc'));
		}		
		
		$this->load->helper('form');
		
	
		$this->render->add_form('app/insurance/transient_form', $data);
		$this->render->show_buffer();
	}
	
	function detail_form2($transaction_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{		
		$this->load->library('render');
		$index = $this->input->post('transient_index');
		if (strlen(trim($index)) == 0) {
					
			// TRANSIENT CREATE - isi form dengan nilai default / kosong
			$data['index']			= '';
			$data['transient_pst_name'] 	= '';
			$data['transient_pst_description'] 	= '';
		} else {
			
			$data['index']			= $index;
			$data['transient_pst_name'] 	= array_shift($this->input->post('transient_pst_name'));
			$data['transient_pst_description'] = array_shift($this->input->post('transient_pst_description'));
		}		
		
		$this->load->helper('form');
		
	
		$this->render->add_form('app/insurance/transient_form2', $data);
		$this->render->show_buffer();
	}
	
	function detail_form_action()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_product_type_name', 'Material', 'trim|max_length[100]');
		//$this->form_validation->set_rules('i_product_type_desc','Description', 'trim|required');
	
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
	
		
		$no 		= $this->input->post('i_index');
		
		$product_type_desc	= $this->input->post('i_product_type_desc');
		$product_type_name	= $this->input->post('i_product_type_name');
		
		

		$data = array(
	
				form_transient_pair('transient_product_type_name', $product_type_name, $product_type_name),
				form_transient_pair('transient_product_type_desc', $product_type_desc,$product_type_desc)
		);
		 
		send_json_transient($index, $data);
	}
	
	function detail_form_action2()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_ist_name', 'Material', 'trim|max_length[100]');
	
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
	
		
		$no 		= $this->input->post('i_index');
		
		$i_pst_name	= $this->input->post('i_pst_name');
		$i_pst_description	= $this->input->post('i_pst_description');
		
		

		$data = array(
	
				form_transient_pair('transient_pst_name', $i_pst_name, $i_pst_name),
				form_transient_pair('transient_pst_description', $i_pst_description,$i_pst_description)
		);
		 
		send_json_transient($index, $data);
	}
	
	
	
	function active(){
		$id = $this->input->post('row_id');
		
		$is_proses_error = $this->insurance_model->active($id);
			
		send_json_action($is_proses_error, "Data telah diaktifkan");
	}

}
