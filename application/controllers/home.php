<?php

class Home extends CI_Controller
{
	var $raw;
	var $root;

	function index()
	{
	
		$this->load->library('access');
		if (!$this->access->is_logged()) redirect('login');
		
		$this->load->library('render');
		$data = $this->user_model->get_user_login_info();
		$data['user_name'] = $data['employee_name'];
		$data['group_name'] = $data['group_name'];
		$data['market_name'] = '';
		$data['last_login'] = strtotime($data['last_time']);
		//$data['approval_count'] = $this->user_model->get_user_approval();
		
		$data['last_activity'] = '';
		$last_act = $this->user_model->get_user_last_activity();
		if($last_act)
		{
			$data['last_activity'] = '['.$last_act['log_action_type_name'].'] <a href="'.site_url($last_act['menu_url']).'">'.$last_act['log_data_remark'].'</a>';
		}
		$this->render->add_view('common/home', $data);
		$this->render->build('Informasi');

		$this->render->show('Home', 'Home');

	}

	function setup() 
	{		
		$this->load->library('access');
#		debug('logged = ' . $this->session->userdata('logged'));
#		debug('user_info = ' . $this->session->userdata('user_info'));
#		exit;
		$this->access->user_page();
		
		$this->load->model('menu_model');
		$data = $this->menu_model->get_menu_data($this->access->group_id);
		
		$this->raw = $data[0];
		$this->root = $data[1];
		
		$this->_setup_walker(1);
		
		$menu = $this->_visible_walker(1);
		$this->session->set_userdata('menubar', $menu);
		
		$redir = $this->session->userdata('redir');
		if (!$redir) redirect(''); else { 
			if(!isset($redir['redir_url']))redirect('');
			else redirect(site_url($redir['redir_url']));
			
		}
		$this->session->set_userdata('redir', NULL);
		$this->session->set_userdata('showmenu', 1);
		
	}

	function _setup_walker($p, $depth = 0)
	{	

		$visible = false;
#		if ($p !=0) debug(str_repeat(".&nbsp;&nbsp;&nbsp;", $depth) . $p . " " . $this->raw[$p]['name'] . "-" .$this->raw[$p]['visible'] );	
		
		if (!isset($this->root[$p])) return $this->raw[$p]['visible'];
		
		foreach($this->root[$p] as $v) if ($this->_setup_walker($v, $depth + 1) == 1) $visible = true;
		
		$this->raw[$p]['visible'] = $visible;

		return $visible;
	}
	
	function _visible_walker_backup($p, $depth = 0)
	{
#		debug($depth);
		
		
		$str = '';
		

		
			$str .= '<li><a href="' . site_url($this->raw[$p]['url']) . '">' . $this->raw[$p]['name'] . '</a>';
		
//print_r($this->root);exit;
		if (isset($this->root[$p])) 
		{
			$item = '';
			foreach($this->root[$p] as $v) $item .= $this->_visible_walker($v, $depth + 1);
			//if($p != 1) $str .= '</li>';
			if (!empty($item)) 
			{
				if ($p == 1) {
					$pos_menu = $this->config->item('pos_menu')?'sf-vertical':'';
					$str .= '<ul id="mainmenu" class="sf-menu '.$pos_menu.'">' . $item . '</ul>'; 
				}
				else $str .= '<ul parent="' . $p . '">' . $item . "</li>\n</ul>";
			}
		}
		else if ($p != 1) $str .= "</li>\n";
		return $str;

	}

