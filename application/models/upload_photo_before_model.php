<?php
class Upload_photo_before_model extends CI_Model 
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
		WHERE status_registration_id = '1' 
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

				
			//if($row['status_registration_id'] == 1){ 
				$link = "<a href=".site_url('upload_photo_before/form/'.$row['registration_id'])." class='link_input'> Upload Photo </a>";		
			/*}else if($row['status_registration_id'] == 2){
				$link = "<a href=".site_url('upload_photo_before/form_report/'.$row['registration_id'])." class='link_input'> Cetak Laporan </a>";		
			}else{
				$link = "<a href=".site_url('upload_photo_before/form_report/'.$row['registration_id'])." class='link_input'> Cetak Laporan </a>";	
				
			}*/
			
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
		$data['upload_photo_before_active_status'] = '0';
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		$this->db->where('upload_photo_before_id', $id); // data yg mana yang akan di update
		$this->db->update('upload_photo_befores', $data);
	
		$this->access->log_delete($id, 'PO Received');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
	function update($id,$items_foto)
	{
		$this->db->trans_start();
		
		$this->db->where('registration_id', $id); // data yg mana yang akan di update
		$this->db->delete('photos');
		// foto
		$index_foto = 0;
		foreach($items_foto as $row_foto)
		{			
			$row_foto['registration_id'] = $id;
			
			$this->db->insert('photos', $row_foto);
			$index_foto++;
		}
	
		$this->access->log_update($id, 'Upload Foto Sebelum Masuk');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	
	
	function detail_list_loader_foto($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('b.*,c.photo_type_name', 1);
		$this->db->from('registrations a');
		$this->db->join('photos b', 'b.registration_id = a.registration_id');
		$this->db->join('photo_types c', 'c.photo_type_id = b.photo_type_id');
		
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
	
	function upload_photo_before($id)
	{
		$this->db->trans_start();
		$data['status_registration_id'] = 2;
		$this->db->where('registration_id', $id); // data yg mana yang akan di update
		$this->db->update('registrations', $data);
	
		
		//$this->access->log_update($id, 'Kategori produk');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	function get_photo_type_name($id)
	{
		$sql = "select photo_type_name
				from photo_types
				where photo_type_id = '$id'
				";
		
		$query = $this->db->query($sql);
	//	query();
		$result = null;
		foreach ($query->result_array() as $row) $result = format_html($row);
		return $result['photo_type_name'];
	}
}
#
