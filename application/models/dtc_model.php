<?php

class Dtc_model extends CI_Model
{
	var $branch_id = 1;
	function __construct()
	{
		parent::__construct();
		$ci = & get_instance();
		if(isset($ci->access))$this->branch_id = $ci->access->branch_id;
		
	}
	
	function _cc_renderer($data)
	{
		return format_html($data);
	}
	
	## EMPLOYEE ##
	function _employee_renderer($data)
	{
		return format_html($data);
	}
	
	
	## EMPLOYEE User##
	function _employee_user_renderer($data)
	{
		return format_html($data);
	}
	
	function employee_user_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'a.employee_id';
		$order_by_column[] = 'a.employee_nip';
		//$order_by_column[] = 'a.employee_barcode_id';
		$order_by_column[] = 'a.employee_name';
		$order_by_column[] = 'b.employee_id';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		
		$column['p1']			= 'employee_nip';
		$column['p2']			= 'employee_name';
		//$column['p3']			= 'employee_barcode_id';
		
		
		$this->db->start_cache();
		$this->db->where('a.employee_active_status','1');
		$this->db->where('a.employee_id <> ', 1);
		
		if ($category)
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->from('employees a');	
		$this->db->join('users b','a.employee_id = b.employee_id','left');
		$query = $this->db->get();
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];		
		
		// proses query sesuai dengan parameter
		$this->db->select('a.*,a.employee_id as emp_id,b.*, b.employee_id as emp2_id'); // ambil seluruh data
		$this->db->from('employees a');	
		$this->db->join('users b','a.employee_id = b.employee_id','left');
		$this->db->limit($limit, $offset);
		$this->db->order_by($order_by);
		$query = $this->db->get();
		//query();
		//debug($this->db->last_query());
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			(empty($row['user_id']))?$status = "Belum Dibuat":$status = "Sudah Dibuat";
			$row = $this->_employee_renderer($row);
			
			$data[] = array(
				$row['emp2_id'] ? $row['emp2_id'] : $row['emp_id'], 
				//$row['employee_barcode_id'],
				$row['employee_nip'], 
				$row['employee_name'],
				$status
			);			
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function employee_user_get($id = 0, $mode = 1)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		
		$this->db->start_cache();
		$this->db->select('e.*', 1); // ambil seluruh data
	
		$this->db->stop_cache();
		
		if ($mode == 1)
			$query = $this->db->get_where('employees e', array('employee_id' => $id), 1);
		else
			$query = $this->db->get_where('employees e', array('employee_nip' => $id), 1);

		//log_message('error',$this->db->last_query());
		
		$result = NULL;
		foreach($query->result_array() as $row)	$result = $this->_employee_renderer($row); 
		
		return $result;
	}
	
	## COA ##
	function _coa_renderer($data)
	{
		return format_html($data);
	}

	
	function coa_control()
	{
		// map parameter ke variable biasa agar mudah digunakan
		$params 	= get_datatables_control();
		$limit 		= $params['limit'];
		$offset 	= $params['offset'];
		$category 	= $params['category'];
		$keyword 	= $params['keyword'];
		
		# order define columns start
		
		$order_by_column[] = 'coa_hierarchy';
		$order_by_column[] = 'coa_id';
		$order_by_column[] = 'coa_name';
		
		$sort_column_index		= $params['sort_column'];
		$sort_dir				= $params['sort_dir'];
		
		# order define column end
		
		$column['p1']			= 'coa_hierarchy';
		$column['p2']			= 'coa_name';
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		
		$this->db->start_cache();
		$this->db->where('coa_id <> ', 0);
		$this->db->where('coa_type', 0);
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			if ($category == 'p1') $this->db->like($column[$category], $keyword, 'after'); else $this->db->like($column[$category], $keyword);
			
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('coas'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data				
		$this->db->order_by($order_by);
		$query = $this->db->get('coas', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$kode = $row['coa_id'];
			$style = $row['coa_type'] == 0 ? 'coa_c1' : 'coa_c2';
			
			$row = $this->_cc_renderer($row);
			
			$tempIndent = '';
			$CCLevel 	= $row['coa_level'] - 1;
#			for($i=0; $i<$CCLevel ; $i++) $tempIndent .='. ';
					
#			$tempIndent .= '<span id="' . $style . '">' . $row['coa_name'] . '</span>';
			$tempIndent .=  $row['coa_name'];
			
			$data[] = array(
				$row['coa_id'],
				$row['coa_hierarchy'],
				$tempIndent
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function coa_get($id, $mode)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('coas', array('coa_id' => $id, 'coa_type' => 0), 1);
		else
			$query = $this->db->get_where('coas', array('coa_hierarchy' => $id, 'coa_type' => 0), 1);
		
		$result = NULL;		
		foreach($query->result_array() as $row)	$result = $this->_coa_renderer($row);
		
		return $result;
	}
	
	
	## COA 2 ##
	function coa2_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'coa_hierarchy';
		$order_by_column[] = 'coa_id';
		$order_by_column[] = 'coa_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'coa_hierarchy';
		$column['p2']			= 'coa_name';
		
		$this->db->start_cache();
		$this->db->where('coa_id <> ', 0);
		# $this->db->where('coa_type', 0);
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			if ($category == 'p1') $this->db->like($column[$category], $keyword, 'after'); else $this->db->like($column[$category], $keyword);
			
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('coas'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data				
		$this->db->order_by($order_by);
		$query = $this->db->get('coas', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$kode = $row['coa_id'];
			$style = $row['coa_type'] == 0 ? 'coa_c1' : 'coa_c2';
			
			$row = $this->_cc_renderer($row);

			
			$tempIndent = '';
			$CCLevel 	= $row['coa_level'] - 1;
			for($i=0; $i<$CCLevel ; $i++) $tempIndent .='. ';
					
			$tempIndent .= $row['coa_name'];
#			$tempIndent .=  $row['coa_name'];
			
			$data[] = array(
				$row['coa_id'],
				$row['coa_hierarchy'],
				$tempIndent
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function coa2_get($id, $mode)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('coas', array('coa_id' => $id), 1);
		else
			$query = $this->db->get_where('coas', array('coa_hierarchy' => $id), 1);
		
		$result = NULL;		
		foreach($query->result_array() as $row)	$result = $this->_coa_renderer($row);
		
		return $result;
	}

	## coa_account_type ##
	function coa_account_type_renderer($data)
	{
		return format_html($data);
	}

	
	function coa_account_type_control()
	{
		// map parameter ke variable biasa agar mudah digunakan
		$params 	= get_datatables_control();
		$limit 		= $params['limit'];
		$offset 	= $params['offset'];
		$category 	= $params['category'];
		$keyword 	= $params['keyword'];
		
		# order define columns start
		
		$order_by_column[] = 'coa_hierarchy';
		$order_by_column[] = 'coa_id';
		$order_by_column[] = 'coa_name';
		
		$sort_column_index		= $params['sort_column'];
		$sort_dir				= $params['sort_dir'];
		
		# order define column end
		
		$column['p1']			= 'coa_hierarchy';
		$column['p2']			= 'coa_name';
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		
		$this->db->start_cache();
		$this->db->where('coa_id <> ', 0);
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			if ($category == 'p1') $this->db->like($column[$category], $keyword, 'after'); else $this->db->like($column[$category], $keyword);
			
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->where('coa_level', 2);
		$query	= $this->db->get('coas'); 
		
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('coa_level', 2);				
		$this->db->order_by($order_by);
		$query = $this->db->get('coas', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$kode = $row['coa_id'];
			$style = $row['coa_type'] == 0 ? 'coa_c1' : 'coa_c2';
			
			$row = $this->_cc_renderer($row);
			
			$tempIndent = '';
			$CCLevel 	= $row['coa_level'] - 1;
#			for($i=0; $i<$CCLevel ; $i++) $tempIndent .='. ';
					
#			$tempIndent .= '<span id="' . $style . '">' . $row['coa_name'] . '</span>';
			$tempIndent .=  $row['coa_name'];
			
			$data[] = array(
				$row['coa_id'],
				$row['coa_hierarchy'],
				$tempIndent
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function coa_account_type_get($id, $mode)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('coas', array('coa_id' => $id), 1);
		else
			$query = $this->db->get_where('coas', array('coa_hierarchy' => $id), 1);
		
		$result = NULL;		
		foreach($query->result_array() as $row)	$result = $this->coa_account_type_renderer($row);
		
		return $result;
	}
	
	## Data Gedung
	function building_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'building_id';
		$order_by_column[] = 'building_code';
		$order_by_column[] = 'building_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'building_code';
		$column['p2']			= 'building_name';
		
		$this->db->start_cache();
		$this->db->where('building_id <> ', 0);
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('buildings'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data				
		$this->db->order_by($order_by);
		$query = $this->db->get('buildings', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$kode = $row['building_id'];
			
			$row = format_html($row);
			
			$data[] = array(
				$row['building_id'], 
				$row['building_code'], 
				$row['building_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function building_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('buildings', array('building_id' => $id), 1);
		else
			$query = $this->db->get_where('buildings', array('building_code' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}

	## Data workshop service
	function workshop_service_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'workshop_service_id';
		$order_by_column[] = 'workshop_service_name';
		$order_by_column[] = 'workshop_service_price';
		$order_by_column[] = 'workshop_service_job_price';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'workshop_service_name';
		
		$this->db->start_cache();
		$this->db->where('workshop_service_id <> ', 0);
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('workshop_services'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data				
		$this->db->order_by($order_by);
		$query = $this->db->get('workshop_services', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$row = format_html($row);
			
			$data[] = array(
				$row['workshop_service_id'], 
				$row['workshop_service_name'], 
				$row['workshop_service_price'],
				$row['workshop_service_job_price']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function workshop_service_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('workshop_services', array('workshop_service_id' => $id), 1);
		else
			$query = $this->db->get_where('workshop_services', array('workshop_service_name' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	
	## Data employee
	function employee_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'employee_id';
		$order_by_column[] = 'employee_nip';
		$order_by_column[] = 'employee_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'employee_nip';
		$column['p2']			= 'employee_name';
		
		$this->db->start_cache();
		
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->where('employee_id <> ', 11111);
		$query	= $this->db->get('employees'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('employee_id <> ', 11111);				
		$this->db->order_by($order_by);
		$query = $this->db->get('employees', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['employee_id'], 
				$row['employee_nip'], 
				$row['employee_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function employee_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('employees', array('employee_id' => $id), 1);
		else
			$query = $this->db->get_where('employees', array('employee_nip' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data employee
	function employee_group_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'employee_group_id';
		$order_by_column[] = 'employee_group_name';
		$order_by_column[] = 'employee_group_description';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'employee_group_name';
		$column['p2']			= 'employee_group_description';
		
		$this->db->start_cache();
		
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->where('employee_group_id <> ', 11111);
		$query	= $this->db->get('employee_groups'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('employee_group_id <> ', 11111);				
		$this->db->order_by($order_by);
		$query = $this->db->get('employee_groups', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['employee_group_id'], 
				$row['employee_group_name'], 
				$row['employee_group_description']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function employee_group_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('employee_groups', array('employee_group_id' => $id), 1);
		else
			$query = $this->db->get_where('employee_groups', array('employee_group_name' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data Transaction Type
	function transaction_type_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'transaction_type_id';
		$order_by_column[] = 'transaction_type_name';
		$order_by_column[] = 'transaction_type_priece';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'transaction_type_name';
		$column['p2']			= 'transaction_type_price';
		
		$this->db->start_cache();
		
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->where('transaction_type_id <> ', 11111);
		$query	= $this->db->get('transaction_types'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('transaction_type_id <> ', 11111);				
		$this->db->order_by($order_by);
		$query = $this->db->get('transaction_types', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['transaction_type_id'], 
				$row['transaction_type_name'], 
				$row['transaction_type_price']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function transaction_type_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('transaction_types', array('transaction_type_id' => $id), 1);
		else
			$query = $this->db->get_where('transaction_types', array('transaction_type_name' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data product_category
	function product_category_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'product_category_id';
		$order_by_column[] = 'product_category_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'product_category_name';
	
		$this->db->start_cache();
		
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('product_categories'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->order_by($order_by);
		$query = $this->db->get('product_categories', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['product_category_id'], 
				$row['product_category_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function product_category_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('product_categories', array('product_category_id' => $id), 1);
		else
			$query = $this->db->get_where('product_categories', array('product_category_name' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data product_type
	function product_type_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'product_type_id';
		$order_by_column[] = 'product_type_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'product_type_name';
	
		$this->db->start_cache();
		
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('product_types'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->order_by($order_by);
		$query = $this->db->get('product_types', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['product_type_id'], 
				$row['product_type_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function product_type_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('product_types', array('product_type_id' => $id), 1);
		else
			$query = $this->db->get_where('product_types', array('product_type_code' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data customer
	function customer_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		$where = '';
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'customer_id';
		$order_by_column[] = 'customer_ktp_number';
		$order_by_column[] = 'customer_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'customer_ktp_number';
		$column['p2']			= 'customer_name';
	
		$this->db->start_cache();
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $column) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$column[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select * from customers
		$where  $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['customer_id'], 
				$row['customer_ktp_number'],
				$row['customer_name']
			); 

		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function customer_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('customers', array('customer_id' => $id), 1);
		else
			$query = $this->db->get_where('customers', array('customer_ktp_number' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data mobil
	function car_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		$where = '';
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'car_id';
		$order_by_column[] = 'car_nopol';
		$order_by_column[] = 'car_model';
		$order_by_column[] = 'car_no_rangka';
		$order_by_column[] = 'car_no_machine';
		
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'car_nopol';
		$column['p2']			= 'car_no_rangka';
		$column['p3']			= 'car_no_machine';
	
		$this->db->start_cache();
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $column) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$column[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.*, concat(b.car_model_merk, ' - ', b.car_model_name) as car_model from cars a
		join car_models b on b.car_model_id = a.car_model_id
		$where  $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['car_id'], 
				$row['car_nopol'],
				$row['car_model'],
				$row['car_no_rangka'],
				$row['car_no_machine']
			); 

		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function car_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('cars', array('car_id' => $id), 1);
		else
			$query = $this->db->get_where('cars', array('car_nopol' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data model mobil
	function car_model_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		$where = '';
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'car_model_id';
		$order_by_column[] = 'car_model_merk';
		$order_by_column[] = 'car_model_name';
		
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'car_model_merk';
		$column['p2']			= 'car_model_name';
	
		$this->db->start_cache();
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $column) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$column[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select * from car_models
		$where  $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['car_model_id'], 
				$row['car_model_merk'],
				$row['car_model_name']
			); 

		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function car_model_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('car_models', array('car_model_id' => $id), 1);
		else
			$query = $this->db->get_where('car_models', array('car_model_merk' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}

		## Data active product
	function active_product_control($param, $cat_id = 0)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		$where = '';
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'product_id';
		$order_by_column[] = 'product_category_name';
		$order_by_column[] = 'product_code';
		$order_by_column[] = 'product_name';
		
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		
		$column['p1']			= 'product_name';
		$column['p2']			= 'product_code';
		$column['p3']			= 'product_category_name';
	
		$this->db->start_cache();
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $column) && strlen($keyword) > 0) 
		{
			
				$where = " and ".$column[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	
		
		if($cat_id){
			$where .= "and a.product_category_id = '$cat_id'";
		}
		
		$sql = "
		select a.*, c.product_category_name
		from products a
		join product_categories c on c.product_category_id = a.product_category_id
		where product_id > 0
		and product_active_status = 1
		$where  $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['product_id'], 
				$row['product_category_name'],
				$row['product_code'],
				$row['product_name']				
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function active_product_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1){
			
			$query = $this->db->get_where('products', array('product_id' => $id), 1);
		}else{
			$query = $this->db->get_where('products', array('product_code' => $id), 1);
		}
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
		## Data product price
	function product_price_control($param, $insurance_id = 0)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		$where = '';
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'product_price_id';
		$order_by_column[] = 'product_name';
		$order_by_column[] = 'product_type_name';
		$order_by_column[] = 'pst_name';
		$order_by_column[] = 'product_price';
		
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		
		$column['p1']			= 'product_name';
	
		$this->db->start_cache();
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $column) && strlen($keyword) > 0) 
		{
			
				$where = " and ".$column[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	
		
		if($insurance_id){
			$where .= " and b.insurance_id = '$insurance_id'";
		}else{
			$where .= " and b.insurance_id = '1'";
		}
		
		$sql = "
		select a.*, b.product_name, c.product_type_name, d.pst_name
		from product_prices a
		join products b on b.product_id = a.product_id
		join product_types c on c.product_type_id = a.product_type_id
		join product_sub_type d on d.pst_id = a.pst_id
		where a.product_id > 0
		and product_active_status = 1
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
				$row['product_price_id'], 
				$row['product_name'],
				$row['product_type_name'],
				$row['pst_name'],
				$row['product_price']				
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function product_price_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1){
			
			$sql = "
		select a.*, b.product_name, c.product_type_name, d.pst_name
		from product_prices a
		join products b on b.product_id = a.product_id
		join product_types c on c.product_type_id = a.product_type_id
		join product_sub_type d on d.pst_id = a.pst_id
		where a.product_price_id = '$id'
		
			
			";

		
		
		$query = $this->db->query($sql);
		//query();
		
		}else{
			$query = $this->db->get_where('product_prices', array('product_code' => $id), 1);
		}
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data produk
	function product_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		$where = '';
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'product_id';
		$order_by_column[] = 'product_code';
		$order_by_column[] = 'product_name';
		$order_by_column[] = 'product_type_name';
		$order_by_column[] = 'product_category_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'product_code';
		$column['p2']			= 'product_name';
		$column['p3']			= 'product_type_name';
		$column['p4']			= 'product_category_name';
	
		$this->db->start_cache();
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $column) && strlen($keyword) > 0) 
		{
			
				$where = " where ".$column[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.*, b.product_type_name, c.product_category_name 
		from products a
		join product_types b on b.product_type_id = a.product_type_id
		join product_categories c on c.product_category_id = a.product_category_id
		$where  $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['product_id'], 
				$row['product_code'],
				$row['product_name'],
				$row['product_type_name'],
				$row['product_category_name']
			); 

		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function product_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('products', array('product_id' => $id), 1);
		else
			$query = $this->db->get_where('products', array('product_code' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}


	## Data stand
	function stand_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'stand_id';
		$order_by_column[] = 'stand_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'stand_name';
	
		$this->db->start_cache();
		
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('stands'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->order_by($order_by);
		$query = $this->db->get('stands', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['stand_id'], 
				$row['stand_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function stand_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('stands', array('stand_id' => $id), 1);
		else
			$query = $this->db->get_where('stands', array('stand_name' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
		## Data salesman
	function salesman_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'salesman_id';
		$order_by_column[] = 'salesman_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'salesman_code';
		$column['p2']			= 'salesman_name';
		
		$this->db->start_cache();
		
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->where('salesman_status', 1);
		$query	= $this->db->get('salesmans'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('salesman_status', 1);
		$this->db->order_by($order_by);
		$query = $this->db->get('salesmans', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['salesman_id'], 
				$row['salesman_code'],
				$row['salesman_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function salesman_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('salesmans', array('salesman_id' => $id), 1);
		else
			$query = $this->db->get_where('salesmans', array('salesman_name' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data vendor
	function vendor_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'vendor_id';
		$order_by_column[] = 'vendor_code';
		$order_by_column[] = 'vendor_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'vendor_code';
		$column['p2']			= 'vendor_name';
		
		$this->db->start_cache();
		
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->where('vendor_status', 1);
		$query	= $this->db->get('vendors'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('vendor_status', 1);
		$this->db->order_by($order_by);
		$query = $this->db->get('vendors', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['vendor_id'], 
				$row['vendor_code'],
				$row['vendor_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function vendor_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('vendors', array('vendor_id' => $id), 1);
		else
			$query = $this->db->get_where('vendors', array('vendor_name' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data periode
	function period_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'period_id';
		$order_by_column[] = 'period_month';
		$order_by_column[] = 'period_year';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'period_code';
		$column['p2']			= 'period_month';
		$column['p3']			= 'period_year';
		
		$this->db->start_cache();
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('periods'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data				
		$this->db->order_by($order_by);
		$query = $this->db->get('periods', $limit, $offset);
			
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
		
			$status = 	($row['period_closed']=='1') ? "Aktif" : "Tidak Aktif";
		
			$row = format_html($row);
			
			$data[] = array(
				$row['period_id'], 
				$row['period_month']."/".$row['period_year'], 
				$status
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function period_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('periods', array('period_id' => $id), 1);
		else
			$query = $this->db->get_where('periods', array('period_name' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data Cabang
	function market_control($param, $id)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'market_id';
		$order_by_column[] = 'market_code';
		$order_by_column[] = 'market_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'market_code';
		$column['p2']			= 'market_name';
		
		$this->db->start_cache();
		$this->db->where('market_id <> ', 0);
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		
		if($id && $id!=9)
		$this->db->where('branch_id', $id);
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('markets'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data				
		$this->db->order_by($order_by);
		$query = $this->db->get('markets', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$kode = $row['market_id'];
			
			$row = format_html($row);
			
			$data[] = array(
				$row['market_id'], 
				$row['market_code'], 
				$row['market_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function market_get($id, $mode)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		if ($mode == 1)
			$query = $this->db->get_where('markets', array('market_id' => $id), 1);
		else
			$query = $this->db->get_where('markets', array('market_code' => $id), 1);
		
		$result = NULL;		
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
		## Data jabatan
	function employee_position_control($param, $id)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'employee_position_id';
		$order_by_column[] = 'employee_position_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p2']			= 'employee_position_name';
		
		$this->db->start_cache();
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		
		$this->db->stop_cache();
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('employee_positions'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data				
		$this->db->order_by($order_by);
		$query = $this->db->get('employee_positions', $limit, $offset);
		
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$row = format_html($row);
			
			$data[] = array(
				$row['employee_position_id'], 
				$row['employee_position_name']
				
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function employee_position_get($id, $mode)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		if ($mode == 1)
			$query = $this->db->get_where('employee_positions', array('employee_position_id' => $id), 1);
		else
			$query = $this->db->get_where('employee_positions', array('employee_position_name' => $id), 1);
		
		$result = NULL;		
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
		## Data phase
	function phase_control($param, $id)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'phase_id';
		$order_by_column[] = 'phase_code';
		$order_by_column[] = 'phase_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p2']			= 'phase_name';
		
		$this->db->start_cache();
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		
		$this->db->stop_cache();
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('phase'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data				
		$this->db->order_by($order_by);
		$query = $this->db->get('phase', $limit, $offset);
		
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$row = format_html($row);
			
			$data[] = array(
				$row['phase_id'], 
				$row['phase_code'], 
				$row['phase_name']
				
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function phase_get($id, $mode)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		if ($mode == 1)
			$query = $this->db->get_where('phase', array('phase_id' => $id), 1);
		else
			$query = $this->db->get_where('phase', array('phase_name' => $id), 1);
		
		$result = NULL;		
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
		## Data project
	function project_control($param, $id)
	{
		$where = '';
		$params 	= get_datatables_control();
		$limit 		= $params['limit'];
		$offset 	= $params['offset'];
		$category 	= $params['category'];
		$keyword 	= $params['keyword'];
		
		// map value dari combobox ke table
		// daftar kolom yang valid
		
		$columns['p1'] 			= 'project_code';
		$columns['p2'] 			= 'project_name';
		
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'project_id';
		$order_by_column[] = 'project_code';
		$order_by_column[] = 'project_name';
	
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " and ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.*
		from projects a
		
		where project_active_status = 1
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
				$row['project_id'], 
				$row['project_code'],
				$row['project_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function project_get($id, $mode)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		if ($mode == 1)
			$query = $this->db->get_where('projects', array('project_id' => $id), 1);
		else
			$query = $this->db->get_where('projects', array('project_name' => $id), 1);
		
		$result = NULL;		
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
		## Data po_received
	function po_received_control($param, $active = 0)
	{
		$where = '';
		$params 	= get_datatables_control();
		$limit 		= $params['limit'];
		$offset 	= $params['offset'];
		$category 	= $params['category'];
		$keyword 	= $params['keyword'];
		
		// map value dari combobox ke table
		// daftar kolom yang valid
		
		$columns['p1'] 			= 'phase_name';
		$columns['p2'] 			= 'project_name';
		$columns['p3']			= 'transaction_code';
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'transaction_id';
		$order_by_column[] = 'phase_name';
		$order_by_column[] = 'transaction_code';
		$order_by_column[] = 'product_category_name';
		
		$order_by_column[] = 'project_name';
		
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " and ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	
		
		if($active == 1){
			$where .= " and transaction_active_status = 1 ";
		}

		$sql = "
		select a.*, b.project_name, c.phase_name, d.product_category_name
		from transactions a
		join projects b on b.project_id = a.project_id
		join phase c on c.phase_id = a.phase_id
		join product_categories d on d.product_category_id = a.transaction_product_category_id
		where transaction_type_id = '1'
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
				$row['transaction_id'], 
				$row['phase_name'],
				$row['transaction_code'],
				$row['product_category_name'],
				$row['project_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function po_received_get($id, $mode)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		if ($mode == 1)
			$query = $this->db->get_where('transactions', array('transaction_id' => $id), 1);
		else
			$query = $this->db->get_where('transactions', array('transation_code' => $id), 1);
		
		$result = NULL;		
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
		## Data po_reservation
	function po_reservation_control($param, $active = 0)
	{
		$where = '';
		$params 	= get_datatables_control();
		$limit 		= $params['limit'];
		$offset 	= $params['offset'];
		$category 	= $params['category'];
		$keyword 	= $params['keyword'];
		
		// map value dari combobox ke table
		// daftar kolom yang valid
		
		$columns['p1'] 			= 'phase_name';
		$columns['p2'] 			= 'f.site_code';
		$columns['p3']			= 'e.transaction_code';
		$columns['p4']			= 'a.transaction_code';
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'transaction_id';
		$order_by_column[] = 'phase_name';
		$order_by_column[] = 'transaction_code_received';
		$order_by_column[] = 'transaction_code';
		$order_by_column[] = 'product_category_name';
		
		$order_by_column[] = 'Site_id';
		
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " and ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	
		
		if($active == 1){
			$where .= " and e.transaction_active_status = 1 ";
		}

		$sql = "
		select a.*, b.project_name, c.phase_name, d.product_category_name, e.transaction_code as transaction_code_received,f.site_code
		from transactions a
		join projects b on b.project_id = a.project_id
		join phase c on c.phase_id = a.phase_id
		join product_categories d on d.product_category_id = a.transaction_product_category_id
	 
		join transactions e on e.transaction_id = a.transaction_sent_id
		JOIN  sites f ON f.site_id = a.site_id
		where a.transaction_type_id = '2'
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
				$row['transaction_id'], 
				$row['phase_name'],
				$row['transaction_code_received'],
				$row['transaction_code'],
				$row['product_category_name'],
				$row['site_code']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function po_reservation_get($id, $mode)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		if ($mode == 1)
			$query = $this->db->get_where('transactions', array('transaction_id' => $id), 1);
		else
			$query = $this->db->get_where('transactions', array('transation_code' => $id), 1);
		
		$result = NULL;		
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
		## Data site
	function site_control($param, $id)
	{
		$where = '';
		$params 	= get_datatables_control();
		$limit 		= $params['limit'];
		$offset 	= $params['offset'];
		$category 	= $params['category'];
		$keyword 	= $params['keyword'];
		
		// map value dari combobox ke table
		// daftar kolom yang valid
		
		$columns['p1'] 			= 'site_code';
		$columns['p2'] 			= 'site_name';
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'site_id';
		$order_by_column[] = 'site_code';
		$order_by_column[] = 'site_name';
		
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " and ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select a.*
		from sites a
		where site_active_status = 1
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
				$row['site_id'], 
				$row['site_code'],
				$row['site_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function site_get($id, $mode)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		if ($mode == 1)
			$query = $this->db->get_where('sites', array('site_id' => $id), 1);
		else
			$query = $this->db->get_where('sites', array('site_code' => $id), 1);
		
		$result = NULL;		
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
			## Data po_received
	function po_number_control($param, $id)
	{
		$where = '';
		$params 	= get_datatables_control();
		$limit 		= $params['limit'];
		$offset 	= $params['offset'];
		$category 	= $params['category'];
		$keyword 	= $params['keyword'];
		
		// map value dari combobox ke table
		// daftar kolom yang valid
		
		
		$columns['p3']			= 'transaction_code';
		
		$sort_column_index = $params['sort_column'];
		$sort_dir = $params['sort_dir'];
		
		$order_by_column[] = 'transaction_code';
		$order_by_column[] = 'transaction_code';
	
		
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			
				$where = " and ".$columns[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	

		$sql = "
		select *
		from transactions 
			where transaction_type_id = '1'
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
				$row['transaction_code'], 
				$row['transaction_code']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($params, $data, $total);
	}
	
	function po_number_get($id, $mode)
	{
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		if ($mode == 1)
			$query = $this->db->get_where('transactions', array('transaction_code' => $id), 1);
	
		$result = NULL;		
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	
	
	
	
	
	## Data insurance
	
	function insurance_control($param,$id)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'insurance_id';
		$order_by_column[] = 'insurance_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'insurance_name';
	
		$this->db->start_cache();
		
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			$this->db->like($column[$category], $keyword);
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1);
		if($id != '0'){
			$this->db->where('insurance_id <>', 1);
		}
		 // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('insurances'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	
				
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data
		if($id != '0'){
			$this->db->where('insurance_id <>', 1);
		}
		$this->db->order_by($order_by);
		$query = $this->db->get('insurances', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['insurance_id'], 
				$row['insurance_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function insurance_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1)
			$query = $this->db->get_where('insurances', array('insurance_id' => $id), 1);
		else
			$query = $this->db->get_where('insurances', array('insurance_name' => $id), 1);
			
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	
	
	
	## Data active product type
	function active_product_type_control($param, $cat_id = 0)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		$where = '';
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'product_type_id';
		$order_by_column[] = 'insurance_name';
		$order_by_column[] = 'product_type_name';
	
		
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		
		$column['p1']			= 'insurance_name';
		$column['p3']			= 'product_type_name';
	
		$this->db->start_cache();
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $column) && strlen($keyword) > 0) 
		{
			
				$where = " and ".$column[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	
		
		if($cat_id){
			$where .= "and a.insurance_id = '$cat_id'";
		}
		
		$sql = "
		select a.*, b.insurance_name
		from product_types a
		join  insurances b on b.insurance_id = a.insurance_id
		where product_type_id > 0
		$where  $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['product_type_id'], 
				$row['product_type_name'],
				$row['insurance_name']			
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function active_product_type_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1){
			
			$query = $this->db->get_where('product_types', array('product_type_id' => $id), 1);
		}else{
			$query = $this->db->get_where('product_types', array('product_type_name' => $id), 1);
		}
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
	
	## Data active product sub type
	function active_product_sub_type_control($param, $cat_id = 0)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset	 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		$where = '';
		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'pst_id';
		$order_by_column[] = 'insurance_name';
		$order_by_column[] = 'pst_name';
	
		
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		
		$column['p1']			= 'insurance_name';
		$column['p3']			= 'pst_name';
	
		$this->db->start_cache();
		
		$order_by = " order by ".$order_by_column[$sort_column_index] . $sort_dir;
		if (array_key_exists($category, $column) && strlen($keyword) > 0) 
		{
			
				$where = " and ".$column[$category]." like '%$keyword%'";
			
			
		}
		if ($limit > 0) {
			$limit = " limit $limit offset $offset";
		};	
		
		if($cat_id){
			$where .= "and a.insurance_id = '$cat_id'";
		}
		
		$sql = "
		select a.*, b.insurance_name
		from product_sub_type a
		join  insurances b on b.insurance_id = a.insurance_id
		where pst_id > 0
		$where  $order_by
			
			";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		
		$sql = $sql.$limit;
		
		$query = $this->db->query($sql);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			
			$row = format_html($row);
			
			$data[] = array(
				$row['pst_id'], 
				$row['pst_name'],
				$row['insurance_name']			
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function active_product_sub_type_get($id, $mode)
	{
		if (empty($id) || !$id || !$mode) return NULL;
		
		$result = NULL;
		
		if ($mode == 1){
			
			$query = $this->db->get_where('product_sub_type', array('pst_id' => $id), 1);
		}else{
			$query = $this->db->get_where('product_sub_type', array('pst_name' => $id), 1);
		}
		foreach($query->result_array() as $row)	$result = format_html($row);
		
		return $result;
	}
}

#
