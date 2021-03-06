<?php

class product_model extends CI_Model{

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
		
		$columns['product_code'] 			= 'product_code';
		$columns['product_name'] 			= 'product_name';
	
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'product_id';
		$order_by_column[] = 'product_code';
		$order_by_column[] = 'product_name';
		$order_by_column[] = 'product_date';
		$order_by_column[] = 'product_active_status';
		$order_by_column[] = 'product_active_status';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.* , c.employee_name as created_name, d.employee_name as inactive_name
		from products a
		
		left join employees c on a.created_by_id = c.employee_id
		left join employees d on a.inactive_by_id = d.employee_id
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
			
			$status = "Created by ".$row['created_name'];	
			$product_date = format_new_date($row['product_date']);
			$active = show_checkbox_status($row['product_active_status']);
				
			if($row['product_active_status'] == 0){
				
				
				$div1 = "<span class='inactive'>";
				$div2 = "</div>";
				$row['product_id'] = $row['product_id'];
				$row['product_code'] = $div1.$row['product_code'].$div2;
				$row['product_name'] = $div1.$row['product_name'].$div2;
				
				$product_date = $div1.$product_date.$div2;
				$active	=$div1.$active.$div2;
				$status = $div1."Inactive by ".$row['inactive_name'].$div2;	
			
			}
			
			$data[] = array(
				$row['product_id'], 
				$row['product_code'],
				$row['product_name'],
				
				$product_date,
				$active,
				$status
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id){
		$this->db->select('*', 1);
		$this->db->where('product_id', $id);
		$query = $this->db->get('products', 1);
		$result = null;
		foreach($query->result_array() as $row)
		{
			$result = format_html($row);
		}
		return $result;
	}
	
	function create($data){
		$this->db->trans_start();
		$this->db->insert('products', $data);
		$id = $this->db->insert_id();
		$insurance_id = $data['insurance_id'];
		
		
		$this->db->select('a.insurance_id, b.product_type_id, c.pst_id', 1);
		$this->db->from('insurances a');
		$this->db->join('product_types b','b.insurance_id = a.insurance_id');
		$this->db->join('product_sub_type c','c.insurance_id = a.insurance_id');
		$this->db->where('a.insurance_id', $insurance_id);
		$query = $this->db->get(); debug();
		
		foreach($query->result_array() as $row)
		{
			$item['product_type_id'] = $row['product_type_id'];
			$item['pst_id'] = $row['pst_id'];
			$item['product_id'] =$id ;
			$item['product_price'] = 0 ;
			$this->db->insert('product_prices', $item);
		}
		
		/*
		// cek menggunakan stok atau tidak
			$use_stock = $this->get_use_stock($data['product_category_id']);
			if($use_stock == 1){

				$this->db->select('*', 1);
				$this->db->from('stands');
				$query_stand = $this->db->get(); debug();

				foreach($query_stand->result_array() as $row_stand)
				{

					$data_stock['product_id'] = $id;
					$data_stock['product_stock_qty'] = 0;
					$data_stock['stand_id'] = $row_stand['stand_id'];
					$this->db->insert('product_stocks', $data_stock);
				}

			}
			*/
		
		$this->access->log_insert($id, "produk [".$data['product_name']."]");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function update($id, $data){
		$this->db->trans_start();
		$this->db->where('product_id', $id);
		$this->db->update('products', $data);
		$this->access->log_update($id, "produk[".$data['product_name']."]");
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function delete($id){
		$this->db->trans_start();
		
		$data['product_active_status'] = 0;
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		
		$this->db->where('product_id', $id);
		$this->db->update('products', $data);
		
		$this->access->log_delete($id, "Produk");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function active($id){
		$this->db->trans_start();
		
		$data['product_active_status'] = 1;
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		
		$this->db->where('product_id', $id);
		$this->db->update('products', $data);
		
		$this->access->log_update($id, "Produk");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}


	function get_use_stock($id)
	{
		$sql = "SELECT product_category_use_stock from product_categories where product_category_id = $id";
		$query = $this->db->query($sql);
		//query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result['product_category_use_stock'];
		
	}
	
	
	
}