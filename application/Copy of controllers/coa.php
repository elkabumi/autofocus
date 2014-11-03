<?php 

class Coa extends CI_Controller 
{	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('coa_model');
		$this->load->library('render');
		
		// set kode module ini .. misal usr
		$this->access->set_module('gl.coa');
		// default access adalah User
		$this->access->user_page();		
	}
	function index()
	{
		$this->render->add_view('app/coa/list');
		$this->render->build('Daftar Akun');
		$this->access->generate_log_view(1);
		
		$this->render->show('Akun');
	}
	function coa_list_controller()
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
			$data['coa_code']			= '';
			$data['coa_hierarchy']		= '';
			$data['coa_name']			= '';
			$data['coa_group']			= '';
			$data['coa_level']			= '';
			$data['coa_type']			= '';
			$data['coa_active_status']	= '';
			
			$this->render->add_form('freeform','app/coa/form_edit', $data);
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
				
				$data['parent_id']				= $parent_id;			
				$data['parent_code']			= $parent_code ;			
				$data['parent_name']			= $parent_name ;
				
				$this->render->add_form('freeform','app/coa/form_edit', $data);
				$this->render->build('Pengelompokan Account');
				
				$this->access->generate_log_view($id);
				
			}
			else
			{
			
				$this->load->library('dialog');
				$this->dialog->flash_note('error','Data tidak ditemukan', 'app/coa_list');
				
			}// end if else
		}// end if else
		$this->render->show('blank', 'Ubah Account');
	}// end of function 
	
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
				$is_process_error = $this->coa_model->coa_delete($id);
				send_json_action($is_process_error,"Data telah dihapus","Data gagal dihapus");	
			}//end if
		}// end if 
		
		$this->form_validation->set_rules('i_coa_code','No Account','trim|min_length[1]|max_length[3]|required');	
		$this->form_validation->set_rules('i_coa_name','Nama Coa','trim|min_length[3]|max_length[50]|required');	
		
		if($this->form_validation->run()==FALSE) send_json_validate();
		
		if(empty($id))
		{
			
			// tidak terjadi terjadi apa2 ...
			
		}
		else
		{
			$data['coa_code']			= $this->input->post('i_coa_code');
			$data['coa_level'] 			= $this->input->post('i_coa_level');
			$data['coa_name'] 			= $this->input->post('i_coa_name');
			$data['coa_group'] 			= $this->input->post('i_coa_group');
			$data['coa_type'] 			= $this->input->post('i_coa_type');
			$data['coa_active_status'] 	= 'TRUE' ;				
		
			$coa_old_type				= $this->input->post('i_coa_old_type');		
			$parent_coa_id		 		= $this->input->post('i_coa_parent');

			$data_parent 				= $this->coa_model->coa_read_parent_id($parent_coa_id);		


			$parent = trim($data_parent['coa_hierarchy']);
			$code = trim($this->input->post('i_coa_code'));			

			if($data['coa_type'] != $coa_old_type)
			{
				if($data['coa_type'] == 1)
				{
					switch($data['coa_level']){
					case 1:
					$data['coa_hierarchy'] = substr($parent,0,0).$code;
					break;
					
					case 2:
					$data['coa_hierarchy'] = substr($parent,0,1).$code;
					break;


					case 3:
					$data['coa_hierarchy'] = substr($parent,0,2).$code;
					break;

					case 4:
					$data['coa_hierarchy'] = substr($parent,0,3).$code;
					break;

					case 5:
					$data['coa_hierarchy'] = substr($parent,0,4).$code;
					break;
					}
				}else{
					switch($data['coa_level']){
					case 2:
					$data['coa_hierarchy'] = $parent."00000".format_zero_padding($code,3);
					break;

					case 3:
					$data['coa_hierarchy'] = $parent."0000".format_zero_padding($code,3);
					break;

					case 4:
					$data['coa_hierarchy'] = $parent."000".format_zero_padding($code,3);
					break;

					case 5:
					$data['coa_hierarchy'] = $parent."00".format_zero_padding($code,3);
					break;
					
					case 6:
					$data['coa_hierarchy'] = $parent.format_zero_padding($code,3);
					break;
					}
				}
			}else
			{
				$data['coa_hierarchy']		= $this->input->post('i_coa_hierarchy');
			}
			
			
			
			if(($data['coa_type'] == '1')AND($data['coa_level'] == '6'))
			{
				send_json_error('Level 6 Harus Detail'); 
			}

			if(($data['coa_type'] == '0') AND ($coa_old_type == '1'))
			{
				$detail = $this->coa_model->coa_read_any_detail($parent_coa_id);
				if(!empty($detail))
				{
					send_json_error('Terdapat Data Tipe Detail Pada Coa Ini'); 
				}
			}
			$hierarchy_result 				= $this->coa_model->coa_read_hierarchy_update($id,$data['coa_hierarchy'] );
			if(!empty($hierarchy_result))
			{
				send_json_error('Data sama telah ada di database'); 
			}
			else
			{
					//print_r($data['coa_hierarchy']);exit;
					$error = $this->coa_model->coa_update($id,$data);
					send_json_action($error, "Data telah berhasil dirubah", "Data gagal dirubah");	
			}	

		}// end if data isn't been created		
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
				
				if(($data['coa_level'] == 1) OR ($data['coa_level'] == 2) OR ($data['coa_level'] == 3) OR ($data['coa_level'] == 4))
				{
				$data['coa_code']			= $get_code;
				$data['length']				= 1;
				}else if($data['coa_level'] == 5)
				{
				$data['coa_code']			= format_zero_padding($get_code,2);
				$data['length']				= 2;
				}else{
				$data['coa_code']			= format_zero_padding($get_code,3);
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
				$data['coa_code']			= format_zero_padding($get_code,2);
				$data['length']				= 2;
				}else{
				$data['coa_code']			= format_zero_padding($get_code,3);
				$data['length']				= 3;
				}
				
				$data['coa_level']				= $data['coa_level'] + 1;
			}
			
			$data['coa_group']				= $data['coa_group'];
			$data['coa_htype']				= $data['coa_type'];
			$data['coa_hierarchy']			= $data['coa_hierarchy'];
			$data['coa_name']				= '';
			// $data['coa_code']				= '';
			$this->render->add_form('freeform','app/coa/form', $data);
			$this->render->build('Tambah Account');
		}
		else
		{
			$this->load->library('dialog');
			$this->dialog->flash_note('error','Data tidak ditemukan', 'app/coa_list');
			
		}// end if else
		$this->render->show('blank', 'Tambah Account');
	}// end of function 
	
	function coa_add_action($is_delete=0)
	{
		
		$this->form_validation->set_rules('i_coa_code','No Account','trim|min_length[1]|max_length[3]|required');	
		$this->form_validation->set_rules('i_coa_name', 'Nama Coa', 'trim|min_length[3]|max_length[50]|required');
		
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		$data['parent_coa_id'] 			= $this->input->post('i_parent_id');
		$data['coa_code'] 				= $this->input->post('i_coa_code');
		$data['coa_type'] 				= $this->input->post('i_coa_type');
		
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
			$data['coa_hierarchy'] = substr($parent,0,0).$code;
			break;
			
			case 2:
			$data['coa_hierarchy'] = substr($parent,0,1).$code;
			break;

			case 3:
			$data['coa_hierarchy'] = substr($parent,0,2).$code;
			break;

			case 4:
			$data['coa_hierarchy'] = substr($parent,0,3).$code;
			break;

			case 5:
			$data['coa_hierarchy'] = substr($parent,0,4).$code;
			break;
			}
		}else
		{
			switch($data['coa_level']){
			case 2:
			$data['coa_hierarchy'] = $parent."00000".format_zero_padding($code,3);
			break;

			case 3:
			$data['coa_hierarchy'] = $parent."0000".format_zero_padding($code,3);
			break;

			case 4:
			$data['coa_hierarchy'] = $parent."000".format_zero_padding($code,3);
			break;

			case 5:
			$data['coa_hierarchy'] = $parent."00".format_zero_padding($code,3);
			break;
			
			case 6:
			$data['coa_hierarchy'] = $parent.format_zero_padding($code,3);
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
	
	
	/**
	* DIGUNAKAN UNTUK LOOKUP
	**/
	
	function lookup_coa_control()
	{
	
		$data = $this->coa_model->coa_lookup_list_control(get_datatables_control());
		send_json($data); 
	
	}// end of function 
	
	function group_lookup_id()
	{
	
		$mode = $this->input->post('mode');
		$id = $this->input->post('data');
		
		$result = $this->coa_model->lookup_read_id($id);
		if($result)
		{
			
			send_json_lookup_feedback($result['coa_id'], format_zero_padding($result['coa_id'], 4), $result['coa_name']);
			
		}// end if
		else send_json_error_feedback();
		
	}// end of function 
	
}// end of class 
