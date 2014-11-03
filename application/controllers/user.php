<?php

class user extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		
		$this->access->set_module('tool.user');
		//$this->access->user_page();
		$this->load->model('user_model');

	}
	
	// halaman utama, menampilkan links ke module2x User
	function index()
	{
		$this->load->library('render');
		$this->render->add_view('app/user/user/list');
		$this->render->build('Daftar User');
		$this->render->show('User', 'User Module');
	}
	
	function user_inactive()
	{
		$this->load->library('render');
		$this->render->add_view('app/user/user/listna');
		$this->render->build('Daftar User Non Aktif');
		$this->render->show('User', 'User Module');
	}
	
	// --------------------------------------------------------------------------------------------------------
	// MODUL USER
	// USER -- menampilkan daftar seluruh user

	
	function user_table_controller()
	{
		$this->load->model('user_model');
		$data = $this->user_model->user_list_controller(get_datatables_control());
		send_json($data); 
	}
	
	function userna_table_controller()
	{
		$this->load->model('user_model');
		$data = $this->user_model->userna_list_controller(get_datatables_control());
		send_json($data); 
	}
	
	
	
	//create data user
	function user_form($id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{
		$this->load->library('render');
		
		$data = array();
		
		if ($id == 0) {
			
			// FORM CREATE - isi form dengan nilai default / kosong
			$data['row_id'] 		= '';
			$data['user_login'] 	= '';
			$data['user_name'] 		= '';			
			$data['user_password'] = '';
			$data['user_group'] 	= '0';
			$data['user_email'] 	= '';	
			$data['user_phone'] 	= '';
			$data['job_title'] 		= '';	
			$data['company'] 		='' ;
			$data['expired_date'] 	= date('d/m/Y'); 
			
			
			$data['employee_id'] = '';
			$data['employee_pic'] = '';
			$this->render->add_form('app/user/user/form', $data);
			$this->render->build('User');
		
		} else {
			
			// FORM UPDATE - ambil data yang diedit kemudian tampilkan dalam form
			$this->load->model('user_model');
			$result = $this->user_model->user_read_id($id);
			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data_form['row_id'] 		= $result['user_id'];
				$data_form['user_login'] 	= $result['user_login'];
				$data_form['user_name'] 	= $result['user_name'];			
				$data_form['user_group'] 	= $result['user_group_id']?$result['user_group_id']:0;
				$data_form['user_email'] 	= $result['user_email'];	
				$data_form['user_phone'] 	= $result['user_phone'];
				$data_form['job_title'] 	= $result['job_title'];	
				$data_form['company'] 		= $result['company'];
				$data_form['expired_date']	= format_new_date($result['expired_date']);
				$data_form['employee_id'] 	= $result['employee_id'];
				
					
				$data_form['employee_pic']	= $result['employee_pic'];;
				$this->render->add_form('app/user/user/form', $data_form);
				$this->render->build('User');
			//	$this->access->generate_log_view($id);
			}
			else // tidak ada? tampilkan error.
			{
				$this->load->library('dialog');
				$this->dialog->flash_note('Error', 'Data tidak ditemukan', 'user/user');
			}
		}
		$this->render->add_js('ajaxfileupload');	
				
		$this->render->show('User');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	///
	function user_form2($id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{
		$this->load->library('render');
		
		$data = array();
		
		if ($id == 0) {
			
			// FORM CREATE - isi form dengan nilai default / kosong
			$data['row_id'] = '';
			$data['user_login'] = '';
			$data['user_name'] = '';			
			$data['user_password'] = '';
			$data['user_group'] = '0';
			$data['employee_id'] = '';
			$this->render->add_form('app/user/user/form2', $data);
			$this->render->build('User');
		
		} else {
			
			// FORM UPDATE - ambil data yang diedit kemudian tampilkan dalam form
			$this->load->model('user_model');
			$result = $this->user_model->user_read_id($id);
			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data_form['row_id'] 		= $result['user_id'];
				$data_form['user_login'] 	= $result['user_login'];
				$data_form['user_name'] 	= $result['user_name'];			
				$data_form['user_group'] 	= $result['user_group_id']?$result['user_group_id']:0;
				$data_form['employee_id'] 	= $result['employee_id'];	
				$this->render->add_form('app/user/user/form2', $data_form);
				$this->render->build('Ganti Password');
				$this->access->generate_log_view($id);
			}
			else // tidak ada? tampilkan error.
			{
				$this->load->library('dialog');
				$this->dialog->flash_note('Error', 'Data tidak ditemukan', 'user/user');
			}
		}
				
		$this->render->show('User');
	}
	
	function userna_form($id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{
		$this->load->library('render');
		
		$data = array();
		
		if ($id == 0) {
			$this->library->load('dialog');
			$this->dialog->flash_note('Data tidak ditemukan', 'user/user_inactive');
		} else {
			$this->load->model('user_model');
			$result = $this->user_model->userna_read_id($id);
			
			if ($result)
			{
				$data_form['row_id'] 		= " ";
				$data_form['user_id']		= $result['user_id'];
				$data_form['user_login'] 	= $result['user_login'];
				$data_form['user_name'] 	= $result['user_name'];			
				$data_form['user_group'] 	= $result['user_group_id'];
				$data_form['employee_id'] 	= $result['employee_id'];	
		 		$this->render->add_form('freeform','app/user/user/formna', $data_form);
				$this->render->build('User Non Aktif');
				$this->access->generate_log_view($id);
			}
			else
			{
				$this->library->load('dialog');
				$this->dialog->flash_note('Data tidak ditemukan', 'app/user/user/list');
			}
		}
		$this->render->show('blank', 'User Non Aktif');
	}
	
	
	
	
	
	//action user
	function user_form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');  // selalu ada di _action()
		
		if ($is_delete) 
		{
			$id = $this->input->post('row_id');
		
			$error = $this->user_model->delete($id);
			send_json_action($error, "Data telah dihapus", "Data gagal dihapus");
		} 			
			$this->form_validation->set_rules('i_sandi1', 'Password', 'trim|required|matches[i_sandi2]');
			$this->form_validation->set_rules('i_sandi2', 'Konfirmasi Password', 'trim|required');
			$this->form_validation->set_rules('i_group', 'Group ID', 'trim|integer|required');
			$this->form_validation->set_rules('i_user_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('i_login', 'Username', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('i_user_email','Email', 'trim|required');
			$this->form_validation->set_rules('i_user_phone','No Telepon', 'trim|required');
			$this->form_validation->set_rules('i_job_title','Job Title', 'trim|required');
			$this->form_validation->set_rules('i_company','Company', 'trim|required');
			$this->form_validation->set_rules('i_expired_date','Expired date','trim|required|valid_date|sql_date');
			
			$data['user_login'] 	= trim($this->input->post('i_login'));
			$id = $this->input->post('row_id');
			if(!$this->user_model->cek_user_log_name($data['user_login'],$id))send_json_error('Mohon gunakan nama user login dengan nama lain');
		
			if ($this->form_validation->run() == FALSE) send_json_validate(); 
			
			$data['user_password'] 		= md5($this->input->post('i_sandi1'));
			$data['user_group_id'] 		= $this->input->post('i_group');
			$data['user_login'] 		= $this->input->post('i_login');
			$data['user_email'] 		= $this->input->post('i_user_email');
			$data['user_phone'] 		= $this->input->post('i_user_phone');
			$data['user_email'] 		= $this->input->post('i_user_email');
			$data['job_title'] 			= $this->input->post('i_job_title');
			$data['company'] 			= $this->input->post('i_company');
			$data['expired_date'] 		= $this->input->post('i_expired_date');
			
			$data['user_last_login']	= date("Y-m-d H:m:s");
			$data['user_registered']	= date("Y-m-d H:m:s");
			$data['user_is_active'] 	= 1;
			
			$employe['employee_name'] 	= $this->input->post('i_user_name');
			$employe['employee_pic'] 	= $this->input->post('i_photo');
			$employe['employee_id'] 	= $this->input->post('employee_id');
			$old_pic 					= $this->input->post('i_oldphoto');

			$id = $this->input->post('row_id');
			
		if (empty($id)) 
		{
			$error = $this->user_model->user_create($data,$employe);
			if($error)if($employe['employee_pic'])rename($this->config->item('upload_tmp').$employe['employee_pic'], $this->config->item('upload_storage')."img_employee/".$employe['employee_pic']);	
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}else{
			if($employe['employee_pic'] != $old_pic) rename($this->config->item('upload_tmp').$employe['employee_pic'], $this->config->item('upload_storage')."img_employee/".$employe['employee_pic']);
			$error = $this->user_model->user_update($id, $data,$employe);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");		
		}
		
		//$nip = $this->input->post('i_nip');
		/*if (empty($id)) 
		{
			$this->form_validation->set_rules('i_sandi1', 'Password', 'trim|required|matches[i_sandi2]');
			$this->form_validation->set_rules('i_sandi2', 'Konfirmasi Password', 'trim|required');
			$this->form_validation->set_rules('i_group', 'Group ID', 'trim|integer|required');
			$this->form_validation->set_rules('i_karyawan', 'Karyawan', 'trim|integer|required');
			if(!$nip)$this->form_validation->set_rules('i_ulogin', 'ID Login', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) send_json_validate(); 
			
			$data['user_password'] 		= md5($this->input->post('i_sandi1'));
			$data['user_group_id'] 		= $this->input->post('i_group');
			$data['employee_id'] 		= $this->input->post('i_karyawan');
			$data['user_is_active'] 	= 1;
			$data['user_last_login']	= date("Y-m-d H:m:s");
			$data['user_registered']	= date("Y-m-d H:m:s");
			
			$result = $this->user_model->is_user_active($data['employee_id']);
			if ($result['user_id']) 
			{
				send_json_error('Data Karyawan Sudah Digunakan'); // otomatis exit jadi nda perlu di return
			}
			
			$result1 = $this->user_model->employee_read_id($data['employee_id']);
			$data['user_login'] 	= trim($result1['employee_nip']);
			$data['user_name'] 		= trim($result1['employee_name']);
			if(!$nip)
			{
				$data['user_login'] 	= trim($this->input->post('i_ulogin'));
				if(!$this->user_model->cek_unik_user($data['user_login']))send_json_error('ID User tidak boleh sama dengan NIP Pegawai');
			}
			$error = $this->user_model->user_create($data);

			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$sandi1 = $this->input->post('i_sandi1');
			$sandi2 = $this->input->post('i_sandi2');
			
			if ((strlen($sandi1) < 1)&&(strlen($sandi2) < 1))  
			{
				$this->form_validation->set_rules('i_group', 'Group ID', 'trim|integer|required');
				$this->form_validation->set_rules('i_karyawan', 'Karyawan', 'trim|integer|required');
				if(!$nip)$this->form_validation->set_rules('i_ulogin', 'ID Login', 'trim|required');
				if ($this->form_validation->run() == FALSE) send_json_validate();
				
				$data['user_group_id'] 		= $this->input->post('i_group');
				$data['employee_id'] 		= $this->input->post('i_karyawan');
				
				$result1 = $this->user_model->employee_read_id($data['employee_id']);
				$data['user_login'] 	= trim($result1['employee_nip']);
				$data['user_name'] 		= trim($result1['employee_name']);
				if(!$nip)
			{
				$data['user_login'] 	= trim($this->input->post('i_ulogin'));
				if(!$this->user_model->cek_unik_user($data['user_login'], $id))send_json_error('ID User tidak boleh sama dengan NIP Pegawai');
			}
				$error = $this->user_model->user_update($id, $data);
				send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
			}else{
				$this->form_validation->set_rules('i_group', 'Group ID', 'trim|integer|required');
				$this->form_validation->set_rules('i_sandi1', 'Password', 'trim|required');
				$this->form_validation->set_rules('i_sandi2', 'Konfirmasi Password', 'trim|required|matches[i_sandi1]');
				$this->form_validation->set_rules('i_karyawan', 'Karyawan', 'trim|integer|required');
				if(!$nip)$this->form_validation->set_rules('i_ulogin', 'ID Login', 'trim|required');
			
				if ($this->form_validation->run() == FALSE) send_json_validate(); // bila input tidak valid, exit dan kirim kesalahan

				$data['user_password'] 		= md5($this->input->post('i_sandi1'));
				$data['user_group_id'] 		= $this->input->post('i_group');
				$data['employee_id'] 		= $this->input->post('i_karyawan');
				
				$result1 = $this->user_model->employee_read_id($data['employee_id']);
				$data['user_login'] 	= trim($result1['employee_nip']);
				$data['user_name'] 		= trim($result1['employee_name']);
				if(!$nip)
			{
				$data['user_login'] 	= trim($this->input->post('i_ulogin'));
				if(!$this->user_model->cek_unik_user($data['user_login'], $id))send_json_error('ID User tidak boleh sama dengan NIP Pegawai');
			}
				$error = $this->user_model->user_update($id, $data);
				send_json_action($error, "Data telah direvisi", "Data gagal direvisi");					
			}
		}*/
				
	}
	
	function userna_form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		if ($is_delete) 
		{
			$this->library->load('dialog');
			$this->dialog->flash_note('Data tidak ditemukan', 'user/user_inactive');
		} 			
			
		$id = $this->input->post('row_id');
			
		if (empty($id)) 
		{
			$id 		= $this->input->post('user_id');
			
			$error = $this->user_model->user_activated($id);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}
		else 
		{
			$this->library->load('dialog');
			$this->dialog->flash_note('Data tidak ditemukan', 'user/user_inactive');
		}
				
	}
	
	
	function reset_form($id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{
		$this->access->set_module('global.password');
		$this->access->crud_page('crud');
		
		$this->load->library('render');
		
		$data = array();
		$id = $this->access->user_state('employee_id');
		$this->load->model('user_model');
		$result = $this->user_model->user_reset_id($id);
			
		if ($result) // cek dulu apakah data ditemukan 
		{
			$data_form['row_id'] 		= $result['user_id'];
			$this->render->add_form('freeform','app/user/user/reset_form', $data_form);
			$this->render->build('Reset Password');
			$this->access->generate_log_view($id);
		}
		else // tidak ada? tampilkan error.
		{
			$this->library->load('dialog');
			$this->dialog->flash_note('Data tidak ditemukan', '');
		}	
		$this->render->show('blank', 'Reset Password');
	}
	
	function reset_action($is_delete = 0)
	{
		$this->access->set_module('global.password');
		$this->access->crud_page('crud');
		if ($is_delete) 
		{
			$this->library->load('dialog');
			$this->dialog->flash_note('Data tidak ditemukan', 'user/reset_fom');
		} 			
		$this->load->library('form_validation');  // selalu ada di _action()

		$this->form_validation->set_rules('i_sandi1', 'Password', 'trim|required');
		$this->form_validation->set_rules('i_sandi2', 'Konfirmasi Password', 'trim|required|matches[i_sandi1]');
		
		if ($this->form_validation->run() == FALSE) send_json_validate();
		$id = $this->input->post('id');
			
		if (empty($id)) 
		{
			$this->library->load('dialog');
			$this->dialog->flash_note('Data tidak ditemukan', 'user/reset_fom');
		}
		else 
		{
			$data['user_password'] 		= md5($this->input->post('i_sandi1'));

			$error = $this->user_model->user_reset($id,$data);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}
	}
	// GROUPS
	// contoh pop-up
	function group_table_control()
	{
		$this->load->model('user_model');
	
		$data = $this->user_model->group_list_control(get_datatables_control());
		
		send_json($data); 
	}
	
	function group_lookup_id()
	{
		
		$this->load->model('user_model');
		
		$mode = $this->input->post('mode');
		$data = $this->input->post('data');
		
		$result = $this->user_model->group_read_id($data, $mode);
		
		if ($result) 
		{ 
			send_json_lookup_feedback($result['group_id'], $result['group_name'], $result['group_name']);
		}
		else send_json_error_feedback();
	}
	
	
	//EMPLOYEE
	function employee_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->employee_user_control(get_datatables_control());
	}
	
	function employee_lookup_id()
	{
		
		$this->load->library('dtc');
		$this->dtc->employee_user_get();
	}
	
	//EMPLOYEE HRD
	function employee_hrd_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->employee_hrd_control(get_datatables_control());
	}
	
	function employee_hrd_lookup_id()
	{
		
		$this->load->library('dtc');
		$this->dtc->employee_hrd_get();
	}
	
	// GROUP
	function group()
	{
		$this->load->library('render');
		$this->render->add_view('app/user/group/list');
		$this->render->build('Daftar Group');
		$this->render->show('blank', 'Group Module');
		$this->access->set_module('user.group');
	}
	
	
	function group_table_controller()
	{
		$this->load->model('user_model');
		$data = $this->user_model->group_list_controller(get_datatables_control());
		send_json($data); 
	}
	
	
	function group_form($id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{
		$this->load->library('render');
		
		$data = array();
		
		if ($id == 0) {
			
			// FORM CREATE - isi form dengan nilai default / kosong
			$data['row_id'] = '';
			$data['group_name'] = '';			
			
			$this->render->add_form('freeform','app/user/group/form', $data);
			$this->render->build('Group');

		} else {

			// FORM UPDATE - ambil data yang diedit kemudian tampilkan dalam form
			$this->load->model('user_model');
			$result = $this->user_model->group_read_id($id);
			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data_form['row_id'] 		= $result['group_id'];
				$data_form['group_name'] 	= $result['group_name'];			
				
				
				$this->render->add_form('freeform','app/user/group/form', $data_form);
				$this->render->build('Group');
				$this->access->generate_log_view($id);
			}
			else // tidak ada? tampilkan error.
			{
				$this->library->load('dialog');
				$this->dialog->flash_note('Data tidak ditemukan', 'trial/warehouse_list');
			}
		}
				
		$this->render->show('blank', 'Group');
	}
	
	
	function group_form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');  // selalu ada di _action()
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if ($is_delete) 
		{
			$this->load->model('user_model');
			$id = $this->input->post('row_id');
			$is_process_error = $this->user_model->group_delete($id);
			send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
		} 
		
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
		
		// definisikan kriteria data
		$this->form_validation->set_rules('i_nama', 'Nama', 'trim|min_length[2]|max_length[50]|required'); // gunakan selalu trim di awal
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); // bila input tidak valid, exit dan kirim kesalahan
		
		
		$id = $this->input->post('row_id');
		// bila id tidak disebutkan berarti create, sebaliknya update
		
		if (empty($id)) // id empty, lakukan proses CREATE
		{
			$this->load->model('user_model');
			
			// tentukan di branch mana data ini dibuat
			//$data['trial_warehouse_branch_id'] 	= $this->access->user_state('branch_id');
			
			// map input ke kolom database
			
			$data['group_name'] 			= $this->input->post('i_nama');


			// contoh checking kesalahan terhadap data
			// bila unique, dan ada data yang sama di database, batalkan.
			$result = $this->user_model->group_read_name($data['group_name']);
			if (isset($result)) 
			{
				send_json_error('Data sama telah ada di database'); // otomatis exit jadi nda perlu di return
			}
			
			// bila data semua valid, proses. get error.
			$error = $this->user_model->group_create($data);
			
			// otomatisasi penanganan error
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$this->load->model('user_model');
			
			$data['group_name'] = $this->input->post('i_nama');
			$result = $this->user_model->group_read_update($id,$data['group_name']);
			if (isset($result)) 
			{
				send_json_error('Data sama telah ada di database'); // otomatis exit jadi nda perlu di return
			}
			$error = $this->user_model->group_update($id, $data);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}
				
	}
	
	// PERMITS FUNCTION
	// @by : tanto
	// @keterangan : di tabel parent tidak ada action apa2 selain action back
	// @action hanya  ada di child, yaitu action save dan tidak ada penambahan
	// @child merupakan list sekaligus form
	function permit()
	{
		$this->load->library('render');
		$this->render->add_view('app/user/permit/list');
		$this->render->build('Daftar Permit');
		$this->render->show('blank', 'Permit Module');
	}
	
	
	function permit_table_controller()
	{
		$this->load->model('user_model');
	
		$data = $this->user_model->permit_list_controller(get_datatables_control());
		
		send_json($data); 
	}
	
	//cuma butuh form edit, tanpa action, karena action dilakukan di child
	// jika id tidak diisi maka dianggap create, else dianggap edit
	function permit_form($id = 0) 
	{
		$this->load->library('render');

		$data = array();
		
		if ($id == 0) {
			
			// FORM CREATE - isi form dengan nilai default / kosong
			$data['row_id'] = '';
			$data['group_name'] = '';			
			
			
			
			$this->render->add_form('freeform','app/user/permit/form', $data);
			$this->render->build('Permit');

		} else {

			// FORM UPDATE - ambil data yang diedit kemudian tampilkan dalam form
			$this->load->model('user_model');
			
			$result = $this->user_model->permit_read_id($id);
			$result_ac = $this->user_model->permit_transient_loader($id);
			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data_form['row_id'] 		= $result['group_id'];
				$data_form['group_name'] 	= $result['group_name'];			
				$data_table['group_id'] 	= $result['group_id'];				
				
				$par 		= '';
				$name2 		= '';
				$parent		= '';
				
				//tampilkan form edit untuk permit
				$this->render->add_form('freeform','app/user/permit/form', $data_form);
				foreach($result_ac as $key => $value)
				{
					$menu_nama = $this->user_model->cek_menu($value['module_id']);
					if($menu_nama != '')
					{
						$result_ac[$key]['name2'] = $menu_nama;
					}
					else
					{
						$result_ac[$key]['name2'] = $value['module_name']." [m] ";
					}
					
					$result_ac[$key]['crud_create'] = (strpos($value['permit_crud_mode'],'c')===false?0:1);
					$result_ac[$key]['crud_read'] = (strpos($value['permit_crud_mode'],'r')===false?0:1);
					$result_ac[$key]['crud_update'] = (strpos($value['permit_crud_mode'],'u')===false?0:1);
					$result_ac[$key]['crud_delete'] = (strpos($value['permit_crud_mode'],'d')===false?0:1);
					
					$code 	= explode('.',$result_ac[$key]['module_code']);
					if($code[0]==$par)
					{
						$result_ac[$key]['name'] 		= '------ '.$result_ac[$key]['name2'];
						$result_ac[$key]['mod_parent']  = $parent;
					}else
					{
						$result_ac[$key]['name'] 		= '<b>'.$result_ac[$key]['name2'].'</b>';
						$result_ac[$key]['mod_parent']  = $value['module_id'];
						$parent							= $value['module_id'];
					}
					$par 	= $code[0];
					//print_r($name2);echo('</br>');
				}
				//exit;
				//@fungsi untuk child
				//@pake ini karena child tidak mengambil dari json, tapi langsung parsing data
				//map data untuk hak akses check box
				
				$data_p['result_ac'] 	= $result_ac;
				$data_p['group_id']	 	= $result['group_id'];

				
				//tampilkan form check box
				$this->render->add_view('app/user/permit/transient_list', $data_p);
				$this->render->build('Permit');
				
			}
			else // tidak ada? tampilkan error.
			{
				$this->load->library('dialog');
				$this->dialog->flash_note('Data tidak ditemukan', 'trial/warehouse_list');
			}
		}
				
		$this->render->show('blank', 'Permit');
	}

	# memasukkan banyak row sekaligus dari tabel transient
	function permit_transient_action($group_id = 0)
	{
		$this->load->library('form_validation');		
		
		// selalu cek input dari client. ini kriterianya. perhatikan ada [] di nama field nya		
		$this->form_validation->set_rules('i_modul_id[]', 'Modul Id', 'trim|integer|required'); // option select selalu integer
	
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); // bila input tidak valid, exit dan kirim kesalahan
		
		// nilai post yang kirim adalah array karena terdiri dari banyak row. perhatikan tanpa[].
		$index 			= $this->input->post('i_index');
		$list_modul_id 	= $this->input->post('i_modul_id');
		// get i_create dkk
		$list_create = $this->input->post('i_create');
		$list_read 	 = $this->input->post('i_read');
		$list_update = $this->input->post('i_update');
		$list_delete = $this->input->post('i_delete');
		
		// map crud ke list_crud
		$list_crud = array();
		foreach($index as $key => $value)
		{
			$list_crud[$key] = "";
		}
		if($list_create)
		{
			foreach($list_create as $key => $value)
			{
				$list_crud[$key].= "c";
			}
		}
		if($list_read)
		{
			foreach($list_read as $key => $value)
			{
				$list_crud[$key].= "r";
			}
		}
		if($list_update)
		{
			foreach($list_update as $key => $value)
			{
				$list_crud[$key].= "u";
			}
		}
		if($list_delete)
		{
			foreach($list_delete as $key => $value)
			{
				$list_crud[$key].= "d";
			}
		}
		
		
		// ubah input array ke data
		$data = array();
		foreach($list_modul_id as $key => $value)
		{
			if($list_crud[$key]!='')
			{
				$data[] = array(
					'permit_module_id'  => $list_modul_id[$key],
					'permit_crud_mode'  => $list_crud[$key]
				);
			}
		}
	
		
		$this->load->model('user_model');
		$error = $this->user_model->permit_transient_query($group_id, $data);
		send_json_action($error, "Data telah disimpan", "Data gagal disimpan");
	}
	
	# @tanto
	# tambah menu permit
	function permit_menu($id = 0)
	{
		$this->load->library('render');
		$this->render->add_view('app/user/permit_menu/list');
		$this->render->build('Daftar Permit');
		$this->render->show('blank', 'Permit Module');
	}
	
	//cuma butuh form edit, tanpa action, karena action dilakukan di child
	// jika id tidak diisi maka dianggap create, else dianggap edit
	function permit_menu_form($id = 0) 
	{
		$this->load->library('render');

		$data = array();
		
		if ($id == 0) {
			
			// FORM CREATE - isi form dengan nilai default / kosong
			$data['row_id'] = '';
			$data['group_name'] = '';			
			
			
			
			$this->render->add_form('freeform','app/user/permit/form', $data);
			$this->render->build('Permit');

		} else {

			// FORM UPDATE - ambil data yang diedit kemudian tampilkan dalam form
			$this->load->model('user_model');
			
			$result 	= $this->user_model->permit_read_id($id);
			$result_ac 	= $this->user_model->menu_transient_loader($id);
			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data_form['row_id'] 		= $result['group_id'];
				$data_form['group_name'] 	= $result['group_name'];			
				$data_table['group_id'] 	= $result['group_id'];				
				
				$par 	= '';
				$name2 	= '';
				
				//tampilkan form edit untuk permit
				$this->render->add_form('freeform','app/user/permit_menu/form', $data_form);
				
				foreach($result_ac as $key => $value)
				{
			
			
					$result_ac[$key]['name2']		= $value['menu_name'];
					$result_ac[$key]['crud_create'] = (strpos($value['permit_crud_mode'],'c')===false?0:1);
					$result_ac[$key]['crud_read'] 	= (strpos($value['permit_crud_mode'],'r')===false?0:1);
					$result_ac[$key]['crud_update'] = (strpos($value['permit_crud_mode'],'u')===false?0:1);
					$result_ac[$key]['crud_delete'] = (strpos($value['permit_crud_mode'],'d')===false?0:1);
					
					/* $code 	= explode('.',$result_ac[$key]['module_code']);*/
					if($value['menu_level']==1)
					{
						$result_ac[$key]['name'] 		= '<b>'.$result_ac[$key]['name2'].'</b>';
						$result_ac[$key]['status']		= "checked";
					}elseif($value['menu_level']==2)
					{
						$result_ac[$key]['name'] 		= '-- '.$result_ac[$key]['name2'];
						$result_ac[$key]['status']		= "checked";
					}elseif($value['menu_level']==3)
					{
						$result_ac[$key]['name'] 		= '----* '.$result_ac[$key]['name2'];
						$result_ac[$key]['status']		= "";
					}elseif($value['menu_level']==4)
					{
						$result_ac[$key]['name'] = '------** '.$result_ac[$key]['name2'];
						$result_ac[$key]['status']		= "";
					}else
					{
						$result_ac[$key]['name'] = '------ '.$result_ac[$key]['name2'];
						$result_ac[$key]['status']		= "";
					}
					//$par 	= $code[0]; 
					//print_r($name2);echo('</br>');
				}
				//exit;
				//@fungsi untuk child
				//@pake ini karena child tidak mengambil dari json, tapi langsung parsing data
				//map data untuk hak akses check box
				
				$data_p['result_ac'] 	= $result_ac;
				$data_p['group_id']	 	= $result['group_id'];
				
				//tampilkan form check box
				$this->render->add_view('app/user/permit_menu/transient_list', $data_p);
				$this->render->build('Permit Menu');
				
			}
			else // tidak ada? tampilkan error.
			{
				$this->load->library('dialog');
				$this->dialog->flash_note('error','Data tidak ditemukan', 'trial/warehouse_list');
			}
		}
				
		$this->render->show('blank', 'Permit');
	}
	
	# memasukkan banyak row sekaligus dari tabel transient
	function permit_menu_transient_action($group_id = 0)
	{
		$this->load->library('form_validation');		
		
		// selalu cek input dari client. ini kriterianya. perhatikan ada [] di nama field nya		
		$this->form_validation->set_rules('i_modul_id[]', 'Modul Id', 'trim|integer|required'); // option select selalu integer
	
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); // bila input tidak valid, exit dan kirim kesalahan
		
		// nilai post yang kirim adalah array karena terdiri dari banyak row. perhatikan tanpa[].
		$index 			= $this->input->post('i_index');
		$list_modul_id 	= $this->input->post('i_modul_id');
		// get i_create dkk
		$list_create = $this->input->post('i_create');
		$list_read 	 = $this->input->post('i_read');
		$list_update = $this->input->post('i_update');
		$list_delete = $this->input->post('i_delete');
		
		// map crud ke list_crud
		$list_crud = array();
		foreach($index as $key => $value)
		{
			$list_crud[$key] = "";
		}
		if($list_create)
		{
			foreach($list_create as $key => $value)
			{
				$list_crud[$key].= "c";
			}
		}
		if($list_read)
		{
			foreach($list_read as $key => $value)
			{
				$list_crud[$key].= "r";
			}
		}
		if($list_update)
		{
			foreach($list_update as $key => $value)
			{
				$list_crud[$key].= "u";
			}
		}
		if($list_delete)
		{
			foreach($list_delete as $key => $value)
			{
				$list_crud[$key].= "d";
			}
		}
		
		asort($list_modul_id);
		#print_r($list_modul_id);exit;
		
		// ubah input array ke data
		$data = array();
		$cek = '';
		foreach($list_modul_id as $key => $value)
		{
			if($list_modul_id[$key] != $cek)
			{
				$cek = $list_modul_id[$key];
				if($list_crud[$key]!='')
				{
					$data[] = array(
						'permit_module_id'  => $list_modul_id[$key],
						'permit_crud_mode'  => $list_crud[$key]
					);
				}
			}
		}
	
		//print_r($data);exit;
		$this->load->model('user_model');
		$error = $this->user_model->permit_transient_query($group_id, $data);
		send_json_action($error, "Data telah disimpan", "Data gagal disimpan");
	}
	
	function do_upload()
	{		
		//$this->load->library('blob');
		//$blob = $this->blob->send('fileToUpload', BLOB_ALLOW_IMAGES, 1);
		$config['upload_path'] = 'tmp/';
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size']	= '1000';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('fileToUpload'))
		{
			$output = array('error' => strip_tags($this->upload->display_errors()));
			debug($output);
			//$output = array('error' => print_r($error,1), 'msg'=>'test');
			send_json($output);
			//$this->load->view('upload_form', $error);
		}	
		else
		{
			$data = $this->upload->data();
			$output = array('error' => '', 'value' => $data['file_name']);
			send_json($output);
			//$this->load->view('upload_success', $data);
		}
	}


	
}	
