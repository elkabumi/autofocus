<?php
class create_po_model extends CI_Model 
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
		SELECT a.* ,b.*,c.customer_name, d.car_nopol, e.insurance_name
				from transaction_po a
		join registrations b on a.registration_id = b.registration_id
		left join customers c on b.customer_id = c.customer_id
		left join cars d on b.car_id = d.car_id
		left join insurances e on b.insurance_id = e.insurance_id
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
			
			
			$create_date = format_new_date($row['tp_create_date']);
			
			/*switch($row['status_registration_id']){
				case 2: $status = "<div class='registration_status2'>Sudah disetujui</div>"; break;
				case 3: 
					$data_progress = $this->get_progress_pengerjaan($row['registration_id']);
				
					$status = "<div class='registration_status3'>Proses Pengerjaan : $data_progress %</div>";

			 	break;
				
			}

				
			if($row['status_registration_id'] == 2){
				$link = "<a href=".site_url('create_po/form/'.$row['registration_id'])." class='link_input'> Create PO </a>";		
			
			}else{
				
				$link = "<a href=".site_url('create_po/form<em></em>/'.$row['registration_id'])." class='link_input'> Create PO </a>";		
			}*/
			
			
			$data[] = array(
				$row['tp_id'], 
				$row['tp_code'],
				$create_date,
				$row['registration_code'],
				$row['car_nopol'],
				$row['customer_name'],
				$row['insurance_name']
				
				//$status,
				
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	
	
	
	
	
	
	
	
	
	function read_id($id)
	{
		
		$this->db->select('a.* ,b.*,c.customer_id,c.customer_name, d.car_id, d.car_nopol,e.insurance_id, e.insurance_name', 1); // ambil seluruh data
		$this->db->join('registrations b', 'b.registration_id = a.registration_id');
		$this->db->join('customers c', 'c.customer_id = b.customer_id','left');
		$this->db->join('cars d', 'd.car_id = b.car_id');
		$this->db->join('insurances e', 'e.insurance_id = b.insurance_id','left');
		$this->db->where('a.tp_id', $id);
		$query = $this->db->get('transaction_po a', 1); 
		//query();
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}
	
	
	function create($data, $items)
	{
		$this->db->trans_start();
		$this->db->insert('transaction_po', $data);
		$id = $this->db->insert_id();
		
		//Insert items
		$index = 0;
		foreach($items as $row)
		{			
			$row['tp_id'] = $id;
			$this->db->trans_start();
			$this->db->insert('transaction_po_details', $row);
			$id_detail = $this->db->insert_id();	
				
				//update status parts	
				$data_row['rs_status_id'] =1;
				$this->db->where('rs_id', $row['rs_id']);
				$this->db->update('registration_spareparts',$data_row);
				
				//create history parts
				$row_history['tpd_id'] =$id_detail;
				$row_history['tpdh_type'] =1;//type create
				$row_history['tpdh_date'] = $data['tp_create_date'];
				$row_history['tpdh_qty'] = $row['tpd_detail_qty'];	
				$row_history['tpdh_desc'] = '';	
				
				$this->db->trans_start();
				$this->db->insert('transaction_po_details_history', $row_history);
					
				
				
			
			$index++;
		}
		
		$this->insert_id = $id;
		
		//create transaction
	//	$this->insert_transaction($id, $data);
		
		$this->access->log_insert($id, 'PO Received');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 
	
	
	
	
	
	
	function update($id,$items)
	{
		//Insert items
		$index = 0;
		foreach($items as $row)
		{			
			$this->db->insert('transaction_po', $row);
			$index++;
		}
	
		
		//create transaction
		//	$this->insert_transaction($id, $data);
		
		$this->access->log_update($id, "Create PO");
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 
	
		
		
		
		
		function detail_list_loader($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('b.*', 1);
		$this->db->from('registrations a');
		$this->db->join('registration_spareparts b', 'b.registration_id = a.registration_id');
		
		$this->db->where('a.registration_id', $id);
		$this->db->where('b.rs_status_id', 0);
		$query = $this->db->get(); 
		debug();
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
		$this->db->select('a.*, b.*, c.*', 1);
		$this->db->from('transaction_po a');
		
		$this->db->join('transaction_po_details b','b.tp_id = a.tp_id');
		
		$this->db->join('registration_spareparts c','c.rs_id = b.rs_id');
		$this->db->where('a.tp_id', $id);
		$query = $this->db->get(); debug();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	function load_registration($id)
	{
		$sql = "
		select a.* , c.customer_name, d.car_nopol, e.insurance_name,f.period_name,g.stand_name
		from registrations a
		
		left join customers c on a.customer_id = c.customer_id
		left join cars d on a.car_id = d.car_id
		left join insurances e on a.insurance_id = e.insurance_id
		left join periods f on a.period_id = f.period_id
		left join stands g on a.stand_id = g.stand_id
		WHERE a.registration_id= $id";
		$query = $this->db->query($sql);
		
		return $query;
	}
}
#
