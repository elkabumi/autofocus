<?php
class Spk_model extends CI_Model 
{
	var $trans_type = 2;
	var $insert_id = NULL;
	
	function __construct()
	{
		//parent::Model();
		//$this->sek_id = $this->access->sek_id;
	}
	
	function list_controller()
	{		
		$params 	= get_datatables_control();
		$limit 		= $params['limit'];
		$offset 	= $params['offset'];
		$category 	= $params['category'];
		$keyword 	= $params['keyword'];
		
		// map value dari combobox ke table
		// daftar kolom yang valid
		$columns['code'] = 'product_cat_code';
		$columns['name'] = 'product_cat_name';
		$columns['note'] = 'product_cat_description';
		
		$sort_column_index	= $params['sort_column'];
		$sort_dir		= $params['sort_dir'];
		
		$order_by_column[] = 'product_cat_id';
		$order_by_column[] = 'product_cat_code';
		$order_by_column[] = 'product_cat_name';
		$order_by_column[] = 'product_cat_description';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		
		$this->db->start_cache();			
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			$this->db->like($columns[$category], $keyword);
		}
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('product_categories'); 

		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];		
		
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1);
		//$this->db->order_by('market_id ASC');
		$this->db->order_by($order_by);
		// bila menggunakan paging gunakan limiter dan offseter
		if ($limit > 0) $this->db->limit($limit, $offset);
		$query = $this->db->get('product_categories');
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$kode = $row['product_cat_id'];
			
			$row = format_html($row);
			
			$data[] = array(
				$row['product_cat_id'], 
				$row['product_cat_code'], 
				$row['product_cat_name'], 
				$row['product_cat_description']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	function read_id($id)
	{
		$this->db->select('a.*,b.*,c.customer_name,d.insurance_name,d.insurance_addres,e.stand_name,e.stand_address,f.car_model_merk,f.car_model_name', 1); // ambil seluruh data
		$this->db->join('cars b','b.car_id = a.car_id');
		$this->db->join('customers c','c.customer_id = a.customer_id','LEFT');
		$this->db->join('insurances d','d.insurance_id = a.insurance_id','LEFT');
		$this->db->join('stands e','e.stand_id = a.stand_id');
		$this->db->join('car_models f','f.car_model_id = b.car_model_id');
		$this->db->where('registration_id', $id);
		$query = $this->db->get('registrations a', 1); // parameter limit harus 1
		//query($query);
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}
	function delete($id)
	{
		$this->db->trans_start();
		$this->db->where('product_cat_id', $id);
		$this->db->delete('registration_items');
		$this->db->where('product_cat_id', $id); // data yg mana yang akan di delete
		$this->db->delete('product_categories');
	
		$this->access->log_delete($id, 'Produk Kategori');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	function create($data, $items)
	{
		$this->db->trans_start();
		$this->db->insert('registrations', $data);
		$id = $this->db->insert_id();
		
		//Insert items
		$index = 0;
		foreach($items as $row)
		{			
			$row['registration_id'] = $id;
			$this->db->insert('detail_registrations', $row);
			
			
			$index++;
		}
		
		$this->insert_id = $id;
		
		//create registration
		//$this->insert_registration($id, $data);
		
		$this->access->log_insert($id, 'Penjualan User');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}// end of function 
	function update($id, $data, $items)
	{
		$this->db->trans_start();
		$this->db->where('product_cat_id', $id); // data yg mana yang akan di update
		$this->db->update('product_categories', $data);
		
		//Insert items
		$this->db->where('product_cat_id', $id);
		$this->db->delete('registration_items');
		$index = 0;
		foreach($items as $row)
		{			
			$row['product_cat_id'] = $id;
			$this->db->insert('registration_items', $row); 
			$index++;
		}
		
		$this->access->log_update($id, 'Kategori produk');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function insert_registration($data_id, $datatrans, $update_mode = 0) {
	$id = 0;

	if ($update_mode) {
	    $query = $this->db->get_where('registrations_sl', array('registration_data_id' => $data_id, 'registration_type_id' => $this->trans_type), 1);
	    if ($query->num_rows() > 0) {
		$row = $query->row_array();
		$id = $row['registration_id'];
		//update registration
		$data['registration_date'] = $datatrans['registration_date'];
		$data['registration_description'] = $datatrans['registration_description'];
		$this->db->update('registrations_sl', $data, array('registration_id' => $id));
		$this->db->where('registration_id', $id);
		$this->db->delete('journals_sl');
	    }
	    else
		$update_mode = 0;
	}
	if (!$update_mode) {
	    $data['registration_date'] = $datatrans['registration_date'];
	    $data['registration_description'] = $datatrans['registration_description'];
	    $data['registration_type_id'] = $this->trans_type;
	    $data['registration_code'] = $datatrans['registration_code'];
	    $data['registration_data_id'] = $data_id;
	    $data['period_id'] = $datatrans['period_id'];
	    $this->db->insert('registrations_sl', $data);
	    $id = $this->db->insert_id();
		//$this->db->update('registrations_sl', array('registration_data_id' => $id), array('registration_id' => $id));
	}
	if ($id == 0)
	    return;
	$index = 0;

	$i = 0;
	$journal_items['registration_id'] = $id;
	$journal_items['market_id'] =  $datatrans['stand_id'];
	
	//pembayaran cash
	if($datatrans['registration_payment_method_id'] == 1){
	
	$debit = 3; $kredit = 30;
	
	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = $datatrans['registration_final_total_price'];
	$journal_items['journal_credit'] = 0;
	$journal_items['coa_id'] = $debit;
	$this->db->insert('journals_sl', $journal_items);
	
	if($datatrans['registration_sent_price'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['registration_description'];
		$journal_items['journal_debit'] = 0;
		$journal_items['journal_credit'] = $datatrans['registration_sent_price'];
		$journal_items['coa_id'] = 32;
		$this->db->insert('journals_sl', $journal_items);
	}

	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = 0;
	$journal_items['journal_credit'] = $datatrans['registration_total_price'];
	$journal_items['coa_id'] = $kredit;
	$this->db->insert('journals_sl', $journal_items);
	
	//pembayaran kredit
	}else if($datatrans['registration_payment_method_id'] == 2){
		$debit = 8; $kredit = 30;
	
	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = $datatrans['registration_final_total_price'] - $datatrans['registration_down_payment'];
	$journal_items['journal_credit'] = 0;
	$journal_items['coa_id'] = $debit;
	$this->db->insert('journals_sl', $journal_items);
	
	if($datatrans['registration_down_payment'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['registration_description'];
		$journal_items['journal_debit'] = $datatrans['registration_down_payment'];
		$journal_items['journal_credit'] = 0;
		$journal_items['coa_id'] = 3;
		$this->db->insert('journals_sl', $journal_items);
	}
	
	if($datatrans['registration_sent_price'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['registration_description'];
		$journal_items['journal_debit'] = 0;
		$journal_items['journal_credit'] = $datatrans['registration_sent_price'];
		$journal_items['coa_id'] = 32;
		$this->db->insert('journals_sl', $journal_items);
	}

	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = 0;
	$journal_items['journal_credit'] = $datatrans['registration_total_price'];
	$journal_items['coa_id'] = $kredit;
	$this->db->insert('journals_sl', $journal_items);
	
	}else{
	
	$debit = 5; $kredit = 30;
	
	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = $datatrans['registration_final_total_price'];
	$journal_items['journal_credit'] = 0;
	$journal_items['coa_id'] = $debit;
	$this->db->insert('journals_sl', $journal_items);
	
	if($datatrans['registration_sent_price'] > 0){
		$journal_items['journal_index'] = $i++;
		$journal_items['journal_description'] = $datatrans['registration_description'];
		$journal_items['journal_debit'] = 0;
		$journal_items['journal_credit'] = $datatrans['registration_sent_price'];
		$journal_items['coa_id'] = 32;
		$this->db->insert('journals_sl', $journal_items);
	}

	$journal_items['journal_index'] = $i++;
	$journal_items['journal_description'] = $datatrans['registration_description'];
	$journal_items['journal_debit'] = 0;
	$journal_items['journal_credit'] = $datatrans['registration_total_price'];
	$journal_items['coa_id'] = $kredit;
	$this->db->insert('journals_sl', $journal_items);
		
	}
	
		return $id;
    }
	
	function detail_list_loader($id)
	{
		// buat array kosong
		$result = array(); 		
		$this->db->select('a.*, b.product_stock_id, c.product_code, c.product_name', 1);
		$this->db->from('registration_details a');
		$this->db->join('product_stocks b', 'b.product_id = a.product_id and price_id = 1');
		$this->db->join('products c','c.product_id = a.product_id');
		
		$this->db->where('a.registration_id', $id);
		$query = $this->db->get(); debug();
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
	
	function load_product_price($id)
	{
		$sql = "
			select a.*, b.product_code, b.product_name, c.product_type_name, d.pst_name
		from product_prices a
		join products b on b.product_id = a.product_id
		join product_types c on c.product_type_id = a.product_type_id
		join product_sub_type d on d.pst_id = a.pst_id
		where a.product_price_id = '$id'
		";
		
		
		$query = $this->db->query($sql); 
		//query();	
		return $query;
	}
	
	function check_stock($id)
	{
		$sql = "select product_stock_qty from product_stocks
				where product_stock_id = '$id'
				";
		
		$query = $this->db->query($sql);
		
		$result = null;
		foreach ($query->result_array() as $row) $result = format_html($row);
		return $result['product_stock_qty'];
	}
	
	function get_data_product($id)
	{
		$sql = "	select b.product_code, b.product_name, c.product_type_name, d.pst_name
		from product_prices a
		join products b on b.product_id = a.product_id
		join product_types c on c.product_type_id = a.product_type_id
		join product_sub_type d on d.pst_id = a.pst_id
		where a.product_price_id = '$id'
				";
		
		$query = $this->db->query($sql);
		
		$result = null;
		foreach ($query->result_array() as $row) $result = format_html($row);
		return array($result['product_code'], $result['product_name'], $result['product_type_name'], $result['pst_name']);
	}
	
	function get_data_detail($id) {
		
		$query = "SELECT a . * , b.product_name
					FROM detail_registrations a
					JOIN product_prices d ON d.product_price_id = a.product_price_id
					JOIN products b ON b.product_id = d.product_id
					
					WHERE registration_id = '$id'
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
	
	function get_data_sperpart($id) {
		
		$query = "SELECT *
					FROM registration_spareparts
					WHERE registration_id = '$id'
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
	
	
	function get_purchase_price($id)
	{
		$sql = "select product_purchase_price
				from products
				where product_id = '$id'
				";
		
		$query = $this->db->query($sql);
		
		$result = null;
		foreach ($query->result_array() as $row) $result = format_html($row);
		return $result['product_purchase_price'];
	}
	
	function get_old_stock($id)
	{
		$sql = "select product_stock_qty
				from product_stocks
				where product_stock_id = '$id'
				";
		
		$query = $this->db->query($sql);
	//	query();
		$result = null;
		foreach ($query->result_array() as $row) $result = format_html($row);
		return $result['product_stock_qty'];
	}
	

}
#
