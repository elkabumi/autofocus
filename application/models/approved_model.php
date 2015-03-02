<?php
class Approved_model extends CI_Model 
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
		$columns['date'] 			= 'registration_date';
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
		$order_by_column[] = 'registration_id';
		$order_by_column[] = 'registration_id';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{

				if($columns[$category] == "registration_date"){
					$date = explode("/", $keyword);
					$new_keyword = $date[2]."-".$date[1]."-".$date[0];
					$where = " AND ".$columns[$category]." = '$new_keyword'";
				}else{
					$where = " AND ".$columns[$category]." like '%$keyword%'";
				}

		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.* , c.customer_name, d.car_nopol, e.insurance_name
		from registrations a
		
		left join customers c on a.customer_id = c.customer_id
		left join cars d on a.car_id = d.car_id
		left join insurances e on a.insurance_id = e.insurance_id
		WHERE status_registration_id = '1' or status_registration_id = '2'
		 $where   $order_by
			
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
			
			switch($row['status_registration_id']){
				case 1: $status = "<div class='registration_status1'>Menunggu Persetujuan</div>"; break;
				case 2: $status = "<div class='registration_status2'>Sudah disetujui</div>"; break;
				case 3: 
				$data_progress = $this->get_progress_pengerjaan($row['registration_id']);
				
				$status = "<div class='registration_status3'>Proses Pengerjaan : $data_progress %</div>";

			 	break;
				
			}

				
			if($row['status_registration_id'] == 1){ 
				$link = "<a href=".site_url('approved/form_approved/'.$row['registration_id'])." class='link_input'> APPROVE </a>";		
			}else if($row['status_registration_id'] == 2){
				$link = "<a href=".site_url('approved/form_report/'.$row['registration_id'])." class='link_input'> Cetak Laporan </a>";		
			}else{
				$link = "<a href=".site_url('approved/form_report/'.$row['registration_id'])." class='link_input'> Cetak Laporan </a>";	
			}
			
			$data[] = array(
				$row['registration_id'], 
				$row['registration_code'],
				$registration_date,
				$row['car_nopol'],
				$row['customer_name'],
				$row['insurance_name'],
				$row['claim_no'],
				$status,
				$link
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id)
	{
		$this->db->select('a.*', 1); // ambil seluruh data
		$this->db->where('registration_id', $id);
		$query = $this->db->get('registrations a', 1); // parameter limit harus 1
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
	
	function update($id, $data, $items, $item2)
	{
		$this->db->trans_start();
		$this->db->where('registration_id', $id); // data yg mana yang akan di update
		$this->db->update('registrations', $data);
		
		
		//Insert items
		$this->db->where('registration_id', $id);
		$this->db->delete('detail_registrations');
		$index = 0;
		foreach($items as $row)
		{			
			$row['registration_id'] = $id;
			$this->db->insert('detail_registrations', $row); 
			$index++;
		}
		
		
				//Insert items
		$this->db->where('registration_id ', $id);
		$this->db->delete('registration_spareparts');
		$index2 = 0;
		foreach($item2 as $row2)
		{			
			$row2['registration_id'] = $id;
			$this->db->insert('registration_spareparts', $row2); 
			$index2++;
		}
		
	
		$this->access->log_update($id, 'Approved');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function insert_registration($data_id, $datatrans, $update_mode = 0) {
	$id = 0;

	if ($update_mode) {
	    $query = $this->db->get_where('registrations_sl', array('registration_data_id' => $data_id, 'registration_type_id' => $this->trans_type), 1);
	    if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$id = $row['registration_id'];
		//update registration
		$data['registration_date'] = $datatrans['registration_date'];
		$data['registration_description'] = $datatrans['registration_description'];
		$this->db->update('registrations_sl', $data, array('registration_id' => $id));
		$this->db->where('registration_id', $id);
		$this->db->delete('journals_sl');
	    }
	    else
		$update_mode = 0;
	}
	if (!$update_mode) {
	    $data['registration_date'] = $datatrans['registration_date'];
	    $data['registration_description'] = $datatrans['registration_description'];
	    $data['registration_type_id'] = $this->trans_type;
	    $data['registration_code'] = $datatrans['registration_code'];
	    $data['registration_data_id'] = $data_id;
	    $data['period_id'] = 1;
	    $this->db->insert('registrations_sl', $data);
	    $id = $this->db->insert_id();
		//$this->db->update('registrations_sl', array('registration_data_id' => $id), array('registration_id' => $id));
	}
	if ($id == 0)
	    return;
	$index = 0;

	$i = 0;
	$journal_items['registration_id'] = $id;
	$journal_items['market_id'] =  $datatrans['stand_id'];
	
	//pembayaran cash
	if($datatrans['registration_payment_method_id'] == 1){
	
	$debit = 3; $kredit = 30;
	
	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = $datatrans['registration_final_total_price'];
	$journal_items['journal_credit'] = 0;
	$journal_items['coa_id'] = $debit;
	$this->db->insert('journals_sl', $journal_items);
	
	if($datatrans['registration_sent_price'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['registration_description'];
		$journal_items['journal_debit'] = 0;
		$journal_items['journal_credit'] = $datatrans['registration_sent_price'];
		$journal_items['coa_id'] = 32;
		$this->db->insert('journals_sl', $journal_items);
	}

	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = 0;
	$journal_items['journal_credit'] = $datatrans['registration_total_price'];
	$journal_items['coa_id'] = $kredit;
	$this->db->insert('journals_sl', $journal_items);
	
	//pembayaran kredit
	}else if($datatrans['registration_payment_method_id'] == 2){
		$debit = 8; $kredit = 30;
	
	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = $datatrans['registration_final_total_price'] - $datatrans['registration_down_payment'];
	$journal_items['journal_credit'] = 0;
	$journal_items['coa_id'] = $debit;
	$this->db->insert('journals_sl', $journal_items);
	
	if($datatrans['registration_down_payment'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['registration_description'];
		$journal_items['journal_debit'] = $datatrans['registration_down_payment'];
		$journal_items['journal_credit'] = 0;
		$journal_items['coa_id'] = 3;
		$this->db->insert('journals_sl', $journal_items);
	}
	
	if($datatrans['registration_sent_price'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['registration_description'];
		$journal_items['journal_debit'] = 0;
		$journal_items['journal_credit'] = $datatrans['registration_sent_price'];
		$journal_items['coa_id'] = 32;
		$this->db->insert('journals_sl', $journal_items);
	}

	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = 0;
	$journal_items['journal_credit'] = $datatrans['registration_total_price'];
	$journal_items['coa_id'] = $kredit;
	$this->db->insert('journals_sl', $journal_items);
	
	}else{
	
	$debit = 5; $kredit = 30;
	
	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = $datatrans['registration_final_total_price'];
	$journal_items['journal_credit'] = 0;
	$journal_items['coa_id'] = $debit;
	$this->db->insert('journals_sl', $journal_items);
	
	if($datatrans['registration_sent_price'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['registration_description'];
		$journal_items['journal_debit'] = 0;
		$journal_items['journal_credit'] = $datatrans['registration_sent_price'];
		$journal_items['coa_id'] = 32;
		$this->db->insert('journals_sl', $journal_items);
	}

	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = 0;
	$journal_items['journal_credit'] = $datatrans['registration_total_price'];
	$journal_items['coa_id'] = $kredit;
	$this->db->insert('journals_sl', $journal_items);
		
	}
	
		return $id;
    }
	
	function detail_list_loader($id)
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
	
	function detail_list_loader2($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('b.*', 1);
		$this->db->from('registrations a');
		$this->db->join('photos b', 'b.registration_id = a.registration_id');
		
		$this->db->where('a.registration_id', $id);
		$this->db->where('b.photo_type_id ',1);
		$query = $this->db->get(); 
		debug();
		//query();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	
		function detail_list_loader3($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('b.*', 1);
		$this->db->from('registrations a');
		$this->db->join('registration_spareparts b', 'b.registration_id = a.registration_id');
		
		$this->db->where('a.registration_id', $id);
		$query = $this->db->get(); debug();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
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

	function get_progress_pengerjaan($id)
	{
		$sql = "select 
				transaction_komponen,
				transaction_lasketok,
				transaction_dempul,
				transaction_cat,
				transaction_poles,
				transaction_rakit
				from transactions
				where registration_id = '$id'
				";
		
		$query = $this->db->query($sql);
		
		$result = null;
		foreach ($query->result_array() as $row) $result = format_html($row);

		$progress = $result['transaction_lasketok'] + $result['transaction_dempul'] + 
		$result['transaction_cat'] + $result['transaction_poles'] + 
		$result['transaction_rakit'] + $result['transaction_komponen'];

		$progress = $progress / 6 ;

		return $progress;
	}
	
	function get_data_product($id)
	{
		
		$sql = "select b.*, c.product_id, c.product_code, c.product_name, d.product_type_name, e.pst_name
				from product_prices b 
				join products c on c.product_id = b.product_id
				join product_types d on d.product_type_id = b.product_type_id
				join product_sub_type e on e.pst_id = b.pst_id
				where product_price_id = '$id'
				";
		
		$query = $this->db->query($sql);
	//	query();
		$result = null;
		foreach ($query->result_array() as $row) $result = format_html($row);
		return $result;
	}
	function report_kwitansi($id)
	{		
		
		$query = "
				select a.* , c.customer_name
				FROM registrations a
				LEFT JOIN customers c ON a.customer_id = c.customer_id
				WHERE a.registration_id =".$id."";
		
		$query = $this->db->query($query);		
	   //	query();
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}

}
#
