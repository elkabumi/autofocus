<?php
class Transaction_reserved_report extends CI_Controller 
{
	var $id ; 
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->access->crud_page('crud'); 
		$this->load->model('global_model');
		$this->load->helper('form');
		$this->load->library('render');
		$this->load->library('report');	
				
	}
	
	function index()
	{	
		$this->report->add_item('transaction_reserved_report/form_transaction_reserved','PO RESERVED');
		$this->report->generate();
		$this->render->show('PO RESERVED REPORT');
	}
	
	
	function form_transaction_reserved()
	{
		$this->report->set_branch(FALSE);	
		$this->report->set_action(1);
		$data['phase_id']					= '';
		$data['project_id']					= '';	
		$data['product_categories_id']		= '';
		$data['transaction_id']				= '';
		
		$data['site_id']			= '';
		$data['site_mapping_id']		= '';
	
		$this->report->show_form2('report/form/form_transaction_reserved','transaction_reserved_report/action_transaction_reserved','transaction_reserved_report', $data);
		$this->report->show('PO RESERVED REPORT');	
	}	
	
	
	
	function action_transaction_reserved(){
		
		//$type=$this->input->post('download_to');
		$i_phase_id			= $this->input->post('i_phase_id');
		$i_project_id		= $this->input->post('i_project_id');
		$i_category_id		= $this->input->post('i_category_id');
		$i_transaction_id	= $this->input->post('i_transaction_id');
		$i_site_id			= $this->input->post('i_site_id');
		$i_site_mapping_id	= $this->input->post('i_site_mapping_id');
		

		$where="WHERE a.transaction_type_id = '2' ";
		
		if($i_phase_id != '')		{$where .=" and a.phase_id ='$i_phase_id'";}
		if($i_project_id != '')		{$where .=" and a.project_id ='$i_project_id'";}
		if($i_category_id != '')	{$where .=" and a.transaction_product_category_id ='$i_category_id'";}
		if($i_transaction_id != '')	{$where .=" and a.transaction_id ='$i_transaction_id'";}
		if($i_site_id != '')		{$where .=" and a.site_id = '$i_site_id'";}
		if($i_site_mapping_id !='')	{$where .=" and a.site_mapping_id ='$i_site_mapping_id'";}							
													
		$this->load->model('report_model');
		$data['detail'] = $this->report_model->po_resereved_report($where);
		
		
	  	$this->global_model->create_report('transection_reserved_report', 'report/transection_reserved_report.php' , $data);
		
	}
}