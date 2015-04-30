<?php
class warehouse_model extends CI_Model 
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
		
		$columns['code'] 		= 'tp_code';
		$columns['nama_part'] 	= 'rs_name';
		$columns['order'] 		= 'tpd_detail_qty';
		$columns['received']	= 'tpd_detail_received';
		$columns['instal'] 		= 'tpd_detail_install';
		$columns['nopol'] 		= 'car_nopol';
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'tp_code';
		$order_by_column[] = 'rs_name';
		$order_by_column[] = 'tpd_detail_qty';
		$order_by_column[] = 'tpd_detail_received';
		$order_by_column[] = 'tpd_detail_install';
		$order_by_column[] = 'car_nopol';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{

				
					$where = " AND ".$columns[$category]." like '%$keyword%'";
				

		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		SELECT a.* ,b.*,c.*, d.car_nopol,e.rs_name
				from transaction_po a
		join registrations b on a.registration_id = b.registration_id
		join transaction_po_details c on a.tp_id = c.tp_id
		left join cars d on b.car_id = d.car_id 
		left join registration_spareparts e on c.rs_id = e.rs_id 
		WHERE tpd_type_id = '1' $where   $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		//query();
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			$link = "<a href=".site_url('warehouse/form/'.$row['tpd_id'])." class='link_input'> detail </a>";	

		$data[] = array(
				$row['tp_id'], 
				$row['tp_code'], 
				$row['rs_name'],
				$row['tpd_detail_qty'],
				$row['tpd_detail_received'],
				$row['tpd_detail_install'],
				$row['car_nopol'],
				$link
				
				//$status,
				
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	
	
	
	
	
	
	
function read_id($id)
	{
		$this->db->select('a.*,b.rs_name', 1); // ambil seluruh data
		$this->db->join('registration_spareparts b','b.rs_id = a.rs_id');	;
		
		$this->db->where('a.tpd_id', $id);
		$query = $this->db->get('transaction_po_details a', 1); // parameter limit harus 1
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
					$data_row['rs_status_id'] =1;
					
					$this->db->where('rs_id', $row['rs_id']);
					$this->db->update('registration_spareparts',$data_row);
				
				
				
				
			
			$index++;
		}
		
		$this->insert_id = $id;
		
		//create transaction
	//	$this->insert_transaction($id, $data);
		
		$this->access->log_insert($id, 'PO Received');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 
	
	
	
	
	
	
	function update($id,$data,$data_history)
	{
		//Insert items
		$data_up['tpd_detail_received'] = $data['tpd_detail_received'] ;
		$this->db->where('tpd_id', $id);
		$this->db->update('transaction_po_details',$data_up);
		
		$data_history['tpd_id'] =$id;
		$data_history['tpdh_type'] =2;//type received
		$data_history['tpdh_qty']  = $data['tpd_detail_received'];	
		$this->db->trans_start();
		$this->db->insert('transaction_po_details_history', $data_history);
		
		//create transaction
		//	$this->insert_transaction($id, $data);
		
		$this->access->log_update($id, "Received PO");
		
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
