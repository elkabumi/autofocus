<?php

define('IMPORT_ALLOW_DATA', 'csv|xls', TRUE);

class Data_import 
{
	var $error = "";
	var $is_error = false;
	var $action_url = "";
	var $back_url = "";
	function send($field, $type_allow = IMPORT_ALLOW_DATA)
	{
		$ci = & get_instance();
		
		$config['upload_path'] 	 = $ci->config->item('upload_tmp');
		$config['allowed_types'] = $type_allow;
		$config['max_size']	 = $ci->config->item('upload_max_size');
		$config['encrypt_name']	 = true;
				
		$ci->load->library('upload', $config);
	
		if ( ! $ci->upload->do_upload($field))
		{
			$is_error = true;
			$error = $ci->upload->display_errors();
			echo $ci->config->item('upload_tmp') . "" . $error;
			return null;
		}	
		else
		{
			$is_error = false;
			$data = $ci->upload->data();
			$server_file = $config['upload_path'] . $data['file_name'];
						
			return array('file_name' => $data['full_path'], 'file_ext' => $data['file_ext'], 'file_size' => $data['file_size']) ;
		}
	}
	
	function show_form($action_url='')
	{
		$ci = & get_instance();
		$form_name = 'freeform';
		$param['action_url'] = $this->action_url;
		$param['back_url'] = $this->back_url;
		$content = $ci->load->view("common/import_data", $param, true);
		$data['name'] = $form_name;
		$data['content'] = $content;

		$ci->render->add_raw($this->_gap($ci->load->view('frame/' . $form_name, $data, true)));
		$ci->render->build('Import data');
	}
	
	function _gap($html)
	{
		return "<div id=\"gap\" />$html</div>";
	}
	
	function is_error()
	{
		return $is_error;
	}
	
	function get_message()
	{
		return $error;
	}
	
	function set_action($url)
	{
		$this->action_url = $url;
	}
	function set_back($url)
	{
		$this->back_url = $url;
	}
}

# -- end file -- #
