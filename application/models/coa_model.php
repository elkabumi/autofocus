<?php
class coa_model extends CI_Model 
{
	function __construct()
	{
		//parent::Model();
		//$this->sek_id = $this->access->sek_id;
	}
	
	function _coa_renderer($data)
	{
	
		return format_html($data);
		
	}// end of function 
	function coa_list_controller($param)
	{
	
		$limit			= $param['limit'];
		$offset			= $param['offset'];
		$category		= $param['category'];
		$keyword		= $param['keyword'];
	
		$column['account_num']	= 'coa_hierarchy';
		$column['account_name']	= 'coa_name';
		$column['account_grup']	= 'coa_group';
		
		# order define columns start
		$sort_column_index	= $param['sort_column'];
		$sort_dir			= $param['sort_dir'];
		
		$order_by_column[] = 'coa_hierarchy';
		$order_by_column[] = 'coa_hierarchy';
		$order_by_column[] = 'coa_name';
		$order_by_column[] = 'coa_group';
		$order_by_column[] = 'coa_type';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;

		if(array_key_exists($category,$column) && strlen($keyword)>0)
		{
		
			$this->db->start_cache();
			$this->db->like($column[$category],$keyword);
			$this->db->stop_cache();
		
		}// end if
	
		$this->db->select('count(1) AS total',1);
		$query 	= $this->db->get('coas');
		
		$row 	= $query->row_array();
		$total 	= $row['total'];
		$this->db->select('*',1);
		$this->db->order_by($order_by);
		
		$query = $this->db->get('coas', $limit, $offset);
		// echo $this->db->last_query();exit;
		
		$data = array(); 
		
		$tempGroup = '';
		$index = 0 ; 
		foreach($query->result_array() as $row)
		{

			if($index==0)
			{
				if($row['coa_level']!='1')
				{
					$tempGroup = $this->get_groupName($row['coa_group']);
				}
			}
			$kode = $row['coa_id'];
			$coa_type = 'General' ;
			
			//setting group 
			if($row['coa_type']=='0')
			{
				$coa_type = 'Detail' ;
			}// end of if 
			
			// setting name
			$coa_name = '';
			
			for($i=0; $i<$row['coa_level']-1; $i++ )
			{
				
				$coa_name .= '&nbsp;&nbsp;';
				
			}// end for adding indent 
			
			if($row['coa_type']=='0')
			{
				$coa_name .= '*&nbsp;';
			}// end if 
			
			// $level = explode(".",trim($row['coa_hierarchy']));
			if($row['coa_level']=='1')
			{
				$tempGroup = $row['coa_name'];
			}// end of if 
			
			$coa_name .= $row['coa_name'] ;
			$row = $this->_coa_renderer($row);
			$data[]	= array(
				$row['coa_id'],
				$row['coa_hierarchy'],
				$coa_name ,
				$tempGroup,
				$coa_type
			);
			$index += 1 ; 
		}// end foreach
		
		return make_datatables_control($param, $data, $total);
	}// end function
	
	function get_groupName($coa_group)
	{
		$this->db->select('coa_name AS group_name');
		$this->db->from('coas');
		$this->db->where('coa_group', $coa_group);
		$this->db->where('coa_level','1');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$row = $query->row_array();
		if($row)$group_name = $row['group_name'];
		else $group_name = '';	
		
		return $group_name ;
	}

	function coa_read_id($id)
	{		
		$this->db->select('a.*, b.coa_name as account_type_name, c.coa_name as sub_account_name, c.coa_code as parent_coa_code', 1); // ambil seluruh data
		$this->db->join('coas b','b.coa_id = a.coa_account_type','left');
		$this->db->join('coas c','c.coa_id = a.parent_coa_id','left');
		$this->db->where('a.coa_id', $id);
		$query = $this->db->get('coas a', 1); // parameter limit harus 1
 		//query();
		$result = null; 
		foreach($query->result_array() as $row)	$result = $this->_coa_renderer($row);
		return $result; 
	}// end of function 
	
	function coa_read_hierarchy($keyword)
	{
		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('coa_hierarchy', $keyword);
		$query = $this->db->get('coas', 1); // parameter limit harus 1
		
		/**
		echo $this->db->last_query();
		exit;
		**/
		
		$result = null; 
		foreach($query->result_array() as $row)	$result = $this->_coa_renderer($row);
		return $result; 
		
	}// end of function 
	
