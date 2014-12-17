<?php 

class Registration extends CI_Controller 
{	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('registration_model');
		$this->load->library('render');
		
		// set kode module ini .. misal usr
		$this->access->set_module('transaction.registration');
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
		$data['transaction_date'] = date('d/m/Y');
		$data['transaction_code'] =  format_code('registrations','transaction_code','T',7);
		$data['customer_id'] = '';
		$data['car_id'] = '';
		$data['claim_type'] = '1';
		$data['insurance_id'] = '';
		$data['check_in'] = date('d/m/Y');
		$data['transaction_estimation_date'] = '';
		$data['transaction_description'] = '';
		$data['transaction_total_price'] = '';
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
		
		//$this->render->add_view('app/registration/form_end', $data);
		//$this->render->build('Pembayaran');
		
		
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
		$this->form_validation->set_rules('i_transaction_estimation_date','Tanggal Estimasi Keluar','trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_spk_no','No SPK','trim|required|integer');
		$this->form_validation->set_rules('i_pkb_no','No PKB','trim|required|integer');
		$this->form_validation->set_rules('i_spk_date','Tanggal SPK','trim|required|valid_date|sql_date');
		//$this->form_validation->set_rules('i_transaction_description','Keterangan','trim|required');
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 

		$id = $this->input->post('row_id');
		$data['transaction_code'] 			= $this->input->post('i_code');
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
		$data['transaction_estimation_date'] 					= $this->input->post('i_transaction_estimation_date');
		$data['check_out'] 					= "";
		$data['transaction_date'] 			= date("Y-m-d");
		$data['status_transaction_id'] 		= 1;
		$data['transaction_description']	= $this->input->post('i_transaction_description');
		$data['own_retention']				= $this->input->post('i_own_retention');
		$data['pic_asuransi']				= $this->input->post('i_pic_asuransi');
		$data['spk_date']					= $this->input->post('i_spk_date');
		$data['spk_no']						= $this->input->post('i_spk_no');
		$data['pkb_no']						= $this->input->post('i_pkb_no');
		
		$list_product_id		= $this->input->post('transient_product_id');
		$list_product_price_id		= $this->input->post('transient_product_price_id');
		$list_transaction_detail_qty	= $this->input->post('transient_transaction_detail_qty');
		$list_transaction_detail_price	 	= $this->input->post('transient_transaction_detail_price');
		$list_transaction_detail_total_price	= $this->input->post('transient_transaction_detail_total_price');
		
		if(!$list_product_id) send_json_error('Simpan gagal. Data panel masih kosong');
	
		
		$total_price = 0;
		
		$items = array();
		if($list_product_id){
		foreach($list_product_id as $key => $value)
		{
			//$get_purchase_price = $this->registration_model->get_purchase_price($list_product_id[$key]);
			
			$items[] = array(				
				//'product_id'  => $list_product_id[$key],
				'detail_transaction_type_id' => '1',
				'employee_id' => $this->access->info['employee_id'],
				'product_price_id' => $list_product_price_id[$key],
				'detail_transaction_qty'  => $list_transaction_detail_qty[$key],
				'detail_transaction_price'  => $list_transaction_detail_price[$key],
				'detail_transaction_total_price'  => $list_transaction_detail_total_price[$key]
			);
			$total_price += $list_transaction_detail_total_price[$key];
		}
		}
		
		$data['total_transaction'] = $total_price;
		
		
		if(empty($id)) // jika tidak ada id maka create
		{ 
			//$data['transaction_code'] 			= format_code('transactions','transaction_code','PU',7);
				
			$error = $this->registration_model->create($data, $items);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah", $this->registration_model->insert_id);
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$error = $this->registration_model->update($id, $data, $items);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}		
	}
	function detail_list_loader($transaction_id=0)
	{
		if($transaction_id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->registration_model->detail_list_loader($transaction_id);
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
				form_transient_pair('transient_transaction_detail_price', tool_money_format($value['transaction_detail_price']), $value['transaction_detail_price']),
				form_transient_pair('transient_transaction_detail_qty', $value['transaction_detail_qty'], $value['transaction_detail_qty']),
				form_transient_pair('transient_transaction_detail_total_price', tool_money_format($value['transaction_detail_total_price']), $value['transaction_detail_total_price'])
		);
		
		
		
		}		
		send_json(make_datatables_list($data)); 
	}
	function detail_form($transaction_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{		
		$this->load->library('render');
		$index = $this->input->post('transient_index');
		if (strlen(trim($index)) == 0) {
					
			// TRANSIENT CREATE - isi form dengan nilai default / kosong
			$data['index']			= '';
			$data['transaction_id'] 				= $transaction_id;
			$data['product_id']	= '';	
			$data['product_price_id'] = '';
			$data['product_name'] = '';			
			$data['transaction_detail_qty'] 	= '';
			$data['transaction_detail_price'] 	= '';
			$data['transaction_detail_purchase_price'] = '';
			$data['transaction_detail_total_price'] = '';
			$data['transaction_detail_description'] = '';
		} else {
			
			$data['index']			= $index;
			$data['transaction_id'] 				= $transaction_id;
			$data['product_id']	= array_shift($this->input->post('transient_product_id'));
			$data['product_code']	= array_shift($this->input->post('transient_product_code'));
			$data['product_price_id']	= array_shift($this->input->post('transient_product_price_id'));
			$data['product_name'] = array_shift($this->input->post('transient_product_name'));
			$data['transaction_detail_qty'] 	= array_shift($this->input->post('transient_transaction_detail_qty'));
			$data['transaction_detail_price'] = array_shift($this->input->post('transient_transaction_detail_price'));
			$data['transaction_detail_qty'] = array_shift($this->input->post('transient_transaction_detail_qty'));
			$data['transaction_detail_total_price'] = array_shift($this->input->post('transient_transaction_detail_total_price'));
			
		}		
		$this->render->add_form('app/registration/transient_form', $data);
		$this->render->show_buffer();
	}
	function detail_form_action()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_product_id', 'Produk', 'trim|required');
		$this->form_validation->set_rules('i_transaction_detail_price', 'Harga', 'trim|required|numeric');
		$this->form_validation->set_rules('i_transaction_detail_qty', 'Jumlah', 'trim|required|numeric');
		$this->form_validation->set_rules('i_transaction_detail_total_price', 'Total', 'trim|required|numeric');
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		$this->load->model('global_model');	
		
		$no 		= $this->input->post('i_index');
		$product_id 	= $this->input->post('i_product_id');
		$product_price_id 		= $this->input->post('i_product_price_id');
		$product_code 	= $this->input->post('i_product_code');
		$transaction_detail_price 	= $this->input->post('i_transaction_detail_price');
		$transaction_detail_qty 	= $this->input->post('i_transaction_detail_qty');
		$transaction_detail_total_price 	= $this->input->post('i_transaction_detail_total_price');
				
		$get_data_product = $this->registration_model->get_data_product($product_price_id);
		$product_lengkap = $get_data_product[1]." (".$get_data_product[2]." - ".$get_data_product[3].")";
		//send_json_error($no);
		
		$data = array(
				form_transient_pair('transient_product_id', $product_code, $product_id),
				form_transient_pair('transient_product_name', $product_lengkap),
				form_transient_pair('transient_transaction_detail_price', tool_money_format($transaction_detail_price), $transaction_detail_price),
				form_transient_pair('transient_transaction_detail_qty', $transaction_detail_qty, $transaction_detail_qty),
				form_transient_pair('transient_transaction_detail_total_price', tool_money_format($transaction_detail_total_price), $transaction_detail_total_price,
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
	
}
