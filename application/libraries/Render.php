<?php 

class Render
{
	var $ci;
	var $title;
	var $block;
	var $layout;
	var $content_buffer;
	var $content_buffer1;
	var $content_buffer2;
	var $content_buffer3;
	var $content_buffer4;
	var $content_buffer5;
	var $is_using_table = 0;
	var $is_accordion;
	var $accordion_buffer;
	var $accordion_title;
	var $accordion_id = 0;
	var $content_form_transient;
	
	function Render($title = '')
	{	
		$ci = $this->ci = & get_instance();
		//$ci = & get_instance();
		$ci->output->set_header("HTTP/1.0 200 OK");
		$ci->output->set_header("HTTP/1.1 200 OK");
		//$ci->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', mktime()).' GMT');
		$ci->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		$ci->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$ci->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$ci->output->set_header("Pragma: no-cache");
		
		$this->block = array();
		$this->content_form_transient = "";
		$this->block['server_time'] = time();
		$this->block['content'] = "";
		$this->block['blocks'] = "";
		$this->block['js'] = "";
		$this->block['css'] = "";
		$this->block['access'] = "";
		$ci->load->model('user_model');		
		$this->block['branch_name'] = $ci->user_model->get_branch_name();
		$this->block['user_name'] = $ci->user_model->get_user_name();
		$this->block['group_name'] = $ci->user_model->get_group_name();
		$this->block['side'] = "";
		$this->block['user_info'] = "";
		$this->block['sys_info'] = '';
		//$this->block['img'] = array(encrypt('header.jpg'));
		//$this->block['menu'] = $ci->user_model->load_menu();
		$this->add_js('jquery-1.4.2.min');
		if (!$ci->access) $ci->load->library('access');
		$pos_menu = $ci->config->item('pos_menu');
		$this->block['top_menu'] = '';
		$this->block['side_menu'] = '';
		if($pos_menu == 1)
		{
			if($ci->access->menubar)$this->block['side_menu'] = $ci->access->menubar;
		}
		else $this->block['top_menu'] = $ci->access->menubar;
		$this->block['logged'] = $ci->session->userdata('logged');
		$this->block['static_info'] = '';
		$this->title = 'Undefined.';
		$this->is_accordion = false;
		$this->layout = $ci->config->item('layout');
		if (!empty($title)) $this->title = $title;
		//$this->block['content'] .= "<div style=\"padding: 2px;background-color:#F9FAFF;\">test</div><br />\n";
		
	}
	function add_js($file)
	{
		$this->block['js'] .= "<script type=\"text/javascript\" src=\"" . base_url() . "assets/js/" . $file . ".js\"></script>\n";
	}
	
	function add_css($file)
	{
		$this->block['css'] .= "<link href=\"" . base_url() . "assets/css/" . $file . ".css\" rel=\"stylesheet\" type=\"text/css\" />\n";
	}
	function prepare_all($params)
	{
		foreach($params as $key => $value) {
			$params[$key] = $this->prepare($value);
		}
		
		return $params;
	}
	
	function prepare($param)
	{
		$param = htmlspecialchars($param);
		return $param;
	}
	
	function set_title($title) 
	{
		if (!empty($title)) $this->title = $title;
	}
	
	function accordion_add_view($title, $content, $params = null)
	{
		$ci = & get_instance();
		
		$data['title']	= $title;
		$data['content'] = $ci->load->view($content, $params, true);
		//$this->content_buffer .= '<div class="block_table">'.$ci->load->view($content, $params, true).'</div>';
		$this->content_buffer .= $ci->load->view('frame/accordion_item', $data, true);
		
	}
	
	function accordion_add_form($title, $form_name, $view_name, $param = null)
	{
		$ci = & get_instance();
		$content = $ci->load->view($view_name, $param, true);
		
		$data['title']	= $title;
		$data['content'] = $this->_gap($ci->load->view('frame/' . $form_name, array('content' => $content), true));
		$this->content_buffer .= $ci->load->view('frame/accordion_item', $data, true);
		
	}