	function coa_read_id_n_hierarchy($id, $hierarchy)
	{
		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('coa_id', $id);
		$this->db->where('coa_hierarchy', $hierarchy);
		$query = $this->db->get('coas', 1); // parameter limit harus 1
		
		/**
		echo $this->db->last_query();
		exit;
		**/
		
		$result = null; 
		foreach($query->result_array() as $row)	$result = $this->_coa_renderer($row);
		return $result; 
		
	}// end of function 
	
	function coa_read_hierarchy_update($id, $hierarchy)
	{
		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('coa_id !=', $id);
		$this->db->where('coa_hierarchy', $hierarchy);
		$query = $this->db->get('coas', 1); // parameter limit harus 1
		//query();
		/**
		echo $this->db->last_query();
		exit;
		**/
		
		$result = null; 
		foreach($query->result_array() as $row)	$result = $this->_coa_renderer($row);
		return $result; 
		
	}// end of function 	
	function coa_read_hierarchy_create($hierarchy)
	{
		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('coa_hierarchy', $hierarchy);
		$query = $this->db->get('coas', 1); // parameter limit harus 1
		
		/**
		echo $this->db->last_query();
		exit;
		**/
		
		$result = null; 
		foreach($query->result_array() as $row)	$result = $this->_coa_renderer($row);
		return $result; 
		
	}// end of function 	
	
	function coa_read_name($keyword)
	{
		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('coa_name', $keyword);
		$query = $this->db->get('coas', 1); // parameter limit harus 1
		$result = null; 
		foreach($query->result_array() as $row)	$result = $this->_coa_renderer($row);
		return $result; 
		
	}// end of function 
	
	function is_coa_detail($id)
	{
	
		$this->db->select('coa_type',1);
		$this->db->where('coa_id',$id);
		$this->db->where('coa_type','0');
		$query = $this->db->get('coas', 1); // parameter limit harus 1
		// echo $this->db->last_query();
		// exit;
		$result = null ; 
		foreach($query->result_array() as $row)	$result = $this->_coa_renderer($row);
		
		if(!empty($result))
		{
			return true;
		}// end if
		
		return false;
		
	}// end of function 
	
	function coa_create($data, $parent_coa_id)
	{
	
		$this->db->trans_start();
		$this->db->insert('coas', $data);
		// echo $this->db->last_query();exit ; 
		$coa_id 	= $this->db->insert_id();
		
		$data_parent['coa_type'] = '1';
		$this->db->where('coa_id', $parent_coa_id); // data yg mana yang akan di update
		$this->db->update('coas', $data_parent); //echo $this->db->last_query();exit ;
			
		$this->db->trans_complete();
		
		if($this->db->trans_status())
		{
			$this->access->log_insert($coa_id, 'Pengelompokan Akun');
		}
		return $this->db->trans_status();
		
	}// end of function 
	
	function coa_update($id, $data)
	{
	
		$this->db->trans_start();
		$this->db->where('coa_id', $id); // data yg mana yang akan di update
		$this->db->update('coas', $data); //echo $this->db->last_query();exit ;
		$this->db->trans_complete();
		if($this->db->trans_status()){
			$this->access->log_update($id, 'Pengelompokan Akun Revisi');
		}
		return $this->db->trans_status();
		
	}// end of function 
	
	function coa_parent_edit($id)
	{
	
		$this->db->trans_start();
		$data['coa_type'] = 0;
		$this->db->where('coa_id', $id); // data yg mana yang akan di update
		$this->db->update('coas', $data); //echo $this->db->last_query();exit ;
		$this->db->trans_complete();
		
		return $this->db->trans_status();
		
	}// end of function 
	
	function coa_delete($id)
	{
	
		$this->db->trans_start();
		$this->db->where('coa_id', $id); // data yg mana yang akan di update
		$this->db->delete('coas');
		// echo $this->db->last_query();
		// exit ;
		
		
		$this->db->trans_complete();
		if($this->db->trans_status())
		{
			$this->access->log_update($id,'Pengelompokan Akun Hapus');
		}
		return $this->db->trans_status();
		
	}// end of function 
	
	function is_coa_hierarchy_exist($hierarchy)
	{
		
		$this->db->select('count(1) AS total',1);
		$query 	= $this->db->get('coas');
		$row 	= $query->row_array();
		$total 	= $row['total'];
	
		if($total > 0)
		{
			return true; 
		}
		return false ; 
		
	}// end of function 
	
