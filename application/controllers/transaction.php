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
				$result = $this->transaction_model->read_id($registration_id);
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
			$this->render->add_form('app/transaction/form', $data);
			$this->render->build('Registrasi');
			$this->render->add_view('app/transaction/transient_list', $data);
			$this->render->build('Data Panel');
			
			$this->render->show('Transaksi');
		}
		
		
		function form2($transaction_id = 0)
		{
			$data = array();
			if($transaction_id == 0){
				$data['row_id'] = '';
				$data['i_transaction_id'] = '';
				$data['transaction_id'] = '';
				$data['employee_group_id'] = '';
				$data['transaction_type_id'] = '';
				$data['transaction_plain_first_date'] = date('d/m/Y');
				$data['transaction_plain_last_date'] = date('d/m/Y');
				$data['transaction_actual_date'] = date('d/m/Y');
				$data['transaction_target_date'] = date('d/m/Y');
				$data['transaction_detail_description'] = '';
			}else{
				$result = $this->transaction_model->read_id2($transaction_id);
			if($result){
				$data = $result;
				$data['row_id'] = $result['registration_id'];
				$data['i_transaction_id'] = $transaction_id;
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
				$this->render->add_form('app/transaction/form', $data);
				$this->render->build('Registrasi');
				$this->render->add_view('app/transaction/transient_list', $data);
				$this->render->build('Data Panel');
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
				$this->form_validation->set_rules('row_id','Registrasi','trim|required');
				$this->form_validation->set_rules('i_employee_group_id','Tim Kerja','trim|required');
				$this->form_validation->set_rules('i_first_date','Registrasi','trim|required|valid_date|sql_date');
				$this->form_validation->set_rules('i_last_date','Tim Kerja','trim|required|valid_date|sql_date');
				$this->form_validation->set_rules('i_actual_date','Registrasi','trim|required|valid_date|sql_date');
				$this->form_validation->set_rules('i_target_date','Tim Kerja','trim|required|valid_date|sql_date');
				$this->form_validation->set_rules('i_komponen','Keterangan bongkar komponen','max_value[100]');
				$this->form_validation->set_rules('i_lasketok','Keterangan Las/Ketok','max_value[100]');
				$this->form_validation->set_rules('i_dempul','Keterangan Dempul','max_value[100]');
				$this->form_validation->set_rules('i_cat','Keterangan Cat','max_value[100]');
				$this->form_validation->set_rules('i_poles','Keterangan Poles','max_value[100]');
				$this->form_validation->set_rules('i_rakit','Keterangan Rakit','max_value[100]');
		// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate();
				$id = $this->input->post('i_transaction_id');
				$data['registration_id'] = $this->input->post('row_id');
				$data['employee_group_id'] = $this->input->post('i_employee_group_id');
				$data['transaction_plain_first_date'] = $this->input->post('i_first_date');
				$data['transaction_plain_last_date'] = $this->input->post('i_last_date');
				$data['transaction_actual_date'] = $this->input->post('i_actual_date');
				$data['transaction_target_date'] = $this->input->post('i_target_date');
				
				$data['transaction_komponen'] = $this->input->post('i_komponen');
				$data['transaction_lasketok'] = $this->input->post('i_lasketok');
				$data['transaction_dempul'] = $this->input->post('i_dempul');
				$data['transaction_cat'] = $this->input->post('i_cat');
				$data['transaction_poles'] = $this->input->post('i_poles');
				$data['transaction_rakit'] = $this->input->post('i_rakit');
				
			
				
				
				$sum_progres = $data['transaction_komponen'] + $data['transaction_lasketok'] 
				+ $data['transaction_dempul'] + $data['transaction_cat'] +$data['transaction_poles'] +$data['transaction_rakit'] ;
				
				$data['transaction_progress']  = $sum_progres / 6;
				//send_json($data['transaction_progress']);
				$registration_id = $this->input->post('row_id');
		/*$items2 = $this->transaction_model->employee_group($registration_id);
		foreach($items2 as $row){
		$items2[]= array(
		'employee_id' => $row['employee_id']
		);
		}*/	
				$list_detail_registration_id	= $this->input->post('transient_detail_registration_id');
				$list_transaction_detail_bongkar_komponen	= $this->input->post('transient_transaction_detail_bongkar_komponen');
				$list_transaction_detail_lasketok	= $this->input->post('transient_transaction_detail_lasketok');
				$list_transaction_detail_dempul	= $this->input->post('transient_transaction_detail_dempul');
				$list_transaction_detail_cat	= $this->input->post('transient_transaction_detail_cat');
				$list_transaction_detail_poles	= $this->input->post('transient_transaction_detail_poles');
				$list_transaction_detail_rakit	= $this->input->post('transient_transaction_detail_rakit');
		/*$list_transaction_detail_plain_first_date = $this->input->post('transient_transaction_detail_plain_first_date');
		$list_transaction_detail_plain_last_date = $this->input->post('transient_transaction_detail_plain_last_date');
		$list_transaction_detail_actual_date = $this->input->post('transient_transaction_detail_actual_date');
		$list_transaction_detail_target_date = $this->input->post('transient_transaction_detail_target_date');*/
				$list_transaction_detail_date	= $this->input->post('transient_transaction_detail_date');
				$list_transaction_detail_description	= $this->input->post('transient_transaction_detail_description');
				$list_transaction_detail_total	= $this->input->post('transient_transaction_detail_total');
			if(!$list_detail_registration_id) send_json_error('Simpan gagal. Data panel masih kosong');
				$total_price = 0;
				$items = array();
			if($list_detail_registration_id){
				foreach($list_detail_registration_id as $key => $value)
				{
			//$get_purchase_price = $this->registration_model->get_purchase_price($list_product_id[$key]);
				$items[] = array(
				'detail_registration_id' => $list_detail_registration_id[$key],
				
				'transaction_detail_bongkar_komponen' => $list_transaction_detail_bongkar_komponen[$key],
				'transaction_detail_lasketok' => $list_transaction_detail_lasketok[$key],
				'transaction_detail_dempul' => $list_transaction_detail_dempul[$key],
				'transaction_detail_cat' => $list_transaction_detail_cat[$key],
				'transaction_detail_poles' => $list_transaction_detail_poles[$key],
				'transaction_detail_rakit' => $list_transaction_detail_rakit[$key],
				
				
				/*'transaction_detail_plain_first_date' => $list_transaction_detail_plain_first_date[$key],
				'transaction_detail_plain_last_date' => $list_transaction_detail_plain_last_date[$key],
				'transaction_detail_actual_date' => $list_transaction_detail_actual_date[$key],
				'transaction_detail_target_date' => $list_transaction_detail_target_date[$key],*/
				'transaction_detail_date' => $list_transaction_detail_date[$key],
				'transaction_detail_description' => $list_transaction_detail_description[$key],
				'transaction_detail_total' => $list_transaction_detail_total[$key]
				);
				$total_price += $list_transaction_detail_total[$key];
				}
				}
				$data['transaction_total'] = $total_price;
				if(empty($id)) // jika tidak ada id maka create
				{
			//$data['registration_code'] = format_code('registrations','registration_code','PU',7);
				$error = $this->transaction_model->create($data, $items);
				send_json_action($error, "Data telah ditambah", "Data gagal ditambah", $this->transaction_model->insert_id);
				}
				else // id disebutkan, lakukan proses UPDATE
				{
					$error = $this->transaction_model->update($id, $data, $items);
					send_json_action($error, "Data telah direvisi", "Data gagal direvisi", $data['registration_id']);
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
					form_transient_pair('transient_detail_registration_id', $value['product_name'],$value['detail_registration_id'],
				array(
						'transient_product_name' => $value['product_name'])),
						form_transient_pair('transient_transaction_detail_bongkar_komponen',show_checkbox_status($value['transaction_detail_bongkar_komponen']),$value['transaction_detail_bongkar_komponen']),
						form_transient_pair('transient_transaction_detail_lasketok',show_checkbox_status($value['transaction_detail_lasketok']),$value['transaction_detail_lasketok']),
						form_transient_pair('transient_transaction_detail_dempul', show_checkbox_status($value['transaction_detail_dempul']),$value['transaction_detail_dempul']),
						form_transient_pair('transient_transaction_detail_cat', show_checkbox_status($value['transaction_detail_cat']),$value['transaction_detail_cat']),
						form_transient_pair('transient_transaction_detail_poles', show_checkbox_status($value['transaction_detail_poles']),$value['transaction_detail_poles']),
						form_transient_pair('transient_transaction_detail_rakit', show_checkbox_status($value['transaction_detail_rakit']),$value['transaction_detail_rakit']),
						/*form_transient_pair('transient_transaction_detail_plain_first_date', $value['transaction_detail_plain_first_date']),
						form_transient_pair('transient_transaction_detail_plain_last_date', $value['transaction_detail_plain_last_date']),
						form_transient_pair('transient_transaction_detail_actual_date', $value['transaction_detail_actual_date']),
						form_transient_pair('transient_transaction_detail_target_date', $value['transaction_detail_target_date']),*/
						form_transient_pair('transient_transaction_detail_date', format_new_date($value['transaction_detail_date'])),
						form_transient_pair('transient_transaction_detail_description', $value['transaction_detail_description']),
						form_transient_pair('transient_transaction_detail_total', tool_money_format($value['transaction_detail_total']),$value['transaction_detail_total'])
					);
				}
				send_json(make_datatables_list($data));
			}
			function detail_list_loader2($transaction_id=0)
			{
				if($transaction_id == 0)send_json(make_datatables_list(null));
				$data = $this->transaction_model->detail_list_loader2($transaction_id);
				$sort_id = 0;
				foreach($data as $key => $value)
				{
				$data[$key] = array(
					form_transient_pair('transient_transaction_type_id', $value['transaction_type_name'],$value['transaction_type_id']),
					form_transient_pair('transient_transaction_detail_plain_first_date', $value['transaction_detail_plain_first_date']),
					form_transient_pair('transient_transaction_detail_plain_last_date', $value['transaction_detail_plain_last_date']),
					form_transient_pair('transient_transaction_detail_actual_date', $value['transaction_detail_actual_date']),
					form_transient_pair('transient_transaction_detail_target_date', $value['transaction_detail_target_date']),
					form_transient_pair('transient_transaction_detail_description', $value['transaction_detail_description'])
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
					$data['transaction_type_id'] = '';
					$data['transaction_detail_plain_first_date'] = '';
					$data['transaction_detail_plain_last_date'] = '';
					$data['transaction_detail_actual_date'] = '';
					$data['transaction_detail_target_date'] = '';
					$data['transaction_detail_description'] = '';
				} else {
					$data['index'] = $index;
					$data['product_name'] = array_shift($this->input->post('transient_product_name'));
					$data['detail_registration_id'] = array_shift($this->input->post('transient_detail_registration_id'));
					$data['transaction_detail_bongkar_komponen'] = array_shift($this->input->post('transient_transaction_detail_bongkar_komponen'));
					$data['transaction_detail_lasketok'] = array_shift($this->input->post('transient_transaction_detail_lasketok'));
					$data['transaction_detail_dempul'] = array_shift($this->input->post('transient_transaction_detail_dempul'));
					$data['transaction_detail_cat'] = array_shift($this->input->post('transient_transaction_detail_cat'));
					$data['transaction_detail_poles'] = array_shift($this->input->post('transient_transaction_detail_poles'));
					$data['transaction_detail_rakit'] = array_shift($this->input->post('transient_transaction_detail_rakit'));
					/*$data['transaction_detail_plain_first_date'] = array_shift($this->input->post('transient_transaction_detail_plain_first_date'));
					$data['transaction_detail_plain_last_date'] = array_shift($this->input->post('transient_transaction_detail_plain_last_date'));
					$data['transaction_detail_actual_date'] = array_shift($this->input->post('transient_transaction_detail_actual_date'));
					$data['transaction_detail_target_date'] = array_shift($this->input->post('transient_transaction_detail_target_date'));*/
					$data['transaction_detail_date'] = array_shift($this->input->post('transient_transaction_detail_date'));
					$data['transaction_detail_description'] = array_shift($this->input->post('transient_transaction_detail_description'));
					$data['transaction_detail_total'] = array_shift($this->input->post('transient_transaction_detail_total'));
				}
					$this->load->helper('form');
					$this->render->add_form('app/transaction/transient_form', $data);
					$this->render->show_buffer();
			}
			function detail_form_action()
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('i_detail_registration_id', 'Harga', 'trim|required');
				$this->form_validation->set_rules('i_product_name', 'Panel', 'trim|required');
				$this->form_validation->set_rules('c_bongkar_komponen', 'Bongkar', 'trim');
				$this->form_validation->set_rules('c_lasketok', 'Las', 'trim');
				$this->form_validation->set_rules('c_dempul', 'Dempul', 'trim');
				$this->form_validation->set_rules('c_cat', 'Cat', 'trim');
				$this->form_validation->set_rules('c_poles', 'Poles', 'trim');
				$this->form_validation->set_rules('c_rakit', 'Rakit', 'trim');
				/*$this->form_validation->set_rules('i_first_date', 'Awal Plain', 'trim|required|valid_date|sql_date');
				$this->form_validation->set_rules('i_last_date', 'Akhir Plain', 'trim|required|valid_date|sql_date');
				$this->form_validation->set_rules('i_actual_date', 'Actual', 'trim|required|valid_date|sql_date');
				$this->form_validation->set_rules('i_target_date', 'Target', 'trim|required|valid_date|sql_date');*/
				$this->form_validation->set_rules('i_date', 'Target', 'trim|valid_date|sql_date');
				$this->form_validation->set_rules('i_description', 'Keterangan', 'trim');
				$this->form_validation->set_rules('i_total', 'Total', 'trim');
				$index = $this->input->post('i_index');
			// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate();
				$no = $this->input->post('i_index');
				$detail_registration_id = $this->input->post('i_detail_registration_id');
				$product_name = $this->input->post('i_product_name');
				$transaction_detail_bongkar_komponen = $this->input->post('c_bongkar_komponen');
				$transaction_detail_lasketok = $this->input->post('c_lasketok');
				$transaction_detail_dempul	= $this->input->post('c_dempul');
				$transaction_detail_cat	= $this->input->post('c_cat');
				$transaction_detail_poles	= $this->input->post('c_poles');
				$transaction_detail_rakit	= $this->input->post('c_rakit');
				/*$transaction_detail_plain_first_date = $this->input->post('i_first_date');
				$transaction_detail_plain_last_date = $this->input->post('i_last_date');
				$transaction_detail_actual_date = $this->input->post('i_actual_date');
				$transaction_detail_target_date = $this->input->post('i_target_date');*/
				$transaction_detail_date = $this->input->post('i_date');
				$transaction_detail_description = $this->input->post('i_description');
				$transaction_detail_total	= $this->input->post('i_total');
				//send_json_error($no);
				$data = array(
				form_transient_pair('transient_detail_registration_id', $product_name, $detail_registration_id),
				form_transient_pair('transient_transaction_detail_bongkar_komponen', show_checkbox_status($transaction_detail_bongkar_komponen),$transaction_detail_bongkar_komponen),
				form_transient_pair('transient_transaction_detail_lasketok', show_checkbox_status($transaction_detail_lasketok),$transaction_detail_lasketok),
				form_transient_pair('transient_transaction_detail_dempul', show_checkbox_status($transaction_detail_dempul),$transaction_detail_dempul),
				form_transient_pair('transient_transaction_detail_cat', show_checkbox_status($transaction_detail_cat),$transaction_detail_cat),
				form_transient_pair('transient_transaction_detail_poles', show_checkbox_status($transaction_detail_poles),$transaction_detail_poles),
				form_transient_pair('transient_transaction_detail_rakit', show_checkbox_status($transaction_detail_rakit),$transaction_detail_rakit),
				/*form_transient_pair('transient_transaction_detail_plain_first_date', $transaction_detail_plain_first_date),
				form_transient_pair('transient_transaction_detail_plain_last_date',$transaction_detail_plain_last_date),
				form_transient_pair('transient_transaction_detail_actual_date', $transaction_detail_actual_date),
				form_transient_pair('transient_transaction_detail_target_date', $transaction_detail_target_date),*/
				form_transient_pair('transient_transaction_detail_date', format_new_date($transaction_detail_date)),
				form_transient_pair('transient_transaction_detail_description',$transaction_detail_description),
				form_transient_pair('transient_transaction_detail_total',tool_money_format($transaction_detail_total),$transaction_detail_total)
				);
			send_json_transient($index, $data);
		}
		function form_transaction_action($is_delete = 0){
				$id = $this->input->post('row2_id');
				$error = $this->transaction_model->transaction($id);
				send_json_action($error, "Simpan Berhasil, Data telah disetujui", "Data gagal direvisi");
			}
			
			function detail_list_loader3($registration_id=0)
	{
		if($registration_id == 0)
		
		send_json(make_datatables_list(null)); 
				
		$data = $this->transaction_model->detail_list_loader3($registration_id);
		
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
			$foto='<img   width="50px;" height="50px;" src='.base_url().'storage/img/'.form_transient_pair('transient_photo', $value['photo']).'';
			$foto_after='<img   width="50px;" height="50px;" src='.base_url().'storage/img/'.form_transient_pair('transient_photo_after', $value['photo_after']).'';
		
		$data[$key] = array(
				
				form_transient_pair('transient_photo_name', $value['photo_name']),
				form_transient_pair('transient_photo',	$foto, $value['photo']),
				form_transient_pair('transient_photo_id',	$value['photo_id'], $value['photo_id']),
				
				form_transient_pair('transient_photo_after',	$foto_after, $value['photo_after'])
			
				
		);
		
		
	
		}		
		send_json(make_datatables_list($data)); 
	}
	function detail_form3($registration_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{		
		$this->load->library('render');
		$index = $this->input->post('transient_index');
		if (strlen(trim($index)) == 0) {
					
			// TRANSIENT CREATE - isi form dengan nilai default / kosong
			$data['index']			= '';
			
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
			$data['transient_photo_after']			 = array_shift($this->input->post('transient_photo_after'));
			
		}		
		$this->render->add_form('app/transaction/transient_form3', $data);
		
		$this->render->show_buffer();
	}
	
	function detail_form_action3()
	{		
		$this->load->library('form_validation');
		//$this->form_validation->set_rules('i_photo_after','Photo After', 'trim|required');
	
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
			
		$no 		= $this->input->post('i_index');
			
		$photo_name	= $this->input->post('i_photo_name');
		$photo_id	= $this->input->post('i_photo_id');
		$photo		= $this->input->post('i_photo');
		$photo_after	= $this->input->post('i_photo_after');
		send_json($photo_id);

		
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
			