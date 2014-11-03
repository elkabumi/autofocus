<?php

class Common 
{
	function lognlock($user_id, $branch_id = NULL)
	{
		$ci = & get_instance();
		
		$ci->load->model('user_model');	
		
		$info = $ci->user_model->get_user_info($user_id, $branch_id);
		$ci->session->set_userdata('logged', 1);	
		$ci->session->set_userdata('user_info', $info);
		$ci->session->set_userdata('showmenu', 1);
		
		$data['log_sys_user_id'] = $user_id;
		$data['log_sys_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['log_sys_action'] = 'LOGIN';
		$ci = & get_instance();
		$data['log_sys_uri'] = substr($ci->uri->uri_string(), -50);
		$ci->db->insert('log_sys', $data);
	}
	
}

#
