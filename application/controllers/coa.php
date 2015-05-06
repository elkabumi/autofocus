<?php 

class Coa extends CI_Controller 
{	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('coa_model');
		$this->load->library('render');
		$this->load->library('access');
		// set kode module ini .. misal usr
		$this->access->set_module('master.coa');
		// default access adalah User
		$this->load->library('render');
		$this->load->helper('form');
		$this->load->model('global_model');
		$this->load->library('form_validation');
		$this->access->user_page();		
	}
	function index()
	{
		$this->render->add_view('app/coa/list');
		$this->render->build('Daftar Akun');
		$this->access->generate_log_view(1);
		
		$this->render->show('Akun');
	}
	function list_controller()
	{
		$data = $this->coa_model->coa_list_controller(get_datatables_control());
		send_json($data); 
	}
	
	function coa_form($id=0)
	{
		$data = array();
		
		if($id == 0)
		{	
			$data['row_id'] 			= '';
			$data['cbo_type'] 			= array(1=>'General',0=>'Detail');
			$data['coa_id']				= '';
			$data['parent_coa_id']		= '';
			$data['parent_name']		= '';
			$data['parent_code']		= '';
			$data['coa_old_type']		= '';
			$data['cbo_normally'] 		= array(1 => 'Debit', -1 => 'Kredit');
			$data['coa_code']			= '';
			$data['coa_normally']		= '';
			$data['coa_hierarchy']		= '';
			$data['coa_name']			= '';
			$data['coa_group']			= '';
			$data['coa_level']			= '';
			$data['coa_type']			= '';
			$data['coa_active_status']	= '';
			$data['length'] 			= '';
			
			$data['coa_account_type'] 			= '';
			$data['cek1'] 				= 0;
			
			$this->render->add_form('app/coa/form', $data);
			$this->render->build('Coa');	
		}
		else
		{
			$data = $this->coa_model->coa_read_id($id);
			
			if($data)
			{
				$data['row_id']			= $data['coa_id'];
				$data['coa_level']		= $data['coa_level'];
				
				if(($data['coa_level'] == 1) OR ($data['coa_level'] == 2) OR ($data['coa_level'] == 3) OR ($data['coa_level'] == 4))
				{
				$data['length']				= 1;
				}else if($data['coa_level'] == 5)
				{
				$data['length']				= 2;
				}else{
				$data['length']				= 3;
				}
				
				$parent_data 			= $this->coa_model->coa_read_id($data['parent_coa_id']);
				
				$parent_id 				= trim($parent_data['coa_id']);
				$parent_code			= trim($parent_data['coa_hierarchy']);
				$parent_name			= trim($parent_data['coa_name']);
					
				$data['coa_level']			= $data['coa_level'] ;				
				
				
				if($data['coa_type']!='0')
				{
					$data['cbo_type'] = array(1=>'General ',0=>'Detail ');	
					$data['coa_old_type'] = '1';
				}
				else
				{
					$data['cbo_type'] = array(0=>'Detail ', 1=>'General ');	
					$data['coa_old_type'] = '0';
					// $data['cbo_type'] = array(0=>'Detail ');	
				}//end if else 
				
				$data['cbo_normally'] 		= array(1 => 'Debit', -1 => 'Kredit');
				
				$data['parent_id']				= $parent_id;			
				$data['parent_code']			= $parent_code ;			
				$data['parent_name']			= $parent_name ;
				
				
				
				$this->render->add_form('app/coa/form_edit', $data);
				$this->render->build('Pengelompokan Account');
				
				$this->access->generate_log_view($id);		
			}
			else
			{
				$this->load->library('dialog');
				$this->dialog->flash_note('error','Data tidak ditemukan', 'app/coa_list');	
			}
		}
		$this->render->show('blank', 'Ubah Account');
	} 
	
	function coa_form_action($is_delete=0)
	{
		$id = $this->input->post('row_id');
		
		if($is_delete)
		{	
			$data = $this->coa_model->coa_read_any_detail($id);
			
			if($data)
			{
				send_json_error('Terdapat Detail Pada Coa Ini');
			}
			else
			{
				$parent_id = $this->coa_model->get_data_parent($id);
				
				$cek_data_parent = $this->coa_model->cek_data_parent($id, $parent_id);
				
				if($cek_data_parent){
					//send_json_error("general");
					$is_process_error = $this->coa_model->coa_delete($id);
				}else{
					//send_json_error("detail");
					
					$is_process_error = $this->coa_model->coa_parent_edit($parent_id);
					$is_process_error = $this->coa_model->coa_delete($id);
				}
				
				send_json_action($is_process_error,"Data telah dihapus","Data gagal dihapus");	
			}
		}
		
		
		if(empty($id))
		{
			
			// input gan ! 
			$this->form_validation->set_rules('i_coa_account_type','Account Type','trim|required');	
			if($this->input->post('i_cek1') == 1){
				$this->form_validation->set_rules('i_sub_account','Sub Account','trim|required');	
			}
			$this->form_validation->set_rules('i_coa_hierarchy2','No Account','trim|min_length[1]|max_length[20]|required');	
			$this->form_validation->set_rules('i_coa_name','Nama Coa','trim|min_length[1]|max_length[100]|required');	
			
			
			
			if($this->form_validation->run()==FALSE) send_json_validate();
			
			$cek1 = $this->input->post('i_cek1');
			
			if($cek1 == 1){
				$data['parent_coa_id']			= $this->input->post('i_sub_account');
			}else{
				$data['parent_coa_id']			= $this->input->post('i_coa_account_type');
			}
			
			$data['coa_code'] 				= $this->input->post('i_coa_hierarchy2');
			$data['coa_hierarchy'] 			= $this->input->post('i_coa_hierarchy');//.".".$this->input->post('i_coa_hierarchy2');
			$data['coa_hierarchy']			= str_replace(" ",'',$data['coa_hierarchy']);
			$data['coa_name'] 				= $this->input->post('i_coa_name');
			$data['coa_group'] 				= $this->input->post('i_coa_group');
		
			if($cek1 == 0){
				$data['coa_level']			= 4;
			}else{
				$get_coa_level = $this->coa_model->get_coa_level($this->input->post('i_sub_account'));
				$data['coa_level']			= $get_coa_level + 1;
			}
			$data['coa_type'] 				= 0;
			$data['coa_normally'] 			= $this->input->post('i_coa_normally');
			$data['coa_account_type'] 		= $this->input->post('i_coa_account_type');
			
				$hierarchy_result 				= $this->coa_model->coa_read_hierarchy_create($data['coa_hierarchy'] );
				if(!empty($hierarchy_result))
				{
					send_json_error('Simpan gagal. No Akun sudah ada di database'); 
				}
				else
				{
					//send_json_error("adri");
					$error = $this->coa_model->coa_create($data, $data['parent_coa_id']);
					send_json_action($error, "Data berhasil ditambah", "Data gagal ditambah");	
				}
		}
		else
		{
			// Edit gan !
		
			$this->form_validation->set_rules('i_coa_hierarchy2','No Account','trim|min_length[1]|max_length[50]|required');	
			$this->form_validation->set_rules('i_coa_name','Nama Coa','trim|min_length[1]|max_length[100]|required');	
			
			if($this->form_validation->run()==FALSE) send_json_validate();
			
			$data['coa_hierarchy'] 			= $this->input->post('i_coa_hierarchy');//.".".$this->input->post('i_coa_hierarchy2');
			$data['coa_name'] 				= $this->input->post('i_coa_name');
			$data['coa_normally'] 			= $this->input->post('i_coa_normally');
			
			$hierarchy_result 				= $this->coa_model->coa_read_hierarchy_update($id,$data['coa_hierarchy'] );
				if(!empty($hierarchy_result))
				{
					send_json_error('Simpan gagal. No Akun sudah ada di database'); 
				}else{
				$error = $this->coa_model->coa_update($id,$data);
				send_json_action($error, "Data telah berhasil diubah", "Data gagal diubah");
				}
		}
			
			
	}// end of function 
	
	function coa_add($id=0)
	{
		
		$data = array();
		//$data['cbo_type'] = array(1=>'General ',0=>'Detail ');
		$data = $this->coa_model->coa_read_id($id);
		
		$this->id = $id; 
		
		if($data)
		{
			if($data['coa_type']=='0')
			{
				$data['coa_current_type']		= $data['coa_type']; 
				$data['coa_level']				= $data['coa_level'];
				$data['cbo_type'] 				= array(0=>'Detail');	
				
				// baca parentya dulu 
				
				$data['parent_id']				= $data['parent_coa_id'];
				$data_parent					= $this->coa_model->coa_read_id($data['parent_id']);
				
				$data['parent_code']			= trim($data_parent['coa_hierarchy']);			
				$data['parent_name']			= trim($data_parent['coa_name']);			
				$data['parent_coa_id']			= $data_parent['parent_coa_id'];
				$data['parent_coa_type']		= $data_parent['coa_type'];	
				$data['coa_current_id']			= $id ; 
				$get_code						= $this->coa_model->coa_generate_code($data['parent_id'],$data['coa_level']);
				
				if(($data['coa_level'] == 1) OR ($data['coa_level'] == 2) OR ($data['coa_level'] == 3) 
				OR ($data['coa_level'] == 4))
				{
				$data['coa_code']			= $get_code;
				$data['length']				= 1;
				}else if($data['coa_level'] == 5)
				{
				$data['coa_code']			= $get_code;
				$data['length']				= 2;
				}else{
				$data['coa_code']			= $get_code;
				$data['length']				= 3;
				}
			}
			else
			{
				$data['coa_current_type']		= $data['coa_type']; 
				$data['parent_id']				= $id;
				
				$data['cbo_type'] 				= array(1=>'General ',0=>'Detail ');	
				$data['parent_code']			= trim($data['coa_hierarchy']);			
				$data['parent_name']			= trim($data['coa_name']);			
				$data['parent_coa_id']			= $data['parent_coa_id'];
				$data['parent_coa_type']		= $data['coa_type'];	
				$data['coa_current_id']			= $id ; 
				$get_code						= $this->coa_model->coa_generate_code($data['parent_id'],$data['coa_level'] + 1);
			
				if(($data['coa_level'] == 1) OR ($data['coa_level'] == 2) OR ($data['coa_level'] == 3))
				{
				$data['coa_code']			= $get_code;
				$data['length']				= 1;
				}else if($data['coa_level'] == 4)
				{
				$get_code = $get_code > 9 ? $get_code : '0'.$get_code;
				$data['coa_code']			= $get_code;
				$data['length']				= 2;
				}else{
				$get_code = $get_code > 9 ? $get_code : '0'.$get_code;
				$data['coa_code']			= $get_code;
				$data['length']				= 3;
				}
				
				$data['coa_level']				= $data['coa_level'] + 1;//print_r($data);exit;
			}
			
			$data['coa_group']				= $data['coa_group'];
			$data['coa_htype']				= $data['coa_type'];
			$data['coa_hierarchy']			= $data['coa_hierarchy'];
			$data['coa_name']				= '';
			$data['cbo_normally'] 		= array(1 => 'Debit', -1 => 'Kredit');
			
			// $data['coa_code']				= '';
			$this->render->add_form('app/coa/form', $data);
			$this->render->build('Tambah Account');
		}
		else
		{
			$this->load->library('dialog');
			$this->dialog->flash_note('error','Data tidak ditemukan', 'app/coa/list');
			
		}// end if else
		$this->render->show('blank', 'Tambah Account');
	}// end of function 
	
	function coa_add_action($is_delete=0)
	{
		
		$this->form_validation->set_rules('i_coa_code','No Account','trim|min_length[1]|max_length[3]|required');	
		$this->form_validation->set_rules('i_coa_name', 'Nama Coa', 'trim|min_length[1]|max_length[50]|required');
		
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		$data['parent_coa_id'] 			= $this->input->post('i_parent_id');
		$data['coa_code'] 				= $this->input->post('i_coa_code');
		$data['coa_type'] 				= $this->input->post('i_coa_type');
		$data['coa_normally'] 			= $this->input->post('i_coa_normally');
		
		$coa_current_type 				= $this->input->post('i_coa_current_type');
		$temp_parent_type		 		= $this->input->post('i_parent_coa_type');
		$split_hierarchy 				= explode('[.]',$this->input->post('i_coa_hierarchy'));
		$temp_hierarchy  				= $this->input->post('i_coa_hierarchy');
		
		$data['coa_hierarchy'] 			= "";
		
		
		if($coa_current_type=='0')
		{
			$data_parent	 			= $this->coa_model->coa_read_parent_id($data['parent_coa_id']);
		}
		else
		{
			$coa_current_id 			= $this->input->post('i_coa_current_id');
			$data_parent	 			= $this->coa_model->coa_read_parent_id($coa_current_id);
		}
		
		// print_r($data_parent);exit;
		
		$data['coa_name'] 				= $this->input->post('i_coa_name');
		$data['coa_group'] 				= $this->input->post('i_coa_group');
		$data['coa_level'] 				= $this->input->post('i_coa_level');
		$data['coa_active_status'] 		= 'TRUE' ;
		$data['coa_hierarchy']			= trim($data_parent['coa_hierarchy']).trim($this->input->post('i_coa_code'));
		
		$parent = trim($data_parent['coa_hierarchy']);
		$code = trim($this->input->post('i_coa_code'));
		
		if($data['coa_type'] == 1)
		{
			switch($data['coa_level']){
			case 1:
			$data['coa_hierarchy'] = $parent.$code;
			break;
			
			case 2:
			$data['coa_hierarchy'] = $parent.$code;
			break;

			case 3:
			$data['coa_hierarchy'] = $parent.$code;
			break;

			case 4:
			$data['coa_hierarchy'] = $parent.$code;
			break;

			case 5:
			$data['coa_hierarchy'] = $parent.$code;
			break;
			}
		}else
		{
			switch($data['coa_level']){
			case 2:
			$data['coa_hierarchy'] = $parent.$code;
			break;

			case 3:
			$data['coa_hierarchy'] = $parent.$code;
			break;

			case 4:
			$data['coa_hierarchy'] = $parent.$code;
			break;

			case 5:
			$data['coa_hierarchy'] = $parent.$code;
			break;
			
			case 6:
			$data['coa_hierarchy'] = $parent.$code;
			break;
			
			}
		}
		
		//print_r($data['coa_hierarchy']);exit;
		if(($data['coa_type'] == '1')AND($data['coa_level'] == '6'))
		{
			send_json_error('Level 6 Harus Detail'); 
		}
		
		$hierarchy_result 				= $this->coa_model->coa_read_hierarchy($data['coa_hierarchy'] );
		if(!empty($hierarchy_result))
		{
			send_json_error('Data sama telah ada di database'); 
		}
		else
		{
			$msg_error = "Data gagal ditambah";
			$error = $this->coa_model->coa_create($data);
			send_json_action($error, "Data telah ditambah", $msg_error );
		}// end if
		
	}// end of function 	
	
	
	function coa_add_action2($is_delete=0)
	{
		
		$this->form_validation->set_rules('i_coa_account_type','Account Type','trim|required');	
		$this->form_validation->set_rules('i_coa_name', 'Account Name', 'trim|min_length[3]|max_length[100]|required');
		
		
		if($this->input->post('i_cek_sub_account') == 1){
			$this->form_validation->set_rules('i_sub_account','Sub Account Of','trim|required');	
		}
		
		$this->form_validation->set_rules('i_coa_hierarchy2', 'No Account', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		if($this->input->post('i_cek_sub_account') == 1){
			$data['parent_coa_id'] 			= $this->input->post('i_sub_account');
		}else{
			$data['parent_coa_id'] 			= $this->input->post('i_coa_account_type');
		}
		
		
		
		$data['coa_code'] 				= $this->input->post('i_coa_hierarchy2');
		$data['coa_hierarchy'] 			= $this->input->post('i_coa_hierarchy').".".$this->input->post('i_coa_hierarchy2');
		$data['coa_name'] 				= $this->input->post('i_coa_name');
		$data['coa_group'] 				= $this->input->post('i_coa_group');
		
		if($this->input->post('i_cek_sub_account') == 1){
			
			$data['coa_level'] 			= $this->input->post('i_coa_group');
		}else{
			$data['coa_level'] 			= 4;
		}
		$data['coa_group'] 				= $this->input->post('i_coa_group');
		$data['coa_group'] 				= $this->input->post('i_coa_group');
		$data['coa_group'] 				= $this->input->post('i_coa_group');
		$data['coa_group'] 				= $this->input->post('i_coa_group');
		
		
		if(!empty($hierarchy_result))
		{
			send_json_error('Data sama telah ada di database'); 
		}
		else
		{
			$msg_error = "Data gagal ditambah";
			$error = $this->coa_model->coa_create($data);
			send_json_action($error, "Data telah ditambah", $msg_error );
		}// end if
		
	}// end of function 	
	
	function get_data_coa()
	{
		$id 	= $this->input->post('id');
		
		$query = $this->coa_model->get_data_coa($id);
		$data = array();
			
			$get_coa_code = $this->coa_model->get_coa_code($id);
			
			if($get_coa_code){
				$get_coa_code = str_replace(".", "", $get_coa_code);
				$get_coa_code = intval($get_coa_code);
				
				if($get_coa_code == 99){
					$get_coa_code = $this->coa_model->get_coa_code2($id);
				} 
				$get_coa_code = str_replace(".", "", $get_coa_code);
				$get_coa_code = intval($get_coa_code);
				
				$get_coa_code = $get_coa_code + 1;
				if(strlen($get_coa_code) == 1){
					$get_coa_code = "0".$get_coa_code;
				}
			}else{
				$get_coa_code = "01";
			}
		
		foreach($query->result_array() as $row)
		{
		
			$data['coa_group']		= $row['coa_group'];
			$data['coa_hierarchy']		= $row['coa_hierarchy'];
			$data['coa_code']		= $get_coa_code;
			
		}
		send_json_message('Kode Akun', $data);
	}
	
	function get_data_coa_sub_account()
	{
		$id 	= $this->input->post('id');
		
		$query = $this->coa_model->get_data_coa($id);
		$get_coa_code = $this->coa_model->get_coa_code($id);
		
		if($get_coa_code){
			$get_coa_code = str_replace(".", "", $get_coa_code);
			$get_coa_code = intval($get_coa_code);
			
			if($get_coa_code == 99){
				$get_coa_code = $this->coa_model->get_coa_code2($id);
			} 
			$get_coa_code = str_replace(".", "", $get_coa_code);
			$get_coa_code = intval($get_coa_code);
			
			$get_coa_code = $get_coa_code + 1;
			if(strlen($get_coa_code) == 1){
				$get_coa_code = "0".$get_coa_code;
			}
		}else{
			$get_coa_code = "01";
		}
		
		$data = array();
		
		
		foreach($query->result_array() as $row)
		{
		
			$data['coa_hierarchy']		= $row['coa_hierarchy'];
			$data['coa_code']			= $get_coa_code;
		}
		send_json_message('Kode Akun', $data);

	}
	
}// end of class 