	function _group_renderer($data)
	{
		return format_html($data);
	}// end of function
	
	
	function _lookup_renderer($data)
	{
	
		return format_html($data);
		
	}// end of function 
	
	function coa_lookup_list_control($param)
	{
	
		// map parameter ke variable biasa agar mudah digunakan
		$limit = $param['limit'];
		$offset = $param['offset'];
		$category = $param['category'];
		$keyword = $param['keyword'];
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('coas'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
	
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data				
		$this->db->order_by('coa_hierarchy ASC');
		$query = $this->db->get('coas', $limit, $offset);
	
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$kode = $row['coa_id'];
			$row = $this->_group_renderer($row);
			
			$data[] = array(
				$row['coa_id'], 
				$row['coa_hierarchy'], 
				$row['coa_name']
			); 
		}// end of foreach
		
		return make_datatables_control($param, $data, $total);
		
	}// end of function 
	
	function lookup_read_id($id)
	{
	
		$query = $this->db->get_where('coas', array('coa_id'=>$id),1);
		$result = null ; 
		foreach($query->result_array() as $row) $result = $row ;
		return $result ; 
	
	}//end of function 
	
	function coa_read_parent_id($parent)
	{
		$this->db->select('coa_code');
		$this->db->select('coa_hierarchy');
		$this->db->select('coa_group');
		$this->db->select('coa_level');
		$this->db->select('coa_type');
		$this->db->from('coas');
		$this->db->where('coa_id', $parent);
		$query 			= $this->db->get();
		
		$result 		= null ; 
		foreach($query->result_array() as $row) $result=$row ; 
		return $result ; 
	}// end of functio n
	
	function coa_read_any_detail($parent_id)
	{
		$this->db->select('coa_code');
		$this->db->select('coa_hierarchy');
		$this->db->select('coa_group');
		$this->db->select('coa_level');
		$this->db->select('coa_type');
		$this->db->from('coas');
		$this->db->where('parent_coa_id', $parent_id);
		$query 			= $this->db->get();
		
		$result 		= null ; 
		foreach($query->result_array() as $row) $result=$row ; 
		return $result ; 
	}// end of functio n
	
	
	function coa_generate_code($parent_id,$level)
	{
		$this->db->select('COUNT(*) AS total',1);
		$this->db->from('coas');
		$this->db->where('parent_coa_id', $parent_id);
		$this->db->where('coa_level', $level);		
		$query = $this->db->get();
		
		$row = $query->row_array();
		$total = $row['total'];
		
		if($total > 0)
		{
			return $total + 1; 
		}
		else
		{
			return 0 + 1; 
		}
	}
	
	function get_data_coa($id)
	{
		$this->db->select('*');
		$this->db->where('coa_id', $id);
		$query = $this->db->get('coas'); debug();	
		//query();
		return $query;
		
	}
	
	function get_coa_level($coa_id)
	{
		$this->db->select('coa_level');
		$this->db->where('coa_id', $coa_id);
		$query = $this->db->get('coas'); debug();	
		//query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['coa_level'];
		
	}
	
	function get_coa_code($coa_id)
	{
		$sql = "select max(coa_code) as coa_code_new from coas where parent_coa_id = $coa_id
				";
		$query = $this->db->query($sql);
		//query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['coa_code_new'];
		
	}
	function get_coa_code2($coa_id)
	{
		$sql = "select max(coa_code) as coa_code_new from coas where parent_coa_id = $coa_id and coa_code <> '.99'";
		$query = $this->db->query($sql);
		//query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['coa_code_new'];
		
	}
	
	
	function cek_data_parent($id, $parent_id)
	{
		$sql = "select parent_coa_id from coas where parent_coa_id  = $parent_id and coa_id <> $id
				";
		
		$query = $this->db->query($sql);
		//query();
		if ($query->num_rows() > 0)
		{		
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function get_data_parent($coa_id)
	{
		$sql = "select parent_coa_id from coas where coa_id = '$coa_id'";
		$query = $this->db->query($sql);
		//query();
		$result = null ; 
		foreach($query->result_array() as $row)	$result = format_html($row);
		return $result['parent_coa_id'];
		
	}
	
}// end of class 
