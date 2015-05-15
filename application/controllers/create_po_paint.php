<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Create_po_paint extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('render');
		$this->load->model('create_po_paint_model');
		$this->load->library('access');
		$this->access->set_module('create_po_paint_mocel.create_po_paint_mocel');
		$this->access->user_page();
	}
	
	function index(){
		
		$this->render->add_view('app/create_po_paint/list');
		$this->render->build('Create PO Cat');
		$this->render->show('Create PO Cat');
		
	}

	
	function table_controller(){
		$data = $this->create_po_paint_model->list_controller();
		send_json($data);
	}
	function form($id = 0){
		$data = array();
		if($id==0){
		
			
			$data['row_id'] = '';
			$data['tpm_code'] = format_code('transaction_po_materials','tpm_code','POC',7);
			$data['stand_id'] ='';
			$data['tpm_create_date'] ='';
			$data['tpm_desc'] ='';
			$data['tpm_total_price'] ='';
			
		
		}else{
			$result = $this->create_po_paint_model->read_id($id);
			if($result){
				$data = $result;
				$data['row_id'] = $id;
				$data['tpm_create_date'] = format_new_date($data['tpm_create_date']);
			}
		}
		
		$this->load->helper('form');
			
		$this->render->add_form('app/create_po_paint/form', $data);
		$this->render->build('Create PO Cat');
		
		if($id==0){
			$this->render->add_view('app/create_po_paint/transient_list');
			$this->render->build('Data cat');
		}else{
			$this->render->add_view('app/create_po_paint/transient_list_view');
			$this->render->build('Data cat');
		}

	
		$this->render->add_form('app/create_po_paint/form_save', $data);
		$this->render->build('Create PO Cat');
		$this->render->show('Create PO Cat');
	}
	
	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if($is_delete)
		{
			$this->load->model('po_reservation_model');
			$id = $this->input->post('row_id');
			$is_process_error = $this->create_po_paint_model->delete($id);
			send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
		}
		
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
	
		// definisikan kriteria data
		
		$this->form_validation->set_rules('i_create_date','Tanggal Create Po','trim|required|valid_date|sql_date');
	
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		
		
		$id = $this->input->post('row_id');
		$data['tpm_code'] 		= $this->input->post('i_code');
		$data['stand_id'] 		= $this->input->post('i_stand_id');	
		$data['tpm_create_date']= $this->input->post('i_create_date');
		$data['tpm_desc']		= $this->input->post('i_description');
		$data['tpm_type']		= 2;//2 untuk type materaial CAT
		
		$list_tm_name			= $this->input->post('transient_materials_name');
		$list_tm_stock_id		= $this->input->post('transient_materials_stock_id');
		$list_tm_qty			= $this->input->post('transient_materials_qty');
		$list_tm_price			= $this->input->post('transient_materials_price');
		$list_tm_unit			= $this->input->post('transient_unit_name');
	
		if(!$list_tm_stock_id) send_json_error('Simpan gagal. Data Order Bahan Masih kosong');
		
		$total_harga = 0;
		$jumlah_order = 0;
		if($list_tm_stock_id){
		foreach($list_tm_stock_id as $key => $value)
		{
			$items[] = array(				
				'material_stock_id'  => $list_tm_stock_id[$key],
				'tpmd_qty'  => $list_tm_qty[$key],
				'tpmd_price' => $list_tm_price[$key]
			);
			
			$check = 0;
			$check_product = 0;
			$tm_stock_id_original = $list_tm_stock_id[$key];
			foreach($list_tm_stock_id as $key_check => $value)
				{
			
					if($tm_stock_id_original == $list_tm_stock_id[$key_check]){
						$check++;
					}
			
				}
			if($check > 1){
				
				$get_data_materails = $this->create_po_paint_model->get_data_material($tm_stock_id_original);
				send_json_error("Simpan gagal. Bahan item tidak boleh sama [".$get_data_materails[0]."]");
			}
			
			$total_harga += $list_tm_price[$key];
	//	
		}
		}
		$data['tpm_total_price'] = $total_harga;
		
		if(empty($id)) // jika tidak ada id maka create
		{ 
			$error = $this->create_po_paint_model->create($data, $items);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah");
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$error = $this->po_reservation_model->update($id, $data, $items);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi", $id);
		}		
	}


	
	function detail_table_loader($id = 0) {
    
		if($id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->create_po_paint_model->detail_list_loader($id);
		$sort_id = 0;
		foreach($data as $key => $value) 
		{	
		
		$data[$key] = array(
				form_transient_pair('transient_materials_name', $value['material_name'], $value['material_name'],
									array('transient_materials_stock_id'=>$value['material_stock_id'],
									'transient_unit_name'=>$value['unit_name']
									)),
				form_transient_pair('transient_materials_qty', $value['tpmd_qty']),
				form_transient_pair('transient_materials_price', tool_money_format($value['tpmd_price']), $value['tpmd_price'])
		);
		
		
		
		}		
		send_json(make_datatables_list($data)); 
	}
	
	function detail_form($id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
		{		
			$this->load->library('render');
			$index = $this->input->post('transient_index');
			if (strlen(trim($index)) == 0) {
						
				// TRANSIENT CREATE - isi form dengan nilai default / kosong
					$data['index']								= '';
					$data['id'] 								= $id;
					$data['transient_materials_name'] 			= '';
					$data['transient_materials_stock_id'] 		= '';
					$data['transient_materials_qty'] 			= '';
					$data['transient_materials_price']			= '';
					$data['transient_unit_name']			= '';
					
			} else {
				
					$data['index']								= $index;
					$data['id'] 						= $id;
					$data['transient_materials_name'] 			= array_shift($this->input->post('transient_materials_name'));
					$data['transient_materials_stock_id'] 		= array_shift($this->input->post('transient_materials_stock_id'));
					$data['transient_materials_qty'] 			= array_shift($this->input->post('transient_materials_qty'));
					$data['transient_materials_price'] 			= array_shift($this->input->post('transient_materials_price'));
					$data['transient_unit_name'] 				= array_shift($this->input->post('transient_unit_name'));
			
			}
			
			$this->load->helper('form');
			$this->render->add_form('app/create_po_paint/transient_form', $data);
			$this->render->show_buffer();
		}
		function detail_form_action()
		{		
			$this->load->library('form_validation');
			$this->form_validation->set_rules('i_price', 'Harga', 'trim|required|numeric');
		
			$this->form_validation->set_rules('i_qty', 'qty', 'trim|required|numeric|min_value[1]');
		
			$index = $this->input->post('i_index');		
			// cek data berdasarkan kriteria
			if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		
		
			$no 							= $this->input->post('i_index');
			$transient_materials_name 		= ($this->input->post('i_name'));
			$transient_materials_stock_id 	= ($this->input->post('i_material_stock_id'));
			$transient_materials_qty 		= ($this->input->post('i_qty'));
			$transient_materials_price 		= ($this->input->post('i_price'));
			$transient_unit_name			= ($this->input->post('i_unit'));
			
			$transient_rs_status	 		= $this->input->post('i_rs_status_id');
			$data = array(
				form_transient_pair('transient_materials_name', $transient_materials_name, $transient_materials_name,
									array('transient_materials_stock_id'=>$transient_materials_stock_id,
									'transient_unit_name'=>$transient_unit_name
									)),
				form_transient_pair('transient_materials_qty', $transient_materials_qty),
				form_transient_pair('transient_materials_price', tool_money_format($transient_materials_price), $transient_materials_price)
		
				
			);
		 
		send_json_transient($index, $data);

		
		}
	function load_satuan()
	{
		$id 	= $this->input->post('id');
		
		$query = $this->create_po_paint_model->load_satuan($id);
		$data = array();
		
		foreach($query->result_array() as $row)
		{
		
			$data['transient_unit_name'] 		= $row['unit_name'];
			
			$data['transient_materials_name'] 		= $row['material_name'];
			
		
			
		}
		send_json_message('Satuan', $data);
	}
}
