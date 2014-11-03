<?php
class Transaction_received_report extends CI_Controller 
{
	var $id ; 
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->access->crud_page('crud'); 
		$this->load->model('global_model');
		//$this->load->model('payroll_salary_model');
		$this->load->helper('form');
		$this->load->library('render');
		$this->load->library('report');	
				
	}
	
	function index()
	{	
		$this->report->add_item('transaction_received_report/form_transaction_received','PO RECEIVED');
		$this->report->generate();
		$this->render->show('PO RECEIVED REPORT');
	}
	function form_transaction_received()
	{
		$this->report->set_branch(FALSE);	
		$this->report->set_action(1);
		$data['phase_id']	= '';
		$data['project_id']	= '';
			
		$data['product_categories_id']		= '';
		
		$data['transaction_id']		= '';
		
		$this->report->show_form2('report/form/form_transaction_received','transaction_received_report/action_transaction_received','transaction_received_report',$data);
		
		$this->report->show('PO RECEIVED REPORT');	
	}	
	
	function action_transaction_received(){
		//$type=$this->input->post('download_to');
		//$size='l';
		$i_phase_id			= $this->input->post('i_phase_id');
		$i_project_id		= $this->input->post('i_project_id');
		$i_category_id		= $this->input->post('i_category_id');
		$i_transaction_id	= $this->input->post('i_transaction_id');
	

	$where="WHERE a.transaction_type_id = '1' ";
		
		if($i_phase_id != '')		{$where .=" and a.phase_id ='$i_phase_id'";}
		if($i_project_id != '')		{$where .=" and a.project_id ='$i_project_id'";}
		if($i_category_id != '')	{$where .=" and a.transaction_product_category_id ='$i_category_id'";}
		if($i_transaction_id != '')	{$where .=" and a.transaction_id ='$i_transaction_id' or 
													a.transaction_sent_id ='$i_transaction_id' or
													a.transaction_retur_id ='$i_transaction_id'";}
		
		
		$this->load->model('report_model');

		$data['detail'] = $this->report_model->po_received_report($where);
	
		
	  	$this->global_model->create_report('po_received_report', 'report/po_received_report.php', $data);
		

	}
}