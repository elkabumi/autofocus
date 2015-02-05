<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Approved extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('approved_model');
		$this->load->library('access');
		$this->access->set_module('master.approved');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/approved/list');
		$this->render->build('Data Registrasi');
		$this->render->show('Data Registrasi');
	}
	
	function table_controller(){
		$data = $this->approved_model->list_controller();
		send_json($data);
	}
	
	
	function form_approved($id = 0)
	{
		$data = array();
		
			$result = $this->approved_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
		
			
			}
		
		
		$this->load->helper('form');
			
		$this->render->add_form('app/approved/form', $data);
		$this->render->build('Transaksi Penjualan User');
		
		$this->render->add_view('app/approved/transient_list');
		$this->render->build('Data Panel');
		
		$this->render->add_view('app/approved/transient_list2');
		$this->render->build('Photo Before');
		
		
		$this->render->show('approved');
	}
	
	function form_report($id = 0)
	{
		$data = array();
		
			$result = $this->approved_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['row2_id'] = $id;
				$data['check_in'] = format_new_date($data['check_in']);
				$data['registration_estimation_date'] = format_new_date($data['registration_estimation_date']);
		
			
			}
		
		
		$this->load->helper('form');
			
		$this->render->add_form('app/approved/form_report', $data);
		$this->render->build('Registrasi');
		
		$this->render->add_view('app/approved/transient_list_report', $data);
		$this->render->build('Data Panel');
		
		$this->render->show('Cetak Laporan');
	}
	
	function detail_list_loader($row_id=0)
			{
				if($row_id == 0)
				
				send_json(make_datatables_list(null)); 
						
				$data = $this->approved_model->detail_list_loader($row_id);
				$sort_id = 0;
				foreach($data as $key => $value) 
				{
				$data[$key] = array(
						form_transient_pair('transient_product_code', $value['product_code'],$value['product_code'],
									array(
											'transient_product_price_id' => $value['product_price_id'],
											'transient_detail_registration_id' =>$value['detail_registration_id'])),
											
						form_transient_pair('transient_product_name', $value['product_name'],$value['product_name']),
						form_transient_pair('transient_reg_price',	$value['detail_registration_price'],$value['detail_registration_price']),
						form_transient_pair('transient_reg_aproved_price',	$value['detail_registration_approved_price'],$value['detail_registration_approved_price'])
						
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
					$data['transient_product_code'] 				= '';
					$data['transient_product_price_id'] 				= '';
					$data['transient_detail_registration_id'] 				= $registration_id;
					$data['transient_product_name'] 				= '';
					$data['transient_reg_price']			= '';	
					$data['transient_reg_aproved_price']				 = '';
			
					
			} else {
				
					$data['index']								= $index;
					$data['registration_id'] 					= $registration_id;
					$data['transient_product_code'] 			= array_shift($this->input->post('transient_product_code'));
					$data['transient_product_price_id'] 		= array_shift($this->input->post('transient_product_price_id'));
					$data['transient_detail_registration_id'] 	= array_shift($this->input->post('transient_detail_registration_id'));
					$data['transient_product_name'] 			= array_shift($this->input->post('transient_product_name'));
					$data['transient_reg_price'] 				= array_shift($this->input->post('transient_reg_price'));
					$data['transient_reg_aproved_price']		= array_shift($this->input->post('transient_reg_aproved_price'));
			}		
			
		
			
		
			$this->render->add_form('app/approved/transient_form', $data);
			$this->render->show_buffer();
		}

			
		function detail_form_action()
		{		
			$this->load->library('form_validation');
			$this->form_validation->set_rules('i_product_code', 'Produk', 'trim|required');
			$index = $this->input->post('i_index');		
			// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		
		
			$no 							= $this->input->post('i_index');
			$transient_product_code 		= $this->input->post('i_product_code');
			$transient_product_price_id 	= $this->input->post('i_product_price_id');
			$transient_detail_registration_id 	= $this->input->post('i_detail_registration_id');
			$transient_product_name 		= $this->input->post('i_product_name');
			$transient_reg_price 	 		= $this->input->post('i_detail_registration_price');
			$transient_reg_aproved_price 	= $this->input->post('i_detail_registration_approved_price');
				
			
			
			$data = array(
					form_transient_pair('transient_product_code', $transient_product_code,$transient_product_code,
									array(
											'transient_product_price_id' => $transient_product_price_id,
											'transient_detail_registration_id' =>$transient_detail_registration_id)),
											
						form_transient_pair('transient_product_name', $transient_product_name,$transient_product_name),
						form_transient_pair('transient_reg_price',	$transient_reg_price,$transient_reg_price),
						form_transient_pair('transient_reg_aproved_price',	$transient_reg_aproved_price,$transient_reg_aproved_price)
					
			);
		 
		send_json_transient($index, $data);

		
		}
	
	
	
	function detail_list_loader2($registration_id=0)
	{
		if($registration_id == 0)
		
		send_json(make_datatables_list(null)); 
				
		$data = $this->approved_model->detail_list_loader2($registration_id);
		
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		$foto='<img   width="50px;" height="50px;" src='.base_url().'storage/img_m_in/'.form_transient_pair('transient_photo', $value['photo_file']).'';
		$data[$key] = array(
				form_transient_pair('transient_photo_name', $value['photo_name']),
				$foto
				
		);
		
		
	
		}		
		send_json(make_datatables_list($data)); 
	}
	
	function form_approved_action($is_delete = 0){
		
		$id = $this->input->post('row2_id');
			
	
			$error = $this->approved_model->approved($id);
			send_json_action($error, "Simpan Berhasil, Data telah disetujui", "Data gagal direvisi");
		
		
	}

}
