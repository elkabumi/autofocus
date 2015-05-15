<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class po_received extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('po_received_model');
		$this->load->library('access');
		$this->access->set_module('inventory.po_received');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/po_received/list');
		$this->render->build('Po Received');
		$this->render->show('Po Received');
		
	}

	
	function table_controller(){
		$data = $this->po_received_model->list_controller();
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
			$result = $this->po_received_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['tp_create_date'] = format_new_date($data['tp_create_date']);
				$data['po_code'] = ($data['tp_code']);
			}
		}
		
	
		$this->load->helper('form');
			
		$this->render->add_form('app/po_received/form', $data);
		$this->render->build('Po Received');
		
		
			$this->render->add_view('app/po_received/transient_list');
			$this->render->build('Data Parts');
		

	
		$this->render->add_form('app/po_received/form_save', $data);
		$this->render->build('Po Received');
		$this->render->show('Po Received');
	}
	
	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if($is_delete)
		{
			$this->load->model('po_reservation_model');
			$id = $this->input->post('row_id');
			$is_process_error = $this->po_received_model->delete($id);
			send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
		}
		$id = $this->input->post('row_id');
		
		$list_rs_part_number 			= ($this->input->post('transient_rs_part_number'));
		$list_tpd_id					= ($this->input->post('transient_tpd_id'));
		$list_rs_name					= ($this->input->post('transient_rs_name'));
		$list_rs_qty_received	 		= ($this->input->post('transient_rs_qty_received'));
		$list_rs_qty_sisa_order 		= ($this->input->post('transient_rs_qty_sisa_order'));
		$list_rs_qty_received_form		= ($this->input->post('transient_rs_qty_received_form'));	
		$list_rs_status			  		= ($this->input->post('transient_rs_status'));
		$list_rs_qty_install		  	= ($this->input->post('transient_rs_qty_install'));
		$list_rs_qty_order		  		= ($this->input->post('transient_rs_qty_order'));
		$list_received_date		  		= ($this->input->post('transient_received_date'));
		$list_received_desc		  		= ($this->input->post('transient_received_desc'));
							
		$items = array();
		if($list_tpd_id){
		foreach($list_tpd_id as $key => $value)
		{
			$items[] = array(				
				'tpd_id'  => $list_tpd_id[$key],
				'tpd_detail_received'  => $list_rs_qty_received[$key],
				'tpd_id'  => $list_tpd_id[$key],
				'tpdh_type'  => 2,
				'tpdh_date'  => $list_received_date[$key],
				'tpdh_qty'  => $list_rs_qty_received_form[$key],
				'tpdh_desc'  => $list_received_desc[$key]
		
			);
		}
		}
		if(empty($id)) // jika tidak ada id maka create
		{ 
		
			$error = $this->po_received_model->create($data, $items);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah", $this->create_po_model->insert_id);
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$error = $this->po_received_model->update($id, $items);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi");
		}		
	}


	function detail_table_loader($registration_id = 0, $id = 0) {
        if ($registration_id == 0)
            send_json(make_datatables_list(null));

			$data = $this->po_received_model->detail_list_loader2($id);
			$sort_id = 0;
			foreach($data as $key => $value) 
			{	
		
			
			if($value['tpd_type_id'] == '1'){
				$status="Order Gudang";
			}else{
				$status="Order Titpan";
			}
			$value['tpd_detail_sisa_order'] = $value['tpd_detail_qty']- $value['tpd_detail_received'];
					
			$data[$key] = array(
					form_transient_pair('transient_rs_part_number', $value['rs_part_number'], $value['rs_part_number'],
										array('transient_tpd_id'=> $value['tpd_id'])
					),
					form_transient_pair('transient_rs_name', $value['rs_name']),
					form_transient_pair('transient_rs_qty_order', $value['tpd_detail_qty']),
				
					form_transient_pair('transient_rs_qty_received',$value['tpd_detail_received']),
					form_transient_pair('transient_rs_qty_sisa_order',$value['tpd_detail_sisa_order'],$value['tpd_detail_sisa_order'],
						
										array('transient_rs_qty_received_form' => 0)
					),
					form_transient_pair('transient_rs_qty_install',$value['tpd_detail_install'],$value['tpd_detail_install'],
							array('transient_received_date' => '',
									'transient_received_desc' => ''
							)),
					
					
					form_transient_pair('transient_rs_status',$status),
			
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
					$data['registration_id'] 					= $registration_id;
					$data['transient_rs_part_number'] 				= '';
					$data['transient_tpd_id'] 				= '';
					
					$data['transient_rs_name'] 				= '';
					$data['transient_rs_qty']			= '';	
					$data['transient_rs_qty_order']			= '';
					$data['transient_rs_status']			= '';	
					
			} else {
				
					$data['index']								= $index;
					$data['registration_id'] 					= $registration_id;
					$data['transient_rs_part_number'] 			= array_shift($this->input->post('transient_rs_part_number'));
					$data['transient_tpd_id'] 					= array_shift($this->input->post('transient_tpd_id'));
					$data['transient_rs_name'] 					= array_shift($this->input->post('transient_rs_name'));
					$data['transient_rs_qty_received']	 		= array_shift($this->input->post('transient_rs_qty_received'));
					$data['transient_rs_qty_sisa_order'] 		= array_shift($this->input->post('transient_rs_qty_sisa_order'));
					$data['transient_rs_qty_received_form']		= array_shift($this->input->post('transient_rs_qty_received_form'));	
					$data['transient_rs_status']		  		= array_shift($this->input->post('transient_rs_status'));
					$data['transient_rs_qty_install']		  	= array_shift($this->input->post('transient_rs_qty_install'));
					$data['transient_rs_qty_order']		  		= array_shift($this->input->post('transient_rs_qty_order'));
					$data['transient_received_date']		  	= array_shift($this->input->post('transient_received_date'));
					$data['transient_received_desc']		  	= array_shift($this->input->post('transient_received_desc'));
				
				
			
			}
			
			$this->load->helper('form');
			$this->render->add_form('app/po_received/transient_form', $data);
			$this->render->show_buffer();
		}
		function detail_form_action()
		{		
			$this->load->library('form_validation');
			$this->form_validation->set_rules('i_qty_received_form', 'Qty Received', 'trim|required|numeric|min_value[1]');
			$this->form_validation->set_rules('i_date','Tanggal received','trim|required|valid_date|sql_date');
		
			$index = $this->input->post('i_index');		
			// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate(); 
				$no 							= $this->input->post('i_index');
				$transient_rs_part_number 		= $this->input->post('i_rs_no');
				$transient_tpd_id 				= $this->input->post('i_tpd_id');
				$transient_rs_name 				= $this->input->post('i_rs_name');
				$transient_rs_qty_received 	 	= $this->input->post('i_rs_received');
				
				$transient_rs_qty_order 	 	= $this->input->post('i_rs_order');
				$transient_rs_qty_sisa_order 	= $this->input->post('i_qty_sisa_order');
				$transient_rs_qty_received_form	= $this->input->post('i_qty_received_form');
				$transient_rs_qty_install 	 	= $this->input->post('i_rs_install');
				$transient_rs_status 	 		= $this->input->post('i_rs_status_id');
				$transient_received_date 	 	= $this->input->post('i_date');
				$transient_received_desc 	 	= $this->input->post('i_description');
				
				
				
				$total_received = $transient_rs_qty_received_form + $transient_rs_qty_received;	
				$total_sisa_order = $transient_rs_qty_order - $total_received;
				
				
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
			if($transient_rs_qty_sisa_order < $transient_rs_qty_received_form){
				send_json_error("Received tidak poleh melebihi qty Sisa Order");
			}
			
			$data = array(
					form_transient_pair('transient_rs_part_number', $transient_rs_part_number, $transient_rs_part_number,
										array('transient_tpd_id'=> $transient_tpd_id)
					),
					form_transient_pair('transient_rs_name', $transient_rs_name),
					form_transient_pair('transient_rs_qty_order', $transient_rs_qty_order ),
				
					form_transient_pair('transient_rs_qty_received',$total_received),
					form_transient_pair('transient_rs_qty_sisa_order',$total_sisa_order,$total_sisa_order,
							array('transient_rs_qty_received_form' => $transient_rs_qty_received_form)
							
					),
					form_transient_pair('transient_rs_qty_install',$transient_rs_qty_install,$transient_rs_qty_install,
					
							array('transient_received_date' => $transient_received_date,
								'transient_received_desc' => $transient_received_desc
							)
						),
					
					
					form_transient_pair('transient_rs_status',$transient_rs_status),
			
				
				
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