	function accordion_build()
	{
		$ci = & get_instance();
		
		$data['title'] = $this->accordion_title;
		$data['content']  = $this->content_buffer;
		$data['id']  = "accordion_" + $this->accordion_id++;
		$this->block['content'] .= $ci->load->view('frame/accordion_main', $data, true);
		$this->content_buffer = "";
	}	
	
	function _gap($html)
	{
		return $html;
		return "<div id=\"gap\" />$html</div>";
	}
	function add_form($view_name, $param = null)
	{
		$content = $this->ci->load->view($view_name, $param, true);
		
		$data['content'] = $content;
		$this->content_form_transient .= $this->_gap($this->ci->load->view('layout/default/tableform', $data, true));
		//$this->content_buffer .= '<div class="block">'.$this->content_form_transient.'</div>';
		$this->content_buffer .= $this->content_form_transient;
	}
	function add_subform($view_name, $title = null, $param = null)
	{
		$content = $this->ci->load->view($view_name, $param, true);
		$data['content'] = $content;
		
		if($title)$this->content_buffer .= '<div class="subtitle">'.$title.'</div>';
		$this->content_buffer .= '<div class="block">'.$this->_gap($this->ci->load->view('layout/default/tableform', $data, true)).'</div>';
	}	
	function add_view($content, $params = null)
	{
		$ci = & get_instance();
		$this->content_buffer .= '<div class="block_table">'.$ci->load->view($content, $params, true).'</div>';
	}
	
	function add_view_dashboard($content, $params = null)
	{
		$ci = & get_instance();
		$this->content_buffer1 .= $ci->load->view('app/dashboard/top_product', $params, true);
		$this->content_buffer2 .= $ci->load->view('app/dashboard/top_customer', $params, true);
		$this->content_buffer3 .= $ci->load->view('app/dashboard/limit_stock', $params, true);
		$this->content_buffer4 .= $ci->load->view('app/dashboard/flow_transaction', $params, true);
		$this->content_buffer5 .= $ci->load->view('app/dashboard/profit', $params, true);
		
	}
	
	function add_item($content, $title = null, $params = null)
	{
		$ci = & get_instance();
		if($title)$this->content_buffer .= '<div class="subtitle">'.$title.'</div>';
		$this->content_buffer .= '<div class="block_table">'.$ci->load->view($content, $params, true).'</div>';
	}
	function add_raw($content)
	{
		$ci = & get_instance();
		$this->content_buffer .= $content;
	}
	
	function build($title = 'Undefined Title. Please specify.', $frame = "win2", $ico = '')
	{
		$data['title'] = ucwords($title);
		$data['content1'] = $this->content_buffer;
		$data['ico'] = $ico;
		$this->block['content'] .= $this->ci->load->view('layout/default/' . $frame, $data, true);
		$this->content_buffer = "";$this->content_form_transient = "";
	}	
	
	function build_dashboard($data_title, $frame = "win2", $ico = '')
	{
		$data['title1'] = ucwords($data_title[0]);
	
		$data['content1'] = $this->content_buffer1;
		$data['content2'] = $this->content_buffer2;
		$data['content3'] = $this->content_buffer3;
		$data['content4'] = $this->content_buffer4;
		$data['content5'] = $this->content_buffer5;
		$data['ico'] = $ico;
		$this->block['content'] .= $this->ci->load->view('layout/default/' . $frame, $data, true);
		$this->content_buffer = "";$this->content_form_transient = "";
	}	
	
