<?php 

define('ACCESS_CREATE', 'c');
define('ACCESS_READ', 	'r');
define('ACCESS_UPDATE', 'u');
define('ACCESS_DELETE', 'd');

class Access
{
	var $user_id;
	var $user_name;
	
	var $branch_id;
	var $branch_name;
	var $branch_code;
	
	var $group_id;
	var $group_name;
	
	var $info;

	var $module_id;
	var $menubar;
	var $ip;

	function Access()
	{
		$ci = & get_instance();
		$ci->load->model('user_model', 'user_model');

		
		
		$this->user_id = NULL;
		$this->user_name = 'Guest';
		$this->user_login = NULL ;
		
		$this->group_name = '---';
		
		$this->branch_id = NULL;
		$this->branch_name = '---';
		$this->branch_code = NULL;
		
		$this->module_id = NULL;
		$this->module_code = NULL;
		$this->module_name = NULL;
		$this->ip 	= $_SERVER['REMOTE_ADDR'];
		$this->info = NULL;
		
		if ($this->is_logged()) 
		{
			$this->_get_user_info();
			$this->menubar = $ci->session->userdata('menubar');
		}
	}
	
	function set_module($module_code)
	{
		$ci = & get_instance();
		$row = $ci->user_model->get_module_code($module_code);
		if (!$row) return;
		$this->module_id = $row['module_id'];
		$this->module_code = $row['module_code'];
		$this->module_name = $row['module_name'];
	}
	
	function set_module_id($module_id)
	{
		$ci = & get_instance();
		$row = $ci->user_model->get_module_id($module_id);
		if (!$row) return;
		$this->module_id = $row['module_id'];
		$this->module_code = $row['module_code'];
		$this->module_name = $row['module_name'];
	}

	function is_logged()
	{
		$ci = & get_instance();
		$logged = $ci->session->userdata('logged');
		return $logged;
	}
	
	function _get_user_info() 
	{
			$ci = & get_instance();
			
			$this->info = $ci->session->userdata('user_info');
			if (!$this->info) return;

			$this->user_id = $this->info['user_id'];	
			$this->user_name = $this->info['user_login'];

			//$this->branch_id  	= $this->info['branch_id'];
			//$this->branch_name 	= $this->info['branch_name'];
			//$this->branch_code 	= $this->info['branch_code'];

			$this->group_id = $this->info['user_group_id'];
			//$this->group_name = $this->info['group_name'];

			foreach($this->info as $key => $value) $this->info[str_replace("user_", "", $key)] = $value;
			//$this->info['branch_id'] = $this->branch_id;		
	}
	
	function is_user()
	{
		$ci = & get_instance();
		
		if ($this->is_logged()) return true;		
		return false;
	}
	
	function is_root()
	{
		if (!$this->is_user()) return false;
		return ($this->user_id == 1);
	}

	function user_state($column)
	{
		if (!$this->is_user()) 	return null;
		
		return $column ? $this->info[$column] : $this->info;
	}
	
	function crud()
	{
		$ci = & get_instance();	
		
		if ($this->is_root()) return 'crud';
		
		
		# klo bukan root, apa bisa akses modul ?
		return trim($ci->user_model->get_crud_mode($this->group_id, $this->module_id));
	}
	
	# layer 1 protection: only user
	function user_page()
	{
		# apakah member ? klo bukan sudah pasti nda bisa masuk
		if (!$this->is_user()) 
		{
			$ci = & get_instance();	
			$ci->load->library('dialog');
			$ci->dialog->flash_note('Akses Ditolak', 'Halaman ini hanya untuk karyawan. Kami akan membawa Anda ke halaman Login.', 'login');
			return false;
		}
		
		return true;
	}
	
	# layer 2
	function root_page()
	{
		# apakah root ? klo bukan sudah pasti nda bisa masuk
		if (!$this->is_root()) 
		{
			$ci = & get_instance();
			$redir_url = $ci->uri->uri_string();
			$ci->session->set_userdata('redir', array('redir_url' => $redir_url));
			$ci->load->library('dialog');
			$ci->dialog->flash_note('Akses Ditolak', 'Halaman ini hanya untuk System Administrator.', 'login');
			return false;
		}
		
		return true;
	}
	
	
	# layer 3 protection : access filter
	function crud_page($access)
	{	
		$ci = & get_instance();
		
		# apakah member ? klo bukan sudah pasti nda bisa masuk
		if (!$this->is_user()) 
		{
			$ci->load->library('dialog');
			$ci->dialog->flash_note('Akses Ditolak', 'Halaman ini hanya untuk karyawan.', 'login');
			return false;
		}
		
		$crud_mode = $this->crud();		
		
		# bila benar user, cek apa dia operator / staff
		if (empty($crud_mode))
		{
			$ci->load->library('dialog');
			$ci->dialog->flash_note('Akses Modul Diperlukan', 'Halaman ini hanya untuk staff/operator sistem.', 'login');
			return false;
		} 
		
		# benar ? .. cek apakah punya akses yang diperlukan ?
		if (strpos($crud_mode, $access) === false)
		{
			$ci->load->library('dialog');
			$ci->dialog->flash_note('Akses Tertentu Diperlukan', 'Akses Anda tidak cukup untuk mengakses halaman ini.', 'login');
			return false;
		}
		
		return true;		
	}
	
