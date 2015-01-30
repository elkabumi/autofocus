<?php
class Transaction_model extends CI_Model 
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
					$where = " and ".$columns[$category]." = '$new_keyword'";
				}else{
					$where = " and ".$columns[$category]." like '%$keyword%'";
				}
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.* , c.customer_name, d.car_nopol, e.insurance_name,f.transaction_id
		from registrations a
		
		left join customers c on a.customer_id = c.customer_id
		left join cars d on a.car_id = d.car_id
		left join insurances e on a.insurance_id = e.insurance_id
		left join transactions f on f.registration_id = a.registration_id
		WHERE a.status_registration_id ='2' or a.status_registration_id = '3'
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
			
			switch($row['status_registration_id']){
				case 2: $status = "0 %"; 
						$progress = "";
				break;
				case 3: 
				$data_progress = $this->get_progress_pengerjaan($row['registration_id']);
				$progress = "<div class='registration_status3' style='width:$data_progress%;'>&nbsp;</div>"; 
				$status = $data_progress." %";
				break;
				
				
			}
			
			$link = "<a href=".site_url('transaction/form/'.$row['registration_id'])." class='link_input'> Proses </a>";
		
			$data[] = array(
				$row['registration_id'], 
				$row['registration_code'],
				$registration_date,
				$row['car_nopol'],
				$row['customer_name'],
				$row['insurance_name'],
				$row['claim_no'],
				$progress,
				$status,
				$link
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id)
	{
		$this->db->select('a.*,b.*,c.*', 1); // ambil seluruh data
		$this->db->join('transactions b', 'b.registration_id = a.registration_id','left');
		$this->db->join('transaction_details c', 'c.transaction_id = b.transaction_id','left');		
		$this->db->where('a.registration_id', $id);
		$query = $this->db->get('registrations a', 1); // parameter limit harus 1
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}
	
	function read_id2($id)
	{
		$this->db->select('a.*,b.*,c.*', 1); // ambil seluruh data
		$this->db->join('transactions b', 'b.registration_id = a.registration_id');
		$this->db->join('transaction_details c', 'c.transaction_id = b.transaction_id');		
		$this->db->where('b.transaction_id', $id);
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
	function create($data, $items)
	{
		$this->db->trans_start();

		$data_update['status_registration_id'] = 3;
		$this->db->where('registration_id', $data['registration_id']); // data yg mana yang akan di update
		$this->db->update('registrations', $data_update);

		$this->db->insert('transactions', $data);
		$id = $this->db->insert_id();
		
		//insert tim kerja
		
		/*foreach($items2 as $row)
		{
			$row['transaction_id'] = $id;
			$this->db->insert('employee_group_histories',$row);
			}
		$this->insert_id = $id;*/
		//Insert items
		$index = 0;
		foreach($items as $row)
		{			
			$row['transaction_id'] = $id;
			$this->db->insert('transaction_details', $row);
			$index++;
		}
		
		$this->insert_id = $data['registration_id'];//create registration
	//	$this->insert_registration($id, $data);

		
		
		$this->access->log_insert($id, 'Transaksi');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 
	function update($id, $data, $items)
	{
		$this->db->trans_start();

			$data_update['status_registration_id'] = 3;
		$this->db->where('registration_id', $data['registration_id']); // data yg mana yang akan di update
		$this->db->update('registrations', $data_update);


		$this->db->where('transaction_id', $id); // data yg mana yang akan di update
		$this->db->update('transactions', $data);
		
		//Insert items
		$this->db->where('transaction_id', $id);
		$this->db->delete('transaction_details');
		$index = 0;
		foreach($items as $row)
		{			
			$row['transaction_id'] = $id;
			$this->db->insert('transaction_details', $row); 
			$index++;
		}
		
		$this->access->log_update($id, 'PO Received');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	
	function detail_list_loader($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*, c.product_id, c.product_code, c.product_name,e.transaction_id,f.transaction_detail_id,f.transaction_detail_plain_first_date,f.transaction_detail_plain_last_date,f.transaction_detail_actual_date,f.transaction_detail_target_date,f.transaction_detail_description,f.transaction_id,f.transaction_detail_bongkar_komponen,f.transaction_detail_lasketok,f.transaction_detail_dempul,f.transaction_detail_cat,f.transaction_detail_poles,f.transaction_detail_rakit,f.transaction_detail_total,f.transaction_detail_date', 1);
		$this->db->from('detail_registrations a');
		$this->db->join('registrations d', 'd.registration_id = a.registration_id');
		$this->db->join('product_prices b', 'b.product_price_id = a.product_price_id');
		$this->db->join('products c', 'c.product_id = b.product_id');
		$this->db->join('transactions e', 'e.registration_id = d.registration_id','left');
		$this->db->join('transaction_details f', 'f.detail_registration_id = a.detail_registration_id','left');
		
		$this->db->where('a.registration_id', $id);
		//$this->db->group_by('e.transaction_id');
		$query = $this->db->get(); debug();
		
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
	function detail_list_loader2($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*,b.*,c.*,d.*', 1);
		$this->db->from('registrations a');
		$this->db->join('transactions b', 'b.registration_id = a.registration_id');
		$this->db->join('transaction_details c', 'c.transaction_id = b.transaction_id');
		$this->db->join('transaction_types d', 'd.transaction_type_id = c.transaction_type_id');		
		
		$this->db->where('b.transaction_id', $id);
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
	
	
}
#
