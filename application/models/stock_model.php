<?php

class Stock_model extends CI_Model{

	function __construct(){
		
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
		
		$columns['product_code'] 			= 'product_stock_kode';
		$columns['product_name'] 			= 'product_stock_name';
		$columns['stand_name'] 				= 'stand_name';
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'product_stock_id';
		$order_by_column[] = 'product_code';
		$order_by_column[] = 'product_name';
		$order_by_column[] = 'stand_name';
		$order_by_column[] = 'product_stock_qty';
		
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.*, b.product_code, b.product_name, c.stand_name
		from product_stocks a
		join products b on b.product_id = a.product_id
		join stands c on c.stand_id = a.stand_id
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
				
			$data[] = array(
				$row['product_stock_id'], 
				$row['product_code'],
				$row['product_name'],
				$row['stand_name'],
				$row['product_stock_qty']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id){
		$this->db->select('a.*, b.product_code, b.product_name, c.stand_name', 1);
		$this->db->join('products b', 'b.product_id = a.product_id');
		$this->db->join('stands c', 'c.stand_id = a.stand_id');
		$this->db->where('product_stock_id', $id);
		$query = $this->db->get('product_stocks a', 1);
		$result = null;
		foreach($query->result_array() as $row)
		{
			$result = format_html($row);
		}
		return $result;
	}
	
	function create($data){
		$this->db->trans_start();
		$this->db->insert('product_stocks', $data);
		$id = $this->db->insert_id();
		
		
		$this->access->log_insert($id, "");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function update($id, $data){
		$this->db->trans_start();
		$this->db->where('product_stock_id', $id);
		$this->db->update('product_stocks', $data);
		$this->access->log_update($id, "");
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function delete($id){
		$this->db->trans_start();
		
		$this->db->where('product_stock_id', $id);
		$this->db->delete('product_stocks');
		
		$this->access->log_delete($id, "Produk");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

}