<?php

define('SYSLOG_NOTE', 0);
define('SYSLOG_ERROR', 1);

define('DATALOG_INSERT', 1);
define('DATALOG_UPDATE', 2);
define('DATALOG_DELETE', 3);

class Logger
{
	
	var $ip = '0.0.0.0';
	var $uri = '';
	var $user_id = 0;
	
	var $kode = 0;
	
	var $sys_map = array(SYSLOG_NOTE => 'NOTE', SYSLOG_ERROR => 'ERROR');
	var $data_map = array(DATALOG_INSERT => 'INSERT', DATALOG_UPDATE => 'UPDATE', DATALOG_DELETE => 'DELETE');

		
	function Logger()
	{
		$ci = & get_instance();
		$ci->load->library('access');
		$ci->load->helper('failsafe');
		
		$this->ip 	= $_SERVER['REMOTE_ADDR'];
		$this->uri	= substr(uri_string(), 1);
		$this->user_id = $ci->access->user_id;
		$this->user_login = $ci->access->user_login;
		$this->is_file_logging = $ci->config->item('log_mode') === 'file' ? true : false;
		
		if ($this->is_file_logging)
		{
			$file = $ci->config->item('syslog_file');
			force_file($file);
			$this->sys_f = fopen($file, 'a');			
			
			$file = $ci->config->item(('datalog_file'));
			force_file($file);
			$this->data_f = fopen($file, 'a');
		}
	}
	
	function _sys_db($tipe, $message)
	{
		$ci = & get_instance();
		$ci->db->insert('syslogs', array(
			'tipe' => $tipe, 
			'ip' => $this->ip, 
			'user_id' => $this->user_id, 
			'uri' => $this->uri, 
			'aksi' => $message
		));		
	}	
	
	function _data_db($tipe, $data_id)
	{
		$ci = & get_instance();
		
		$data_id = (empty($data_id) || !isset($data_id) || $data_id == 0) ? 0 : $data_id;
		
		$ci->db->insert('log_data', array(
			'log_data_type' => $tipe, 
			'log_data_code' => $this->kode,
			'log_data_data_id' => $data_id, 
			'log_data_ip' => $this->ip, 
			'log_data_module_id' => $this->module, 
			'log_data_user_id' => $this->user_id
		));		
	}
	
	
	# switcher
	
	function _syslog($tipe, $message)
	{
		if ($this->is_file_logging) $this->_sys_file($tipe, $message); 
			else $this->_sys_db($tipe, $message);
	}
	
	function _datalog($tipe, $data_id)
	{
		if ($this->kode == 0) 
		{
			$aksi = $this->data_map[$tipe];
			$this->_syslog($tipe, "MISPLACED DATALOG - $aksi -> $data_id ON $kode");
			return;
		}
		
		if ($this->is_file_logging) $this->_data_file($tipe, $data_id); 
			else $this->_data_db($tipe, $data_id);
	}
	
	
	# implementation
	
	function sys_note($message)
	{
		$this->_syslog(SYSLOG_NOTE, $message);
	}
	
	function sys_error($message)
	{
		$this->_syslog(SYSLOG_ERROR, $message);
	}	
	
	function data_insert($data_id)
	{
		$this->_datalog(DATALOG_INSERT, $data_id);
	}
	
	function data_update($data_id)
	{
		$this->_datalog(DATALOG_UPDATE, $data_id);
	}
	
	function data_delete($data_id)
	{
		$this->_datalog(DATALOG_DELETE, $data_id);
	}
	
	# viewer
	function get_syslog($limit)
	{
		$ci = & get_instance();
		
		$ci->db->select('a.*, EXTRACT(EPOCH FROM waktu) AS waktu_epoch, b.nama_login AS user_nama');
		$ci->db->from('syslogs a');
		$ci->db->join('users b', 'a.user_id = b.user_id');
		$ci->db->order_by('waktu DESC');
		$query = $ci->db->get();
		
		$data = $query->result_array();
		foreach($data as $key => $value)
		{
			$data[$key]['waktu'] = date('d-m-Y H:i:s', $data[$key]['waktu_epoch']);
		}		
		
		return $ci->load->view('status/logviewer', array('list' => $data), true);	
	}
	
	function get_datalog($data_id, $limit)
	{
		$ci = & get_instance();
		
		$ci->db->select('a.*, EXTRACT(EPOCH FROM waktu) AS waktu_epoch, b.nama_login AS user_nama');
		$ci->db->from('log_data a');
		$ci->db->join('users b', 'a.user_id = b.user_id');
		$ci->db->where(array('a.kode' => $this->kode, 'data_id' => $data_id));
		$ci->db->order_by('waktu DESC');
		$query = $ci->db->get();
		
		$data = $query->result_array();
		foreach($data as $key => $value)
		{
			$data[$key]['waktu'] = date('d-m-Y H:i:s', $data[$key]['waktu_epoch']);
			$data[$key]['aksi'] = $this->data_map[$data[$key]['tipe']];
		}		
		
		return $ci->load->view('status/logviewer', array('list' => $data), true);	
	}
	
}

# -- end file -- #