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
		
		$columns['product_stock_kode'] 			= 'product_stock_kode';
		$columns['product_stock_name'] 			= 'product_stock_name';
		$columns['product_stock_jumlah'] 		= 'product_stock_jumlah';
		$columns['product_stock_description']	= 'product_stock_description';
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'product_stock_id';
		$order_by_column[] = 'product_stock_kode';
		$order_by_column[] = 'product_stock_name';
		$order_by_column[] = 'product_stock_jumlah';
		$order_by_column[] = 'product_stock_description';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.*
		from product_stocks a
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
				$row['product_stock_kode'],
				$row['product_stock_name'],
				$row['product_stock_jumlah'],
				$row['product_stock_description'],
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id){
		$this->db->select('*', 1);
		$this->db->where('product_stock_id', $id);
		$query = $this->db->get('product_stocks', 1);
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
		
		
		$this->access->log_insert($id, "produk[".$data['product_stock_kode']."]");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function update($id, $data){
		$this->db->trans_start();
		$this->db->where('product_stock_id', $id);
		$this->db->update('product_stocks', $data);
		$this->access->log_update($id, "produk[".$data['product_stock_kode']."]");
		
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