<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Employee_group extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('employee_group_model');
		$this->load->library('access');
		$this->access->set_module('master.employee_group');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/employee_group/list');
		$this->render->build('employee_group');
		$this->render->show('employee_group');
	}
	
	function table_controller(){
		$data = $this->employee_group_model->list_controller();
		send_json($data);
	}
	
	
	function form($id = 0)
	{
		$data = array();
		if($id==0){
		
			
			$data['row_id'] = '';
			$data['employee_group_id'] = '';
			$data['employee_group_name'] = '';
			$data['employee_group_description'] = '';
		
		}else{
			$result = $this->employee_group_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
		
			
			}
		}
		
		$this->load->helper('form');
			
		$this->render->add_form('app/employee_group/from', $data);
		$this->render->build('Group Pegawai');
		
		$this->render->add_view('app/employee_group/transient_list');
		$this->render->build('Pegawai');
				
		$this->render->add_form('app/employee_group/form_save', $data);
		$this->render->build('Group Pegawai');
		
		$this->render->show('Group Pegawai');
	}
	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if($is_delete)
		{
			$this->load->model('employee_group_model');
			$id = $this->input->post('row_id');
			
			$is_process_error = $this->employee_group_model->delete($id);
			
			send_json_action($is_process_error, "Data telah dihapus");
		}
		
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
	
		// definisikan kriteria data
		
		$this->form_validation->set_rules('i_group_name','Nama Group','trim|required');
		$this->form_validation->set_rules('i_description','Description','trim|max_length[100]');
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		
		
		$id = $this->input->post('row_id');
		$data['employee_group_name'] 			= $this->input->post('i_group_name');
		$data['employee_group_description'] 	= $this->input->post('i_description');	
		
		$list_employee_id	= $this->input->post('transient_employee_id');

		$items = array();
		if($list_employee_id){
		foreach($list_employee_id as $key => $value)
		{
			
			$items[] = array(				
				'employee_id'  => $list_employee_id[$key]

			);
		}
		}

		if(empty($id)) // jika tidak ada id maka create
		{ 
			
			$error = $this->employee_group_model->create($data, $items);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah", $this->employee_group_model->insert_id);
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$error = $this->employee_group_model->update($id, $data, $items);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi", $id);
		}		
	}
	
	
	function detail_list_loader($row_id=0)
	{
		if($row_id == 0)
		
		send_json(make_datatables_list(null)); 
				
		$data = $this->employee_group_model->detail_list_loader($row_id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		$data[$key] = array(
				form_transient_pair('transient_employee_id', $value['employee_id']),
				form_transient_pair('transient_employee_nip', $value['employee_nip']),
				form_transient_pair('transient_employee_name', $value['employee_name']),
				form_transient_pair('transient_employee_address', $value['employee_address']),
				form_transient_pair('transient_employee_phone', $value['employee_phone']),
				
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
			$data['employee_id'] 	= '';
			$data['employee_nip'] 	= '';
			$data['employee_name'] 	= '';
			$data['employee_address'] 	= '';
			$data['employee_phone'] 	= '';
		} else {
			
			$data['index']			= $index;
			$data['employee_id'] 	= array_shift($this->input->post('transient_employee_id'));
			$data['employee_nip'] 	= array_shift($this->input->post('transient_employee_nip'));
			$data['employee_name'] 	= array_shift($this->input->post('transient_employee_name'));
			$data['employee_address'] 	= array_shift($this->input->post('transient_employee_address'));
			$data['employee_phone'] 	= array_shift($this->input->post('transient_employee_phone'));
		}		
		
		$this->load->helper('form');
		
	
		$this->render->add_form('app/employee_group/transient_form', $data);
		$this->render->show_buffer();
	}
	
	
	function detail_form_action()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_employee_id', 'Id', 'trim|required');
		$this->form_validation->set_rules('i_nip','Nip', 'trim|required');
		$this->form_validation->set_rules('i_name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('i_address','Alamat', 'trim|required');
		$this->form_validation->set_rules('i_phone','Telepon', 'trim|required');

	
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
	
		
		$no 		= $this->input->post('i_index');
		
		$employee_id		= $this->input->post('i_employee_id');
		$employee_nip		= $this->input->post('i_nip');
		$employee_name		= $this->input->post('i_name');
		$employee_address	= $this->input->post('i_address');
		$employee_phone		= $this->input->post('i_phone');
		
		

		$data = array(
				
				form_transient_pair('transient_employee_id', $employee_id, $employee_id),
				form_transient_pair('transient_employee_nip', $employee_nip, $employee_nip),
				form_transient_pair('transient_employee_name', $employee_name,$employee_name),
				form_transient_pair('transient_employee_address', $employee_address, $employee_address),
				form_transient_pair('transient_employee_phone', $employee_phone,$employee_phone)
		);
		 
		send_json_transient($index, $data);
	}
	
	function load_employee()
	{
		$id 	= $this->input->post('employee_id');
		
		$query = $this->employee_group_model->load_employee($id);
		$data = array();
		
		foreach($query->result_array() as $row)
		{
			$data['employee_nip'] = $row['employee_nip'];
			$data['employee_name'] = $row['employee_name'];
			$data['employee_address'] = $row['employee_address'];
			$data['employee_phone'] = $row['employee_phone'];
		}
		send_json_message('Pegawai', $data);
	}
	

}
