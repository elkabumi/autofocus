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
				$data['spk_date'] = format_new_date($data['spk_date']);
			
			}
		
		
		$this->load->helper('form');
			
		$this->render->add_form('app/approved/form', $data);
		$this->render->build('Transaksi Penjualan User');
		
		
		
		$this->render->add_view('app/approved/transient_list');
		$this->render->build('Data Panel');
		
		
		$this->render->add_view('app/approved/transient_list3');
		$this->render->build('Data Parts');
		
		
		//$this->render->add_view('app/approved/transient_list2');
		//$this->render->build('Photo Before');
		
		$this->render->add_view('app/approved/transient_list_foto');
		$this->render->build('Photo Sebelum Mobil Masuk');
		
		$this->render->add_js('ajaxfileupload');
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
		
		//$this->render->add_view('app/approved/transient_list_report', $data);
		//$this->render->build('Data Panel');
		
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
											'transient_detail_registration_id' =>$value['detail_registration_id'],
											'transient_reg_aproved_price' => $value['detail_registration_approved_price']
											)
											),
											
											
											
						form_transient_pair('transient_product_name', $value['product_name']." (".$value['product_type_name']." - ".$value['pst_name'].")", $value['product_name']),
						form_transient_pair('transient_reg_price',	tool_money_format($value['detail_registration_price']),$value['detail_registration_price'])
						//form_transient_pair('transient_reg_aproved_price',	tool_money_format($value['detail_registration_approved_price']),$value['detail_registration_approved_price'])
						
				);
		
		
	
		}		
		send_json(make_datatables_list($data)); 
		}

	function detail_list_loader3($registration_id=0)
	{
		if($registration_id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->approved_model->detail_list_loader3($registration_id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		
		$data[$key] = array(
				form_transient_pair('transient_rs_part_number', $value['rs_part_number'], $value['rs_part_number'],
								array('transient_rs_id'=> $value['rs_id'],
										'transient_rs_approved_repair' =>$value['rs_approved_repair']
								)
				),
				form_transient_pair('transient_rs_name', $value['rs_name']),
				form_transient_pair('transient_rs_qty',$value['rs_qty']),
				form_transient_pair('transient_rs_repair', tool_money_format($value['rs_repair']), $value['rs_repair'])
				//form_transient_pair('transient_rs_approved_repair',	tool_money_format($value['rs_approved_repair']),$value['rs_approved_repair'])
				
		);
		
		
		
		}		
		send_json(make_datatables_list($data)); 
	}
	
	function detail_list_foto($registration_id=0)
	{
		if($registration_id == 0)
		
		send_json(make_datatables_list(null)); 
				
		$data = $this->approved_model->detail_list_loader_foto($registration_id);
		
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
											'transient_photo_type_id', $value['photo_type_id'],
											
											)
				),
				$foto
				
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

			$get_data_product  = $this->approved_model->get_data_product($this->input->post('i_product_price_id'));

			$transient_product_name 		= $get_data_product['product_name']." (".$get_data_product['product_type_name']."-".$get_data_product['pst_name'].")";
			$transient_reg_price 	 		= $this->input->post('i_detail_registration_price');
			$transient_reg_aproved_price 	= $this->input->post('i_detail_registration_approved_price');
				
			
			
			$data = array(
					form_transient_pair('transient_product_code', $transient_product_code,$transient_product_code,
									array(
											'transient_product_price_id' => $transient_product_price_id,
											'transient_detail_registration_id' =>$transient_detail_registration_id)),
											
						form_transient_pair('transient_product_name', $transient_product_name,$transient_product_name),
						form_transient_pair('transient_reg_price',	tool_money_format($transient_reg_price),$transient_reg_price),
						form_transient_pair('transient_reg_aproved_price',	tool_money_format($transient_reg_aproved_price),$transient_reg_aproved_price)
					
			);
		 
		send_json_transient($index, $data);

		
		}
	function detail_form3($registration_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
		{		
			$this->load->library('render');
			$index = $this->input->post('transient_index');
			if (strlen(trim($index)) == 0) {
						
				// TRANSIENT CREATE - isi form dengan nilai default / kosong
					$data['index']			= '';
					$data['registration_id'] 					= $registration_id;
					$data['transient_rs_part_number'] 				= '';
					$data['transient_rs_id'] 				= '';
					
					$data['transient_rs_name'] 				= '';
					$data['transient_rs_qty']			= '';	
					$data['transient_rs_repair']				 = '';
					$data['transient_rs_approved_repair']				 = '';
					
			} else {
				
					$data['index']								= $index;
					$data['registration_id'] 					= $registration_id;
					$data['transient_rs_part_number'] 			= array_shift($this->input->post('transient_rs_part_number'));
					$data['transient_rs_id'] 		= array_shift($this->input->post('transient_rs_id'));
					$data['transient_rs_name'] 	= array_shift($this->input->post('transient_rs_name'));
					$data['transient_rs_qty'] 			= array_shift($this->input->post('transient_rs_qty'));
					$data['transient_rs_repair'] 				= array_shift($this->input->post('transient_rs_repair'));
					$data['transient_rs_approved_repair']		= array_shift($this->input->post('transient_rs_approved_repair'));
			}		
			
		
			
		
			$this->render->add_form('app/approved/transient_form3', $data);
			$this->render->show_buffer();
		}
		function detail_form_action3()
		{		
			$this->load->library('form_validation');
			$this->form_validation->set_rules('i_rs_name', 'nama Parts', 'trim|required');
			$this->form_validation->set_rules('i_rs_approved_repair','Harga Approved Parts','trim|required|is_numeric');
		
			$index = $this->input->post('i_index');		
			// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		
		
			$no 							= $this->input->post('i_index');
			$transient_rs_part_number 		= $this->input->post('i_rs_no');
			$transient_rs_id 				= $this->input->post('i_rs_id');
			$transient_rs_name 				= $this->input->post('i_rs_name');
			$transient_rs_qty 	 			= $this->input->post('i_rs_qty');
			$transient_rs_repair 			= $this->input->post('i_rs_repair');
			$transient_rs_approved_repair 	= $this->input->post('i_rs_approved_repair');
				
			
			
			$data = array(
					form_transient_pair('transient_rs_part_number', $transient_rs_part_number, $transient_rs_part_number,
										array('transient_rs_id'=> $transient_rs_id)
							),
				form_transient_pair('transient_rs_name', $transient_rs_name),
				form_transient_pair('transient_rs_qty',$transient_rs_qty),
				form_transient_pair('transient_rs_repair', tool_money_format($transient_rs_repair), $transient_rs_repair),
				form_transient_pair('transient_rs_approved_repair',	tool_money_format($transient_rs_approved_repair),$transient_rs_approved_repair)
				
				
			);
		 
		send_json_transient($index, $data);

		
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
		$this->render->add_form('app/approved/transient_form_foto', $data);
		
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
		
		$photo_type_name = $this->approved_model->get_photo_type_name($photo_type_id);
		
		
		$foto='<img   width="50px;" height="50px;" src='.base_url().'tmp/'.form_transient_pair('transient_photo', $photo_file,$photo_file).'';
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

	
	
	
	
	function form_approved_action($is_delete = 0){
		
		$this->load->library('form_validation');
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if($is_delete)
		{
			$this->load->model('approved_model');
			$id = $this->input->post('row_id');
			$is_process_error = $this->approved_model->delete($id);
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
		$this->form_validation->set_rules('i_own_retention','OR','trim');
		$this->form_validation->set_rules('i_check_in','Tanggal Masuk','trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_registration_estimation_date','Tanggal Estimasi Keluar','trim|required|valid_date|sql_date');
		$this->form_validation->set_rules('i_spk_no','No SPK','trim|required');
		$this->form_validation->set_rules('i_pkb_no','No PKB','trim|required');
		$this->form_validation->set_rules('i_spk_date','Tanggal SPK','trim|required|valid_date|sql_date');
		
		$this->form_validation->set_rules('i_disc_panel','Diskon Panel','max_value[100]');
			$this->form_validation->set_rules('i_disc_parts','Diskon SpareParts','max_value[100]');
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
		$data['approved_disc_panel']	= $this->input->post('i_disc_panel');
		$data['approved_disc_sparepart']		= $this->input->post('i_disc_parts');
		
		
		$list_detail_registration_id	 	= $this->input->post('transient_detail_registration_id');
		$list_product_price_id				= $this->input->post('transient_product_price_id');
		$list_registration_detail_price	 	= $this->input->post('transient_reg_price');
		$list_registration_detail_approved_price	 	= $this->input->post('transient_reg_aproved_price');
		
		
		$list_rs_id			= $this->input->post('transient_rs_id');
		
		$list_rs_part_number	 	= $this->input->post('transient_rs_part_number');
		$list_rs_name	 	= $this->input->post('transient_rs_name');
		$list_rs_qty	 	= $this->input->post('transient_rs_qty');
		$list_rs_repair	 	= $this->input->post('transient_rs_repair');
		$list_rs_approved_repair	 	= $this->input->post('transient_rs_approved_repair');
	
		
		$total_price = 0;
		$approved_total_price = 0;

		$items = array();
		if($list_detail_registration_id){
		foreach($list_detail_registration_id as $key => $value)
		{
			//$get_purchase_price = $this->approved_model->get_purchase_price($list_product_id[$key]);
			
			$items[] = array(				
				//'product_id'  => $list_product_id[$key],
				'detail_registration_id' => $list_detail_registration_id[$key],
				'detail_registration_type_id' => '1',
				'employee_id' => $this->access->info['employee_id'],
				'product_price_id' => $list_product_price_id[$key],
				'detail_registration_price'  => $list_registration_detail_price[$key],
				'detail_registration_approved_price'  => $list_registration_detail_approved_price[$key]
			);
			
			$total_price += $list_registration_detail_price[$key];
			$approved_total_price += $list_registration_detail_approved_price[$key];
		}
		}
		
		/*
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
		*/
		
		$data['total_registration'] = $total_price;
		$data['approved_total_registration'] = $approved_total_price;
		$total_diskon_panel = ($data['approved_total_registration'] / 100) * $data['approved_disc_panel'];
		$data['approved_disc_panel_total'] = $data['approved_total_registration'] - $total_diskon_panel ;
		
		$total_rs_repair =0;
		$approved_rs_repair =0;
		
		$item2 = array();
		if($list_rs_id){
		foreach($list_rs_id as $key => $value)
		{
			//$get_purchase_price = $this->approved_model->get_purchase_price($list_product_id[$key]);
			
			$item2[] = array(				
				//'product_id'  => $list_product_id[$key],
				//'rs_id' => $list_rs_id[$key],
				'rs_part_number ' => $list_rs_part_number[$key],
				'rs_name' => $list_rs_name[$key],
				'rs_qty' => $list_rs_qty[$key],
				'rs_repair'  => $list_rs_repair[$key],
				'rs_approved_repair'  => $list_rs_approved_repair[$key]
			);
			
			$total_rs_repair += $list_rs_repair[$key];
			$approved_rs_repair += $list_rs_approved_repair[$key];
		}
		}
		
		$data['sparepart_total_registration'] = $total_rs_repair;
		$data['approved_sparepart_total_registration'] = $approved_rs_repair;
		$total_diskon_parts =($data['approved_sparepart_total_registration'] / 100) * $data['approved_disc_sparepart'];
		$data['approved_disc_sparepart_total'] = $data['approved_sparepart_total_registration'] - $total_diskon_parts ;
		
		
			$error = $this->approved_model->update($id, $data, $items,$item2);
			send_json_action($error, "Data telah desetujui", "Data gagal direvisi");

			
		
		
	}
	function report_kwitansi($id = 0){
		
		if($id){
		   $this->load->model('global_model');
		  
		   $result = $this->approved_model->report_kwitansi($id);
				
				
				if ($result) // cek dulu apakah data ditemukan 
				{
					$data = $result;
					$data['row_id'] = $id;		
					
					$data['own_retention'] = ($result['own_retention'])? $result['own_retention'] : "-";
					$data['registration_dp'] = ($result['registration_dp']) ? $result['registration_dp'] : "-";
					
				
					if($data['claim_type'] == 1){
						$title = 'Lap_Kwitansi_OR_'.$id.'';
					}else if($data['claim_type'] == 0){
						$title = 'Lap_Kwitansi_DP_'.$id.'';
					}
				
					
				}
	
			//$data='';
			$this->global_model->create_report_kwitansi($title,'report/kwitansi.php', $data,'header.php');
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