	function add_window($content, $params = null)
	{
		$ci = & get_instance();
		$this->content_buffer .= '<div class="block_table">'.$ci->load->view($content, $params, true).'</div>';
	}
	function build_window($frame = "win3")
	{
		$data['content'] = $this->content_buffer;
		$this->block['content'] .= $this->ci->load->view('layout/default/' . $frame, $data, true);
		$this->content_buffer = "";
	}
	function show_buffer() 
	{
		$ci = & get_instance();
		$ci->output->set_output($this->content_form_transient);
		$this->content_buffer = "";
		$this->content_form_transient = "";
	}
	function show_parameters()
	{
		global $active_group;
		$ci = & get_instance();
		
		$params['host/db'] 		= $ci->db->hostname.'/'.$ci->db->database;
		$params['set_module'] 		= "undefined";
		$params['access_name'] 		= "undefined";
		$params['access_id'] 		= "undefined";
		$params['crud mode'] 		= "undefined";
		if (isset($ci->access)) 
		{
			$params['set_module'] = $ci->access->module_code;
			$params['access_name'] = $ci->access->module_name;
			$params['access_id'] = $ci->access->module_id;

			$params['crud mode'] = $ci->access->crud();
			$params['user login'] = $ci->access->user_name . "(" . $ci->access->user_id . ")";
			$params['employee'] = $ci->access->info['employee_name'] . "(" . $ci->access->info['employee_id'] . ")";
			$params['branch'] = $ci->access->branch_name . "(" .  $ci->access->branch_id . ")";
			$params['group_id'] = $ci->access->group_id;
		}
		
		$param_split = array();
		$counter = 1;
		$page = 0;
		foreach($params as $key => $value) 
		{
			$param_split[$page][$key] = $value;
			if (($counter++ % 5) == 0) $page++;	
			
		}
		$this->block['sys_info'] = $ci->load->view('common/parameter', array('list' => $param_split), true);
	}
	