	function create_page()
	{
		return $this->crud_page(ACCESS_CREATE);
	}
	
	function read_page()
	{
		return $this->crud_page(ACCESS_READ);
	}
	
	function update_page()
	{
		return $this->crud_page(ACCESS_UPDATE);
	}
	
	function delete_page()
	{
		return $this->crud_page(ACCESS_DELETE);
	}
	
	## LOGGING
	# transaction log
	function log_data_db($tipe, $data_id, $remark)
	{
		$ci = & get_instance();	
		if(!$this->module_id)
		{
			log_message('error', 'Akses modul belum diset. '. $remark);
			return;
		}
		$ci->user_model->log_data_insert($tipe, $this->module_id, $data_id, $this->ip, $this->user_id, $remark);		
	}
	
	function log_insert($data_id, $remark)
	{
		$this->log_data_db(0, $data_id, $remark);
	}
	
	function log_update($data_id, $remark)
	{
		$this->log_data_db(1, $data_id, $remark);
	}
	
	function log_delete($data_id, $remark)
	{
		$this->log_data_db(2, $data_id, $remark);
	}
	
	function generate_log_view($data_id = '')
	{
		$ci = & get_instance();	
		$data = $ci->user_model->get_log_view($this->module_id, $data_id);
		$ci->render->add_view('common/log', array('list' => $data));
		$ci->render->build('Data Log', "win2", 'clock-history-frame-icon.png');		
	}
	
	function generate_doc_status_view($data_id, $module_id = 0)
	{

		$ci = & get_instance();
		if($module_id == 0)$module_id=$this->module_id;
		/*$query = $ci->db->get_where('cancelation', array('module_id' => $module_id, 'cancelation_data_id' => $data_id, 'cancelation_is_approved'=>'f','cancelation_is_rejected'=>'f'));
		if ($query->num_rows() != 0)
		{
			$data = array('pic' => 'doc_rejected', 'text' => 'Dokumen ini sedang dibatalkan');		
			$ci->render->add_view('common/doc_status', array('data' => $data));
			$ci->render->build('Status Dokumen');
			return 1;
		}*/
		
		$query = $ci->db->get_where('approvals', array('approval_module_id' => $module_id, 'approval_data_id' => $data_id));

		$last = 0;
		$employee = '';
		$approval_remark = '';
		#echo $ci->db->last_query();exit;
		if ($query->num_rows() == 0)
		{
			$last = 3;		
			
		} else {
		
			$approval_id = $query->row()->approval_id;
			$approval_remark = $query->row()->approval_reject_remark;
			$ci->db->order_by('approval_employee_index', 'DESC');
			$ci->db->join('employees e', 'v.employee_id = e.employee_id');
			$query = $ci->db->get_where('approval_voters v', array('approval_id' => $approval_id, 'approval_employee_exec' => 't'));
		
			if ($query->num_rows() == 0) $last = 4; else 
			{
				$row = $query->row();
				$last = $row->approval_employee_status;
				if ($last == 2 || $last == 0) $employee = '<font color="#0e23ad"><b>' . $row->employee_name . "</b></font>, NIK: <font color=\"#0d7313\">" . $row->employee_nip . '</font>';
			}
		
		}
		
		$data[] = array('pic' => 'doc_waiting', 'text' => "Dokumen menunggu persetujuan oleh $employee");		
		$data[] = array('pic' => 'doc_approved', 'text' => 'Dokumen telah DISETUJUI');		
		$data[] = array('pic' => 'doc_rejected', 'text' => "Dokumen DITOLAK oleh $employee<br /><b>Alasan:</b> <font color=red>$approval_remark</font>");
		$data[] = array('pic' => 'doc_waiting', 'text' => 'Dokumen menunggu VERIFIKASI atau tahap lain yang harus dipenuhi.');
		$data[] = array('pic' => 'doc_waiting', 'text' => 'APPROVAL ERROR');		
		
		$ci->render->add_view('common/doc_status', array('data' => $data[$last]));
		$ci->render->build('Status Dokumen');
		return 0;		

	}
	function user_activity($user_id = 0)
	{

		$ci = & get_instance();
		
		if($user_id == 0)$user_id=$this->user_id;
		$query = $ci->db->get_where('log_data', array('log_data_user_id' => $user_id));

		return 1;	

	}
	
}

# -- end file -- #
