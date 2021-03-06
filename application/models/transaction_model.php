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
		select a.* , c.customer_name, d.car_nopol, e.insurance_name,f.transaction_id, f.transaction_progress
		from registrations a
		
		left join customers c on a.customer_id = c.customer_id
		left join cars d on a.car_id = d.car_id
		left join insurances e on a.insurance_id = e.insurance_id
		left join transactions f on f.registration_id = a.registration_id
		WHERE (a.status_registration_id ='2' or a.status_registration_id = '3')
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
				$data_progress = $row['transaction_progress'];
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
		$this->db->select('a.*,b.transaction_paint_total,b.*', 1); // ambil seluruh data
		$this->db->join('transactions b', 'b.registration_id = a.registration_id','left');
		$this->db->where('a.registration_id', $id);
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
	function create($data, $items, $items_material, $items_foto,$items_sparepats)
	{
		$this->db->trans_start();

		$data_update['status_registration_id'] = 3;
		$this->db->where('registration_id', $data['registration_id']); // data yg mana yang akan di update
		$this->db->update('registrations', $data_update);

		$this->db->insert('transactions', $data);
		$id = $this->db->insert_id();
		
		// jasa
		$index = 0;
		foreach($items as $row)
		{			
			$row['transaction_id'] = $id;
			$this->db->insert('transaction_details', $row);
			$index++;
		}

		// cat / bahan
		$index_material = 0;
		foreach($items_material as $row_material)
		{			
			$row_material['transaction_id'] = $id;
			$this->db->insert('transaction_materials', $row_material);
			$this->kurangi_stock($row_material['tmmaterial_stock_id_qty'],$row_material['tm_qty']);
			
			$index_material++;
		}

		// foto
		$index_foto = 0;
		foreach($items_foto as $row_foto)
		{			
			$row_foto['registration_id'] = $data['registration_id'];
			
			$this->db->insert('photos', $row_foto);
			$index_foto++;
		}
		//spareparts
		$index_spareparts = 0;
		foreach($items_sparepats as $row_sparepats)
		{			
		
			if($row_sparepats['tpd_id'] != '0'){
			$data_install['tpd_detail_install'] = $row_sparepats['tpd_detail_install'];
			$this->db->where('tpd_id',$row_sparepats['tpd_id']);
			$this->db->update('transaction_po_details',$data_install);
			//update status parts	
		
				//create history parts
				$data_history['tpd_id']		 =	$row_sparepats['tpd_id'];
				$data_history['tpdh_type'] =	$row_sparepats['tpdh_type'];
				$data_history['tpdh_qty']  = 	$row_sparepats['tpdh_qty'];	
				$data_history['tpdh_date'] =	$row_sparepats['tpdh_date'];
				$data_history['tpdh_desc']  = 	$row_sparepats['tpdh_desc'];	
				
				$this->db->trans_start();
				$this->db->insert('transaction_po_details_history', $data_history);
			}
			$index_spareparts++;
			
		}
		$this->insert_id = $data['registration_id'];//create registration
	//	$this->insert_registration($id, $data);

		
		
		$this->access->log_insert($id, 'Transaksi');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function
	

	 
	function update($id, $data, $items, $items_material,$items_cat,$items_foto,$items_sparepats)
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
		//bahan
		$index_material = 0;
		foreach($items_material as $row_material)
		{	
				$row_data_material['transaction_id'] = $id;
				$row_data_material['material_stock_id'] = $row_material['material_stock_id'];
				$row_data_material['tm_qty'] = $row_material['tm_qty'];
				$row_data_material['tm_description'] = $row_material['tm_description'];
				$row_data_material['tm_price'] = $row_material['tm_price'];
				$this->db->insert('transaction_materials', $row_data_material);
				//query();
				$this->kurangi_stock($row_material['material_stock_id'],$row_material['list_bahan_qty_form']);
		
				$index_material++;
			
		}
		//cat
		$index_cat= 0;
		foreach($items_cat as $row_cat)
		{	
				$row_data_cat['transaction_id'] = $id;
				$row_data_cat['material_stock_id'] = $row_cat['material_stock_id'];
				$row_data_cat['tm_qty'] = $row_cat['tm_qty'];
				$row_data_cat['tm_description'] = $row_cat['tm_description'];
				$row_data_cat['tm_price'] = $row_cat['tm_price'];
				$this->db->insert('transaction_materials', $row_data_cat);
				//query();
				$this->kurangi_stock($row_cat['material_stock_id'],$row_cat['list_cat_qty_form']);
		
				$index_cat++;
			
		}

		// foto
		$index_foto = 0;
		$this->db->where('registration_id', $data['registration_id']);
		$this->db->delete('photos');
		foreach($items_foto as $row_foto)
		{			
			$row_foto['registration_id'] = $data['registration_id'];
			
			$this->db->insert('photos', $row_foto);
			$index_foto++;
		}
		//spareparts
		$index_spareparts = 0;
		foreach($items_sparepats as $row_sparepats)
		{			
			
		if($row_sparepats['tpd_id'] != 0){
			$data_install['tpd_detail_install'] = $row_sparepats['tpd_detail_install'];
			
			$this->db->where('tpd_id',$row_sparepats['tpd_id']);
			$this->db->update('transaction_po_details',$data_install);
			//query();
			//update status parts	
		
				//create history parts
				$data_history['tpd_id']		 =	$row_sparepats['tpd_id'];
				$data_history['tpdh_type'] =	$row_sparepats['tpdh_type'];
				$data_history['tpdh_qty']  = 	$row_sparepats['tpdh_qty'];	
				$data_history['tpdh_date'] =	$row_sparepats['tpdh_date'];
				$data_history['tpdh_desc']  = 	$row_sparepats['tpdh_desc'];	
				
				$this->db->trans_start();
				$this->db->insert('transaction_po_details_history', $data_history);
			}	
			$index_spareparts++;
			
		}
		$this->access->log_update($id, 'Transaksi');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function tambah_stock($id,$qty){
		$sql = "UPDATE material_stock SET material_stock_qty = material_stock_qty + $qty
				WHERE  material_stock_id = $id
				";
		
		$query = $this->db->query($sql);
	}
	function kurangi_stock($id,$qty){
		$sql = "UPDATE material_stock SET material_stock_qty = material_stock_qty - $qty
				WHERE  material_stock_id = $id
				";
		
		$query = $this->db->query($sql);
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
		$this->db->select('a.*,c.*', 1);
		$this->db->from('registration_spareparts a');
		$this->db->join('transaction_po b', 'b.registration_id= a.registration_id','LEFT');
		$this->db->join('transaction_po_details c', 'c.tp_id = b.tp_id','LEFT');
		
		$this->db->where('a.registration_id', $id);
		$query = $this->db->get(); 
		//debug();
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
	
	function detail_list_loader_bahan($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('c.*,d.material_stock_qty,e.material_name,f.unit_name', 1);
		$this->db->from('registrations a');
		$this->db->join('transactions b', 'b.registration_id = a.registration_id');
		$this->db->join('transaction_materials c', 'c.transaction_id = b.transaction_id');
		$this->db->join('material_stock d', 'c.material_stock_id = d.material_stock_id');
		$this->db->join('materials e', 'd.material_id = e.material_id');
		$this->db->join('unit f', 'f.unit_id = e.unit_id');
		$this->db->where('a.registration_id', $id);
		$this->db->where('e.material_type_id',1);
		$query = $this->db->get(); debug();
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
		$this->db->select('c.*,d.material_stock_qty,e.material_name,f.unit_name', 1);
		$this->db->from('registrations a');
		$this->db->join('transactions b', 'b.registration_id = a.registration_id');
		$this->db->join('transaction_materials c', 'c.transaction_id = b.transaction_id');
		$this->db->join('material_stock d', 'c.material_stock_id = d.material_stock_id');
		$this->db->join('materials e', 'd.material_id = e.material_id');
		$this->db->join('unit f', 'f.unit_id = e.unit_id');
		$this->db->where('a.registration_id', $id);
		$this->db->where('e.material_type_id',2);
		$query = $this->db->get(); debug();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	function detail_list_loader_foto($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('b.*, c.photo_type_name', 1);
		$this->db->from('registrations a');
		$this->db->join('photos b', 'b.registration_id = a.registration_id');
		$this->db->join('photo_types c', 'c.photo_type_id = b.photo_type_id');
		$this->db->where('a.registration_id', $id);
		$this->db->where('c.photo_type_cat', 2);
		$this->db->order_by('b.photo_id asc');
		$query = $this->db->get(); debug();
		//query();
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
	
	
	
	function load_detail_material($material_stock_id)
	{
		$sql = "
		select c.unit_name,b.material_name,a.material_stock_qty
		FROM material_stock a
		JOIN materials b ON a.material_id = b.material_id 
		JOIN unit c ON c.unit_id = b.unit_id 
		WHERE a.material_stock_id = $material_stock_id ";
		$query = $this->db->query($sql);
		//query();
		return $query;
	}
	function cek_transaction_material($material_stock_id,$transaction_id)
	{
		$sql = "
		select COUNT(tm_id) as id
		FROM material_stock a
		LEFT JOIN transaction_materials d ON a.material_stock_id = d.material_stock_id 
		WHERE a.material_stock_id = $material_stock_id AND  d.transaction_id =$transaction_id";
		$query = $this->db->query($sql);
		//query();
		foreach ($query->result_array() as $row) $result = format_html($row);
		return $result['id'];
	}
	function get_data_material($id)
	{
		$sql = "SELECT a.*,b.*
		FROM material_stock a
		JOIN materials b ON a.material_id = b.material_id
		WHERE material_stock_id = ".$id."
				";
		
		$query = $this->db->query($sql);
		
		$result = null;
		foreach ($query->result_array() as $row) $result = format_html($row);
		return array($result['material_name']);
	}
}
#
