<?php

define('IMPORT_ALLOW_DATA', 'csv|xls|txt', TRUE);

class Import 
{
	var $error = "";
	var $is_error = true;
	var $action_url = "";
	var $back_url = "";
	var $file_name = "";
	var $view_url = "";
	
	function get($field = 'fileToImport', $type_allow = IMPORT_ALLOW_DATA)
	{
		$ci = & get_instance();
		
		$config['upload_path'] 	 	= $ci->config->item('upload_tmp');
		$config['allowed_types'] 	= $type_allow;
		$config['max_size']	 	= $ci->config->item('upload_max_size');
		$config['encrypt_name']	 	= true;
		
		$ci->load->library('upload', $config);
	
		if ( ! $ci->upload->do_upload($field))
		{
			$this->is_error = true;
			//$error = $ci->upload->display_errors();
			//echo $ci->config->item('upload_tmp') . "" . $error;
			return null;
		}	
		else
		{
			$this->is_error = false;
			$data = $ci->upload->data();
			$server_file = $config['upload_path'] . $data['file_name'];
			$this->file_name = $data['full_path'];
			return array('file_name' => $data['full_path'], 'file_ext' => $data['file_ext'], 'file_size' => $data['file_size']) ;
		}
	}
	
	function add_form($url)
	{
		$this->view_url = $url;
	}
	
	function show($title='Import')
	{
		$ci = & get_instance();
		$form_name = 'freeform';
		$param['action_url'] = $this->action_url;
		$param['back_url'] = $this->back_url;
		$content  = '<form class="form_class" id="id_form_nya" method="POST" enctype="multipart/form-data" action="'.site_url($this->action_url).'"><div class="ajax_status"></div>';
		
		if($this->view_url)$content .= $ci->load->view($this->view_url, null, true);
		$content .= $ci->load->view("common/import_data", $param, true);
		
		$content .= '</form>';
					
		$data['name'] = $form_name;
		$data['content'] = $content;

		$ci->render->add_raw($this->_gap($ci->load->view('frame/' . $form_name, $data, true)));
		$ci->render->build('Import data');
		
		$ci->render->show('blank', $title);
	}
	
	function _gap($html)
	{
		return "<div id=\"gap\" />$html</div>";
	}
	
	function is_error()
	{
		return $this->is_error;
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
	
	function read()
	{
		if($this->is_error) return null;
		$ci = & get_instance();
		$ci->load->helper('file');
		$string = read_file($this->file_name);
		$str_arr = explode("\n",$string);
		unlink($this->file_name);
		$this->is_error = true;
		return $str_arr;
	}
}

# -- end file -- #