	function _visible_walker($p, $depth = 0)
	{
#		debug($depth);
		
		
		$str = '';

		if (($p != 1) && ($this->raw[$p]['visible'] == 1)) {
		
			$str .= '<li ';
			
			if($this->raw[$p]['parent'] == 1 && $this->raw[$p]['url'] != "dashboard"){
				$str .= ' class="treeview"';
			}
			
			$icon = ($this->raw[$p]['icon']) ? $this->raw[$p]['icon'] : "fa-chevron-circle-right";
			
			$str .= '>
					<a href="'.site_url($this->raw[$p]['url']).'">
					<i class="fa '.$icon.'"></i>
					<span>'.$this->raw[$p]['name'].'</span>';
					
			if($this->raw[$p]['parent'] == 1 && $this->raw[$p]['url'] != "dashboard"){
				$str .= '<i class="fa fa-angle-left pull-right"></i>';
			}
					
			$str .= '</a>
					'; 
		}
		
		
//print_r($this->root);exit;
		if (isset($this->root[$p])) 
		{
			$item = '';
			foreach($this->root[$p] as $v) $item .= $this->_visible_walker($v, $depth + 1);
			//if($p != 1) $str .= '</li>';
			
			if (!empty($item)) 
			{
				if ($p == 1) {
					$str .= '<ul class="sidebar-menu">' . $item . '</ul>'; 
					
				}
				else{ 
					$str .= '<ul class="treeview-menu">' . $item . "</li>\n</ul>";
					
				}
			}
		}
		else if ($p != 1) $str .= "</li>\n";
		return $str;
	}
	
	function _visible_walker_old($p, $depth = 0)
	{
#		debug($depth);
		
		
		$str = '';

		if (($p != 1) && ($this->raw[$p]['visible'] == 1)) {
			
			$icon = ($this->raw[$p]['icon']) ? $this->raw[$p]['icon'] : "fa-chevron-circle-right";
			
			$str .= '<li'; 
			
			$str .= '>
					<a href="'.site_url($this->raw[$p]['url']).'">
					<i class="fa '.$icon.'"></i>
					<span>'.$this->raw[$p]['name'].'</span>';
		}
//print_r($this->root);exit;
		if (isset($this->root[$p])) 
		{
			$item = '';
			foreach($this->root[$p] as $v) $item .= $this->_visible_walker($v, $depth + 1);
			//if($p != 1) $str .= '</li>';
			if (!empty($item)) 
			{
				
				
				if ($p == 1) {
					$str .= '<ul class="sidebar-menu">' . $item . '</ul>'; 
					
				}
				else{ 
					$str .= '<ul class="treeview-menu">' . $item . "</li>\n</ul>";
					
				}
			}
		}
		else if ($p != 1) $str .= "</li>\n";
		return $str;

	}
	
	function go() 
	{	
		$this->load->library('access');
		
		$code = $this->uri->segment(3);
		if (!$code) redirect('login');
		
		$this->load->model('redirect_model');
		
		$redir = $this->redirect_model->get($code);
		
#		debug($this->access->user_id . ' = ' . $redir['redir_user_id']);
		if(!$redir)
		{
			$this->load->library('dialog');
			$this->dialog->flash_note('Error','Link tidak ditemukan', 'home');
			return;
		}
		if ($this->access->user_id != $redir['redir_user_id']) 
		{
			$this->session->set_userdata('redir', $redir);
			redirect(site_url('login/force'));			
		}
		
		redirect(site_url($redir['redir_url']));
	}
	
	function branch($commit = NULL)
	{
	
		$this->load->library('access');
		$this->access->set_module('global.branchto');		
		$this->access->user_page();
		
		$branch_id = $this->input->post('i_branch');
		
		if ($commit) 
		{
			$this->load->library('common');
			$this->common->lognlock($this->access->user_id, $branch_id);
			redirect('home');	
			return;
		}
			
		
		$this->load->model('user_model');
		$list_branch = $this->user_model->get_branch_all();
		
		
		$this->load->library('render');
		$branch_id = $this->access->branch_id;
		$this->render->add_form('freeform', 'common/branchto', array('list' => $list_branch, 'branch_id'=>$branch_id));
		$this->render->build('Pindah Cabang');
		
		$this->render->show('blank', 'Cabang');
	}
	
	function setmenu($is_set = NULL) {
		$this->load->library('access');	
		$this->access->user_page();
		$this->session->set_userdata('showmenu', ($is_set ? 1 : 0));
		echo "ok";
	}
	
	function getmenu() {
		$this->load->library('access');	
		$this->access->user_page();
		$status = $this->session->userdata('showmenu');
		echo $status;
	}


}

#
