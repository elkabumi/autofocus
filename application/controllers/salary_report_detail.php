<?php 

class Salary_report_detail extends CI_Controller 
{	
	function __construct()
	{
		parent::__construct();	
		$this->load->model('salary_report_detail_model');
		$this->load->library('render');
		
		// set kode module ini .. misal usr
		//$this->access->set_module('report.salary_report_detail');
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
			$data['employee_group_id'] 		='';
		
		$this->load->helper('form');
			
		$this->render->add_form('app/salary_report_detail/form', $data);
		$this->render->build('Summary Report');
		
		
		$this->render->add_view('app/salary_report_detail/transient_list');
		$this->render->build('Detail');
	
		
		$this->render->show('Laporan Gaji Harian');
		
	}
	
	function detail_table_loader($type = 0,$date_1 = 0, $date_2= 0,$employee_group_id=0) {
		if($type == 0){
		
	
			 	
				send_json(make_datatables_list(null));
			
		
		}else{
			
			$data = $this->salary_report_detail_model->detail_list_loader2($date_1,$date_2,$employee_group_id);
			
			$sort_id = 0;
			foreach($data as $key => $value) 
			{	
				$data[$key] = array(
		
					form_transient_pair('transient_registration_date',format_new_date($value['registration_date']),$value['registration_date']),
					form_transient_pair('transient_team_name',$value['employee_group_name']),
					form_transient_pair('transient_team_payment',number_format($value['transaction_total']),$value['transaction_total']),

					
				);
			}
		}
        send_json(make_datatables_list($data));
    }
	
	
	
	

	
	
	function report($i_date_1,$i_date_2,$employee_group_id){


			$data['detail'] = $this->salary_report_detail_model->report($i_date_1, $i_date_2,$employee_group_id);
	
			$this->load->model('global_model');
			$this->global_model->create_report('Laporan_Gaji_Harian_tanggal_'.$i_date_1.'_sampai_'.$i_date_2.'', 'report/salary_report_detail.php', $data);
			

	}
}
