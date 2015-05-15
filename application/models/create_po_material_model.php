<?php
class create_po_material_model extends CI_Model 
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
		
		$columns['code'] 			= 'tpm_code';
		$columns['date'] 			= 'tpm_create_date';
		$columns['harga'] 			= 'tpm_total_price';
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'tpm_id';
		$order_by_column[] = 'tpm_code';
		$order_by_column[] = 'tpm_create_date';
		$order_by_column[] = 'tpm_total_price';
		
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
		SELECT *
		FROM transaction_po_materials
		WHERE tpm_type = 1
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
			
			
			$create_date = format_new_date($row['tpm_create_date']);
			$price = tool_money_format($row['tpm_total_price']);
		
			
			
			$data[] = array(
				$row['tpm_id'], 
				$row['tpm_code'],
				$create_date, 
				$price
				
				//$status,
				
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	
	
	
	
	
	
	
	
	
	function read_id($id)
	{
		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('tpm_id', $id);
		$query = $this->db->get('transaction_po_materials', 1); 
		//query();
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}
	
	
	function create($data, $items)
	{
		$this->db->trans_start();
		$this->db->insert('transaction_po_materials', $data);
		$id = $this->db->insert_id();
		
		//Insert items
		$index = 0;
		foreach($items as $row)
		{			
			$row['tpm_id'] = $id;
			$this->db->trans_start();
			$this->db->insert('transaction_po_material_details', $row);
			$id_detail = $this->db->insert_id();	
			
			//UPDATE stock materials/bahan
			$sql = "UPDATE material_stock SET material_stock_qty = material_stock_qty +".$row['tpmd_qty']."
			WHERE material_stock_id = ".$row['material_stock_id']."";
			$query = $this->db->query($sql);
		
			$index++;
		}
		
		$this->insert_id = $id;
		
		//create transaction
	//	$this->insert_transaction($id, $data);
		
		$this->access->log_insert($id, 'Create Po Materials');
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
		$this->db->select('b.*,c.*,d.material_name,e.unit_name', 1);
		$this->db->from('transaction_po_materials a');
		$this->db->join('transaction_po_material_details b', 'b.tpm_id = a.tpm_id');
		$this->db->join('material_stock c', 'c.material_stock_id	 = b.material_stock_id	');
		$this->db->join('materials d', 'd.material_id = c.material_id	');
		$this->db->join('unit e', 'd.unit_id	 = e.unit_id	');
		
		$this->db->where('a.tpm_id', $id);
		$this->db->where('a.tpm_type', 1);// 1 untuk typee Materaial Bahan
		$query = $this->db->get(); 
		debug();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
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
	
	
	
	function load_satuan($id)
	{
		$sql = "
		select c.unit_name,b.material_name
		FROM material_stock a
		JOIN materials b ON a.material_id = b.material_id 
		JOIN unit c ON c.unit_id = b.unit_id 
		WHERE a.material_stock_id = $id";
		$query = $this->db->query($sql);
		//query();
		return $query;
	}
	
}
#