	function show_notes()
	{
		$ci = & get_instance();
		
		
		$ci->load->model('global_model');
		$message = $ci->global_model->get_announce();
 #		debug($message);
		
		# NOTIFIKASI YG SUDAH DICLOSING
		$ci->db->order_by('period_year DESC, period_month DESC');
		$ci->db->where('period_closed', 't');
		$ci->db->limit(1);
		$query = $ci->db->get('periods');
#		debug($ci->db->last_query());
		foreach($query->result() as $row) {
			$data['message'] = "Periode " . $row->period_month . "/" . $row->period_year . " Telah ditutup.";
			$rendered = $ci->load->view('common/announcer_small', $data, true);				
			$this->block['content'] = $ci->load->view('frame/plain_win', array('content' => $rendered), true) . $this->block['content'];
		}		

		# NOTIFIKASI CLOSING
		if ($message['status_active'] == 'f') return;
		
		$months = $ci->config->item('months');
#		debug($months);
		
		$data['icon'] = 'warn';
		$data['execdate'] = date('d/m/Y', $message['closing_epoch']) . " " . sprintf("%02d", $message['closing_hour']) . ":" . sprintf("%02d", $message['closing_minute']);
		$data['closeperiod'] = $months[$message['closing_period_m']] . " " . $message['closing_period_y'];
		$data['message'] = $message['announce_text'];
		
		
		$rendered = $ci->load->view('common/announcer', $data, true);
				
		$this->block['content'] = $ci->load->view('frame/plain_win', array('content' => $rendered), true) . $this->block['content'];
	}
	function get_nav()
	{
		$ci = & get_instance();
		$seg1 = $ci->uri->segment(1);
		$seg2 = $ci->uri->segment(2);
		$seg3 = $ci->uri->segment(3);
		$url = $seg1;
		if($seg2)$url .= '/'.$seg2;
		if($seg3)$url .= '/'.$seg3;
		if(!$url)return '<a href="'.base_url().'">Home</a>';
		$query = $ci->db->query("select a.menu_name as lb1,a.menu_url as url1, b.menu_name as lb2,b.menu_url as url2,c.menu_name as lb3,c.menu_url as url3 
from side_menus a
left join side_menus b on a.menu_parent=b.menu_id
left join side_menus c on b.menu_parent=c.menu_id
where a.menu_url like '$url' or a.menu_url like '$seg1'");		
		$str_nav = '';
		foreach($query->result_array() as $row)
		{
			if($row['lb1'])$str_nav = '&raquo; <a class="nav1">'.$row['lb1'].'</a> ';
			if($row['lb2'])$str_nav = ' &raquo; <a class="nav2" href="'.$row['url2'].'">'.$row['lb2'].'</a> '.$str_nav;
			if($row['lb3'])$str_nav = ' &raquo; <a class="nav3" href="'.$row['url3'].'">'.$row['lb3'].'</a> '.$str_nav;
		}
		$str_nav = '<a class="nav0" href="'.base_url().'">Home</a>'.$str_nav;
		return $str_nav;
	}
	function user_info()
	{
		$ci = & get_instance();
		if ($ci->access->is_logged()) 
		{
			$params['user_id'] = $ci->access->user_id;
			$params['employee'] = $ci->access->info['employee_name'];// . "(" . $ci->access->info['employee_id'] . ")";
			$params['employee_pic'] = $this->get_employee_pic($params['user_id']); $params['employee_pic'] = ($params['employee_pic']) ? $params['employee_pic'] : "default.jpg";
			//$params['branch'] = $ci->access->branch_name . "(" .  $ci->access->branch_id . ")";
			$params['group_name'] = $ci->access->info['group_name'];
			
			
			
			$this->block['user_info'] = $ci->load->view('common/userinfo', $params, true);
		}
	}
	function show( $title, $layout_name = '') 
	{
		$ci = & get_instance();
		
		/*if (!empty($title)) $this->title = $title;
		
		
		$this->block['title'] = $this->title;
		$this->block['menu_is_hidden'] = ($ci->session->userdata('showmenu') ? 1 : 0);
		
		$this->show_notes();
		if (!$ci->config->item('is_production')) $this->show_parameters();
		
		
		if (empty($layout_name))
		{
			$ci->load->view('common/base', $this->block);
		} 
		else 
		{
			$layout = $ci->load->view('layout/'.$layout_name, $this->block, true);
			$ci->load->view('common/base', array('body' => $layout));
		}*/
		if (isset($ci->access))
		{
			$this->block['access'] = $ci->access->crud();
		}
		$this->user_info();
		$this->block['navigation'] = $this->get_nav();
		$this->show_parameters();
		$this->title = $this->ci->config->item('app_name');
		if (!empty($title)) $this->title .= ' | '. ucwords($title);
		$this->block['title'] = $this->title;
		
		if($layout_name == "expand")
		{
			$this->add_css($this->layout . '/layout2');
			$this->add_css($this->layout . '/style2');
		}
		else
		{
			$this->add_css($this->layout . '/layout');
			$this->add_css($this->layout . '/style');	
		}
		
		$this->add_css('flick/jquery-ui-1.8.12.custom');
		
		$this->add_css('jqModal');
		//$this->add_js('jquery-1.4.2.min'); // 1.6 not support menu in ie6
		$this->add_js('jqModal');
		$this->add_js('jquery.dataTables.min');
		//$this->add_js('jquery.dataTables.min-1.6');
		$this->add_js('datatables.plugins');
		$this->add_js('jquery-ui-1.8.12.custom.min');
		$this->add_js('app');
		
		if($layout_name == "expand")
		{
			$this->ci->load->view('layout/layout', $this->block);
		}
		else
		{
			$this->ci->load->view('layout/layout1', $this->block);		
		}
	}
	function show_blank( $title, $layout_name = '') 
	{
		$this->add_css($this->layout . '/layout');
		$this->add_css($this->layout . '/style');
		$this->block['title'] = $title;
		$this->ci->load->view('layout/layout_blank', $this->block);
	}
	function use_table($used = 1)
	{
		$this->is_using_table = $used;
	}
	function get_expired_stock()
	{
		$ci = & get_instance();
		$sql = "select count(product_stock_qty) as total_expired
				from product_stocks a
				join products b on b.product_id = a.product_id
				where  a.product_stock_qty <= b.product_min_reorder
				";
		
		$query = $ci->db->query($sql);
		
		$result = null;
		foreach ($query->result_array() as $row) $result = format_html($row);
		return $result['total_expired'];
	}
	function get_employee_pic($id) { 
		$ci = & get_instance(); 
		$sql = "select employee_pic from users a join employees b on b.employee_id = a.employee_id where user_id = '$id' "; 
		$query = $ci->db->query($sql); 
		$result = null; foreach ($query->result_array() as $row) $result = format_html($row); return $result['employee_pic']; }
	
}

# -- end file -- #
