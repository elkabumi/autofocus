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
		
		
		$this->render->add_view('app/summary_report/transient_list');
		$this->render->build('Detail');
	
		
		$this->render->show('Summary Report');
		
	}
	
	function detail_table_loader($type = 0,$date_1 = 0, $date_2= 0) {
		if($type == 0){
		
	
			 	
				send_json(make_datatables_list(null));
			
		
		}else{
			
			$data = $this->summary_report_model->detail_list_loader2($date_1,$date_2);
			
			$sort_id = 0;
			foreach($data as $key => $value) 
			{	
			
			switch($value['status_registration_id']){
				case 1: $status = "<div class='registration_status1'>Menunggu Persetujuan</div>"; break;
				case 2: $status = "<div class='registration_status2'>Sudah disetujui</div>"; break;
				case 3: 
				$data_progress = $value['transaction_progress'];
				
				$status = "<div class='registration_status3'>Proses Pengerjaan : $data_progress %</div>";



			 	break;
				case 4: $status = "<div class='registration_status4'>Pengerjaan Selesai</div>"; break;
				case 5: $status = "<div class='registration_status5'>Pembayaran belum lunas</div>"; break;
				case 6: $status = "<div class='registration_status5'>Pembayaran Lunas</div>"; break;
			}

			if($value['status_registration_id']==1 || $value['status_registration_id'] == 2){
				$total_biaya_estimasi = $value['approved_sparepart_total_registration'] + $value['approved_total_registration'];
				$total_biaya_pengerjaan = 0;
				$laba = 0;
			}else{
				$total_biaya_estimasi = $value['approved_sparepart_total_registration'] + $value['approved_total_registration'];
				$total_biaya_pengerjaan = $value['approved_sparepart_total_registration'] + $value['transaction_total'] + $value['transaction_material_total'];
				$laba = $total_biaya_estimasi - $total_biaya_pengerjaan;
			}

			$registration_date = format_new_date($value['registration_date']);
			$data[$key] = array(
		
					form_transient_pair('transient_registration_code', $value['registration_code']),
					form_transient_pair('transient_registration_date',$registration_date),
					form_transient_pair('transient_car_nopol', $value['car_nopol']),
					form_transient_pair('transient_customer_name', $value['customer_name']),
					form_transient_pair('transient_insurance_name', $value['insurance_name']),
					form_transient_pair('transient_claim_no', $value['claim_no']),
					form_transient_pair('transient_total_registration', tool_money_format($total_biaya_estimasi), $total_biaya_estimasi),
					form_transient_pair('transient_transaction_total', tool_money_format($total_biaya_pengerjaan), $total_biaya_pengerjaan),
					form_transient_pair('transient_laba', tool_money_format($laba), $laba),
					form_transient_pair('transient_status', $status)
					
				);
			}
		}
        send_json(make_datatables_list($data));
    }
	
	
	
	

	
	
	function report($i_date_1,$i_date_2 ){
		
		$where = "WHERE a.registration_date between '".$i_date_1."'  AND '".$i_date_2."'";


		$date1 = explode("-", $i_date_1);
		$date2 = explode("-", $i_date_2);

			$data['detail'] = $this->summary_report_model->report($where);
			$data['title'] = "Laporan Summary tanggal ".$date1[2]."/".$date1[1]."/".$date1[0]." sampai ".$date2[2]."/".$date2[1]."/".$date2[0]; 
	
		$this->load->model('global_model');
	  	$this->global_model->create_report('summary_report', 'report/summary_report.php', $data);
		

	}
}
