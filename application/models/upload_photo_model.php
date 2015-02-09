<?php
class Upload_photo_model extends CI_Model 
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
		$order_by_column[] = 'status_registration_id';
		$order_by_column[] = 'status_registration_id';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " and ".$columns[$category]." like '%$keyword%'";
			
			
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
		where (status_registration_id = 3 OR status_registration_id = 4) AND transaction_progress = '100'  
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
			$status = show_checkbox_status($row['status_registration_id']);
			switch($row['status_registration_id']){
				case 3: $status = "<div class='registration_status3'>Progress Pengerjaan 100%</div>"; break;
				case 4: $status = "<div class='registration_status4'>Pengerjaan Selesai</div>"; break;
			}
			if($row['status_registration_id'] == 3){	
				$link = "<a href=".site_url('upload_photo/form/'.$row['registration_id'])." class='link_input'> Upload Foto </a>";
			}
			else if($row['status_registration_id'] == 4){	
				$link = "<a  href=".site_url('upload_photo/form/'.$row['registration_id'])." class='link_input'> Edit Foto</a>";
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
	function create($id,$data, $items)
	{
		$this->db->trans_start();
		$this->db->where('registration_id', $id); // data yg mana yang akan di update
		$this->db->update('registrations', $data);
		
		//insert tim kerja
		
		/*foreach($items2 as $row)
		{
			$row['transaction_id'] = $id;
			$this->db->insert('employee_group_histories',$row);
			}
		$this->insert_id = $id;*/
		//Insert items
		$this->db->where('registration_id', $id);
		$this->db->delete('photos');
		
		$index = 0;
		foreach($items as $row)
		{			
			$row['registration_id'] = $id;
			$this->db->insert('photos', $row); 
			$index++;
		}
		
		
		
		
		$this->access->log_update($id, 'PO Received');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 
	
	
	
	function detail_list_loader($id)
	{
		// buat array kosong
		$result = array(); 		
		$sql = "SELECT b.*, a.status_registration_id
					FROM registrations a
					JOIN photos b ON b.registration_id = a.registration_id
					WHERE a.registration_id = '$id' AND (b.photo_type_id='3' OR b.photo_type_id='4')";
		
		$query = $this->db->query($sql);
		//$query = $this->db->get(); 
		//debug();
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
	
}
#
