<?php 

class Salary_report extends CI_Controller 
{	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('salary_report_model');
		$this->load->library('render');
		
		// set kode module ini .. misal usr
		//$this->access->set_module('report.salary_report');
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
			
		$this->render->add_form('app/salary_report/form', $data);
		$this->render->build('Summary Report');
		
		
		$this->render->add_view('app/salary_report/transient_list');
		$this->render->build('Detail');
	
		
		$this->render->show('Laporan Gaji Summary');
		
	}
	
	function detail_table_loader($type = 0,$date_1 = 0, $date_2= 0) {
		if($type == 0){
		
	
			 	
				send_json(make_datatables_list(null));
			
		
		}else{
			
			$data = $this->salary_report_model->detail_list_loader2($date_1,$date_2);
			
			$sort_id = 0;
			foreach($data as $key => $value) 
			{	
				$data[$key] = array(
		
					form_transient_pair('transient_team_name',$value['employee_group_name']),
					form_transient_pair('transient_team_payment',number_format($value['get_total_payment']),$value['get_total_payment']),

					
				);
			}
		}
        send_json(make_datatables_list($data));
    }
	
	
	
	

	
	
	function report($i_date_1,$i_date_2 ){
		
		$where = "WHERE a.registration_date between '".$i_date_1."'  AND '".$i_date_2."'";


		$date1 = explode("-", $i_date_1);
		$date2 = explode("-", $i_date_2);

			$data['detail'] = $this->salary_report->report($where);
			$data['title'] = "Laporan Summary tanggal ".$date1[2]."/".$date1[1]."/".$date1[0]." sampai ".$date2[2]."/".$date2[1]."/".$date2[0]; 
	
		$this->load->model('global_model');
	  	$this->global_model->create_report('salary_report', 'report/salary_report.php', $data);
		

	}
}
