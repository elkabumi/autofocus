<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Po_received_report extends CI_Controller{
		function __construct(){
			parent::__construct();
			$this->load->library('render');
			$this->load->model('po_received_report_model');
			$this->load->library('access');
			$this->access->set_module('transaction.payment');
			$this->access->user_page();
		}
		function index(){
			$this->render->add_view('app/po_received_report/list');
			$this->render->build('Detail Per Mobil');
			$this->render->show('Detail Per Mobil');
		}
		function table_controller(){
			$data = $this->po_received_report_model->list_controller();
			send_json($data);
		}
		function form($registration_id = 0)
		{
			$data = array();
		
			$result = $this->po_received_report_model->read_id($registration_id);
			if($result){
				$data = $result;
				$data['row_id'] = $registration_id;
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
				$data['spk_date'] = format_new_date($data['spk_date']);
				$data['sisa'] = $result['sisa'];
				$data['dibayar'] = $result['dibayar'];
			}
			$data['payment_date'] = date('d/m/Y');
				
			$this->load->helper('form');
			$this->render->add_form('app/po_received_report/form', $data);
			$this->render->build('Registrasi');
			
			$this->render->add_view('app/po_received_report/transient_list_sparepart', $data);
			$this->render->build('Data Sparepart');
			
			$this->render->add_view('app/po_received_report/transient_list_panel', $data);
			$this->render->build('Data Panel Asuransi');

			$this->render->add_view('app/po_received_report/transient_list', $data);
			$this->render->build('Data Jasa');

			$this->render->add_view('app/po_received_report/transient_list_cat', $data);
			$this->render->build('Data Cat');
			
			$this->render->show('Detail Per Mobil');
		}
		
		
		
			
		function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
		{
			$this->load->library('form_validation');
			// bila operasinya DELETE -----------------------------------------------------------------------------------------
			if($is_delete)
			{
				$this->load->model('po_received_report_model');
				$id = $this->input->post('i_transaction_id');
				$is_process_error = $this->po_received_report_model->delete($id);
				send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
			}
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
		// definisikan kriteria data
				
				$this->form_validation->set_rules('i_bayar','Tim Kerja','trim|required');
				$this->form_validation->set_rules('i_sisa','Registrasi','trim|required');
				$this->form_validation->set_rules('i_status','status','trim');
				$this->form_validation->set_rules('i_payment_date','Tim Kerja','trim|required|valid_date|sql_date');
			
		// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate();

				$transaction_id = $this->input->post('i_transaction_id');

				$data['registration_id'] = $this->input->post('row_id');
				$data['payment_date'] = $this->input->post('i_payment_date');
				$data['payment_jumlah'] = $this->input->post('i_bayar');
				$data['payment_sisa'] = $this->input->post('i_sisa');
				
				$status = $this->input->post('i_status');

				$error = $this->po_received_report_model->create($data,$status);
				send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
			}
			
			function detail_list_loader($registration_id=0)
			{
				if($registration_id == 0)send_json(make_datatables_list(null));

				$data = $this->po_received_report_model->detail_list_loader($registration_id);
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
					$this->render->add_form('app/po_received_report/transient_form', $data);
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
				
		$data = $this->po_received_report_model->detail_list_loader_sparepart($registration_id);
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
						
				$data = $this->po_received_report_model->detail_list_loader_panel($row_id);
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
				
		$data = $this->po_received_report_model->detail_list_loader_cat($registration_id);
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
		$this->render->add_form('app/po_received_report/transient_form_cat', $data);
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
	

	function load_workshop_service()
	{
		$id 	= $this->input->post('workshop_service_id');
		
		$query = $this->po_received_report_model->load_workshop_service($id);
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
		
	function report($id = 0){
	
	if($id){
	   $this->load->model('global_model');
	   
	   $result = $this->po_received_report_model->read_id($id);
			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data = $result;
				$data['row_id'] = $id;		
				$data['car_nopol'] = $result['car_nopol'];
				$data['insurance_pph'] = $result['insurance_pph'];	
				$data['customer_name'] = ($result['customer_name']) ? $result['customer_name'] : "-";
				$data['check_in'] = format_new_date($data['check_in']);
				$data['check_out'] = format_new_date($data['check_out']);
				$data['registration_date'] = format_new_date($data['registration_date']);
				$data['incident_date'] = format_new_date($data['incident_date']);
				$data['claim_type_name'] = ($data['claim_type'] == 1) ? "Asuransi" : "Pribadi";
			}
		//$data='';
			
		$data_detail = $this->po_received_report_model->get_data_detail($id);
		$data_sperpart = $this->po_received_report_model->get_data_sperpart($id);
		$data_jasa = $this->po_received_report_model->get_data_jasa($id);
		$data_cat = $this->po_received_report_model->get_data_cat($id);
	   
	   $this->global_model->create_report_detail_mobil('LAPORAN DETAIL PER MOBIL', 'report/po_received_report.php', $data, $data_detail,$data_sperpart,$data_jasa,$data_cat,'header.php');
		}
	}

	function report_kwitansi($id = 0){
	
	if($id){
	   $this->load->model('global_model');
	   
	   $result = $this->po_received_report_model->read_id($id);
			
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data = $result;
				$data['row_id'] = $id;		
				$data['car_nopol'] = $result['car_nopol'];
				$data['insurance_pph'] = $result['insurance_pph'];	
				$data['customer_name'] = ($result['customer_name']) ? $result['customer_name'] : "-";
				$data['check_in'] = format_new_date($data['check_in']);
				$data['check_out'] = format_new_date($data['check_out']);
				$data['registration_date'] = format_new_date($data['registration_date']);
				$data['incident_date'] = format_new_date($data['incident_date']);
				$data['claim_type_name'] = ($data['claim_type'] == 1) ? "Asuransi" : "Pribadi";
			}
		//$data='';
			
		$data_detail = $this->po_received_report_model->get_data_detail($id);
		$data_sperpart = $this->po_received_report_model->get_data_sperpart($id);
		$data_jasa = $this->po_received_report_model->get_data_jasa($id);
		$data_cat = $this->po_received_report_model->get_data_cat($id);
	   
	   $this->po_received_report_model->create_report_kwitansi('KWITANSI PERBAIKAN', 'report/report_kwitansi.php', $data, $data_detail,$data_sperpart,$data_jasa,$data_cat,'header.php');
		}
	}


}
			
