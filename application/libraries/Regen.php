<?php

define("REGEN_STRING", 	"paramString");
define("REGEN_INTEGER", "paramInteger");
define("REGEN_LONG", "paramLong");
define("REGEN_DATE", 	"paramDate");
define("REGEN_NUMERIC", "paramNumeric");
define("REGEN_SYSTEM",  "paramSystem");
define("REGEN_BOOLEAN", "paramBoolean");

class Regen 
{
	var $param = array();
	var	$count = 0;
	var $rep_file_name = "";
	var $unique_name = "";

	function Regen() 
	{ 
		#global $db, $active_group;

		$this->param[REGEN_STRING] = array();
		$this->param[REGEN_INTEGER] = array();
		$this->param[REGEN_DATE] = array();
		$this->param[REGEN_NUMERIC] = array();
		$this->param[REGEN_BOOLEAN] = array();
		$this->param[REGEN_SYSTEM] = array();
		
		$ci = & get_instance();
		
		$ci->load->dbutil();
		$ci->dbutil->db;
		$port = $ci->db->port ? ':'.$ci->db->port : '';
		$this->add_parameter('HOST', $ci->db->hostname.$port, REGEN_SYSTEM);
		$this->add_parameter('USER', $ci->db->username, REGEN_SYSTEM);
		$this->add_parameter('PASS', $ci->db->password, REGEN_SYSTEM);
		$this->add_parameter('DB', $ci->db->database, REGEN_SYSTEM);

		$script_uri = str_replace("index.php", "", $_SERVER["SCRIPT_FILENAME"]) . "system/application/reports/";
		//echo $script_uri;
		//exit;
		
		$this->add_parameter('SUBREPORT_DIR', $script_uri, REGEN_SYSTEM);

	}

	function set_title($number = 'TX99', $title = 'NO TITLE. PLEASE SPECIFY.', $subtitle = 'NO SUBTITLE. PUT EMPTY STRING TO OVERRIDE THIS.',$branch_name='')
	{
		$ci = & get_instance();
		
		$now = time();

		$number = trim($number);
		$title = trim($title);
		$subtitle = trim($subtitle);
		$branch_name = trim($branch_name);

		$this->add_parameter('PNUMBER', $number, REGEN_STRING);
		$this->add_parameter('PTITLE', $title, REGEN_STRING);
		$this->add_parameter('PSUBTITLE', $subtitle, REGEN_STRING);
		$this->add_parameter('PAPPLICATION', $ci->config->item('app_name'), REGEN_STRING);
		$this->add_parameter('PEMPLOYEE', $ci->access->info['name'], REGEN_STRING);
		$this->add_parameter('PWHEN', date('d-m-Y H:i:s', $now), REGEN_STRING);
		$this->add_parameter('PBASEURL', base_url(), REGEN_STRING);
		$this->add_parameter('PBRANCH',$branch_name, REGEN_STRING);
		
		$allow_char = strtoupper("abcdefghijklmnopqrstuvwxyz0123456789_ ");
		$title_len = strlen($title);
		$new_title = "";
		for($i=0; $i < $title_len; $i++) {
			if (strpos($allow_char, $title[$i]) !== FALSE) {
				$new_title .= $title[$i];
			}
		}
		
		//debug($title);
		//debug($title[3]);
		//debug($new_title);
		
		$this->rep_file_name =  $number . "_" . str_replace(" ", "_", strtolower($new_title));
		$this->unique_name =  $_SERVER['REMOTE_ADDR'] . "_" . date('YmdHis'); 
	}

	function add_parameter($key, $value, $type = REGEN_STRING)
	{
		$this->param[$type][$this->count]['key'] 	= $key;
		$this->param[$type][$this->count]['value'] 	= $value;
		$this->count++;
	}

	function build_show($report_name, $export_type = "pdf", $source_type = 'jasper')
	{
		$this->build($report_name, $export_type, FALSE, $source_type);
	}

	function build_download($report_name, $export_type = "pdf", $source_type = 'jasper') 
	{
		$this->build($report_name, $export_type, TRUE, $source_type);
	}
	
	function build_once($report_name, $next_page)
	{
		$this->build($report_name, $export_type = "pdfx", FALSE, $source_type = 'jasper', TRUE, $next_page);
	}

	function build($report_name, $export_type = "pdf", $is_download = FALSE, $source_type = 'jasper', $is_once = FALSE, $next_page = "")
	{
		$ci = & get_instance();

		$tmp_dir = $ci->config->item('report_proc_path');
		$rep_dir = $ci->config->item('report_bank_path');
		$bin_dir = $ci->config->item('tools_path');
		
		$rep_src = $rep_dir.$report_name;
		if (($export_type == 'xls') && file_exists($rep_src."_xl.$source_type")) $rep_src.= "_xl";
	
		$rep_src.= ".$source_type";
		$rep_out = $tmp_dir . $this->unique_name; 
		$rep_con = $tmp_dir . $this->unique_name . ".xml";

		$this->add_parameter('SOURCE_FILE', $rep_src, REGEN_SYSTEM);
		$this->add_parameter('SOURCE_TYPE', $source_type, REGEN_SYSTEM);
		$this->add_parameter('OUTPUT_FILE', $rep_out, REGEN_SYSTEM);
		$this->add_parameter('OUTPUT_TYPE', $export_type, REGEN_SYSTEM);
	
		$data = $ci->load->view('common/connector', array('list' => $this->param), TRUE);
		file_put_contents($rep_con, $data);

		$script = "java -jar system/tools/rep.jar $rep_con";
		$out = `$script`;
		@unlink($rep_con);
		
		if (strcmp(trim($out), 'done.') == 0) 
		{
			if ($is_once)
			{
				sleep(2);
				$this->printonce_dialog($next_page);
				return;
				
			} else {
			
				$this->output($export_type, $rep_out, $is_download);
						
			}
			
		} else {
			
			echo $out;
			
		}
		
	}
	
	function printonce_dialog($next_page = "#")
	{
		$ci = & get_instance();
		
		$ci->load->library('render');
		
		$data = array();
		$data['source_url'] = site_url("op/frep/" . $this->unique_name);
		$data['next_page'] = site_url($next_page);

		$ci->render->add_view('common/printonce', $data);
		$ci->render->build('Cetak');
		$ci->render->show('dialog', 'Cetak');
		
	}
	
	function output($export_type, $rep_out, $is_download)
	{
		if (file_exists($rep_out)) {
				
			if ($export_type == 'xls') header('Content-type: application/vnd.ms-excel'); else header('Content-type: application/pdf');
			if ($is_download) header('Content-Disposition: attachment; filename=' . basename($this->rep_file_name . '.'.$export_type));
			
			header('Expires: 0');
			header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
			
			readfile($rep_out);		
			@unlink($rep_out);
			exit;
			
		} else {

			echo "failed.";

		}
	}
	
	function get($report_name)
	{
		$ci = & get_instance();
		$is_download = $ci->input->post('mode');
		$file_type = $ci->input->post('download_to');		
		if ($is_download) $this->build_download($report_name, $file_type); 
		else $this->build_show($report_name);
	}
}

# ---- #
