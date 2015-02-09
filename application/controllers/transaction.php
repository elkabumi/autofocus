<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			class Transaction extends CI_Controller{
			function __construct(){
			parent::__construct();
			$this->load->library('render');
			$this->load->model('transaction_model');
			$this->load->library('access');
			$this->access->set_module('transaction.transaction');
			$this->access->user_page();
			}
			function index(){
			$this->render->add_view('app/transaction/list');
			$this->render->build('Progress Pengerjaan');
			$this->render->show('Progress Pengerjaan');
		}
		function table_controller(){
			$data = $this->transaction_model->list_controller();
			send_json($data);
		}
		function form($registration_id = 0)
		{
			$data = array();
			$this->load->model('global_model');

			$result = $this->transaction_model->read_id($registration_id);
			if($result){
				$data = $result;
				$data['row_id'] = $registration_id;
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
				$data['spk_date'] = format_new_date($data['spk_date']);
				$data['transaction_plain_first_date'] = format_new_date($result['transaction_plain_first_date']);
				$data['transaction_plain_last_date'] = $result['transaction_plain_last_date'];
				$data['transaction_actual_date'] = $result['transaction_actual_date'];
				$data['transaction_target_date'] = $result['transaction_target_date'];
			}
				
			$this->load->helper('form');
			$this->render->add_form('app/transaction/form', $data);
			$this->render->build('Registrasi');
			
			// List sparepart
			$this->render->add_view('app/transaction/transient_list_sparepart', $data);
			$this->render->build('Data Sparepart');
			
			// list panel asuransi
			$this->render->add_view('app/transaction/transient_list_panel', $data);
			$this->render->build('Data Panel Asuransi');

			// list jasa
			$this->render->add_view('app/transaction/transient_list', $data);
			$this->render->build('Data Jasa');

			// list cat
			$this->render->add_view('app/transaction/transient_list_cat', $data);
			$this->render->build('Data Cat');

			// list foto
			$this->render->add_view('app/transaction/transient_list_foto');
			$this->render->build('Photo');
			
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
				$is_process_error = $this->transaction_model->delete($id);
				send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
			}
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
		// definisikan kriteria data
				
				$this->form_validation->set_rules('i_employee_group_id','Tim Kerja','trim|required');
				$this->form_validation->set_rules('i_first_date','Tanggal awal plain','trim|required|valid_date|sql_date');
				$this->form_validation->set_rules('i_last_date','Tanggal akhir plain','trim|required|valid_date|sql_date');
				$this->form_validation->set_rules('i_actual_date','Tanggal Aktual','trim|required|valid_date|sql_date');
				$this->form_validation->set_rules('i_target_date','Tanggal target selesai','trim|required|valid_date|sql_date');
			
		// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate();

				$transaction_id = $this->input->post('i_transaction_id');

				$data['registration_id'] = $this->input->post('row_id');
				$data['employee_group_id'] = $this->input->post('i_employee_group_id');
				$data['transaction_plain_first_date'] = $this->input->post('i_first_date');
				$data['transaction_plain_last_date'] = $this->input->post('i_last_date');
				$data['transaction_actual_date'] = $this->input->post('i_actual_date');
				$data['transaction_target_date'] = $this->input->post('i_target_date');

				// simpan transient jasa
				$list_transaction_detail_date		= $this->input->post('transient_transaction_detail_date');
				$list_workshop_service_id			= $this->input->post('transient_workshop_service_id');
				$list_workshop_service_price		= $this->input->post('transient_workshop_service_price');
				$list_workshop_service_job_price	= $this->input->post('transient_workshop_service_job_price');
				$list_transaction_detail_progress	= $this->input->post('transient_transaction_detail_progress');

			if(!$list_transaction_detail_date) send_json_error('Simpan gagal. Data Progress Pengerjaan masih kosong');
				$total_price = 0;
				$total_progress = 0;
				$jumlah_jasa = 0;
				$items = array();

				// jasa
				if($list_transaction_detail_date){
					foreach($list_transaction_detail_date as $key => $value)
					{
				//$get_purchase_price = $this->registration_model->get_purchase_price($list_product_id[$key]);
						$items[] = array(
							'transaction_detail_date' => ($list_transaction_detail_date[$key]),
							'transaction_detail_progress' => $list_transaction_detail_progress[$key],
							'workshop_service_id' => $list_workshop_service_id[$key],
							'workshop_service_price' => $list_workshop_service_price[$key],
							'workshop_service_job_price' => $list_workshop_service_job_price[$key]
							);
						$total_price += $list_workshop_service_job_price[$key];
						$total_progress += $list_transaction_detail_progress[$key];
						$jumlah_jasa++;
					}
				}

				// simpan transient cat/bahan
				$list_tm_name			= $this->input->post('transient_tm_name');
				$list_tm_qty			= $this->input->post('transient_tm_qty');
				$list_tm_description	= $this->input->post('transient_tm_description');
				$list_tm_price				= $this->input->post('transient_tm_price');
				
				$total_material = 0;
				$items_material = array();

				if($list_tm_name){
					foreach($list_tm_name as $key => $value)
					{
						$items_material[] = array(
							'tm_name' 			=> ($list_tm_name[$key]),
							'tm_qty' 			=> $list_tm_qty[$key],
							'tm_description' 	=> $list_tm_description[$key],
							'tm_price'			=> $list_tm_price[$key]
							);
						$total_material += $list_tm_price[$key];

					}
				}

				// simpan transient foto
				$list_registration_photo_name	 	= $this->input->post('transient_photo_name');
				$list_registration_photo_type	 	= $this->input->post('transient_photo_type');
				$list_registration_photo_file		= $this->input->post('transient_photo_file');
				$list_registration_photo_edit		= $this->input->post('transient_photo_edit');

				$items_foto = array();
				if($list_registration_photo_name){
				foreach($list_registration_photo_name as $key => $value)
				{
					$path = "";
					if($list_registration_photo_edit[$key] == 1){
						
						$storage = "img_mobil/";
						$path = $this->access->info['employee_id']."_".date("ymdhms")."_".$list_registration_photo_type[$key]."_";
					
					rename($this->config->item('upload_tmp').$list_registration_photo_file[$key],
					$this->config->item('upload_storage').$storage.$path.$list_registration_photo_file[$key]);	
					}

					$items_foto[] = array(				
						'photo_name'  => $list_registration_photo_name[$key],
						'photo_type_id'  => $list_registration_photo_type[$key],
						'photo_file'  => $path.$list_registration_photo_file[$key]
						
					);
					
					
					
				}
				}


				$data['transaction_material_total'] = $total_material;
				$data['transaction_progress'] = $total_progress / $jumlah_jasa;
				$data['transaction_total'] = $total_price;

				if(empty($transaction_id)) // jika tidak ada id maka create
				{
			//$data['registration_code'] = format_code('registrations','registration_code','PU',7);
				$error = $this->transaction_model->create($data, $items, $items_material, $items_foto);
				send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
				}
				else // id disebutkan, lakukan proses UPDATE
				{
					$error = $this->transaction_model->update($transaction_id, $data, $items, $items_material, $items_foto);
					send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
				}
			}
			function detail_list_loader($registration_id=0)
			{
				if($registration_id == 0)send_json(make_datatables_list(null));

				$data = $this->transaction_model->detail_list_loader($registration_id);
				$sort_id = 0;

				foreach($data as $key => $value)
				{
				$data[$key] = array(
					form_transient_pair('transient_transaction_detail_date', format_new_date($value['transaction_detail_date']), $value['transaction_detail_date'],
							array(
									'transient_transaction_detail_id' => $value['transaction_detail_id'],
									
									)),
					
						form_transient_pair('transient_workshop_service_id', $value['workshop_service_name'], $value['workshop_service_id']),
						form_transient_pair('transient_workshop_service_price', tool_money_format($value['workshop_service_price']), $value['workshop_service_price']),
						form_transient_pair('transient_workshop_service_job_price', tool_money_format($value['workshop_service_job_price']),$value['workshop_service_job_price']),
						form_transient_pair('transient_transaction_detail_progress', $value['transaction_detail_progress'])
					);
				}
				send_json(make_datatables_list($data));
			}
			
			function detail_form($registration = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
			{
				$this->load->library('render');
				$index = $this->input->post('transient_index');
				if (strlen(trim($index)) == 0) {
					// TRANSIENT CREATE - isi form dengan nilai default / kosong
					$data['index'] = '';
					$data['transaction_detail_id'] = '';
					$data['transaction_detail_date'] = '';
					$data['workshop_service_id'] = '';
					$data['workshop_service_price'] = '';
					$data['workshop_service_name'] = '';
					$data['workshop_service_job_price'] = '';
					$data['transaction_detail_progress'] = '';
				} else {
					$data['index'] = $index;
					//$data['workshop_service_name'] = array_shift($this->input->post('transient_workshop_service_name'));
					$data['transaction_detail_id'] = array_shift($this->input->post('transient_transaction_detail_id'));
					$data['transaction_detail_date'] = array_shift($this->input->post('transient_transaction_detail_date'));
					$data['workshop_service_id'] = array_shift($this->input->post('transient_workshop_service_id'));
					$data['workshop_service_price'] = array_shift($this->input->post('transient_workshop_service_price'));
					$data['workshop_service_job_price'] = array_shift($this->input->post('transient_workshop_service_job_price'));
					$data['transaction_detail_progress'] = array_shift($this->input->post('transient_transaction_detail_progress'));
				}
					$this->load->helper('form');
					$this->render->add_form('app/transaction/transient_form', $data);
					$this->render->show_buffer();
			}
			
			
			function detail_form_action()
			{
				$this->load->library('form_validation');
				//$this->form_validation->set_rules('i_detail_registration_id', 'Harga', 'trim|required');
				$this->form_validation->set_rules('i_transaction_detail_date', 'Tanggal', 'trim|required|valid_date|sql_date');
				$this->form_validation->set_rules('i_workshop_service_id', 'Jasa', 'trim|required');
				$this->form_validation->set_rules('i_transaction_detail_progress', 'Progress', 'trim|required|max_value[100]');
				$index = $this->input->post('i_index');
			// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate();
				$no = $this->input->post('i_index');
				
				$transaction_detail_id = $this->input->post('i_transaction_detail_id');
				$transaction_detail_date = ($this->input->post('i_transaction_detail_date'));
				$workshop_service_id = $this->input->post('i_workshop_service_id');
				$workshop_service_price	= $this->input->post('i_workshop_service_price');
				$workshop_service_name	= $this->input->post('i_workshop_service_name');
				$workshop_service_job_price	= $this->input->post('i_workshop_service_job_price');
				$transaction_detail_progress	= $this->input->post('i_transaction_detail_progress');
				//send_json_error($no);
				$data = array(
				form_transient_pair('transient_transaction_detail_date', format_new_date($transaction_detail_date), $transaction_detail_date,
							array(
									'transient_transaction_detail_id' => $transaction_detail_id)),
					
						form_transient_pair('transient_workshop_service_id', $workshop_service_name, $workshop_service_id),
						form_transient_pair('transient_workshop_service_price', tool_money_format($workshop_service_price), $workshop_service_price),
						form_transient_pair('transient_workshop_service_job_price', tool_money_format($workshop_service_job_price),$workshop_service_job_price),
						form_transient_pair('transient_transaction_detail_progress', $transaction_detail_progress)
					);
			send_json_transient($index, $data);
		}
			
	function detail_list_loader_sparepart($registration_id=0)
	{
		if($registration_id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->transaction_model->detail_list_loader_sparepart($registration_id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		
		$data[$key] = array(
				form_transient_pair('transient_rs_part_number', $value['rs_part_number'], $value['rs_part_number']
				),
				form_transient_pair('transient_rs_name', $value['rs_name']),
				form_transient_pair('transient_rs_qty',$value['rs_qty']),
				form_transient_pair('transient_rs_repair', tool_money_format($value['rs_repair']), $value['rs_repair']),
				form_transient_pair('transient_rs_approved_repair', tool_money_format($value['rs_approved_repair']), $value['rs_approved_repair'])
		);
		
		
		
		}		
		send_json(make_datatables_list($data)); 
	}

	function detail_list_loader_panel($row_id=0)
			{
				if($row_id == 0)
				
				send_json(make_datatables_list(null)); 
						
				$data = $this->transaction_model->detail_list_loader_panel($row_id);
				$sort_id = 0;
				foreach($data as $key => $value) 
				{
				$data[$key] = array(
						form_transient_pair('transient_product_code', $value['product_code'],$value['product_code'],
									array(
											'transient_product_price_id' => $value['product_price_id'],
											'transient_detail_registration_id' =>$value['detail_registration_id'])),
											
						form_transient_pair('transient_product_name', $value['product_name']." (".$value['product_type_name']." - ".$value['pst_name'].")", $value['product_name']),
						form_transient_pair('transient_reg_price',	$value['detail_registration_price'],$value['detail_registration_price']),
						form_transient_pair('transient_reg_aproved_price',	$value['detail_registration_approved_price'],$value['detail_registration_approved_price'])
						
				);
		
		
	
		}		
		send_json(make_datatables_list($data)); 
	}

	function detail_list_loader_cat($registration_id=0)
	{
		if($registration_id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->transaction_model->detail_list_loader_cat($registration_id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		
		$data[$key] = array(
				form_transient_pair('transient_tm_name', $value['tm_name'], $value['tm_name']),
				form_transient_pair('transient_tm_qty', $value['tm_qty']),
				form_transient_pair('transient_tm_description',$value['tm_description']),
				form_transient_pair('transient_tm_price', tool_money_format($value['tm_price']), $value['tm_price'])
		);
		
		
		
		}		
		send_json(make_datatables_list($data)); 
	}

	function detail_list_loader_foto($registration_id=0)
	{
		if($registration_id == 0)
		
		send_json(make_datatables_list(null)); 
				
		$data = $this->transaction_model->detail_list_loader_foto($registration_id);
		
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
											'transient_photo_edit' => 0
											)
				),
				form_transient_pair('transient_photo_type', $value['photo_type_name'], $value['photo_type_id']),
				$foto
				
		);
		
		
	
		}		
		send_json(make_datatables_list($data)); 
	}

	function detail_form_cat($registration_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{		
		$this->load->library('render');
		$index = $this->input->post('transient_index');
		if (strlen(trim($index)) == 0) {
					
			// TRANSIENT CREATE - isi form dengan nilai default / kosong
			$data['index']			= '';
			$data['registration_id'] 				= $registration_id;
			$data['tm_name']	= '';	
			$data['tm_qty'] = '';
			$data['tm_description'] = '';			
			$data['tm_price'] 	= '';
		
		} else {
			
			$data['index']			= $index;
			$data['registration_id'] 				= $registration_id;
			$data['tm_name']	= array_shift($this->input->post('transient_tm_name'));
			$data['tm_qty'] = array_shift($this->input->post('transient_tm_qty'));
			$data['tm_description'] = array_shift($this->input->post('transient_tm_description'));
			$data['tm_price'] 	= array_shift($this->input->post('transient_tm_price'));
		
		}		
		$this->render->add_form('app/transaction/transient_form_cat', $data);
		$this->render->show_buffer();
	}
	
	
	function detail_form_action_cat()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_tm_name', 'Nama bahan / cat', 'trim|required');
		$this->form_validation->set_rules('i_tm_qty', 'Qty', 'trim|required');
		//$this->form_validation->set_rules('i_tm_description', 'Keterangan', 'trim|required|numeric');
		$this->form_validation->set_rules('i_tm_price', 'Harga', 'trim|required|numeric');
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		$this->load->model('global_model');	
		
		$no 		= $this->input->post('i_index');
		$tm_name 	= $this->input->post('i_tm_name');
		$tm_qty 	= $this->input->post('i_tm_qty');
		$tm_description 	= $this->input->post('i_tm_description');
		$tm_price 	= $this->input->post('i_tm_price');
	
		//send_json_error($no);
		
	$data = array(
				form_transient_pair('transient_tm_name', $tm_name, $tm_name
				),
				form_transient_pair('transient_tm_qty', $tm_qty),
				form_transient_pair('transient_tm_description',$tm_description),
				form_transient_pair('transient_tm_price', tool_money_format($tm_price), $tm_price)
		);
		 
		send_json_transient($index, $data);
	}
	
	function detail_form_foto($registration_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{		
		$this->load->library('render');
		$index = $this->input->post('transient_index');
		if (strlen(trim($index)) == 0) {
					
			// TRANSIENT CREATE - isi form dengan nilai default / kosong
			$data['index']			= '';
			$data['registration_id'] 				= $registration_id;
			$data['photo_name']	= '';
			$data['photo_type']	= '2';
			$data['photo_edit']	= '1';	
			$data['photo_type_name'] = "Foto Pengerjaan";
			$data['photo_file'] = '';
		} else {
			
			$data['index']			= $index;
			$data['registration_id'] 				= $registration_id;
			$data['photo_name'] = array_shift($this->input->post('transient_photo_name'));
			$data['photo_type'] = array_shift($this->input->post('transient_photo_type'));
			$data['photo_type_name'] = array_shift($this->input->post('transient_photo_type_name'));
			$data['photo_file'] = array_shift($this->input->post('transient_photo_file'));
			$data['photo_edit'] = array_shift($this->input->post('transient_photo_edit'));

			
		}		
		$this->render->add_form('app/transaction/transient_form_foto', $data);
		
		$this->render->show_buffer();
	}
	function detail_form_action_foto()
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
		$photo_type_name	= $this->input->post('i_photo_type_name');
		$photo_file	= $this->input->post('i_photo_file');
		$photo_edit	= $this->input->post('i_photo_edit');
		
		
		$foto='<img   width="50px;" height="50px;" src='.base_url().'tmp/'.form_transient_pair('transient_photo', $photo_file,$photo_file).'';
		form_transient_pair('transient_photo', $photo_file,$photo_file);
		$data = array(
	
				form_transient_pair('transient_photo_name', $photo_name, $photo_name, 
					array(
											'transient_photo_type_name' => $photo_type_name,
											'transient_photo_file' => $photo_file,
											'transient_photo_edit' => $photo_edit
											)
				),
				form_transient_pair('transient_photo_type', $photo_type_name, $photo_type),
				form_transient_pair('transient_photo',	$foto, $photo_file),
				
					
					
		);
		 
		send_json_transient($index, $data);
	}

	function load_workshop_service()
	{
		$id 	= $this->input->post('workshop_service_id');
		
		$query = $this->transaction_model->load_workshop_service($id);
		$data = array();
		
		foreach($query->result_array() as $row)
		{
			$data['workshop_service_price'] = $row['workshop_service_price'];
			$data['workshop_service_job_price'] = $row['workshop_service_job_price'];
			$data['workshop_service_name'] = $row['workshop_service_name'];
		}
		send_json_message('workshop_service', $data);
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
			
