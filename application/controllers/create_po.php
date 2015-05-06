<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Create_po extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('create_po_model');
		$this->load->library('access');
		$this->access->set_module('create_po_mocel.create_po_mocel');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/create_po/list');
		$this->render->build('Create po');
		$this->render->show('Create po');
		
	}

	
	function table_controller(){
		$data = $this->create_po_model->list_controller();
		send_json($data);
	}
	function form($id = 0){
		$data = array();
		if($id==0){
		
			
			$data['row_id'] = '';
			$data['period_id'] = '';
			$data['stand_id'] = '';
			$data['registration_date'] = '';
			$data['registration_code'] = '';
			$data['customer_id']			= '';
			$data['car_id']			= '';
			$data['claim_type'] = '';
			$data['insurance_id'] = '';
			$data['pic_asuransi'] = '';
			$data['claim_no'] = '';
			$data['insurance_pph'] = '';
			$data['own_retention'] = '';
			
			$data['po_code'] = '';
			$data['tp_create_date'] = '';
			$data['tp_desc'] = '';	
		
		}else{
			$result = $this->create_po_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['tp_create_date'] = format_new_date($data['tp_create_date']);
				
				$data['po_code'] = ($data['tp_code']);
			}
		}
		
		$this->load->helper('form');
			
		$this->render->add_form('app/create_po/form', $data);
		$this->render->build('Create_po');
		
		if($id==0){
			$this->render->add_view('app/create_po/transient_list');
			$this->render->build('Data Parts');
		}else{
			$this->render->add_view('app/create_po/transient_list_view');
			$this->render->build('Data Parts');
		}

	
		$this->render->add_form('app/create_po/form_save', $data);
		$this->render->build('Create_po');
		$this->render->show('Create po');
	}
	
	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if($is_delete)
		{
			$this->load->model('po_reservation_model');
			$id = $this->input->post('row_id');
			$is_process_error = $this->create_po_model->delete($id);
			send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
		}
		
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
	
		// definisikan kriteria data
		
		$this->form_validation->set_rules('i_create_date','Tanggal Create Po','trim|required|valid_date|sql_date');
	
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		
		
		$id = $this->input->post('row_id');
		$data['registration_id'] 				= $this->input->post('i_registration_id');
		$data['tp_code'] 				= $this->input->post('i_code');	
		$data['tp_create_date']					= $this->input->post('i_create_date');
		$data['tp_desc']				= $this->input->post('i_po_description');
		$data['tp_qty_received']				= 0;
		$data['tp_qty_instal']			= 0;
		
		
		
		$list_rs_id				= $this->input->post('transient_rs_id');
		$list_rs_qty			= $this->input->post('transient_rs_qty');
		$list_rs_qty_ordered	= $this->input->post('transient_rs_qty_order');
		$list_rs_status			= $this->input->post('transient_rs_status');
	
				
		
		$total_qty  = 0;
		$jumlah_order = 0;
		$items = array();
		if($list_rs_id){
		foreach($list_rs_id as $key => $value)
		{
			if($list_rs_status[$key] != 0){
			$items[] = array(				
				'rs_id'  => $list_rs_id[$key],
				'tpd_detail_qty'  => $list_rs_qty[$key],
				'tpd_detail_received'  => 0,
				'tpd_detail_install' => 0,
				'tpd_type_id' => $list_rs_status[$key]
			);
			$total_qty += $list_rs_qty[$key];
			$jumlah_order++;
			
			}
		if($jumlah_order == '0') send_json_error('Simpan gagal. Data Order masih kosong');
	//	
		}
		}
		$data['tp_qty'] = $total_qty;
		
		if(empty($id)) // jika tidak ada id maka create
		{ 
		
			$error = $this->create_po_model->create($data, $items);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$error = $this->po_reservation_model->update($id, $data, $items);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi", $id);
		}		
	}


	
	function detail_table_loader($registration_id = 0, $id = 0) {
        if ($registration_id == 0)
            send_json(make_datatables_list(null));
		
		if(!$id){
		
			$data = $this->create_po_model->detail_list_loader($registration_id);
			$sort_id = 0;
			foreach($data as $key => $value) 
			{	
		
				$status="Belum di order";
			$data[$key] = array(
					form_transient_pair('transient_rs_part_number', $value['rs_part_number'], $value['rs_part_number'],
										array('transient_rs_id'=> $value['rs_id'])
					),
					form_transient_pair('transient_rs_name', $value['rs_name']),
					form_transient_pair('transient_rs_qty',$value['rs_qty']),
					form_transient_pair('transient_rs_qty_order', 0),
					form_transient_pair('transient_rs_status',$status),
					
			
								
			);
			}
		
		}else{
			$data = $this->create_po_model->detail_list_loader2($id);
			$sort_id = 0;
			foreach($data as $key => $value) 
			{	
		
			
			if($value['tpd_type_id'] == '1'){
				$status="Order Gudang";
			}else{
				$status="Order Titpan";
			}
			$data[$key] = array(
					form_transient_pair('transient_rs_part_number', $value['rs_part_number'], $value['rs_part_number'],
										array('transient_rs_id'=> $value['rs_id'])
					),
					form_transient_pair('transient_rs_name', $value['rs_name']),
					form_transient_pair('transient_rs_qty',$value['rs_qty']),
					form_transient_pair('transient_rs_qty_order', $value['tpd_detail_qty']),
					form_transient_pair('transient_rs_status',$status),
			
				);
			
			}

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
					$data['registration_id'] 					= $registration_id;
					$data['transient_rs_part_number'] 				= '';
					$data['transient_rs_id'] 				= '';
					
					$data['transient_rs_name'] 				= '';
					$data['transient_rs_qty']			= '';	
					$data['transient_rs_qty_order']			= '';
					
					$data['transient_rs_status']			= '';	
					
			} else {
				
					$data['index']								= $index;
					$data['registration_id'] 					= $registration_id;
					$data['transient_rs_part_number'] 			= array_shift($this->input->post('transient_rs_part_number'));
					$data['transient_rs_id'] 					= array_shift($this->input->post('transient_rs_id'));
					$data['transient_rs_name'] 					= array_shift($this->input->post('transient_rs_name'));
					$data['transient_rs_qty'] 					= array_shift($this->input->post('transient_rs_qty'));
					$data['transient_rs_qty_order']				= array_shift($this->input->post('transient_rs_qty'));	
					$data['transient_rs_status']		  		= array_shift($this->input->post('transient_rs_status'));
			
			}
			
			$data['rs_status'] 		= array(0=>'belum order',1=>'Order gudang',2=>'Order titipan');
			$this->load->helper('form');
			$this->render->add_form('app/create_po/transient_form', $data);
			$this->render->show_buffer();
		}
		function detail_form_action()
		{		
			$this->load->library('form_validation');
			$this->form_validation->set_rules('i_rs_qty', 'Quantity', 'trim|required|numeric');
		
			$this->form_validation->set_rules('i_rs_qty_order', 'Order', 'trim|required|numeric|min_value[1]');
		
			$index = $this->input->post('i_index');		
			// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		
		
			$no 							= $this->input->post('i_index');
			$transient_rs_part_number 		= $this->input->post('i_rs_no');
			$transient_rs_id 				= $this->input->post('i_rs_id');
			$transient_rs_name 				= $this->input->post('i_rs_name');
			$transient_rs_qty 	 			= $this->input->post('i_rs_qty');
			
			$transient_rs_status	 		= $this->input->post('i_rs_status_id');
			if($transient_rs_status == '0'){
				
				$transient_rs_qty_order	 		= 0;
			}else{
			
				$transient_rs_qty_order	 		= $this->input->post('i_rs_qty_order');
			}
			
			
			switch($transient_rs_status){
				case(0):
					$status_name =  'Belum Order';
				break;
				case(1):
					$status_name =  'Order Gudang';
				break;
				case(2):
					$status_name =  'Order Titipan';
				break;
			}
			if($transient_rs_qty < $transient_rs_qty_order){
				send_json_error("Order tidak poleh melebihi quantity");
			}
			
			$data = array(
					form_transient_pair('transient_rs_part_number', $transient_rs_part_number, $transient_rs_part_number,
										array('transient_rs_id'=> $transient_rs_id)
							),
				form_transient_pair('transient_rs_name', $transient_rs_name),
				form_transient_pair('transient_rs_qty',$transient_rs_qty),
				form_transient_pair('transient_rs_qty_order',$transient_rs_qty_order),
				
				form_transient_pair('transient_rs_status',$status_name,$transient_rs_status)
				
				
				
			);
		 
		send_json_transient($index, $data);

		
		}
	
	function load_registration()
	{
		$id 	= $this->input->post('id');
		
		$query = $this->create_po_model->load_registration($id);
		$data = array();
		
		foreach($query->result_array() as $row)
		{
		
			$data['period_name'] 		= $row['period_name'];
			$data['stand_name'] 		= $row['stand_name'];
			$data['customer_name']			= $row['customer_name'];
			$data['car_nopol']			= $row['car_nopol'];
			$data['po_code'] =  format_code('transaction_po','tp_code','PO',7);
		
			
		}
		send_json_message('Registration', $data);
	}
	
}
