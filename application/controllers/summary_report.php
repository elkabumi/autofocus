<?php 

class Summary_report extends CI_Controller 
{	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('summary_report_model');
		$this->load->library('render');
		
		// set kode module ini .. misal usr
		//$this->access->set_module('report.summary_report');
		// default access adalah User
		$this->load->library('access');
		$this->access->user_page();
	
	}
	function index()
	{
		$data = array();
		
			$data['row_id'] = '';
			$data['date_1'] = '';
			$data['date_2'] = '';
			
		
		$this->load->helper('form');
			
		$this->render->add_form('app/summary_report/form', $data);
		$this->render->build('Summary Report');
		
		//$this->render->add_view('app/summary_report/transient_list');
		//$this->render->build('Detail');
		
		$this->render->show('Summary Report');
		
	}
	

	function form_action($is_delete = 0) // jika 0, berarti insert atau update, bila 1 berarti delete
	{
		$this->load->library('form_validation');
		
		// bila operasinya DELETE -----------------------------------------------------------------------------------------		
		if($is_delete)
		{
			$this->load->model('summary_report_model');
			$id = $this->input->post('row_id');
			$is_process_error = $this->summary_report_model->delete($id);
			send_json_action($is_process_error, "Data telah dihapus", "Data gagal dihapus");
		}
		
		// bila bukan delete, berarti create atau update ------------------------------------------------------------------
	
		// definisikan kriteria data
		
		$this->form_validation->set_rules('i_phase_id','Phase Project','trim|required|integer');
		$this->form_validation->set_rules('i_project_id','Project Name','trim|required');
		$this->form_validation->set_rules('i_transaction_product_category_id','PO Type','trim|required');
		$this->form_validation->set_rules('i_transaction_code','Retur Number','trim|min_length[3]|max_length[50]|required');
		$this->form_validation->set_rules('i_transaction_date','PO Date','trim|required|valid_date|sql_date');
		
		//$this->form_validation->set_rules('i_transaction_description','Description','trim|required');
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		
		
		$id = $this->input->post('row_id');
		$data['transaction_type_id'] 		= 3;
		$data['transaction_code'] 			= $this->input->post('i_transaction_code');
		$data['transaction_date'] 			= $this->input->post('i_transaction_date');	
		$data['project_id']					= $this->input->post('i_project_id');
		$data['transaction_description']	= $this->input->post('i_transaction_description');
		$data['transaction_sent_id']		= 0;
		$data['transaction_retur_id']		= $this->input->post('i_transaction_id');
		$data['phase_id']					= $this->input->post('i_phase_id');
		$data['transaction_received_date'] 	= date("Y-m-d");
		$data['transaction_delivery_date'] 	= date("Y-m-d");		
		$data['transaction_product_category_id'] = $this->input->post('i_transaction_product_category_id');	
		$data['create_by_id']				= $this->access->info['employee_id'];	
		$data['site_id']					= 0;
		$data['site_mapping_id']			= 0;
		
		$list_product_id		= $this->input->post('transient_product_id');
		$list_transaction_detail_ordered	= $this->input->post('transient_transaction_detail_ordered');
		$list_transaction_detail_return	= $this->input->post('transient_transaction_detail_return');
		$list_transaction_detail_description	= $this->input->post('transient_transaction_detail_description');
		$list_uom_id	= $this->input->post('transient_uom_id');
		
		if(!$list_product_id) send_json_error('Material should not be empty');
		
		
		$stock_error = 0;
		
		$items = array();
		if($list_product_id){
		foreach($list_product_id as $key => $value)
		{
			
			$items[] = array(				
				'product_id'  => $list_product_id[$key],
				'transaction_detail_qty'  => $list_transaction_detail_ordered[$key],
				'transaction_detail_description'  => $list_transaction_detail_description[$key],
				'transaction_detail_ordered' => 0,
				'transaction_detail_return' => $list_transaction_detail_return[$key],
				'transaction_detail_balance' => 0,
				'uom_id' => $list_uom_id[$key]
			);
			
			
		}
		}
			
		
		if(empty($id)) // jika tidak ada id maka create
		{ 
			
			$data['transaction_status'] 		= 1;
			$data['transaction_active_status'] 	= 1;
			$data['inactive_by_id'] 			= 0;
			$data['create_date'] 				= date("Y-m-d");
			
			$error = $this->summary_report_model->create($data, $items);
			send_json_action($error, "Data telah ditambah", "Data gagal ditambah", $this->summary_report_model->insert_id);
		}
		else // id disebutkan, lakukan proses UPDATE
		{
			$error = $this->summary_report_model->update($id, $data, $items);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi", $id);
		}		
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
			$data['transaction_detail_qty'] 	= '';
			$data['transaction_detail_description'] 	= '';
			$data['uom_id'] 	= '';
		} else {
			
			$data['index']			= $index;
			$data['transaction_id'] 				= $transaction_id;
			$data['product_id']	= array_shift($this->input->post('transient_product_id'));
			$data['transaction_detail_return'] = array_shift($this->input->post('transient_transaction_detail_return'));
			$data['transaction_detail_ordered'] = array_shift($this->input->post('transient_transaction_detail_ordered'));
			$data['transaction_detail_description'] = array_shift($this->input->post('transient_transaction_detail_description'));
			$data['uom_id'] = array_shift($this->input->post('transient_uom_id'));
			
			$get_data_uom = $this->summary_report_model->get_data_uom($data['uom_id']);
			$data['uom_name'] =  $get_data_uom;
		}		
		
		$this->load->helper('form');
		
		$this->load->model('global_model');
		$data['cbo_uom_id'] 			= $this->global_model->get_uom();
		
		$this->render->add_form('app/summary_report/transient_form', $data);
		$this->render->show_buffer();
	}
	function detail_form_action()
	{		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_product_id', 'Material', 'trim|required');
		$this->form_validation->set_rules('i_transaction_detail_return', 'Retur', 'trim|required|numeric|min_value[1]');
		$this->form_validation->set_rules('i_transaction_detail_ordered', 'Ordered Quantity', 'trim|required|numeric');
		
		$index = $this->input->post('i_index');		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); 
		
		$this->load->model('global_model');	
		
		$no 		= $this->input->post('i_index');
		$product_id 	= $this->input->post('i_product_id');
		$transaction_detail_return 	= $this->input->post('i_transaction_detail_return');
		$transaction_detail_ordered 	= $this->input->post('i_transaction_detail_ordered');
		$transaction_detail_description	= $this->input->post('i_transaction_detail_description');
		$uom_id 	= $this->input->post('i_uom_id');
	
		$get_data_product = $this->summary_report_model->get_data_product($product_id);
		$get_data_uom = $this->summary_report_model->get_data_uom($uom_id);
		
		if($transaction_detail_return > 0 ){
			$status = '1';
		}else{
			$status = '0';
		}
		
		if($transaction_detail_return > $transaction_detail_ordered){
			send_json_error("Retur tidak poleh melebihi ordered quantity");
		}
		//send_json_error($no);
		
		$data = array(
				form_transient_pair('transient_product_id', $get_data_product[0], $product_id),
				form_transient_pair('transient_product_name', $get_data_product[1]),
				form_transient_pair('transient_transaction_detail_ordered', $transaction_detail_ordered),
				form_transient_pair('transient_transaction_detail_return', $transaction_detail_return),
				form_transient_pair('transient_uom_id', $get_data_uom, $uom_id),
				form_transient_pair('transient_transaction_detail_description', $transaction_detail_description),
				form_transient_pair('transient_transaction_detail_ordered_status', show_checkbox_status($status), $status)
		);
		 
		send_json_transient($index, $data);
	}
	
	function load_po_received()
	{
		$id 	= $this->input->post('id');
		
		$query = $this->summary_report_model->load_po_received($id);
		$data = array();
		
		foreach($query->result_array() as $row)
		{
			$data['phase_id'] = $row['phase_id'];
			$data['phase_name'] = $row['phase_name'];
			$data['transaction_code_received'] = $row['transaction_code_received'];
			$data['project_id'] = $row['project_id'];
			$data['project_name'] = $row['project_name'];
			$data['transaction_product_category_id'] = $row['transaction_product_category_id'];
			$data['product_category_name'] = $row['product_category_name'];
		}
		send_json_message('PO received', $data);
	}
	
		function detail_table_loader( $type = 0,$phase_id = 0, $project_id = 0, $material_type = 0, $transaction_id = 0) {
		if($type == 0){
		
	
			 	
	send_json(make_datatables_list(null));
			
		
		}else{
			
		
			
			$data = $this->summary_report_model->detail_list_loader2($phase_id, $project_id, $material_type, $transaction_id);
			
			$sort_id = 0;
			foreach($data as $key => $value) 
			{	
			
	
			$balance =	$value['get_total_qty'] - $value['get_total_ordered'];
			$bagi = (100 / $value['get_total_qty'] );
			$complete = $bagi * $value['get_total_ordered'];
			$data[$key] = array(
					form_transient_pair('transient_phase',$value['phase_name'], $value['phase_id']),
					form_transient_pair('transient_project', $value['project_name'], $value['project_id']),
					form_transient_pair('transient_product_category', $value['product_category_name'], $value['transaction_product_category_id']),
					form_transient_pair('transient_transaction_code', $value['transaction_code']),
				
					form_transient_pair('transient_transaction_date', format_new_date($value['transaction_date'])),
					form_transient_pair('transient_transaction_received_date', format_new_date($value['transaction_received_date'])),
					form_transient_pair('transient_transaction_delivery_date', format_new_date($value['transaction_delivery_date'])),
					
					form_transient_pair('transient_transaction_detail_qty', $value['get_total_qty']),
					form_transient_pair('transient_transaction_detail_ordered', $value['get_total_ordered']),
					form_transient_pair('transient_transaction_detail_balance', $balance),
				
					form_transient_pair('transient_complete', $complete.'%'),
					form_transient_pair('transient_status', ''),
					form_transient_pair('transient_create_date', format_new_date($value['create_date'])),
					form_transient_pair('transient_information', '')
			);
			}

		}
        send_json(make_datatables_list($data));
    }
	
	function report($i_phase_id,$i_project_id,$i_category_id,$i_transaction_id ){
		
		$where="WHERE a.transaction_type_id = '1' ";

		
		if($i_phase_id != '0')			{$where .=" and a.phase_id ='$i_phase_id'";}
		if($i_project_id != '0')		{$where .=" and a.project_id ='$i_project_id'";}
		if($i_category_id != '0')		{$where .=" and a.transaction_product_category_id ='$i_category_id'";}
		if($i_transaction_id != '0')	{$where .=" and a.transaction_id ='$i_transaction_id'";}
		
		
		$this->load->model('report_model');

		$data['detail'] = $this->report_model->summary_report($where);
	
		$this->load->model('global_model');
	  	$this->global_model->create_report('summary_report', 'report/summary_report.php', $data);
		

	}
}
