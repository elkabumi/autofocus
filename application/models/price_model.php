<?php
class price_model extends CI_Model 
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
		
		$columns['insurance_name'] 			= 'insurance_name';
		$columns['insurance_addres'] 		= 'insurance_addres';
		$columns['insurance_phone']       	= 'insurance_phone';
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'insurance_id';
		$order_by_column[] = 'insurance_name';
		$order_by_column[] = 'insurance_addres';
		$order_by_column[] = 'insurance_phone';
		
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
		from insurances a
		
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
			$insurance_date = format_new_date($row['insurance_date']);
			$active = show_checkbox_status($row['insurance_active_status']);
				
			if($row['insurance_active_status'] == 0){
				
				
				$div1 = "<span class='inactive'>";
				$div2 = "</div>";
				$row['insurance_id'] = $row['insurance_id'];
				$row['insurance_name'] = $div1.$row['insurance_name'].$div2;
				$row['insurance_addres'] = $div1.$row['insurance_addres'].$div2;
				$row['insurance_phone '] = $div1.$row['insurance_phone'].$div2;
				$product_date = $div1.$insurance_date.$div2;
				$active	=$div1.$active.$div2;
				$status = $div1."Inactive by ".$row['inactive_name'].$div2;	
			
			}
			
			$data[] = array(
				$row['insurance_id'], 
				$row['insurance_name'],
				$row['insurance_addres'],
				$row['insurance_phone']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function read_id($id)
	{
		$this->db->select('*', 1);
		$this->db->from('insurances ');

		$this->db->where('insurance_id', $id);
		
		$query = $this->db->get(); debug();// parameter limit harus 1
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}
	function delete($id)
	{
		$this->db->trans_start();
		$data['price_category_active_status'] = '0';
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		$this->db->where('price_category_id', $id); // data yg mana yang akan di update
		$this->db->update('price_categorys', $data);
	
		$this->access->log_delete($id, 'PO Received');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	function create($data, $items)
	{
		$this->db->trans_start();
		$this->db->insert('price_categorys', $data);
		$id = $this->db->insert_id();
		
		//Insert items
		$index = 0;
		foreach($items as $row)
		{			
			$row['price_category_id'] = $id;
			$this->db->insert('product_types', $row);
			$index++;
		}
		
		$this->insert_id = $id;
		
		//create transaction
	//	$this->insert_transaction($id, $data);
		
		$this->access->log_insert($id, 'PO Received');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 

	
	function get_kolom_price($id){
		
				$sql = "SELECT a.*,b.*,c.*
						from insurances a
						JOIN product_types b ON a.insurance_id 	 = b.insurance_id 	
						JOIN product_sub_type c ON a.insurance_id 	 = c.insurance_id 	

				where a.insurance_id  = $id
				order by product_type_id
				";

		$query = $this->db->query($sql);
		 if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
	}
	
	function detail_list_loader($id)
	{
		// buat array kosong
		$result = array(); 		
	
		$this->db->select('a.*, b.*, c.*', 1);
		$this->db->from('insurances a');
		$this->db->join('product_types b','b.insurance_id = a.insurance_id');
		$this->db->join('product_sub_type c','c.insurance_id = a.insurance_id');
		$this->db->where('a.insurance_id', $id);
		$query = $this->db->get(); debug();
		//query($query);
		debug();
	
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	function get_debit_name($id)
	{
		$data = '';		
		$this->db->select('coa_name',1);
		$this->db->from('coas');
		$this->db->where('coa_id', $id);
		$query = $this->db->get();
		
		if($query->num_rows>0)
		{
			$row = $query->row_array();
			$data = $row['coa_name'];
		}
		return $data;
	}
	function get_credit_name($id)
	{
		$data = '';		
		$this->db->select('coa_name',1);
		$this->db->from('coas');
		$this->db->where('coa_id', $id);
		$query = $this->db->get();
		
		if($query->num_rows>0)
		{
			$row = $query->row_array();
			$data = $row['coa_name'];
		}
		return $data;
	}
	
	function load_product_stock($id)
	{
		$sql = "
			select 
			a.*, b.product_code
			from product_stocks a 
			join products b on b.product_id = a.product_id
			where product_stock_id = $id
		";
		
		
		$query = $this->db->query($sql); 
		//query();	
		return $query;
	}
	
	
	
	function check_po_received($id)
	{
		$sql = "select * from transactions where transaction_sent_id = $id
				";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{		
			return TRUE;
		}else{
			return FALSE;
		}
	}
	function active($id){
		$this->db->trans_start();
		
		$this->db->trans_start();
		$data['transaction_active_status'] = '1';
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		$this->db->where('transaction_id', $id); // data yg mana yang akan di update
		$this->db->update('transactions', $data);
	
		$this->access->log_update($id, 'PO Received');
		$this->db->trans_complete();

		return $this->db->trans_status();
	
	}
	
	function load_product($insurance_id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*
							', 1);
		$this->db->from('products a');
		$this->db->where('a.product_active_status', 1);
		$this->db->where('a.insurance_id', $insurance_id);
		$query = $this->db->get();
		//query();
		foreach($query->result_array() as $row)
		{
			$result[] = format_html($row);
		}
		return $result;
	}
	
	function get_item_price($product_id, $product_type_id, $pst_id) {
		$query = "select product_price from product_prices 
					where product_id = $product_id
					and product_type_id = $product_type_id
					and pst_id = $pst_id
					"
					;
		
        $query = $this->db->query($query);
     	// query();
       	$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['product_price']; 
    }
	
	function get_price($product_id = 0) {
		
		$query = "select a.* , b.product_type_name, c.pst_name
					from product_prices a
					join product_types b on b.product_type_id = a.product_type_id
					join product_sub_type c on c.pst_id = a.pst_id
					where product_id = $product_id
					order by product_type_id, a.pst_id desc
					"
					;
		
        $query = $this->db->query($query);
       // query();
        if ($query->num_rows() == 0)
            return array();

        $data = $query->result_array();

        foreach ($data as $index => $row) {
         	
        }
        return $data;
    }
	
	function get_insurance($product_id) {
		$query = "select insurance_id from products 
					where product_id = $product_id
					"
					;
		
        $query = $this->db->query($query);
     	// query();
       	$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['insurance_id']; 
    }
	
	function update($id, $items, $no)
	{
		$this->db->trans_start();
		
		$items_new = array();
		for($i=0; $i<$no; $i++)	
		{		
			$product_price_id = $items['subject_id'][$i];
			
			$items_new['product_price'] = $items['subject_value'][$i];
			
			$this->db->where('product_price_id', $product_price_id);
			$this->db->update('product_prices', $items_new);
			
		}
		
		$this->access->log_update($id, 'Edit Harga');
		$this->db->trans_complete();
		return $this->db->trans_status();

		return $this->db->trans_status();
	}
}
#
