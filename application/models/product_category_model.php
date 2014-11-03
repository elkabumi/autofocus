<?php
class product_category_model extends CI_Model 
{
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
		
		$columns['product_category_name'] 					= 'product_category_name';
		$columns['product_category_description'] 			= 'product_category_description';
		$columns['product_category_date'] 					= 'product_category_date';
	
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'product_category_id 	';
		$order_by_column[] = 'product_category_name';
		$order_by_column[] = 'product_category_description';
		$order_by_column[] = 'product_category_date';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
	SELECT a . *,  c.employee_name AS created_name, d.employee_name AS inactive_name
		FROM product_categories a
		LEFT JOIN employees c ON a.created_by_id = c.employee_id
		LEFT JOIN employees d ON a.inactive_by_id = d.employee_id
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
			$product_categories_date = format_new_date($row['product_categories_date']);
			$active = show_checkbox_status($row['product_category_active_status']);
				
			if($row['product_category_active_status'] == 0){
				
				
				$div1 = "<span class='inactive'>";
				$div2 = "</span>";
				$row['product_category_id'] = $row['product_category_id'];
				$row['product_category_name'] = $div1.$row['product_category_name'].$div2;
				$row['product_category_description'] = $div1.$row['product_category_description'].$div2;
				$product_categories_date = $div1.$product_categories_date.$div2;
				$active	=$div1.$active.$div2;
				$status = $div1."Inactive by ".$row['inactive_name'].$div2;	
			
			}
			
			$data[] = array(
				$row['product_category_id'], 
				$row['product_category_name'],
				$row['product_category_description'],
				$product_categories_date,
				$active,
				$status
			
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	function read_id($id)
	{
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('product_category_id', $id);
		
		$query = $this->db->get('product_categories', 1); // parameter limit harus 1
		
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result;
	}
	function create($data)
	{
		$this->db->trans_start();
		$this->db->insert('product_categories', $data);

		$id = $this->db->insert_id();
		$this->access->log_insert($id, "Kategori Produk [$data[product_category_name]]");
		
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
	function update($id, $data)
	{
		$this->db->trans_start();
		$this->db->where('product_category_id', $id); // data yg mana yang akan di update
		$this->db->update('product_categories', $data);
		$this->access->log_update($id, "Kategori Produk [$data[product_category_name]]");
		
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	function delete($id)
	{
		
		$this->db->trans_start();
		
		$data['product_category_active_status'] = 0;
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		
		$this->db->where('product_category_id', $id);
		$this->db->update('product_categories', $data);
		
		$this->access->log_delete($id, "Produk Kategori");
		$this->db->trans_complete();
		return $this->db->trans_status();
		
		
	}
	function active($id){
		$this->db->trans_start();
		
		$data['product_category_active_status'] = 1;
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		
		$this->db->where('product_category_id', $id);
		$this->db->update('product_categories', $data);
		
		$this->access->log_update($id, "Produk Kategori");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}
#
