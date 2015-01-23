<?php 

class po_reservation_summary_report extends CI_Controller{
	function __construct(){
			parent::__construct();
			$this->load->model('po_reservation_summary_report_model');
			$this->load->library('render');
		
			// set kode module ini .. misal usr
			$this->access->set_module('laporan.laporan_stock');
			// default access adalah User
			$this->load->library('access');
		}
		
	function index(){
			$this->load->model('global_model');
			$data = array();
			$data['row_id'] = '';
			$data['stand_id'] =  $this->global_model->get_stand();
			$this->load->helper('form');
			
			$this->render->add_form('app/po_reservation_summary_report/form', $data);
			$this->render->build('Laporan Stock');
		
			$this->render->add_view('app/po_reservation_summary_report/transient_list');
			$this->render->build('Detail Laporan Stock');
		
			$this->render->show('Laporan Stock');
		
	}
	function detail_table_loader($type = 0,$material_id = 0) {
		if($type == 0){
		
	
			 	
				send_json(make_datatables_list(null));
			
		
		}else{
			
			$data = $this->po_reservation_summary_report_model->detail_list_loader2($material_id);
			
			$sort_id = 0;
			foreach($data as $key => $value) 
			{	
			$data[$key] = array(
		
					form_transient_pair('transient_product_code', $value['product_code']),
					form_transient_pair('transient_product_name',$value['product_name']),
					form_transient_pair('transient_stand_name', $value['stand_name']),
					form_transient_pair('transient_product_qty', $value['product_stock_qty'])
				);
			}
		}
        send_json(make_datatables_list($data));
    }
	
		
	
	function report($stand_id){
	
		if($stand_id != '0'){$where="where a.stand_id = '$stand_id'";}else{$where ='';}
		
		
		
		
		$data['detail'] = $this->po_reservation_summary_report_model->report_stock($where);

		$this->load->model('global_model');
	  	$this->global_model->create_report('Lap_Data_Stock', 'report/report_stock_exc.php', $data);
	}
}