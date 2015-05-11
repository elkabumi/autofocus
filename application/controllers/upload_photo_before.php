<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Upload_photo_before extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('upload_photo_before_model');
		$this->load->library('access');
		$this->access->set_module('master.upload_photo_before');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/upload_photo_before/list');
		$this->render->build('Data Registrasi');
		$this->render->show('Data Registrasi');
	}
	
	function table_controller(){
		$data = $this->upload_photo_before_model->list_controller();
		send_json($data);
	}
	
	
	function form($id = 0)
	{
		$data = array();
		
			$result = $this->upload_photo_before_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
				$data['spk_date'] = format_new_date($data['spk_date']);
			
			}
		
		
		$this->load->helper('form');
			
		$this->render->add_form('app/upload_photo_before/form', $data);
		$this->render->build('Data Registrasi');
	
		
		$this->render->add_view('app/upload_photo_before/transient_list_foto');
		$this->render->build('Photo Sebelum Mobil Masuk');
		
		$this->render->add_view('app/upload_photo_before/form_save', $data);	
		$this->render->build('Data Registrasi');
		
		$this->render->add_js('ajaxfileupload');
		$this->render->show('upload photo before');
	}
	
	function form_action($is_delete = 0){
		
		$this->load->library('form_validation');
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if($is_delete)
		{
			$this->load->model('upload_photo_before_model');
			$id = $this->input->post('row_id');
			$is_process_error = $this->upload_photo_before_model->delete($id);
			send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
		}
		
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
	
		// definisikan kriteria data
		/*
		$this->form_validation->set_rules('i_code','Kode','trim|min_length[3]|max_length[50]|required');
		$this->form_validation->set_rules('i_period_id','Periode','trim|required|integer');
		$this->form_validation->set_rules('i_stand_id','Cabang','trim|required|integer');
		$this->form_validation->set_rules('i_customer_id','Customer','trim|required|integer');
		$this->form_validation->set_rules('i_car_id','Mobil','trim|required|integer');
		$this->form_validation->set_rules('i_claim_type','Tipe Klaim','trim|required');
		$this->form_validation->set_rules('i_own_retention','OR','trim');
		$this->form_validation->set_rules('i_check_in','Tanggal Masuk','trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_registration_estimation_date','Tanggal Estimasi Keluar','trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_spk_no','No SPK','trim|required');
		$this->form_validation->set_rules('i_pkb_no','No PKB','trim|required');
		$this->form_validation->set_rules('i_spk_date','Tanggal SPK','trim|required|valid_date|sql_date');
		
		$this->form_validation->set_rules('i_disc_panel','Diskon Panel','max_value[100]');
		$this->form_validation->set_rules('i_disc_parts','Diskon SpareParts','max_value[100]');
		$this->form_validation->set_rules('i_registration_description','Keterangan','trim|required');
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		*/
		$id = $this->input->post('row_id');
		/*
		$data['registration_code'] 			= $this->input->post('i_code');
		$data['period_id'] 					= $this->input->post('i_period_id');
		$data['stand_id'] 					= $this->input->post('i_stand_id');
		$data['customer_id'] 				= $this->input->post('i_customer_id');
		$data['car_id'] 					= $this->input->post('i_car_id');
		$data['employee_id']				= $this->access->info['employee_id'];
		$data['incident_date'] 				= "";
		$data['claim_type']					= $this->input->post('i_claim_type');
		$data['insurance_id'] 				= $this->input->post('i_insurance_id');
		
		$data['registration_dp']			= $this->input->post('i_registration_dp');
		$data['insurance_pph'] 				= $this->input->post('i_insurance_pph');
		$data['claim_no'] 					= $this->input->post('i_claim_no');
		$data['check_in'] 					= $this->input->post('i_check_in');
		$data['registration_estimation_date'] 					= $this->input->post('i_registration_estimation_date');
		$data['check_out'] 					= "";
		$data['registration_date'] 			= date("Y-m-d");
		$data['status_registration_id'] 		= 2;
		$data['registration_description']	= $this->input->post('i_registration_description');
		$data['own_retention']				= $this->input->post('i_own_retention');
		$data['pic_asuransi']				= $this->input->post('i_pic_asuransi');
		$data['spk_date']					= $this->input->post('i_spk_date');
		$data['spk_no']						= $this->input->post('i_spk_no');
		$data['pkb_no']						= $this->input->post('i_pkb_no');
		$data['upload_photo_before_disc_panel']	= $this->input->post('i_disc_panel');
		$data['upload_photo_before_disc_sparepart']		= $this->input->post('i_disc_parts');
		
		*/
		$list_registration_photo_name	 	= $this->input->post('transient_photo_name');
		$list_registration_photo_type_id	= $this->input->post('transient_photo_type_id');
		$list_registration_photo_file		= $this->input->post('transient_photo_file');
		$list_registration_photo_edit		= $this->input->post('transient_photo_edit');
				
		$items_foto = array();
		if($list_registration_photo_name){
			foreach($list_registration_photo_name as $key => $value)
			{
				$path = "";
				if($list_registration_photo_edit[$key] == 1){
						
					$storage = "img_mobil/";
					$path = $this->access->info['employee_id']."_".date("ymdhms")."_".$list_registration_photo_type_id[$key]."_";
					
					rename($this->config->item('upload_tmp').$list_registration_photo_file[$key],
					$this->config->item('upload_storage').$storage.$path.$list_registration_photo_file[$key]);	
			}

			$items_foto[] = array(				
						'photo_name'  => $list_registration_photo_name[$key],
						'photo_type_id'  => $list_registration_photo_type_id[$key],
						'photo_file'  => $path.$list_registration_photo_file[$key]
						
			);
					
					
					
			}
		}
		
		
			$error = $this->upload_photo_before_model->update($id,$items_foto);
			send_json_action($error, "Data Foto Telah disimpan", "Data gagal disimpan");

			
		
		
	}
	
	function detail_list_foto($registration_id=0)
	{
		if($registration_id == 0)
		
		send_json(make_datatables_list(null)); 
				
		$data = $this->upload_photo_before_model->detail_list_loader_foto($registration_id);
		
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
			$storage = "storage/img_mobil/";

			$foto='<img width="50px;" height="50px;" src='.base_url().$storage.form_transient_pair('transient_photo', $value['photo_file'], $value['photo_file']).'';
				

		$data[$key] = array(
				form_transient_pair('transient_photo_name', $value['photo_name'],$value['photo_name'],
					array(
											'transient_photo_type_name' => $value['photo_type_name'],
											'transient_photo_file' => $value['photo_file'],
											'transient_photo_edit' => 0,
											'transient_photo_type_id'=>  $value['photo_type_id'],
											
											)
				),
				$foto
				
		);
		
		
	
		}		
		send_json(make_datatables_list($data)); 
	}
			
	function detail_form_foto($registration_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{		
		$this->load->library('render');
		$index = $this->input->post('transient_index');
		$this->load->model('global_model');
		if (strlen(trim($index)) == 0) {
					
			// TRANSIENT CREATE - isi form dengan nilai default / kosong
			$data['index']			= '';
			$data['registration_id'] 				= $registration_id;
			$data['photo_name']	= '';
			$data['photo_type']	= '2';
			$data['photo_edit']	= '1';	
			$data['photo_type_id'] = "";
			$data['photo_file'] = '';
		} else {
			
			$data['index']			= $index;
			$data['registration_id'] 				= $registration_id;
			$data['photo_name'] = array_shift($this->input->post('transient_photo_name'));
			$data['photo_type'] = 2;
			$data['photo_type_id'] = array_shift($this->input->post('transient_photo_type_id'));
			$data['photo_file'] = array_shift($this->input->post('transient_photo_file'));
			$data['photo_edit'] = array_shift($this->input->post('transient_photo_edit'));

			
		}		
		$data['cbo_photo_type_id'] 		= $this->global_model->get_type_photo(1);
		$this->load->helper('form');
		$this->render->add_form('app/upload_photo_before/transient_form_foto', $data);
		
		$this->render->show_buffer();
	}
	function detail_form_foto_action()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_photo_name', 'nama foto', 'trim|required');
		$this->form_validation->set_rules('i_photo_file','foto', 'trim|required');
	
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
	
		
		$no 		= $this->input->post('i_index');
		
		$photo_name	= $this->input->post('i_photo_name');
		$photo_type	= $this->input->post('i_photo_type');
		$photo_type_id	= $this->input->post('i_photo_type_id');
		$photo_file	= $this->input->post('i_photo_file');
		$photo_edit	= $this->input->post('i_photo_edit');
		if($photo_edit == '0' or $photo_edit == '2' ){
			$photo_edit	 = '2';
			$foto='<img   width="50px;" height="50px;" src='.base_url().'storage/img_mobil/'.form_transient_pair('transient_photo', $photo_file,$photo_file).'';
		}else{
			$foto='<img   width="50px;" height="50px;" src='.base_url().'tmp/'.form_transient_pair('transient_photo', $photo_file,$photo_file).'';
		}
		
		$photo_type_name = $this->upload_photo_before_model->get_photo_type_name($photo_type_id);
		
		
		form_transient_pair('transient_photo', $photo_file,$photo_file);
		$data = array(
	
				form_transient_pair('transient_photo_name', $photo_name, $photo_name, 
					array(
											'transient_photo_type_name' => $photo_type_name,
											'transient_photo_file' => $photo_file,
											'transient_photo_edit' => $photo_edit,
											'transient_photo_type_id' => $photo_type_id
											)
				),
				
				form_transient_pair('transient_photo',	$foto, $photo_file),
				
					
					
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
