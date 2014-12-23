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
		$this->render->build('Data Registrasi');
		$this->render->show('Data Registrasi');
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
				$data['transaction_detail_plain_first_date'] = date('d/m/Y');
				$data['transaction_detail_plain_last_date'] = date('d/m/Y');
				$data['transaction_detail_actual_date'] = date('d/m/Y');
				$data['transaction_detail_target_date'] = date('d/m/Y');
				$data['transaction_detail_description'] = '';
			}else{
				$result = $this->transaction_model->read_id($registration_id);
				if($result){
				$data = $result;
				$data['row_id'] = $registration_id;
				$data['transaction_id'] = '';
				$data['employee_group_id'] = '';
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
				}
		}
		
		
		$this->load->helper('form');
			
		$this->render->add_form('app/transaction/form', $data);
		$this->render->build('Registrasi');
		
		$this->render->add_view('app/transaction/transient_list', $data);
		$this->render->build('Data Panel');
		
		$this->render->add_view('app/transaction/transient_list2',$data);
		$this->render->build('Data Transaksi Detail');
		
		$this->render->show('Cetak Laporan');
	}
	
	function form2($transaction_id = 0)
	{
		$data = array();
		
		if($transaction_id == 0){
					
				$data['row_id'] = '';
				$data['i_transaction_id'] = '';
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
				$data['transaction_id'] = '';
				$data['employee_group_id'] = '';
				$data['transaction_type_id'] = '';
				$data['transaction_detail_plain_first_date'] = date('d/m/Y');
				$data['transaction_detail_plain_last_date'] = date('d/m/Y');
				$data['transaction_detail_actual_date'] = date('d/m/Y');
				$data['transaction_detail_target_date'] = date('d/m/Y');
				$data['transaction_detail_description'] = '';
			}else{
				$result = $this->transaction_model->read_id2($transaction_id);
				if($result){
				$data = $result;
				$data['row_id'] = $result['registration_id'];
				$data['i_transaction_id'] = $transaction_id;
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
				}
		}
		
		
		$this->load->helper('form');
			
		$this->render->add_form('app/transaction/form', $data);
		$this->render->build('Registrasi');
		
		$this->render->add_view('app/transaction/transient_list', $data);
		$this->render->build('Data Panel');
		
		$this->render->add_view('app/transaction/transient_list2',$data);
		$this->render->build('Data Transaksi Detail');
		
		$this->render->show('Cetak Laporan');
	}
	
	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if($is_delete)
		{
			$this->load->model('transaction_model');
			$id = $this->input->post('row_id');
			$is_process_error = $this->transaction_model->delete($id);
			send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
		}
		
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
	
		// definisikan kriteria data
		$this->form_validation->set_rules('row_id','Registrasi','trim|required');
		$this->form_validation->set_rules('i_employee_group_id','Tim Kerja','trim|required');
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 

		$id = $this->input->post('i_transaction_id');
		$data['registration_id'] 			= $this->input->post('row_id');
		$data['employee_group_id'] 			= $this->input->post('i_employee_group_id');
		$registration_id = $this->input->post('row_id');
		
		/*$items2 = $this->transaction_model->employee_group($registration_id);
		foreach($items2 as $row){
			$items2[]= array(
				'employee_id' => $row['employee_id']
				);			
			}*/		
		
		$list_transaction_type_id		= $this->input->post('transient_transaction_type_id');
		$list_transaction_detail_plain_first_date		= $this->input->post('transient_transaction_detail_plain_first_date');
		$list_transaction_detail_plain_last_date	= $this->input->post('transient_transaction_detail_plain_last_date');
		$list_transaction_detail_actual_date	 	= $this->input->post('transient_transaction_detail_actual_date');
		$list_transaction_detail_target_date	= $this->input->post('transient_transaction_detail_target_date');
		$list_transaction_detail_description	= $this->input->post('transient_transaction_detail_description');
		
		if(!$list_transaction_type_id) send_json_error('Simpan gagal. Data panel masih kosong');
	
		
		$total_price = 0;
		
		$items = array();
		if($list_transaction_type_id){
		foreach($list_transaction_type_id as $key => $value)
		{
			//$get_purchase_price = $this->registration_model->get_purchase_price($list_product_id[$key]);
			
			$items[] = array(				
				'transaction_type_id' => $list_transaction_type_id[$key],
				'transaction_detail_plain_first_date'  => $list_transaction_detail_plain_first_date[$key],
				'transaction_detail_plain_last_date'  => $list_transaction_detail_plain_last_date[$key],
				'transaction_detail_actual_date'  => $list_transaction_detail_actual_date[$key],
				'transaction_detail_target_date'  => $list_transaction_detail_target_date[$key],
				'transaction_detail_description'  => $list_transaction_detail_description[$key]
			);
		}
		}
				
		
		if(empty($id)) // jika tidak ada id maka create
		{ 
			//$data['registration_code'] 			= format_code('registrations','registration_code','PU',7);
				
			$error = $this->transaction_model->create($data, $items);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah", $this->transaction_model->insert_id);
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$error = $this->transaction_model->update($id, $data, $items);
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
				form_transient_pair('transient_product_id', $value['product_code'], $value['product_id']),
				form_transient_pair('transient_product_name', $value['product_name']),
				form_transient_pair('transient_registration_detail_price', tool_money_format($value['detail_registration_price']), $value['detail_registration_price']),
				form_transient_pair('transient_registration_detail_qty', $value['detail_registration_qty'], $value['detail_registration_qty']),
				form_transient_pair('transient_registration_detail_total_price', tool_money_format($value['detail_registration_total_price']), $value['detail_registration_total_price'])
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
				form_transient_pair('transient_transaction_type_id', $value['transaction_type_id']),
				form_transient_pair('transient_transaction_detail_plain_first_date', $value['transaction_detail_plain_first_date']),
				form_transient_pair('transient_transaction_detail_plain_last_date', $value['transaction_detail_plain_last_date']),
				form_transient_pair('transient_transaction_detail_actual_date', $value['transaction_detail_actual_date']),
				form_transient_pair('transient_transaction_detail_target_date', $value['transaction_detail_target_date']),
				form_transient_pair('transient_transaction_detail_description', $value['transaction_detail_description'])
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
			$data['transaction_type_id'] 	= '';
			$data['transaction_detail_plain_first_date'] 	= '';
			$data['transaction_detail_plain_last_date'] 	= '';
			$data['transaction_detail_actual_date'] 	= '';
			$data['transaction_detail_target_date'] 	= '';
			$data['transaction_detail_description'] 	= '';
		} else {
			
			$data['index']			= $index;
			$data['transaction_type_id'] 	= array_shift($this->input->post('transient_transaction_type_id'));
			$data['transaction_detail_plain_first_date'] 	= array_shift($this->input->post('transient_transaction_detail_plain_first_date'));
			$data['transaction_detail_plain_last_date'] 	= array_shift($this->input->post('transient_transaction_detail_plain_last_date'));
			$data['transaction_detail_actual_date'] 	= array_shift($this->input->post('transient_transaction_detail_actual_date'));
			$data['transaction_detail_target_date'] 	= array_shift($this->input->post('transient_transaction_detail_target_date'));
			$data['transaction_detail_description'] 	= array_shift($this->input->post('transient_transaction_detail_description'));
		}		
		
		$this->load->helper('form');
		
	
		$this->render->add_form('app/transaction/transient_form', $data);
		$this->render->show_buffer();
	}
	
	function detail_form_action()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_transaction_type_id', 'Produk', 'trim|required');
		$this->form_validation->set_rules('i_first_date', 'Awal Plain', 'trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_last_date', 'Akhir Plain', 'trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_actual_date', 'Actual', 'trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_target_date', 'Target', 'trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_description', 'Keterangan', 'trim|required');
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		$this->load->model('global_model');	
		
		$no 		= $this->input->post('i_index');
		$transaction_type_id 					= $this->input->post('i_transaction_type_id');
		$transaction_detail_plain_first_date 	= $this->input->post('i_first_date');
		$transaction_detail_plain_last_date 	= $this->input->post('i_last_date');
		$transaction_detail_actual_date 		= $this->input->post('i_actual_date');
		$transaction_detail_target_date 		= $this->input->post('i_target_date');
		$transaction_detail_description 		= $this->input->post('i_description');
				
		//send_json_error($no);
		
		$data = array(
				form_transient_pair('transient_transaction_type_id', $transaction_type_id),
				form_transient_pair('transient_transaction_detail_plain_first_date', $transaction_detail_plain_first_date),
				form_transient_pair('transient_transaction_detail_plain_last_date',$transaction_detail_plain_last_date),
				form_transient_pair('transient_transaction_detail_actual_date', $transaction_detail_actual_date),
				form_transient_pair('transient_transaction_detail_target_date', $transaction_detail_target_date),
				form_transient_pair('transient_transaction_detail_description', $transaction_detail_description)
		);
		 
		send_json_transient($index, $data);
	}
	
	function form_transaction_action($is_delete = 0){
		
		$id = $this->input->post('row2_id');
			
	
			$error = $this->transaction_model->transaction($id);
			send_json_action($error, "Simpan Berhasil, Data telah disetujui", "Data gagal direvisi");
		
		
	}

}
