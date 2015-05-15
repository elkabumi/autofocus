<?php
class warehouse_paint_model extends CI_Model 
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
		
		$columns['nama_bahan'] 		= 'material_name';
		$columns['nama_cabang'] 	= 'stand_name';
		$columns['stock'] 		= 'material_stock_qty';
		
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'material_name';
		$order_by_column[] = 'stand_name';
		$order_by_column[] = 'material_stock_qty';
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{

				
					$where = " AND ".$columns[$category]." like '%$keyword%'";
				

		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		SELECT a.*,b.*,c.stand_name
			FROM material_stock  a
			JOIN materials b  ON a.material_id = b.material_id
			JOIN stands c ON c.stand_id = a.stand_id
			WHERE material_type_id = 2 $where $order_by 
			
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
				$row['material_stock_id'], 
				$row['material_name'], 
				$row['stand_name'],
				$row['material_stock_qty']
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
	
	
	function create($data){
		$this->db->trans_start();
		$this->db->insert('material_stock', $data);
		$id = $this->db->insert_id();
				
		$this->access->log_insert($id, "material stock [".$data['material_id']."]");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function update($id, $data){
		$this->db->trans_start();
		$this->db->where('material_stock', $id);
		$this->db->update('material_stock_id', $data);
		$this->access->log_update($id, "material stock [".$data['material_id']."]");
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	function delete($id){
		$this->db->trans_start();
		
		$this->db->where('material_stock_id', $id);
		$this->db->delete('material_stock_id');
		
		$this->access->log_delete($id, "material stock");
		$this->db->trans_complete();
		return $this->db->trans_status();
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
	function load_satuan($id)
	{
		$sql = "
		select b.unit_name 
		FROM materials a
		JOIN unit b ON a.unit_id = b.unit_id 
		 WHERE a.material_id = $id";
		$query = $this->db->query($sql);
		
		return $query;
	}function cek_gudang($material_id,$stand_id)
	{
		$sql = "SELECT COUNT(material_stock_id) AS id FROM material_stock WHERE material_id=".$material_id." AND stand_id=".$stand_id." ";
		$query = $this->db->query($sql);
		foreach($query->result_array() as $row)
		{
		
			$data['id'] 		= $row['id'];
		
			
		}
		return $data['id'];
	}
}
#
