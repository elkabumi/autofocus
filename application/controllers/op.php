<?php

class Op extends CI_Controller {

	function index()
	{
		$id = $this->session->userdata('user_id');
		if (empty($id)) { echo "empty"; return; }
		echo "ok";
	}
	
	function note() {
		$this->load->library('dialog');
		if (!$this->dialog->flash_trap()) redirect('/');
	}
	
	function frep($code)
	{
		$code = $this->uri->segment(3);
		if (!$code) redirect('home');
		
		$tmp_dir = $this->config->item('report_proc_path');
		$rep_out = $tmp_dir . $code;		
		
		$this->load->library('Regen');
		$this->regen->output('pdf', $rep_out, false);
		exit;
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
