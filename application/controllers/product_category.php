<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class product_category extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->access->set_module('master.product_category');
		$this->access->user_page();
		$this->load->model('product_category_model');
		$this->access->user_page();		
	}
	
	function index()
	{
		$this->load->library('render');
		$this->render->add_view('app/product_category/list');
		$this->render->build('Data product Category');
	//	$this->access->generate_log_view();
		$this->render->show('Item Category');
		
	}
	function table_controller(){
		$data = $this->product_category_model->list_controller();
		send_json($data);
	}
	
	function form() // jika id tidak diisi maka dianggap create, else dianggap edit
	{
		$id = $this->input->post('row_id');
		$data = array();
		$this->load->library('render');		
		if ($id == 0) {
			
			// FORM CREATE - isi form dengan nilai default / kosong
			$data['row_id'] = '';
			$data['i_name'] = '';//format_code('product_categories','product_category_code','',3);
			$data['i_description'] = '';
			$data['i_use_stock'] = 1;
			
		} else {
			
			// FORM UPDATE - ambil data yang diedit kemudian tampilkan dalam form			
			$result = $this->product_category_model->read_id($id);
			
			if ($result) // cek dulu apakah data dproductukan 
			{
				$data['row_id'] = $result['product_category_id'];
				$data['i_name'] = $result['product_category_name'];
				$data['i_description'] = $result['product_category_description'];		
				$data['i_use_stock'] = $result['product_category_use_stock'];		
			}
		}
		
		$this->render->add_form('app/product_category/form', $data);
		$this->render->show_buffer();
	}
	
	// BUSINESS TYPE LIST FORM ACTION -- action untuk form diatas
	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation'); // selalu ada di _action()
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if ($is_delete)
		{		
			$id = $this->input->post('row_id');
			$is_process_error = $this->product_category_model->delete($id);
			send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
		} 
		
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
		
		// cek dulu data yang masuk
		$this->form_validation->set_rules('i_name', 'Name', 'trim|required'); // gunakan selalu trim di awal
		$this->form_validation->set_rules('i_use_stock','Use stock', 'trim');
		$this->form_validation->set_rules('i_description','Description', 'trim|max_length[100]');
	
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); // bila input tidak valid, exit dan kirim kesalahan
		
		// bila id tidak disebutkan berarti create, sebaliknya update
		$id = $this->input->post('row_id');
		
		if (empty($id)) // id empty, lakukan proses CREATE
		{
			$data['product_category_active_status']		= 1;
			$data['created_by_id']			=  $this->access->info['employee_id'];
			$data['product_category_name'] = $this->input->post('i_name');
			$data['product_category_use_stock'] = $this->input->post('i_use_stock');
			$data['product_category_description'] = $this->input->post('i_description');
			$data['product_categories_date']	= date('Y-m-d');
			$error = $this->product_category_model->create($data);
			
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			
			// map input ke kolom database
			$data['product_category_name'] = $this->input->post('i_name');
			$data['product_category_description'] = $this->input->post('i_description');
			$data['product_category_use_stock'] = $this->input->post('i_use_stock');
			$error = $this->product_category_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
				
	}	
	function active(){
		$id = $this->input->post('row_id');
		
		$is_proses_error = $this->product_category_model->active($id);
			
		send_json_action($is_proses_error, "Data telah diaktifkan");
	}
}

#
