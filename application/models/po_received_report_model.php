<?php
class Po_received_report_model extends CI_Model 
{
	var $trans_type = 5;
	var $insert_id = NULL;
	
	function __construct()
	{
		//parent::Model();
		//$this->sek_id = $this->access->sek_id;
	}
	function list_controller()
	{	
	$where = '';
		$params 	= get_datatables_control();
		$limit 		= $params['limit'];
		$offset 	= $params['offset'];
		$category 	= $params['category'];
		$keyword 	= $params['keyword'];
		
		// map value dari combobox ke table
		// daftar kolom yang valid
		
		$columns['code'] 			= 'registration_code';
		$columns['nopol'] 			= 'car_nopol';
		$columns['customer_name']	= 'customer_name';
		$columns['insurance_name'] 	= 'insurance_name';
		$columns['claim_no'] 		= 'claim_no';
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'registration_id';
		$order_by_column[] = 'registration_code';
		$order_by_column[] = 'registration_date';
		$order_by_column[] = 'car_nopol';
		$order_by_column[] = 'customer_name';
		$order_by_column[] = 'insurance_name';
		$order_by_column[] = 'claim_no';
		$order_by_column[] = 'registration_total';
		$order_by_column[] = 'total_transaction';
		$order_by_column[] = 'total_transaction';
		$order_by_column[] = 'registration_id';
		$order_by_column[] = 'registration_id';
		
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.* , c.customer_name, d.car_nopol, e.insurance_name, f.transaction_total, f.transaction_progress,
		f.transaction_material_total
		from registrations a
		left join customers c on a.customer_id = c.customer_id
		left join cars d on a.car_id = d.car_id
		left join insurances e on a.insurance_id = e.insurance_id
		left join transactions f on f.registration_id = a.registration_id
		$where  $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		//query();
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			
			$registration_date = format_new_date($row['registration_date']);
			
			$status = 0;
			
			switch($row['status_registration_id']){
				case 1: $status = "<div class='registration_status1'>Menunggu Persetujuan</div>"; break;
				case 2: $status = "<div class='registration_status2'>Sudah disetujui</div>"; break;
				case 3: 
				$data_progress = $row['transaction_progress'];
				
				$status = "<div class='registration_status3'>Proses Pengerjaan : $data_progress %</div>";



			 	break;
				case 4: $status = "<div class='registration_status4'>Pengerjaan Selesai</div>"; break;
				case 5: $status = "<div class='registration_status5'>Pembayaran Belum Lunas</div>"; break;
				case 6: $status = "<div class='registration_status6'>Pembayaran Lunas</div>"; break;
			}

			if($row['status_registration_id']==1 || $row['status_registration_id'] == 2){
				$total_biaya_estimasi = $row['approved_sparepart_total_registration'] + $row['approved_total_registration'];
				$total_biaya_pengerjaan = 0;
				$laba = 0;
			}else{
				$total_biaya_estimasi = $row['approved_sparepart_total_registration'] + $row['approved_total_registration'];
				$total_biaya_pengerjaan = $row['approved_sparepart_total_registration'] + $row['transaction_total'] + $row['transaction_material_total'];
				$laba = $total_biaya_estimasi - $total_biaya_pengerjaan;
			}
			

			$link_detail = "<a href=".site_url('po_received_report/form/'.$row['registration_id'])." class='link_input'> Detail </a>";
			$link_report = "<a href=".site_url('po_received_report/report/'.$row['registration_id'])." class='link_input'> Download</a>";		
			$link_kwitansi = "<a href=".site_url('po_received_report/report_kwitansi/'.$row['registration_id'])." class='link_input'> Download</a>";		
			 
			
			$data[] = array(
				$row['registration_id'], 
				$row['registration_code'],
				$registration_date,
				$row['car_nopol'],
				$row['customer_name'],
				$row['insurance_name'],
				$row['claim_no'],
				tool_money_format($total_biaya_estimasi),
				tool_money_format($total_biaya_pengerjaan),
				tool_money_format($laba),
				$status,
				$link_report,
				$link_kwitansi
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);	
		}
	
