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
			
				$result = $this->upload_photo_model->read_id($registration_id);
			if($result){
				$data = $result;
				$data['row_id'] = $registration_id;
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
				$data['spk_date'] = format_new_date($data['spk_date']);
				
				}
			$this->load->helper('form');
			$this->render->add_form('app/upload_photo/form', $data);
			$this->render->build('Registrasi');
		
			$this->render->add_view('app/upload_photo/transient_list', $data);	
			$this->render->build('Foto');
			
			$this->render->add_js('ajaxfileupload');
			$this->render->show('Upload Foto');
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
				$data['status_registration_id']	 = 4;	
				
				$list_photo_id		= $this->input->post('transient_photo_id');
				$list_photo_name	= $this->input->post('transient_photo_name');
				$list_photo_file	= $this->input->post('transient_photo_file');
				$list_photo_type_id	= $this->input->post('transient_photo_type_id');
				$list_photo_edit	= $this->input->post('transient_photo_edit');
				$date = date('ymdhis');
				
				$items = array();
				if($list_photo_file){
				foreach($list_photo_file as $key => $value)
				{
				
					$path = "";
					if($list_photo_edit[$key] == 1){
						
							$storage = "img_mobil/";
							$path = $this->access->info['employee_id']."_".date("ymdhms")."_".$list_photo_type_id[$key]."_";
					
						
					rename($this->config->item('upload_tmp').$list_photo_file[$key],
					$this->config->item('upload_storage').$storage.$path.$list_photo_file[$key]);	
					}

						
						
							
					
					$items[] = array(
						'photo_name'  => $list_photo_name[$key],
						'photo_file'  	=> $path.$list_photo_file[$key],
						'photo_type_id' =>	$list_photo_type_id[$key]
					);
					
					
				}
				}
				
				
				$error = $this->upload_photo_model->create($id,$data, $items);
				send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
			
				
			}
		
			function detail_list_loader($row_id=0)
			{
				if($row_id == 0)
				
				send_json(make_datatables_list(null)); 
						
				$data = $this->upload_photo_model->detail_list_loader($row_id);
				$sort_id = 0;
				foreach($data as $key => $value) 
				{
					
						if($value['photo_type_id'] == '3'){
							$photo_type_name = 'foto mobil keluar';
							if($value['photo_file'] != ''){
								$foto='<img   width="50px;" height="50px;" src='.base_url().'storage/img_mobil/'.$value['photo_file'].'';
							}else{
								$foto ='';
							}
						}else if($value['photo_type_id'] == '4'){
							$photo_type_name = 'foto mobil Perbandingan';
							if($value['photo_file'] != ''){
								$foto='<img   width="50px;" height="50px;" src='.base_url().'storage/img_mobil/'.$value['photo_file'].'';
							}else{
								$foto ='';
							}
						}
				
		
			
				$data[$key] = array(
						form_transient_pair('transient_photo_name', $value['photo_name'],$value['photo_name'],
										array(
											'transient_photo_id' => $value['photo_id'])),
						form_transient_pair('transient_photo_v',$foto, $foto, 
										array(
											'transient_photo_file' => $value['photo_file'],
											'transient_photo_edit' => 0)),
						form_transient_pair('transient_photo_type_id',$photo_type_name,$value['photo_type_id']),		
					
				);
		
		
	
		}		
		send_json(make_datatables_list($data)); 
		}
		function detail_list_loader_cat($registration_id=0)
		{
		if($registration_id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->upload_photo_model->detail_list_loader_cat($registration_id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		
		$data[$key] = array(
				form_transient_pair('transient_tm_name', $value['tm_name'], $value['tm_name']
				),
				form_transient_pair('transient_tm_qty', $value['tm_qty']),
				form_transient_pair('transient_tm_description',$value['tm_description']),
				form_transient_pair('transient_tm_price', tool_money_format($value['tm_price']), $value['tm_price'])
		);
		
		
		
		}		
		send_json(make_datatables_list($data)); 
	}
		function detail_form($registration_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
		{		
			$this->load->library('render');
			$this->load->model('global_model');
			$index = $this->input->post('transient_index');
			if (strlen(trim($index)) == 0) {
						
				// TRANSIENT CREATE - isi form dengan nilai default / kosong
					$data['index']							= $index;
					$data['transient_photo_id'] 			= '';
					$data['transient_photo_type_id'] 		='';
					$data['registration_id'] 				= $registration_id;
					$data['transient_photo_id'] 			= '';
					$data['transient_photo_name']			= '';	
					$data['transient_photo_file'] 			=  '';
					$data['transient_photo_edit'] 			=  '1';
					
					
			} else {
				
					$data['index']							= $index;
					$data['registration_id'] 				= $registration_id;
					$data['transient_photo_type_id'] 		= array_shift($this->input->post('transient_photo_type_id'));
					$data['transient_photo_id'] 			= array_shift($this->input->post('transient_photo_id'));
					$data['transient_photo_name'] 			= array_shift($this->input->post('transient_photo_name'));
					$data['transient_photo_file']			= array_shift($this->input->post('transient_photo_file'));
					$data['transient_photo_edit']			= array_shift($this->input->post('transient_photo_edit'));
			}		
			$data['photo_type_id'] 		= $this->global_model->get_type_photo();
			$this->load->helper('form');
			
		
			$this->render->add_form('app/upload_photo/transient_form', $data);
			$this->render->show_buffer();
		}

			
		function detail_form_action()
		{		
			$this->load->library('form_validation');
			$this->form_validation->set_rules('i_photo_file', 'Foto file', 'trim|required');
			$this->form_validation->set_rules('i_photo_name', 'nama Foto', 'trim|required');
			$index = $this->input->post('i_index');		
			// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
			
			$no 		= $this->input->post('i_index');
			
			
			$i_photo_name	= $this->input->post('i_photo_name');
			$i_photo_id		= $this->input->post('i_photo_id');
			
			$i_photo_type_id	= $this->input->post('i_photo_type_id');
			$i_photo_file	= $this->input->post('i_photo_file');
			$i_photo_edit	= $this->input->post('i_photo_edit');
			
			if($i_photo_type_id == '3'){$photo_type_name = 'foto mobil keluar';}else if($i_photo_type_id == '4') {$photo_type_name = 'foto mobil Perbandingan';}
		
			$foto='<img   width="50px;" height="50px;" src='.base_url().'tmp/'.$i_photo_file.'';
	
			$data = array(
						form_transient_pair('transient_photo_name', $i_photo_name,$i_photo_name,
										array(
											'transient_photo_id' => $i_photo_id)),
						form_transient_pair('transient_photo_v',$foto, $foto, 
										array(
											'transient_photo_file' => $i_photo_file,
											'transient_photo_edit' => $i_photo_edit)),
						form_transient_pair('transient_photo_type_id',$photo_type_name,$i_photo_type_id),		
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
			