<?php

class Permit_model extends CI_Model {

	function modules() {
		$query = $this->db->get('modules');
		if ($query->num_rows() == 0) return NULL;
		return $query->result_array();
	}
	
	function is_group_exists($group_id) {
		$query = $this->db->get_where('groups', array('group_id' => $group_id));
		if ($query->num_rows() == 0) return NULL;
		return $query->row_array();
	}
	
	function permits($group_id) {
	
		$this->db->join('modules m', 'm.module_id = p.permit_module_id');
		$query = $this->db->get_where('permits p', array('p.permit_group_id' => $group_id));
#		debug($this->db->last_query());
		if ($query->num_rows() == 0) return NULL;
		
		
		return $query->result_array();
	}
	
	function update($group_id, $modules_array) {
		
		$this->db->trans_start();
			$this->db->delete('permits', array('permit_group_id' => $group_id));
			
			foreach($modules_array as $module_item) {
				$data['permit_group_id'] = $group_id;
				$data['permit_module_id'] = $module_item['id'];
				$data['permit_crud_mode'] = $module_item['mode'];
				$this->db->insert('permits', $data);
				debug($this->db->last_query());			
			}
			
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
	function permit_list_controller($param)
	{
		$limit 		= $param['limit'];
		$offset 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];

		$columns['nama'] = 'group_name';
		
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		$order_by_column[] = 'group_id';
		$order_by_column[] = 'group_name';
		debug('ppp' . $sort_column_index);
		$order_by = $order_by_column[!$sort_column_index ? 0 : $sort_column_index] . $sort_dir;
		
		$this->db->start_cache();
		// check apakah parameter search dari client valid, bila tidak anggap ambil semua data
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			// daftarkan kriteria search ke seluruh query
			
			$this->db->like($columns[$category], $keyword);
			
			// bila query Anda tidak menggunakan ini, hapus dengan $this->db->flush_cache();
		}
		//$this->db->where('group_is_active', 'TRUE');
		$this->db->stop_cache();
	
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		
		$query	= $this->db->get('groups'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];		
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data		
		$this->db->order_by($order_by);
		$query = $this->db->get('groups', $limit, $offset);
		//query();
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$kode = $row['group_id'];
			
			$row = $this->_permit_renderer($row);
			
			$data[] = array(
				$row['group_id'], 
 				$row['group_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}

}

#
