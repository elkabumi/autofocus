<?php

class user_aproved extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		
		$this->access->set_module('tool.user_aproved');
		//$this->access->user_page();
		$this->load->model('user_model');
		$this->access->user_page();
			$this->load->library('render');
	}
	
	// halaman utama, menampilkan links ke module2x User
	function index()
	{
		
		$this->render->add_view('app/user_aproved/list');
		$this->render->build('Daftar User Aproved' );
		$this->render->show('User aproved', 'User Module');
	}
	function table_controller()
	{
		$data = $this->user_model->user_aproved_list_controller(get_datatables_control());
		send_json($data); 
	}
	
	function user_aproved_form($id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{
			
				$result = $this->user_model->user_aproved_read_id($id);
				$data_form['row_id'] 		= $result['user_id'];
				$data_form['user_login'] 	= $result['user_login'];
				$data_form['user_name'] 	= $result['user_name'];			
				$data_form['user_group'] 	= $result['user_group_id']?$result['user_group_id']:0;
				$data_form['user_email'] 	= $result['user_email'];	
				$data_form['user_phone'] 	= $result['user_phone'];
				$data_form['job_title'] 	= $result['job_title'];	
				$data_form['company'] 		= $result['company'];
				$data_form['expired_date']	= format_new_date($result['expired_date']);
				$data_form['employee_id'] 	= $result['employee_id'];
				
					
				$data_form['employee_pic']	= $result['employee_pic'];
				
				
				$this->load->helper('form');
			//	$this->access->generate_log_view($id);
		$this->render->add_js('ajaxfileupload');	
		$this->render->add_form('app/user_aproved/form', $data_form);
		$this->render->build('User');
		$this->render->show('User');
	}
	
	
	function user_aproved_form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');  // selalu ada di _action()
		
		if ($is_delete) 
		{
			$id = $this->input->post('row_id');
		
			$error = $this->user_model->delete($id);
			send_json_action($error, "Data telah dihapus", "Data gagal dihapus");
		} 			
		
			$this->form_validation->set_rules('i_expired_date','Expired date','trim|required|valid_date|sql_date');
			
			
			
			$data['user_is_active'] 	= 1;
			$data['expired_date'] 	= date('Y-m-d', mktime(0,0,0, date('m')+1, date('d'), date('Y')));
			$data['user_last_login']	= date("Y-m-d H:m:s");
			$data['user_registered']	= date("Y-m-d H:m:s");
			
			$employe['employee_id'] 	= $this->input->post('employee_id');
			//$employe['employee_pic'] 	= $this->input->post('i_photo');
			//$old_pic 					= $this->input->post('i_oldphoto');
			
			
			$id = $this->input->post('row_id');
			
		/*if($employe['employee_pic'] != $old_pic)
		 rename($this->config->item('upload_tmp').$employe['employee_pic'], $this->config->item('upload_storage')."img_employee/".$employe['employee_pic']);*/
			$error = $this->user_model->user_aproved_update($id, $data,$employe);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");		
				
	}
	
}
?>