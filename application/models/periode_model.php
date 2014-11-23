<?php

class Periode_model extends CI_Model 
{
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
		$columns['code'] 		= 'period_code';
		$columns['bulan'] 		= strval('period_month');
		$columns['tahun'] 		= strval('period_year');
		$columns['deskripsi'] 	= 'period_description';
		$columns['close']		= 'period_closed';
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		# order define columns start

		$order_by_column[] = 'period_id';
		$order_by_column[] = 'period_code';
		$order_by_column[] = 'period_month';
		$order_by_column[] = 'period_year';
		$order_by_column[] = 'period_description';
		$order_by_column[] = 'period_closed';
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		
		// check apakah parameter search dari client valid, bila tidak anggap ambil semua data
		$this->db->start_cache();			
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			// daftarkan kriteria search ke seluruh query
			$this->db->like($columns[$category], $keyword);
		}
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('periods'); 

		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1);
		$this->db->order_by($order_by);
		
		// bila menggunakan paging gunakan limiter dan offseter
		if ($limit > 0) $this->db->limit($limit, $offset);
		$query = $this->db->get('periods');
		
		#echo $this->db->last_query();
		
		$data = array();  // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) 
		{
		    if($row['period_month']==1)
			{
				$bulan 	= 'Januari';
			}
			elseif($row['period_month']==2)
			{
				$bulan 	= 'Februari';
			}
			elseif($row['period_month']==3)
			{
				$bulan 	= 'Maret';
			}
			elseif($row['period_month']==4)
			{
				$bulan 	= 'April';
			}
			elseif($row['period_month']==5)
			{
				$bulan 	= 'Mei';
			}
			elseif($row['period_month']==6)
			{
				$bulan 	= 'Juni';
			}
			elseif($row['period_month']==7)
			{
				$bulan 	= 'Juli';
			}
			elseif($row['period_month']==8)
			{
				$bulan 	= 'Agustus';
			}
			elseif($row['period_month']==9)
			{
				$bulan 	= 'September';
			}
			elseif($row['period_month']==10)
			{
				$bulan 	= 'Oktober';	
			}
			elseif($row['period_month']==11)
			{
				$bulan 	= 'November';	
			}
			elseif($row['period_month']==12)
			{
				$bulan 	= 'Desember';	
			}
			
			$closed								= ($row['period_closed']=="1")?'checked':'';
			
			$data[] = array
			(
				$row['period_id'], 
				$row['period_code'], 
				$row['period_month']." - ".$bulan."",
				$row['period_year'], 
				$row['period_description'],
				'<input type="checkbox" name="is_closed" '.$closed.' disabled="disabled"/>'
			); 
		}
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function delete($id)
	{
		$this->db->trans_start();
		$this->db->where('period_id', $id); // data yg mana yang akan di delete
		$this->db->delete('periods');
		$this->access->log_delete(1, 'Periode');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
	function create($data)
	{
		$this->db->trans_start();
	
		$this->db->insert('periods', $data);
		$id = $this->db->insert_id();
		//$this->access->log_insert(1, "Periode");
		
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
	function update($id, $data)
	{
		$this->db->trans_start();
		$this->db->where('period_id', $id); // data yg mana yang akan di update
		$this->db->update('periods', $data);
		$this->access->log_update(1, "Periode");
		
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
	function read_id($id)
	{
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('period_id', $id);
		$query = $this->db->get('periods', 1); // parameter limit harus 1
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}	
	
	function data_is_exist($period_month, $period_year)
	{
		$data = '';		
		$this->db->select('period_id',1);
		$this->db->where('period_month', $period_month);
		$this->db->where('period_year', $period_year);
		$this->db->from('periods');
		$query = $this->db->get();
		//query();
		
		if($query->num_rows>0)
		{
			return true;
		}else{
			return false;
		}
	}
}
