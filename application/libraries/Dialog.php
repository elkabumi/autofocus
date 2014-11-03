<?php

class Dialog {

	function Dialog()
	{
		$ci = & get_instance();
		$ci->load->library('render');
		$ci->load->library('session');
	}
	
	function confirm($title, $message, $yes_target, $no_target)
	{
		$ci = & get_instance();
		
		$data['title'] = $title;
		$data['message'] = $message;
		$data['yes_target'] = trim($yes_target) == '' ? '' : site_url($yes_target);			
		$data['no_target'] = trim($no_target) == '' ? '' : site_url($no_target);
		
		$ci->render->add_js('dialog');
		$ci->render->add_view('dialog/confirm', $data);
		$ci->render->build('Konfirmasi');
		$ci->render->show('dialog', 'Konfirmasi');
	}
	
	function note($title, $message, $target)
	{
		/*$ci = & get_instance();
		
		$data['title'] = $title;
		$data['message'] = $message;
		$data['target'] = trim($target) == '' ? '' : site_url($target);			
		
		$ci->render->add_js('dialog');
		$ci->render->add_view('dialog/note', $data);
		$ci->render->build('Pengumuman');
		$ci->render->show('dialog', 'Pengumuman');*/
		$ci = & get_instance();
		
		$data['title'] = $title;
		$data['message'] = $message;
		$data['target'] = trim($target) == '' ? '' : site_url($target);			
		
		$ci->render->add_js('dialog');
		$ci->render->add_view('dialog/note', $data);
		$ci->render->build('Pengumuman', 'login');
		$ci->render->show('dialog', 'Pengumuman');
	}
	
	function error($title, $message, $target)
	{
		$ci = & get_instance();
		
		$data['title'] = $title;
		$data['message'] = $message;
		$data['target'] = trim($target) == '' ? '' : site_url($target);			
		
		$ci->render->add_js('dialog');
		$ci->render->add_view('dialog/error', $data);
		$ci->render->build('Error');
		$ci->render->show('dialog', 'Error');
	}
	
	function flash_note($title, $message, $target)
	{
		$ci = & get_instance();
		$ci->session->set_flashdata('dialog_type', 'note');
		$ci->session->set_flashdata('dialog_data', array('title' => $title, 'message' => $message , 'target' => $target));
		if(is_ajax()){
			$curr_url = $ci->uri->segment(1);
			$ci->session->set_userdata('redir', array('redir_url' => $curr_url));
			login_redirect(site_url('login'));exit;
		}
		else {
			$curr_url = $ci->uri->uri_string();	
			$ci->session->set_userdata('redir', array('redir_url' => $curr_url));
			redirect('op/note');
		}
	}
	
	function flash_error($title, $message, $target)
	{
		$ci = & get_instance();
		$ci->session->set_flashdata('dialog_type', 'error');
		$ci->session->set_flashdata('dialog_data', array('title' => $title, 'message' => $message , 'target' => $target));
		redirect('op/note');
	}
	
	function flash_trap()
	{
		$ci = & get_instance();
		$type = $ci->session->flashdata('dialog_type');
		$data = $ci->session->flashdata('dialog_data');
		
		if ($type == 'note') 
		{
			$this->note($data['title'], $data['message'], $data['target']);
			return true;
		}
		else if ($type == 'error') 
		{
			$this->error($data['title'], $data['message'], $data['target']);
			return true;
		}
		
		return false;
	}
}

# -- end file -- #
