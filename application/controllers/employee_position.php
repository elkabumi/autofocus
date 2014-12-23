<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class Employee_position extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->access->set_module('master.employee_position');
		$this->access->user_page();
		$this->load->model('employee_position_model');
				
	}
	
	function index()
	{
		$this->load->library('render');
		$this->render->add_view('app/employee_position/list');
		$this->render->build('Data Jabatan Pegawai');
	//	$this->access->generate_log_view();
		$this->render->show('Jabatan Pegawai');
		
	}
	function list_loader()
	{
		$data = $this->employee_position_model->list_loader();
		send_json(make_datatables_list($data)); 
	}
	
	function form() // jika id tidak diisi maka dianggap create, else dianggap edit
	{
		$id = $this->input->post('row_id');
		$data = array();
		$this->load->library('render');		
		if ($id == 0) {
			
			// FORM CREATE - isi form dengan nilai default / kosong
			$data['row_id'] = '';
			$data['i_name'] = '';//format_code('product_categories','employee_position_code','',3);
			$data['i_description'] = '';
			
		} else {
			
			// FORM UPDATE - ambil data yang diedit kemudian tampilkan dalam form			
			$result = $this->employee_position_model->read_id($id);
			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data['row_id'] = $result['employee_position_id'];
				$data['i_name'] = $result['employee_position_name'];
				$data['i_description'] = $result['employee_position_description'];		
			}
		}
		
		$this->render->add_form('app/employee_position/form', $data);
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
			$is_process_error = $this->employee_position_model->delete($id);
			send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
		} 
		
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
		
		// cek dulu data yang masuk
		$this->form_validation->set_rules('i_name', 'Nama', 'trim|required'); // gunakan selalu trim di awal
	
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); // bila input tidak valid, exit dan kirim kesalahan
		
		// bila id tidak disebutkan berarti create, sebaliknya update
		$id = $this->input->post('row_id');
		
		if (empty($id)) // id empty, lakukan proses CREATE
		{
			$data['employee_position_name'] = $this->input->post('i_name');
			$data['employee_position_description'] = $this->input->post('i_description');
			$error = $this->employee_position_model->create($data);
			
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			
			// map input ke kolom database
			$data['employee_position_name'] = $this->input->post('i_name');
			$data['employee_position_description'] = $this->input->post('i_description');
			
			$error = $this->employee_position_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
				
	}	
}

#
