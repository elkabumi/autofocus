<?php 

class Lookup extends CI_Controller 
{	
	function __construct()
	{
		parent::__construct();	
		//$this->load->library('dtc');
	}
	
	# lookup data workshop service
	function workshop_service_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->workshop_service_control();
	}

	function workshop_service_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->workshop_service_get();
	}

	# lookup data gedung
	function building_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->building_control();
	}
	
	function building_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->building_get();
	}
	
	# lookup data employee
	function employee_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->employee_control();
	}
	
	function employee_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->employee_get();
	}
	
	# lookup data Transaction Type
	function transaction_type_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->transaction_type_control();
	}
	
	function transaction_type_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->transaction_type_get();
	}
	
	# lookup data group employee
	function employee_group_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->employee_group_control();
	}
	
	function employee_group_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->employee_group_get();
	}
	
	# lookup data product_category
	function product_category_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->product_category_control();
	}
	
	function product_category_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->product_category_get();
	}
	
	# lookup data product_type
	function product_type_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->product_type_control();
	}
	
	function product_type_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->product_type_get();
	}
	
	# lookup data customer
	function customer_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->customer_control();
	}
	
	function customer_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->customer_get();
	}
	
	# lookup data mobil
	function car_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->car_control();
	}
	
	function car_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->car_get();
	}
	
	# lookup data model mobil
	function car_model_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->car_model_control();
	}
	
	function car_model_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->car_model_get();
	}
	
	 #lookup data product aktif
	function active_product_table_control($cat_id = 0)
	{
		$this->load->library('dtc');
		$this->dtc->active_product_control($cat_id);
	}
	
	function active_product_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->active_product_get();
	}
	
	 #lookup data product price
	function product_price_table_control($insurance_id = 0)
	{
		$this->load->library('dtc');
		$this->dtc->product_price_control($insurance_id);
	}
	
	function product_price_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->product_price_get();
	}
	
	 #lookup data product
	function product_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->product_control();
	}
	
	function product_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->product_get();
	}
	
	 #lookup data stand
	function stand_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->stand_control();
	}
	
	function stand_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->stand_get();
	}
	
	 #lookup data salesman
	function salesman_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->salesman_control();
	}
	
	function salesman_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->salesman_get();
	}
	
	 #lookup data vendor
	function vendor_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->vendor_control();
	}
	
	function vendor_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->vendor_get();
	}	
	
	# lookup data periode
	function period_table_control()
	{
		$this->load->library('dtc');
		$this->dtc->period_control();
	}
	
	function period_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->period_get();
	}
	
	# lookup data coa
	function coa_table_control($kredit = 0)
	{
		$this->load->library('dtc');
		$this->dtc->coa_control($kredit);
	}
	function coa_lookup_hierarchy()
	{
		$this->load->library('dtc');
		$this->dtc->coa_get();
	}
	
	# lookup data coa type
	function coa_account_type_table_control($kredit = 0)
	{
		$this->load->library('dtc');
		$this->dtc->coa_account_type_control($kredit);
	}
	function coa_account_type_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->coa_account_type_get();
	}
	
		# lookup data cabang
	function market_table_control($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->market_control($id);
	}
	
	function market_lookup_id($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->market_get($id);
	}
	
	# lookup data cabang
	function employee_position_table_control($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->employee_position_control($id);
	}
	
	function employee_position_lookup_id($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->employee_position_get($id);
	}
	
	# lookup data phase
	function phase_table_control($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->phase_control($id);
	}
	
	function phase_lookup_id($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->phase_get($id);
	}
	
	# lookup data project
	function project_table_control($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->project_control($id);
	}
	
	function project_lookup_id($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->project_get($id);
	}
	
	# lookup data PO Received
	function po_received_table_control($active=0)
	{
		$this->load->library('dtc');
		$this->dtc->po_received_control($active);
	}
	
	function po_received_lookup_id($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->po_received_get($id);
	}
	
	# lookup data PO reservation
	function po_reservation_table_control($active=0)
	{
		$this->load->library('dtc');
		$this->dtc->po_reservation_control($active);
	}
	
	function po_reservation_lookup_id($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->po_reservation_get($id);
	}
	
	
	# lookup data PO Received numer
	function po_number_table_control($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->po_number_control($id);
	}
	
	function po_number_lookup_id($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->po_number_get($id);
	}
	
	
	# lookup data Site
	function site_table_control($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->site_control($id);
	}
	
	function site_lookup_id($id=0)
	{
		$this->load->library('dtc');
		$this->dtc->site_get($id);
	}
	# lookup data insurance
	function insurance_table_control($type=0)
	{
		$this->load->library('dtc');
		$this->dtc->insurance_control($type);
	}
	
	function insurance_lookup_id($type=0)
	{
		$this->load->library('dtc');
		$this->dtc->insurance_get($type);
	}
	
	 #lookup data product type aktif
	function active_product_type_table_control($cat_id = 0)
	{
		$this->load->library('dtc');
		$this->dtc->active_product_type_control($cat_id);
	}
	
	function active_product_type_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->active_product_type_get();
	}
	
		 #lookup data product type aktif
	function active_product_sub_type_table_control($cat_id = 0)
	{
		$this->load->library('dtc');
		$this->dtc->active_product_sub_type_control($cat_id);
	}
	
	function active_product_sub_type_lookup_id()
	{
		$this->load->library('dtc');
		$this->dtc->active_product_sub_type_get();
	}
}
