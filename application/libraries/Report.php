<?php 

class Report
{
	var $module_id;
	var $data_id;
	var $items;
	var $title;
	var $is_branch;
	var $default_action;
	function Report()
	{
		$ci = & get_instance();
		$this->is_branch = TRUE;
		$this->default_action = 0;
		if (!isset($ci->render)) $ci->load->library('render');
		
	}
	
	function add_item($url, $name='')
	{
		if($name=='')$name=$url;
		$this->items[] = $url.'|'.$name;
		
	}
	
	function set_branch($visible = TRUE)
	{
		$this->is_branch = $visible;	
	}
	function set_action($visible = TRUE)
	{
		$this->default_action = $visible;	
	}
	function generate($target_url='')
	{
		$ci = & get_instance();
		
		for($i=0;$i<count($this->items);$i++)
		{
			$row = $this->items[$i];
			$row_arr = explode("|",$row);
			$data[]=array('name'=>$row_arr[1], 'url' =>$row_arr[0] );
		}
				
		$ci->render->add_view('common/report' , array('data' => $data,'target_url'=>$target_url));
		$ci->render->build('Daftar Laporan');
	}
	
	function generate2($target_url='')
	{
		$ci = & get_instance();
		
		for($i=0;$i<count($this->items);$i++)
		{
			$row = $this->items[$i];
			$row_arr = explode("|",$row);
			$data[]=array('name'=>$row_arr[1], 'url' =>$row_arr[0] );
		}
				
		$ci->render->add_view('common/report2' , array('data' => $data,'target_url'=>$target_url));
		$ci->render->build('Daftar Laporan');
	}
	
	function show_form($view_url, $action_url='', $back_url='', $view_param = NULL)
	{
		$ci = & get_instance();
		$param['branch'] = '';
		if($view_url=='')$content = '';
		else $content = $ci->load->view($view_url, $view_param, true);
		//if($this->is_branch)
		//	if($ci->access->branch_id == 1)	$param['branch'] = $ci->load->view('common/branch_view', null, true);
		if($this->is_branch)
		{
			$ci->load->model('global_model');
			$data_branch = $ci->global_model->get_region_info();
			$param['branch'] = $ci->load->view('common/branch_view', $data_branch, true);
		}
		$form_name = 'freeform';
		$param['action_url'] = $action_url;
		$param['back_url'] = $back_url;
		$param['content'] = $content;
		$param['default_action'] = $this->default_action;					
		$data['name'] = $form_name;
		$data['content'] = $ci->load->view('common/report_form', $param, true);
		
		$ci->render->add_raw($this->_gap($ci->load->view('frame/' . $form_name, $data, true)));
		
	}
	
		function show_form2($view_url, $action_url='', $back_url='', $view_param = NULL)
	{
		$ci = & get_instance();
		$param['branch'] = '';
		if($view_url=='')$content = '';
		else $content = $ci->load->view($view_url, $view_param, true);
		//if($this->is_branch)
		//	if($ci->access->branch_id == 1)	$param['branch'] = $ci->load->view('common/branch_view', null, true);
		if($this->is_branch)
		{
			$ci->load->model('global_model');
			$data_branch = $ci->global_model->get_region_info();
			$param['branch'] = $ci->load->view('common/branch_view', $data_branch, true);
		}
		$form_name = 'freeform';
		$param['action_url'] = $action_url;
		$param['back_url'] = $back_url;
		$param['content'] = $content;
		$param['default_action'] = $this->default_action;					
		$data['name'] = $form_name;
		$data['content'] = $ci->load->view('common/report_form2', $param, true);
		
		$ci->render->add_raw($this->_gap($ci->load->view('frame/' . $form_name, $data, true)));
		
	}
	
	function _gap($html)
	{
		return "<div id=\"gap\" />$html</div>";
	}
	
	function show($title='Report')
	{
		$ci = & get_instance();
		$ci->render->build($title);
		$ci->render->show($title);
	}
	function get($report_name)
	{
		$ci = & get_instance();
		$ci->load->library('regen');
		$is_download = $ci->input->post('mode');
		$file_type = $ci->input->post('download_to');
		if ($is_download) $ci->regen->build_download($report_name, $file_type); 
		else $ci->regen->build_show($report_name);
	}
	function set_title($number = 'TX99', $title = 'NO TITLE. PLEASE SPECIFY.', $subtitle = 'NO SUBTITLE. PUT EMPTY STRING TO OVERRIDE THIS.')
	{
		$ci = & get_instance();
		$ci->load->library('regen');
		$ci->regen->set_title($number, $title, $subtitle);
	}
	function add_parameter($key, $value, $type = REGEN_STRING)
	{
		$ci = & get_instance();
		$ci->load->library('regen');
		$ci->regen->add_parameter($key, $value, $type);
	}
}

# -- end file -- #
