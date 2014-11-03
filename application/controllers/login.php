<?php

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');	
	}

	function captcha()
	{
		$this->load->library('captcha');
		$this->captcha->CreateImage();
	}
	
	function index()
	{
		
		$logged = $this->session->userdata('logged');

		if (!$logged) 
		{
			$this->_login_form();
			return;
		}

		redirect('/');	
	}
	
	function force()
	{
		$redir = $this->session->userdata('redir');
		$this->_login_form($redir['user_login']);
	}
	
	function denied()
	{	
		$this->session->set_userdata('branch_id', 1);
	}

	function _login_form($name = '')
	{
		
		$this->load->library('form_validation', 'fv');
		
		$this->load->library('render');		
		$this->render->add_form('login', array('name' => $name));
		$this->render->build('Login', 'login');
		
		$this->render->show('Login', 'Login System');

	}

	function submit()
	{
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('i_user', 'User name/NIK', 'required|trim');
		$this->form_validation->set_rules('i_pass', 'Password', 'required|trim');		
#		$this->form_validation->set_rules('i_captcha', 'Kode verifikasi', 'required|trim');		
		
		if (!$this->form_validation->run()) {
			$this->_login_form();
			return;
		}
/*	
		$user = $this->input->post('i_user');
		$pass = $this->input->post('i_pass');
#		$captcha = $this->input->post('i_captcha');

#		$saved_captcha = $this->session->userdata('captcha');
#		if (strcasecmp($captcha, $saved_captcha) != 0)
#		{
#			$this->load->library('dialog');
#			$this->dialog->note('Login', 'Ketik ulang tidak sesuai dengan gambar', 'login');		
#			return;
#		}
		
		$user_id = $this->user_model->is_valid($user, $pass);

		if(!$user_id)
		{	
			$this->load->library('dialog');
			$this->dialog->note('Login', 'Password tidak sesuai', 'login');		
			
			$data['log_sys_user_id'] = 0;
			$data['log_sys_ip'] = $_SERVER['REMOTE_ADDR'];
			$data['log_sys_action'] = "LOGIN FAILED " . substr($user, 0, 37);
			$data['log_sys_uri'] = substr($this->uri->uri_string(), -50);
			$this->db->insert('log_sys', $data);
			
			return;
		}

		$this->load->library('common');
		$this->common->lognlock($user_id);
		
		redirect('/home/setup');*/
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('i_user', 'User name/NIK', 'required|trim');
		$this->form_validation->set_rules('i_pass', 'Password', 'required|trim');		
		//$this->form_validation->set_rules('i_captcha', 'Ketik Ulang', 'required|trim');		
		
		if (!$this->form_validation->run()) {
			//$this->_login_form();
			send_json_validate();
			return;
		}
	
		$user = $this->input->post('i_user');
		$pass = $this->input->post('i_pass');
		$captcha = $this->input->post('i_captcha');

		$saved_captcha = $this->session->userdata('captcha');
		if (strcasecmp($captcha, $saved_captcha) != 0)
		{
			//$this->load->library('dialog');
			//$this->dialog->note('Login', 'Ketik ulang tidak sesuai dengan gambar', 'login');		
			//return;
		}
		/*$log_status = $this->user_model->cek_status($user, $pass);
		if(!$log_status)
		{
			if(is_ajax())send_json_error('Login ditolak.');	
			else
			{
				$this->load->library('dialog');
				$this->dialog->note('Login Gagal', 'Acount telah digunakan untuk login', 'login');	
			}		
			return;	
		}
		*/
		$user_id = $this->user_model->is_valid($user, $pass);

		if(!$user_id)
		{				
			
			if(is_ajax())send_json_error('Login ditolak.');	
			else
			{
				$this->load->library('dialog');
				$this->dialog->note('Login Gagal', 'Username atau Password tidak sesuai', 'login');	
			}		
			return;
		}
		
		

		$info = $this->user_model->get_user_info($user_id);
		$this->session->set_userdata('logged', 1);	
		$this->session->set_userdata('user_info', $info);
		$this->session->set_userdata('login_time', time());
		$redir = $this->session->userdata('redir');
		/*if (!$redir) send_json_redirect('trial'); 
		else { 
			$this->session->set_userdata('redir', NULL);
			send_json_redirect(site_url($redir['redir_url']));			
		}
		
		send_json_redirect(site_url('trial'));*/
		//$this->load->library('common');
		//$this->common->lognlock($user_id);
		
		$data['log_sys_time'] = date("Y-m-d H:m:s");
		$data['log_sys_type'] = 0;
		$data['log_sys_user_id'] = $user_id;
		$data['log_sys_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['log_sys_action'] = "LOGIN";
		$data['log_sys_uri'] = substr($this->uri->uri_string(), -50);
		$this->db->insert('log_sys', $data);

		if(is_ajax())send_json_redirect(site_url('/home/setup'));
		else redirect('/home/setup');

		send_json_redirect(site_url('/home/setup'));

		
	}
	
	function logout($confirmed = 0)
	{
		$this->load->library('access');
		
		$this->load->library('dialog');
		
		if (!$confirmed) 
		{
			$this->dialog->confirm('Logout', 'Apakah Anda ingin keluar dari program ini?', 'login/logout/1', '');
			return;	
		}
		
 		$user_id = $this->access->user_id > 0 ? $this->access->user_id : 0;
 		
		$data['log_sys_time'] = date("Y-m-d H:m:s");
		$data['log_sys_type'] = 0;
		$data['log_sys_user_id'] = $user_id;
		$data['log_sys_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['log_sys_action'] = 'LOGOUT';
		$data['log_sys_uri'] = substr($this->uri->uri_string(), -50);
		$this->db->insert('log_sys', $data);
		
		$user_is_login='0';
		$this->db->where('user_id',$user_id); // data yg mana yang akan di update
		$this->db->update('users', array('user_is_login' => $user_is_login));
		
		$this->session->sess_destroy();		
		$this->dialog->note('Logout<br>', 'Sesi Anda telah dinonaktifkan. Terima Kasih.', 'login');		
	}

}

# --- end --- #