	function read_id($id)
	{
		$this->db->select('a.*,b.*, c.*, d.car_nopol,d.car_no_machine, g.car_model_merk, g.car_model_name, e.customer_name,f.insurance_name,f.insurance_addres', 1); // ambil seluruh data
		$this->db->join('transactions b', 'b.registration_id = a.registration_id','left');
		$this->db->join('payments c', 'c.registration_id = a.registration_id','left');
		$this->db->join('cars d','d.car_id = a.car_id');
		$this->db->join('customers e','e.customer_id = a.customer_id');
		$this->db->join('insurances f','f.insurance_id = a.insurance_id','left');
		$this->db->join('car_models g', 'g.car_model_id = d.car_model_id');
		$this->db->where('a.registration_id', $id);
		$query = $this->db->get('registrations a', 1); // parameter limit harus 1
		//query($query);
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}

	
	function delete($id)
	{

		$this->db->trans_start();
		$data['approved_active_status'] = '0';
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		$this->db->where('approved_id', $id); // data yg mana yang akan di update
		$this->db->update('approveds', $data);
	
		$this->access->log_delete($id, 'PO Received');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	function create($data,$status)
	{
		$this->db->trans_start();
		
		if($status == 0){
			$data_update['status_registration_id'] = 6;
		}else{
			$data_update['status_registration_id'] = 5;
		}
		$this->db->where('registration_id', $data['registration_id']); // data yg mana yang akan di update
		$this->db->update('registrations', $data_update);

		$this->db->insert('payments', $data);
		$id = $this->db->insert_id();
		
		$this->insert_id = $data['registration_id'];//create registration
	//	$this->insert_registration($id, $data);
		
		$this->access->log_insert($id, 'Transaksi');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 
	function update($id, $data, $items, $items_material)
	{
		$this->db->trans_start();

		/*$data_update['status_registration_id'] = 3;
		$this->db->where('registration_id', $data['registration_id']); // data yg mana yang akan di update
		$this->db->update('registrations', $data_update);
		*/

		$this->db->where('transaction_id', $id); // data yg mana yang akan di update
		$this->db->update('transactions', $data);
		
		//Insert jasa
		$this->db->where('transaction_id', $id);
		$this->db->delete('transaction_details');
		$index = 0;
		foreach($items as $row)
		{			
			$row['transaction_id'] = $id;
			$this->db->insert('transaction_details', $row); 
			$index++;
		}
		
		// cat / bahan
		$this->db->where('transaction_id', $id);
		$this->db->delete('transaction_materials');
		$index = 0;
		$index_material = 0;
		foreach($items_material as $row_material)
		{			
			$row_material['transaction_id'] = $id;
			$this->db->insert('transaction_materials', $row_material);
			$index_material++;
		}

		$this->access->log_update($id, 'Transaksi');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	
	function detail_list_loader($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*, f.workshop_service_name', 1);
		$this->db->from('transaction_details a');
		$this->db->join('transactions e', 'e.transaction_id = a.transaction_id');
		$this->db->join('workshop_services f', 'f.workshop_service_id = a.workshop_service_id');
		$this->db->where('e.registration_id', $id);
		$this->db->order_by('a.transaction_detail_id asc');
		//$this->db->group_by('e.transaction_id');
		$query = $this->db->get(); debug();
		//query();
		
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	function detail_list_loader_sparepart($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*', 1);
		$this->db->from('registration_spareparts a');
		$this->db->where('a.registration_id', $id);
		$query = $this->db->get(); 
		debug();
		//query();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	function detail_list_loader_panel($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*, c.product_id, c.product_code, c.product_name, d.product_type_name, e.pst_name', 1);
		$this->db->from('detail_registrations a');
		$this->db->join('product_prices b', 'b.product_price_id = a.product_price_id');
		$this->db->join('products c', 'c.product_id = b.product_id');
		$this->db->join('product_types d', 'd.product_type_id = b.product_type_id');
		$this->db->join('product_sub_type e', 'e.pst_id = b.pst_id');
		
		$this->db->where('a.registration_id', $id);
		$query = $this->db->get(); debug();
		//query();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	
	function detail_list_loader_cat($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('c.*', 1);
		$this->db->from('registrations a');
		$this->db->join('transactions b', 'b.registration_id = a.registration_id');
		$this->db->join('transaction_materials c', 'c.transaction_id = b.transaction_id');
		$this->db->where('a.registration_id', $id);
		$query = $this->db->get(); debug();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	

	function employee_group($id)
	{
		$this->db->select('a.employee_id', 1); // ambil seluruh data
		$this->db->where('employee_group_id', $id);
		$query = $this->db->get('employee_group_items a', 1); // parameter limit harus 1
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}
	
	function approved($id)
	{
		$this->db->trans_start();
		$data['status_registration_id'] = 2;
		$this->db->where('registration_id', $id); // data yg mana yang akan di update
		$this->db->update('registrations', $data);
	
		
		//$this->access->log_update($id, 'Kategori produk');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	function load_workshop_service($id)
	{
		$sql = "
			select 
			a.*
			from workshop_services a 
			
			where workshop_service_id = $id
		";
		
		
		$query = $this->db->query($sql); 
		//query();	
		return $query;
	}


	function read_id_report($id)
	{
		$this->db->select('a.*,b.*,c.*,d.period_name,e.stand_name,f.customer_name,g.car_nopol,h.insurance_name,i.employee_group_name', 1); // ambil seluruh data
		$this->db->join('transactions b', 'b.registration_id = a.registration_id','left');
		$this->db->join('transaction_details c', 'c.transaction_id = b.transaction_id','left');		
		$this->db->join('periods d', 'a.period_id = d.period_id','left');
		$this->db->join('stands e', 'a.stand_id = e.stand_id','left');				
		$this->db->join('customers f', 'a.customer_id = f.customer_id','left');		
		$this->db->join('cars g', 'a.car_id = g.car_id','left');
		$this->db->join('insurances h', 'a.insurance_id = h.insurance_id','left');		
		$this->db->join('employee_groups i', 'b.employee_group_id  = i.employee_group_id ','left');		
		
		$this->db->where('a.registration_id', $id);
		$query = $this->db->get('registrations a', 1); // parameter limit harus 1
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}
	
	function get_data_detail($id) {
		
		$query = "SELECT a . * , b.product_name
					FROM detail_registrations a
					JOIN product_prices d ON d.product_price_id = a.product_price_id
					JOIN products b ON b.product_id = d.product_id
					
					WHERE registration_id = '$id'
					"
					;
		
        $query = $this->db->query($query);
       // query();
        if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
    }
	
	function get_data_sperpart($id) {
		
		$query = "SELECT *
					FROM registration_spareparts
					WHERE registration_id = '$id'
					"
					;
		
        $query = $this->db->query($query);
       // query();
        if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
    }
	
	function get_data_cat($id) {
		
		$query = "SELECT c.*
					FROM registrations a
					JOIN transactions b on b.registration_id = a.registration_id
					JOIN transaction_materials c on c.transaction_id = b.transaction_id
					WHERE a.registration_id = '$id'
					"
					;
		
        $query = $this->db->query($query);
       // query();
        if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
    }
	
	function get_data_jasa($id) {
		
		$query = "SELECT a.*, f.workshop_service_name
					FROM transaction_details a
					JOIN transactions e on e.transaction_id = a.transaction_id
					JOIN workshop_services f on f.workshop_service_id = a.workshop_service_id
					WHERE registration_id = '$id'
					ORDER BY a.transaction_detail_id asc
					"
					;
		
        $query = $this->db->query($query);
       // query();
        if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
    }

    function create_report_kwitansi($title, $content, $data = '', $data_detail = '',$data_sperpart ='',$data_jasa ='',$data_cat ='', $header){
		
	    $this->load->library('html2pdf');
	    $this->html2pdf->folder('report_new/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename($title.'.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper( 'A4', 'Portrait');
	    
	   	

	    $mydata = $this->load->view($header,$data,TRUE) ;
	    $mydata .= $this->load->view($content, array('data' => $data, 'data_detail' => $data_detail,'data_sperpart' => $data_sperpart,'data_jasa' =>$data_jasa,'data_cat' => $data_cat, 'title' => $title) ,TRUE) ;
	    $mydata .= $this->load->view('footer.php',$data,TRUE) ;
	    //Load html view
	    $this->html2pdf->html($mydata);
	    
	    if($this->html2pdf->create('save')) {
	    	header('Content-type: application/pdf');
			readfile('report_new/'.$title.'.pdf');
	    }
	}
}
#
