<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
		class Upload_photo extends CI_Controller{
			function __construct(){
			parent::__construct();
			$this->load->library('render');
			$this->load->model('upload_photo_model');
			$this->load->library('access');
			$this->access->set_module('upload.upload');
			$this->access->user_page();
		}
		function index(){
			$this->render->add_view('app/upload_photo/list');
			$this->render->build('Data Upload Foto');
			$this->render->show('Data Upload Foto');
		}
		function table_controller(){
			$data = $this->upload_photo_model->list_controller();
			send_json($data);
		}
		function form($registration_id = 0)
		{
			$data = array();
			if($registration_id == 0){
				$data['row_id'] = '';
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
				$data['transaction_id'] = '';
				$data['employee_group_id'] = '';
				$data['transaction_type_id'] = '';
				$data['transaction_plain_first_date'] = date('d/m/Y');
				$data['transaction_plain_last_date'] = date('d/m/Y');
				$data['transaction_actual_date'] = date('d/m/Y');
				$data['transaction_target_date'] = date('d/m/Y');
				$data['transaction_detail_description'] = '';
			}else{
				$result = $this->upload_photo_model->read_id($registration_id);
			if($result){
				$data = $result;
				$data['row_id'] = $registration_id;
				$data['transaction_id'] = $result['transaction_id'];
				$data['employee_group_id'] = $result['employee_group_id'];
				$data['transaction_plain_first_date'] = $result['transaction_plain_first_date'];
				$data['transaction_plain_last_date'] = $result['transaction_plain_last_date'];
				$data['transaction_actual_date'] = $result['transaction_actual_date'];
				$data['transaction_target_date'] = $result['transaction_target_date'];
				$data['transaction_komponen'] =$result['transaction_komponen'];
				$data['transaction_lasketok'] = $result['transaction_lasketok'];
				$data['transaction_dempul'] = $result['transaction_dempul'];
				$data['transaction_cat'] = $result['transaction_cat'];
				$data['transaction_poles'] = $result['transaction_poles'];
				$data['transaction_rakit'] = $result['transaction_rakit'];
			}
				}
			$this->load->helper('form');
			$this->render->add_form('app/upload_photo/form', $data);
			$this->render->build('Registrasi');
			
			$this->render->add_view('app/upload_photo/transient_list', $data);
			$this->render->build('Upload Photo');
			$this->render->add_js('ajaxfileupload');
			$this->render->show('Transaksi');
		}
		
		
	
		function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
		{
			$this->load->library('form_validation');
			// bila operasinya DELETE -----------------------------------------------------------------------------------------
			if($is_delete)
			{
				$this->load->model('transaction_model');
				$id = $this->input->post('i_transaction_id');
				$is_process_error = $this->update_photo->delete($id);
				send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
			}
				$id 			=$this->input->post('row_id');	
				$data['status_registration_id'] = 3;	
				
				$list_photo_id		= $this->input->post('transient_photo_id');
				$list_photo_name	= $this->input->post('transient_photo_name');
				$list_photo 		= $this->input->post('transient_photo');
				$list_photo_after	= $this->input->post('transient_photo_after');
				
				$items = array();
				if($list_photo_id){
				foreach($list_photo_id as $key => $value)
				{
					if($list_photo_after[$key])
					rename($this->config->item('upload_tmp').$list_photo_after[$key],
					$this->config->item('upload_storage')."img_after/".$list_photo_after[$key]);	
					
					$items[] = array(				
						'photo_id'  => $list_photo_id[$key],
						'photo_name'  => $list_photo_name[$key],
						'photo'  	=> $list_photo[$key],
						'photo_after'  => $list_photo_after[$key]
					);
					
					
					
				}
				}
				
				$error = $this->upload_photo_model->create($id,$data, $items);
				send_json_action($error, "Data telah direvisi", "Data gagal direvisi",$id);
			
				
			}
		
			function detail_list_loader($row_id=0)
			{
				if($row_id == 0)
				
				send_json(make_datatables_list(null)); 
						
				$data = $this->upload_photo_model->detail_list_loader($row_id);
				$sort_id = 0;
				foreach($data as $key => $value) 
				{
	$foto='<img   width="50px;" height="50px;" src='.base_url().'storage/img_before/'.$value['photo'].'';
	$foto_after='<img   width="50px;" height="50px;" src='.base_url().'tmp/'.$value['photo_after'].'';
			
				$data[$key] = array(
						form_transient_pair('transient_photo_name', $value['photo_name'],$value['photo_name'],
										array(
											'transient_photo_id' => $value['photo_id'])),
						form_transient_pair('transient_photo_v',	$foto, $foto, 
										array(
											'transient_photo' => $value['photo'])),
						form_transient_pair('transient_photo_after_v',	$foto_after,$foto_after,
											 array(
											'transient_photo_after' => $value['photo_after'])),
						
				);
		
		
	
		}		
		send_json(make_datatables_list($data)); 
		}
		function detail_form($registration_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
		{		
			$this->load->library('render');
			$index = $this->input->post('transient_index');
			if (strlen(trim($index)) == 0) {
						
				// TRANSIENT CREATE - isi form dengan nilai default / kosong
					$data['transient_photo_id'] 				= '';
					$data['registration_id'] 				= $registration_id;
					$data['transient_photo_id'] 				= '';
					$data['transient_photo_name']			= '';	
					$data['transient_photo']				 = '';
					$data['transient_photo_after'] 			=  '';
					
			} else {
				
					$data['index']							= $index;
					$data['registration_id'] 				= $registration_id;
					$data['transient_photo_id'] 			= array_shift($this->input->post('transient_photo_id'));
					$data['transient_photo_name'] 			= array_shift($this->input->post('transient_photo_name'));
					$data['transient_photo'] 				= array_shift($this->input->post('transient_photo'));
					$data['transient_photo_after']			= array_shift($this->input->post('transient_photo_after'));
			}		
			
			$this->load->helper('form');
			
		
			$this->render->add_form('app/upload_photo/transient_form', $data);
			$this->render->show_buffer();
		}

			
		function detail_form_action()
		{		
			$this->load->library('form_validation');
			$this->form_validation->set_rules('i_photo_after', 'photo after', 'trim|max_length[100]');
		
			$index = $this->input->post('i_index');		
			// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
			
			$no 		= $this->input->post('i_index');
			
			
			$i_photo_name	= $this->input->post('i_photo_name');
			$i_photo_id	= $this->input->post('i_photo_id');
			$i_photo	= $this->input->post('i_photo');
			$i_photo_after	= $this->input->post('i_photo_after');
			
	$foto='<img   width="50px;" height="50px;" src='.base_url().'storage/img_before/'.$i_photo.'';
	$foto_after='<img   width="50px;" height="50px;" src='.base_url().'tmp/'.$i_photo_after.'';
		
			$data = array(
				
						form_transient_pair('transient_photo_name', $i_photo_name,$i_photo_name,
										array(
											'transient_photo_id' => $i_photo_id)),
						form_transient_pair('transient_photo_v',	$foto, $foto, 
										array(
											'transient_photo' => $i_photo)),
						form_transient_pair('transient_photo_after_v',	$foto_after,$foto_after,
											 array(
											'transient_photo_after' => $i_photo_after)),
			);
			 
			send_json_transient($index, $data);
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
			