<?php 

class Registration extends CI_Controller 
{	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('registration_model');
		$this->load->library('render');
		
		// set kode module ini .. misal usr
		$this->access->set_module('registration.registration');
		// default access adalah User
		$this->load->library('access');
		
	
	}
	function index()
	{
		$data = array();
		$this->load->model('global_model');
		$period_id = $this->global_model->get_active_period();
			
		$data['row_id'] = '';
		$data['period_id'] = $period_id[0];
		$data['stand_id'] = '';
		$data['registration_date'] = date('d/m/Y');
		$data['registration_code'] =  format_code('registrations','registration_code','R',7);
		$data['customer_id'] = '';
		$data['car_id'] = '';
		$data['claim_type'] = '1';
		$data['insurance_id'] = '';
		$data['check_in'] = date('d/m/Y');
		$data['registration_estimation_date'] = '';
		$data['registration_description'] = '';
		$data['registration_total_price'] = '';
		$data['own_retention']				= '';
		$data['pic_asuransi']				= '';
		$data['spk_date']					= '';
		$data['spk_no']						= '';
		$data['pkb_no']						= '';
	
		
		$this->load->helper('form');
		
		
		$this->render->add_form('app/registration/form', $data);
		$this->render->build('Registrasi');
		
		$this->render->add_view('app/registration/transient_list');
		$this->render->build('Data Panel');
		
		$this->render->add_view('app/registration/transient_list2');
		$this->render->build('Photo Before');
		
		//$this->render->add_view('app/registration/form_end', $data);
		//$this->render->build('Pembayaran');
		
		
		$this->render->add_js('ajaxfileupload');
		$this->render->show('Registrasi');
		
	}
	function table_controller()
	{
		$data = $this->registration_model->list_controller();
		send_json($data); 
	}
	
	
	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if($is_delete)
		{
			$this->load->model('registration_model');
			$id = $this->input->post('row_id');
			$is_process_error = $this->registration_model->delete($id);
			send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
		}
		
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
	
		// definisikan kriteria data
		$this->form_validation->set_rules('i_code','Kode','trim|min_length[3]|max_length[50]|required');
		$this->form_validation->set_rules('i_period_id','Periode','trim|required|integer');
		$this->form_validation->set_rules('i_stand_id','Cabang','trim|required|integer');
		$this->form_validation->set_rules('i_customer_id','Customer','trim|required|integer');
		$this->form_validation->set_rules('i_car_id','Mobil','trim|required|integer');
		$this->form_validation->set_rules('i_claim_type','Tipe Klaim','trim|required');
		$this->form_validation->set_rules('i_own_retention','OR','trim|required|is_numeric');
		$this->form_validation->set_rules('i_check_in','Tanggal Masuk','trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_registration_estimation_date','Tanggal Estimasi Keluar','trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_spk_no','No SPK','trim|required');
		$this->form_validation->set_rules('i_pkb_no','No PKB','trim|required');
		$this->form_validation->set_rules('i_spk_date','Tanggal SPK','trim|required|valid_date|sql_date');
		//$this->form_validation->set_rules('i_registration_description','Keterangan','trim|required');
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 

		$id = $this->input->post('row_id');
		$data['registration_code'] 			= $this->input->post('i_code');
		$data['period_id'] 					= $this->input->post('i_period_id');
		$data['stand_id'] 					= $this->input->post('i_stand_id');
		$data['customer_id'] 				= $this->input->post('i_customer_id');
		$data['car_id'] 					= $this->input->post('i_car_id');
		$data['employee_id']				= $this->access->info['employee_id'];
		$data['incident_date'] 				= "";
		$data['claim_type']					= $this->input->post('i_claim_type');
		$data['insurance_id'] 				= $this->input->post('i_insurance_id');
		$data['claim_no'] 					= $this->input->post('i_claim_no');
		$data['check_in'] 					= $this->input->post('i_check_in');
		$data['registration_estimation_date'] 					= $this->input->post('i_registration_estimation_date');
		$data['check_out'] 					= "";
		$data['registration_date'] 			= date("Y-m-d");
		$data['status_registration_id'] 		= 1;
		$data['registration_description']	= $this->input->post('i_registration_description');
		$data['own_retention']				= $this->input->post('i_own_retention');
		$data['pic_asuransi']				= $this->input->post('i_pic_asuransi');
		$data['spk_date']					= $this->input->post('i_spk_date');
		$data['spk_no']						= $this->input->post('i_spk_no');
		$data['pkb_no']						= $this->input->post('i_pkb_no');
		
		$list_product_id		= $this->input->post('transient_product_id');
		$list_product_price_id		= $this->input->post('transient_product_price_id');
		$list_registration_detail_qty	= $this->input->post('transient_registration_detail_qty');
		$list_registration_detail_price	 	= $this->input->post('transient_registration_detail_price');
		
		$list_registration_detail_total_price	= $this->input->post('transient_registration_detail_total_price');
		
		
		$list_registration_photo_name	 	= $this->input->post('transient_photo_name');
		$list_registration_photo	= $this->input->post('transient_photo');
		
		if(!$list_product_id) send_json_error('Simpan gagal. Data panel masih kosong');
	
		
		$total_price = 0;
		
		$items = array();
		if($list_product_id){
		foreach($list_product_id as $key => $value)
		{
			//$get_purchase_price = $this->registration_model->get_purchase_price($list_product_id[$key]);
			
			$items[] = array(				
				//'product_id'  => $list_product_id[$key],
				'detail_registration_type_id' => '1',
				'employee_id' => $this->access->info['employee_id'],
				'product_price_id' => $list_product_price_id[$key],
				'detail_registration_qty'  => $list_registration_detail_qty[$key],
				'detail_registration_price'  => $list_registration_detail_price[$key],
				'detail_registration_total_price'  => $list_registration_detail_total_price[$key]
			);
			
			$check = 0;
			$check_product = 0;
			$product_price_id_original = $list_product_price_id[$key];
			foreach($list_product_price_id as $key_check => $value)
				{
			
					if($product_price_id_original == $list_product_price_id[$key_check]){
						$check++;
					}
			
				}
			if($check > 1){
				
				$get_data_product = $this->registration_model->get_data_product($product_price_id_original);
				send_json_error("Simpan gagal. Panel item tidak boleh sama [ ".$get_data_product[0]. " - ".$get_data_product[1]. " ( ".$get_data_product[2]. " - ".$get_data_product[3]." )]");
			}
			$total_price += $list_registration_detail_total_price[$key];
		}
		}
		
		$data['total_registration'] = $total_price;
		
		$item2 = array();
		if($list_registration_photo_name){
		foreach($list_registration_photo_name as $key => $value)
		{
			if($list_registration_photo[$key])
			rename($this->config->item('upload_tmp').$list_registration_photo[$key],
			$this->config->item('upload_storage')."img_before/".$list_registration_photo[$key]);	
			
			$item2[] = array(				
				'photo_name'  => $list_registration_photo_name[$key],
				'photo'  => $list_registration_photo[$key]
				
			);
			
			
			
		}
		}

		
		
		if(empty($id)) // jika tidak ada id maka create
		{ 
			//$data['registration_code'] 			= format_code('registrations','registration_code','PU',7);
				
			$error = $this->registration_model->create($data, $items,$item2);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah", $this->registration_model->insert_id);
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$error = $this->registration_model->update($id, $data, $items,$item2);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}		
	}
	function detail_list_loader($registration_id=0)
	{
		if($registration_id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->registration_model->detail_list_loader($registration_id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		
		$data[$key] = array(
				form_transient_pair('transient_product_id', $value['product_code'], $value['product_id'],
				
				array(
                    'transient_product_price_id' => $value['product_price_id'],
					'transient_product_code' => $value['product_code']
				)),
				form_transient_pair('transient_product_name', $value['product_name']),
				form_transient_pair('transient_registration_detail_price', tool_money_format($value['registration_detail_price']), $value['registration_detail_price']),
				form_transient_pair('transient_registration_detail_qty', $value['registration_detail_qty'], $value['registration_detail_qty']),
				form_transient_pair('transient_registration_detail_total_price', tool_money_format($value['registration_detail_total_price']), $value['registration_detail_total_price'])
		);
		
		
		
		}		
		send_json(make_datatables_list($data)); 
	}
	
	
	function detail_list_loader2($registration_id=0)
	{
		if($registration_id == 0)
		
		send_json(make_datatables_list(null)); 
				
		$data = $this->registration_model->detail_list_loader2($registration_id);
		
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		$data[$key] = array(
				form_transient_pair('transient_photo_name', $value['photo_name']),
				form_transient_pair('transient_photo', $value['photo'])
				
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
			$data['index']			= '';
			$data['registration_id'] 				= $registration_id;
			$data['product_id']	= '';	
			$data['product_price_id'] = '';
			$data['product_name'] = '';			
			$data['registration_detail_qty'] 	= '';
			$data['registration_detail_price'] 	= '';
			$data['registration_detail_purchase_price'] = '';
			$data['registration_detail_total_price'] = '';
			$data['registration_detail_description'] = '';
		} else {
			
			$data['index']			= $index;
			$data['registration_id'] 				= $registration_id;
			$data['product_id']	= array_shift($this->input->post('transient_product_id'));
			$data['product_code']	= array_shift($this->input->post('transient_product_code'));
			$data['product_price_id']	= array_shift($this->input->post('transient_product_price_id'));
			$data['product_name'] = array_shift($this->input->post('transient_product_name'));
			$data['registration_detail_qty'] 	= array_shift($this->input->post('transient_registration_detail_qty'));
			$data['registration_detail_price'] = array_shift($this->input->post('transient_registration_detail_price'));
			$data['registration_detail_qty'] = array_shift($this->input->post('transient_registration_detail_qty'));
			$data['registration_detail_total_price'] = array_shift($this->input->post('transient_registration_detail_total_price'));
			
		}		
		$this->render->add_form('app/registration/transient_form', $data);
		$this->render->show_buffer();
	}
	
	
	function detail_form2($registration_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{		
		$this->load->library('render');
		$index = $this->input->post('transient_index');
		if (strlen(trim($index)) == 0) {
					
			// TRANSIENT CREATE - isi form dengan nilai default / kosong
			$data['index']			= '';
			$data['registration_id'] 				= $registration_id;
			$data['photo_name']	= '';	
			$data['photo'] = '';
		} else {
			
			$data['index']			= $index;
			$data['registration_id'] 				= $registration_id;
			$data['photo_name'] = array_shift($this->input->post('transient_photo_name'));
			$data['photo'] = array_shift($this->input->post('transient_photo'));
			
		}		
		$this->render->add_form('app/registration/transient_form2', $data);
		
		$this->render->show_buffer();
	}
	function detail_form_action2()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_photo_name', 'nama foto', 'trim|required');
		$this->form_validation->set_rules('i_photo','foto', 'trim|required');
	
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
	
		
		$no 		= $this->input->post('i_index');
		
		$photo_name	= $this->input->post('i_photo_name');
		$photo	= $this->input->post('i_photo');
		
		
		$foto='<img   width="50px;" height="50px;" src='.base_url().'tmp/'.form_transient_pair('transient_photo', $photo,$photo).'';
		form_transient_pair('transient_photo', $photo,$photo);
		$data = array(
	
				form_transient_pair('transient_photo_name', $photo_name, $photo_name),
				form_transient_pair('transient_photo',	$foto,$photo),
				
					
					
		);
		 
		send_json_transient($index, $data);
	}
	
	
	function detail_form_action()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_product_id', 'Produk', 'trim|required');
		$this->form_validation->set_rules('i_registration_detail_price', 'Harga', 'trim|required|numeric');
		$this->form_validation->set_rules('i_registration_detail_qty', 'Jumlah', 'trim|required|numeric');
		$this->form_validation->set_rules('i_registration_detail_total_price', 'Total', 'trim|required|numeric');
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		$this->load->model('global_model');	
		
		$no 		= $this->input->post('i_index');
		$product_id 	= $this->input->post('i_product_id');
		$product_price_id 		= $this->input->post('i_product_price_id');
		$product_code 	= $this->input->post('i_product_code');
		$registration_detail_price 	= $this->input->post('i_registration_detail_price');
		$registration_detail_qty 	= $this->input->post('i_registration_detail_qty');
		$registration_detail_total_price 	= $this->input->post('i_registration_detail_total_price');
				
		$get_data_product = $this->registration_model->get_data_product($product_price_id);
		$product_lengkap = $get_data_product[1]." (".$get_data_product[2]." - ".$get_data_product[3].")";
		//send_json_error($no);
		
		$data = array(
				form_transient_pair('transient_product_id', $product_code, $product_id),
				form_transient_pair('transient_product_name', $product_lengkap),
				form_transient_pair('transient_registration_detail_price', tool_money_format($registration_detail_price), $registration_detail_price),
				form_transient_pair('transient_registration_detail_qty', $registration_detail_qty, $registration_detail_qty),
				form_transient_pair('transient_registration_detail_total_price', tool_money_format($registration_detail_total_price), $registration_detail_total_price,
				array(
                    'transient_product_price_id' => $product_price_id,
					'transient_product_code' => $product_code
				))
		);
		 
		send_json_transient($index, $data);
	}
	
	function load_product_price()
	{
		$id 	= $this->input->post('product_price_id');
		
		$query = $this->registration_model->load_product_price($id);
		$data = array();
		
		foreach($query->result_array() as $row)
		{
			$data['product_id'] = $row['product_id'];
			$data['product_code'] = $row['product_code'];
			$data['price'] = $row['product_price'];
			$data['qty'] = 1;
			$data['total'] = $row['product_price'];
		}
		send_json_message('Product Stock', $data);
	}
	
	function report($id = 0){
	
	if($id){
	   $this->load->model('global_model');
	   
	   $result = $this->registration_model->read_id($id);
			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data = $result;
				$data['row_id'] = $id;		
				$data['car_nopol'] = $result['car_nopol'];	
				$data['customer_name'] = ($result['customer_name']) ? $result['customer_name'] : "-";
				
			}
		//$data='';
			
		$data_detail = $this->registration_model->get_data_detail($id);
	   
	   $this->global_model->create_report_registration('Laporan Regitrasi', 'report/registration.php', $data, $data_detail, 'header.php');
	}
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
