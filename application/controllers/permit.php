<?php

class Permit extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		
		$this->load->library('access');
		$this->access->set_module('tool.permit');
		$this->access->crud_page('r');
	}
	
	function index() {
	
		$this->load->library('render');
		$this->render->add_view('app/user/permit/group_list');
		$this->render->build('Daftar Grup Akses');
		$this->render->show('Grup Akses', 'Grup Akses');	
		
	}
	function form_group($group_id = 0)	{
	
		$this->load->model('permit_model');
		$this->load->library('render');
		
		if ($group_id == 0) {
			
			// FORM CREATE - isi form dengan nilai default / kosong
			$data['row_id'] = '';
			$data['group_name'] = '';			
			
			$this->render->add_form('app/user/group/form', $data);
			$this->render->build('Group');

		} else {

			// FORM UPDATE - ambil data yang diedit kemudian tampilkan dalam form
			$this->load->model('user_model');
			$result = $this->user_model->group_read_id($group_id);
			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data_form['row_id'] 		= $result['group_id'];
				$data_form['group_name'] 	= $result['group_name'];			
				
				
				$this->render->add_form('app/user/group/form', $data_form);
				$this->render->build('Group');
				//$this->access->generate_log_view($group_id);
			}
			else // tidak ada? tampilkan error.
			{
				$this->library->load('dialog');
				$this->dialog->flash_note('Data tidak ditemukan', 'trial/warehouse_list');
			}
		}
				
		$this->render->show('Group');
	}
	function form($group_id = 0)	{
	
		$this->load->model('permit_model');
		$this->load->library('render');
				
		$group = $this->permit_model->is_group_exists($group_id);
		if (!$group) {
			$this->load->library('dialog');
			$this->dialog->flash_note('Data tidak ditemukan', 'permit');
		}
		
		$title = $group['group_name'];
		
		$checked = array();
		$data = $this->permit_model->permits($group_id);
		
		if ($data) {
			foreach($data as $row) {
				$checked[$row['module_group']] = $row['permit_crud_mode'];
			}
		} 
		//debug($checked);

		$param = array(
			'checked' => $checked, 
			'group_id' => $group_id, 
			'next_url' => site_url('permit')
		);
		
		$this->render->add_view('app/user/permit/list', $param);
		$this->render->build('Daftar Akses untuk Group : ' . $title);
		$this->render->show('User Grup Hak Akses');	
	}
	
	function action() {
	
		$this->load->model('permit_model');
		
		$ip_group_id = $this->input->post('ip_group_id');
		
		$ip_c = $this->input->post('ip_c');
		$ip_r = $this->input->post('ip_r');
		$ip_u = $this->input->post('ip_u');
		$ip_d = $this->input->post('ip_d');	
		
		# group odules
		$module_set 	= array();
		$module_crud  	= array();
		$module_id  	= array();
		
		$data = $this->permit_model->modules();
		foreach($data as $r) {
		
			$key = $r['module_group'];
			$module_set[$key][] = $r['module_code'];
			$module_crud[$key] = '';
			$module_id[$key][] = $r['module_id'];
		}		
		
		# create status
		if (is_array($ip_c))
		foreach($ip_c as $key) {
			$crud = $module_crud[$key];
			if (strpos($crud, 'c') === false) $module_crud[$key] .= 'c';
		}		
		
		# read status
		if (is_array($ip_r))
		foreach($ip_r as $key) {
			$crud = $module_crud[$key];
			if (strpos($crud, 'r') === false) $module_crud[$key] .= 'r';
		}		
		
		# update status
		if (is_array($ip_u))
		foreach($ip_u as $key) {
			$crud = $module_crud[$key];
			if (strpos($crud, 'u') === false) $module_crud[$key] .= 'u';
		}
		
		# delete status
		if (is_array($ip_d))
		foreach($ip_d as $key) {
			$crud = $module_crud[$key];
			if (strpos($crud, 'd') === false) $module_crud[$key] .= 'd';
		}		
				
#		debug($module_crud);
		
		$module_enabled = array();
		$index = 0;
		foreach($module_crud as $key => $value) {
			if (trim($value) != '') {
				foreach($module_id[$key] as $id) {
					$module_enabled[$index]['id'] = $id;
					$module_enabled[$index]['mode'] = $value;
					$index++;
				}
			}
		}
		
#		debug($module_enabled);
		$error = $this->permit_model->update($ip_group_id, $module_enabled);
		send_json_action($error, "Data telah disimpan", "Data gagal disimpan");
				
	}
	
	
	function group_table_controller()
	{
		$this->load->model('permit_model');
	
		$data = $this->user_model->permit_list_controller(get_datatables_control());
		
		send_json($data); 
	}
	
	
}

#
