<?php

class Periode extends CI_Controller
{
	function __construct()
	{
		parent::__construct();	
		// library untuk memproteksi halaman
		$this->load->library('access');
		$this->load->model('periode_model');
		$this->load->library('render');
		
		// set kode module ini .. misal usr
		$this->access->set_module('master.period');
		// default access adalah User
		$this->access->user_page();		
	}
		
	function index()
	{
		$this->render->add_view('app/periode/list');
		$this->render->build('Periode');
		
		$this->render->show('Periode');
	}
		
	function table_controller()
	{		
		$data = $this->periode_model->list_controller();		
		send_json($data); 
	}
	
	function form($id = 0)
	{
		$data = array();
		if ($id == 0) 
		{
			$data['row_id'] 			= '';
			$data['period_code'] 		= format_code('periods', 'period_code', 'PR', 7);
			$data['period_month'] 		= '';
			$data['period_year'] 		= '';
			$data['period_description'] = '';
			$data['period_closed']		= '';
		
		} 
		else 
		{
			$result = $this->periode_model->read_id($id);			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data = $result;
				$data['row_id'] = $id;		
			}
		}	
		$this->load->model('global_model');
		$this->load->helper('form');
		
		
		$data['bulan']    = array ('1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember')  ;
		
		
		$this->render->add_form('app/periode/form', $data);
		$this->render->build('Periode');
		//$this->access->generate_log_view($id);
		$this->render->show('Periode');
	}
	
	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');
		
		if ($is_delete)
		{		
			$id = $this->input->post('row_id');
			$is_process_error = $this->periode_model->delete($id);
			send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
		} 
		//$this->form_validation->set_rules('i_code', 'Kode', 'trim|max_length[10]|required'); // gunakan selalu trim di awal
		$this->form_validation->set_rules('period_code', 'Nama', 'trim|required'); // gunakan selalu trim di awal
		$this->form_validation->set_rules('period_year', 'Kelurahan', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) send_json_validate(); // bila input tidak valid, exit dan kirim kesalahan
		
		$id = $this->input->post('row_id');
		//$data['period_id'] = $this->input->post('row_id');
		$data['period_code'] = $this->input->post('period_code');
		$data['period_month'] = $this->input->post('period_month');
		$data['period_year'] = $this->input->post('period_year');
		$data['period_name'] = $data['period_month']."/".$data['period_year'];
		$data['period_description'] = $this->input->post('period_description');
		$data['period_closed'] = $this->input->post('period_closed');
			
		if (empty($id)) // id empty, lakukan proses CREATE
		{
			//$data['market_code'] = format_code('markets', 'market_code', 'P',2);
			
			$data_is_exist = $this->periode_model->data_is_exist($data['period_month'], $data['period_year']);
				if($data_is_exist){
					send_json_error("Simpan gagal. Data periode ". $data['period_name'] ." sudah ada");
				}
			
			$error = $this->periode_model->create($data);			
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$error = $this->periode_model->update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
				
	}
}	
