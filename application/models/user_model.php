<?php

class User_model extends CI_Model
{
	var $branch_id;
	function __construct()
	{
		//parent::Model();
		//$this->branch_id = $this->access->user_state('branch_id');
	}

	
	function get_from_id($id)
	{
		$query = $this->db->get_where('users', array('user_id' => $id));
		
		$data = null;
		foreach($query->result_array() as $row) $data = $row;
		
		return $data;
	}
	
	function get_from_employee($id) {
		$query = $this->db->get_where('users', array('employee_id' => $id, 'user_active_status' => 't'));
		
		$data = null;
		foreach($query->result_array() as $row) $data = $row;
		
		return $data;
	}
	
	# cek apakah user diijinkan masuk ke module
	function get_crud_mode($group_id, $module_id)
	{	
		# crud = create, read, update, delete
		
		# ijinkan apa saja untuk root, user_id = 1 adalah root
		if ($group_id == 1) return 'crud';
		
		# selain root, cek dunk!
		$this->db->select('p.permit_crud_mode');
		$this->db->from('permits p');
		$this->db->join('modules m', 'p.permit_module_id = m.module_id', 'left');
		$this->db->where(array('p.permit_group_id' => $group_id, 'm.module_id' => $module_id));	
		$query = $this->db->get();
#		debug($this->db->last_query());

		# tanpa akses sama sekali
		if ($query->num_rows() == 0) return '';
		
		# ada akses, cari tau apa aja
		$row = $query->row_array();
		$data = $row['permit_crud_mode'];
		
		return $data;
	}
	
	function get_list()
	{
		$this->db->select('u.user_id, u.user_login, u.user_name, g.group_name, u.user_is_active');
		$this->db->from('users u');
		$this->db->join('groups g', 'u.group_id=g.group_id');
		$this->db->order_by('u.user_name');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_profile_id($id)
	{
		$this->db->select('a.*, b.group_name');
		$this->db->from('users a');
		$this->db->join('groups b', 'a.group_id = b.group_id');
		$this->db->where(array('a.user_id' => $id), 1);
		$query = $this->db->get();
		
		$data = null;
		foreach($query->result_array() as $row) $data = $row;
		
		return $data;
	}
	
	function get_groups()
	{
		$this->db->order_by('group_name DESC');
		$query = $this->db->get('groups');
		return $query->result_array();
	}
	
	function insert($data)
	{
		$ci = & get_instance();
	
		$data['user_password'] = md5($data['user_password']);
		
		$this->db->trans_start();		
		$this->db->insert('users', $data);
		$ci->access->log_insert($id, '');
		$this->db->trans_complete();
	
		return $this->db->trans_status();
	}
	
	function update($id, $data)
	{
		$ci = & get_instance();
		
		$sandi = trim($data['user_password']);
		if (!empty($sandi)) $data['user_password'] = md5($data['user_password']);
		
		$this->db->trans_start();
			$this->db->update('users', $data, array('user_id' => $id));
			$ci->access->log_update($id, '');
		$this->db->trans_complete();
	
		return $this->db->trans_status();
		
	}
	
	function delete($id)
	{
		$ci = & get_instance();
		
		if ($id == 1) return false;
		
		$this->db->trans_start();
		
		
		$this->db->select('employee_id',1);
		$this->db->from('users');
		$this->db->where('user_id', $id);
		$query = $this->db->get();
		
		if($query->num_rows>0)
		{
			$row = $query->row_array();
			$employe_id = $row['employee_id'];
			$this->db->delete('employees', array('employee_id' => $employe_id, 'employee_id > ' => 1));	
		}

	
		
		
		$this->db->delete('users', array('user_id' => $id, 'user_id > ' => 1));	
		
	
		//$this->db->delete('employees', array('employee_id' => $id, 'employee_id > ' => 1));		
		
	
		
	
	
		
		
			
		$ci->access->log_delete($id, 'Data di-non-aktifkan');
		$this->db->trans_complete();
	
		return $this->db->trans_status();
	}
	
	
	// LOGIN
	function cek_status($user, $pass)
	{
		$param['user_login'] = $user;
		$param['user_password'] = md5($pass);
		$param['user_is_active'] = '1';
		$param['user_is_login'] = '0';
		$this->db->join('employees em', 'u.employee_id = em.employee_id');
		$query = $this->db->get_where('users u', $param);
		
		# debug($this->db->last_query());

		if ($query->num_rows() == 0) return NULL;
		$data = $query->row_array();
		
		//update user_is_login menjadi 1 
	
		return $data['user_id'];
	}
	// LOGIN
	function is_valid($user, $pass)
	{
		$param['user_login'] = $user;
		$param['user_password'] = md5($pass);
		$param['user_is_active'] = '1';
		//$param['user_is_login'] = '0';
		$this->db->join('employees em', 'u.employee_id = em.employee_id');
		$query = $this->db->get_where('users u', $param);
		
		# debug($this->db->last_query());

		if ($query->num_rows() == 0) return NULL;
		$data = $query->row_array();
		
		//update user_is_login menjadi 1 
		$user_is_login='1';
		$this->db->where('user_id', $data['user_id']); // data yg mana yang akan di update
		$this->db->update('users', array('user_is_login' => $user_is_login));
		
		return $data['user_id'];
	}

	function get_user_info($user_id, $branch_id = NULL)
	{
		$this->db->select('u.*, em.employee_id, em.employee_pic, em.employee_name, em.employee_nip, gp.group_name');
		//$this->db->select('co.company_id, co.company_name');
		$this->db->from('users u');
		$this->db->join('groups gp', 'u.user_group_id = gp.group_id', 'left');
		$this->db->join('employees em', 'u.employee_id = em.employee_id', 'left');
		//$this->db->join('branches br', ($branch_id ? 'br.branch_id = CAST(' . intval($branch_id) . ' AS INTEGER)': 'em.branch_id = br.branch_id'), 'left');
		//$this->db->join('companies co', 'br.company_id = co.company_id', 'left');
		$this->db->where('user_id', $user_id, 1);
		$query = $this->db->get();
		
		//query();
		
		if ($query->num_rows() == 0) return NULL;
		$info = $query->row_array();

		//$info['branch_id'] = null_default($info['branch_id'], '0');
		//$info['branch_code'] = null_default($info['branch_code'], '000');
		//$info['branch_name'] = null_default($info['branch_name'], '---');
		return $info;

	}

	//Load Menu
	function load_menu(){
		
		$ci = & get_instance();
		
		if (!isset($ci->access)) $ci->load->library('access');	
		if (!$ci->access->is_user()) return;

		$group_id = $this->access->user_id;
		$branch_id = $this->access->branch_id;
		
		$str = '<ul class="sf-menu sf-vertical">'."\n";		
		
		if($group_id && $branch_id)
		{
		//$sql = "select m.* from menu m, permits p where m.module_id=p.module_id and p.group_id='$group_id' and m.status='1' order by weight ASC";
			$sql = "select * from menus order by weight asc";
			$query = $this->db->query($sql);
			$data = array();		
			foreach($query->result() as $row)
			{
				$data[$row->parent_id][] = $row;
			}
			$str .= $this->loop($data,0); 
		}
		$str .= '</ul>'."\n";
		return $str; 
	}
	
	function loop($data,$parent)
	{
  		if(isset($data[$parent]))
		{ 
  			$str = '';
			if($parent!=0) $str .= '<ul parent="'.$parent.'">'; 
			foreach($data[$parent] as $value)
			{
	 			$str .= '<li>';
	  			$child = $this->loop($data,$value->mod_id);
	  			$str .= '<a href="'.site_url($value->url).'">'.$value->mod_name.'</a>';
	  			if($child) $str .= $child;
	 			$str .='</li>'."\n";
			}
			if($parent!=0)$str .= '</ul>'."\n";
			return $str;
  		}
		else return false;	  
	}
	
	// USER NAME			
	function get_user_name()
	{
		$ci = & get_instance();
		if (!isset($ci->access)) $this->load->library('access');
		return $ci->access->user_name;		
	}

	// BRANCH NAME			
	function get_branch_name()
	{
		$ci = & get_instance();
		if (!isset($ci->access)) $this->load->library('access');
		return $ci->access->branch_name;	
	}
	
	// GROUP NAME			
	function get_group_name()
	{
		$ci = & get_instance();
		if (!isset($ci->access)) $this->load->library('access');
		return $ci->access->group_name;	
	}
	
	function get_branch($id)
	{
		$this->db->order_by('branch_name');
		$query = $this->db->get_where('branches', array('branch_id' => $id));	
		return $query;
	}
	
	function get_market($id)
	{		
		$query = $this->db->get_where('markets', array('branch_id' => $id));	
		return $query;		
	}
	
	function get_clasification($id)
	{
		//$query = $this->db->get_where('markets', array('markets_id' => $id));	
		//return $query;
		
		$this->db->select('a.*','b.booth_classification_id','b.booth_classification_name'); // ambil seluruh data
		$this->db->where('market_id', $id);
		$this->db->join('booth_classifications b','a.booth_classification_id = b.booth_classification_id');
		$query = $this->db->get('markets a', 1); // parameter limit harus 1
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result; 
	}
	
	function get_branch_all($employee_id = 0)
	{
		if ($employee_id != 1) {
			
			$query = $this->db->get_where('employees', array('employee_id' => $employee_id));
			if ($query->num_rows() == 0) return array();
			
			$row = $query->row();
			$branch_id = $row->branch_id;
			
			if ($branch_id != 1) {			
				$query = $this->db->get_where('hierarchies', array('branch_id' => $branch_id));
				if ($query->num_rows() == 0) return array();
				$row = $query->row();
				$region_id = $row->region_id;
			
				$this->db->join('hierarchies h', 'b.branch_id = h.branch_id');
				$this->db->where('h.region_id', $region_id);
			}
		}
		
		$this->db->order_by('b.branch_name');
		$query = $this->db->get('branches b');
		//debug();
		return $query->result_array();
	}
	//======================================list User ON==============================
	
	function user_on_controller($param)
	{
		//$ci = & get_instance();
		$this->branch_id = $this->access->branch_id;
		
		$limit = $param['limit'];
		$offset = $param['offset'];
		$category = $param['category'];
		$keyword = $param['keyword'];
		
		$columns['nama'] 			= 'user_name';

		
		
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
	
		$order_by_column[] = 'user_name';

		
		$order_by = $order_by_column[!$sort_column_index ? 0 : $sort_column_index] . $sort_dir;
		
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			$this->db->start_cache();
			$this->db->like($columns[$category], $keyword);
			$this->db->stop_cache();
		}

		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->from('users a');
		//$this->db->where('a.user_id <> 1');
		$this->db->where('a.user_is_active','1');
		$this->db->where('a.user_is_login','1');		
		$query	= $this->db->get(); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	

		$this->db->select('a.*', 1); 
		$this->db->from('users a');
		//$this->db->where('a.user_id <> 1');
		$this->db->where('a.user_is_active','1');	
		$this->db->where('a.user_is_login','1');	
		$this->db->order_by($order_by);
		if ($limit > 0) $this->db->limit($limit, $offset);
		$query = $this->db->get();
	 
		$data = array();
		foreach($query->result_array() as $row) {
			
			$row = $this->_user_renderer($row);
			$status ='active';
			$data[] = array(
				$row['user_id'], 
				$row['user_name'],
				$status
			); 
		}
		
		return make_datatables_control($param, $data, $total);
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//======================================USER===========================
	function user_list_controller($param)
	{
		//$ci = & get_instance();
		$this->branch_id = $this->access->branch_id;
		
		$limit = $param['limit'];
		$offset = $param['offset'];
		$category = $param['category'];
		$keyword = $param['keyword'];
		
		$columns['login'] 			= 'user_login';
		$columns['nama'] 			= 'user_name';
		$columns['email']			= 'user_email';
		$columns['phone']			= 'user_phone';
		$columns['job_title']		= 'job_title';
		$columns['company'] 		= 'company';
		$columns['expired_date']	= 'expired_date';
		
		
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'user_login';
		$order_by_column[] = 'user_name';
		$order_by_column[] = 'user_email';
		$order_by_column[] = 'user_phone';
		
		$order_by_column[] = 'job_title';
		$order_by_column[] = 'company';
		$order_by_column[] = 'expired_date';
		
		$order_by = $order_by_column[!$sort_column_index ? 0 : $sort_column_index] . $sort_dir;
		
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			$this->db->start_cache();
			$this->db->like($columns[$category], $keyword);
			$this->db->stop_cache();
		}

		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->from('users a');
		//$this->db->join('groups b', 'a.user_group_id = b.group_id');	// join table untuk mengambil tipe buku	
		$this->db->join('employees c','a.employee_id = c.employee_id');
		//$this->db->join('emp_positions d','d.position_id = c.position_id');
		$this->db->where('a.user_id <> 1');
		$this->db->where('a.user_is_active','1');		
		$query	= $this->db->get(); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	

		$this->db->select('a.*', 1); 
		$this->db->from('users a');
		//$this->db->join('groups b', 'a.user_group_id = b.group_id');	
		$this->db->join('employees c','a.employee_id = c.employee_id');
		//$this->db->join('emp_positions d','d.position_id = c.position_id');
		$this->db->where('a.user_id <> 1');
		$this->db->where('a.user_is_active','1');		
		$this->db->order_by($order_by);
		if ($limit > 0) $this->db->limit($limit, $offset);
		$query = $this->db->get();
	 
		$data = array();
		foreach($query->result_array() as $row) {
			
			$row = $this->_user_renderer($row);
			
			$data[] = array(
				$row['user_id'], 
				$row['user_login'], 
				$row['user_name'],
				$row['user_email'], 
				$row['user_phone'], 
				$row['job_title'], 
				$row['company'],
				format_new_date($row['expired_date']) 
				//$row['position_name']
			); 
		}
		
		return make_datatables_control($param, $data, $total);
	}





	function user_aproved_list_controller($param)
	{
		//$ci = & get_instance();
		$this->branch_id = $this->access->branch_id;
		
		$limit = $param['limit'];
		$offset = $param['offset'];
		$category = $param['category'];
		$keyword = $param['keyword'];
		
		$columns['login'] 			= 'user_login';
		$columns['nama'] 			= 'user_name';
		$columns['email']			= 'user_email';
		$columns['phone']			= 'user_phone';
		$columns['job_title']		= 'job_title';
		$columns['company'] 		= 'company';
		
		
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'user_login';
		$order_by_column[] = 'user_name';
		$order_by_column[] = 'user_email';
		$order_by_column[] = 'user_phone';
		
		$order_by_column[] = 'job_title';
		$order_by_column[] = 'company';
		
		$order_by = $order_by_column[!$sort_column_index ? 0 : $sort_column_index] . $sort_dir;
		
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			$this->db->start_cache();
			$this->db->like($columns[$category], $keyword);
			$this->db->stop_cache();
		}

		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->from('users a');
		//$this->db->join('groups b', 'a.user_group_id = b.group_id');	// join table untuk mengambil tipe buku	
		$this->db->join('employees c','a.employee_id = c.employee_id');
		//$this->db->join('emp_positions d','d.position_id = c.position_id');
		$this->db->where('a.user_id <> 1');
		$this->db->where('a.user_is_active','0');
		$this->db->where('a.expired_date','0000-00-00');		
		$query	= $this->db->get(); 
		$row 	= $query->row_array(); 
		$total 	= $row['total'];	

		$this->db->select('a.*', 1); 
		$this->db->from('users a');
		$this->db->join('employees c','a.employee_id = c.employee_id');
		$this->db->where('a.user_id <> 1');
		$this->db->where('a.user_is_active','0');		
		$this->db->where('a.expired_date','0000-00-00');	
		$this->db->order_by($order_by);
		if ($limit > 0) $this->db->limit($limit, $offset);
		$query = $this->db->get();
	 
		$data = array();
		foreach($query->result_array() as $row) {
			
			$row = $this->_user_renderer($row);
			
			$data[] = array(
				$row['user_id'], 
				$row['user_login'], 
				$row['user_name'],
				$row['user_email'], 
				$row['user_phone'], 
				$row['job_title'], 
				$row['company'] 
				//$row['position_name']
			); 
		}
		
		return make_datatables_control($param, $data, $total);
	}



	function user_create($data,$employe)
	{
		$this->db->trans_start();
		$employee_name 	=  $employe['employee_name'];
		$employee_pic	 =  $employe['employee_pic'];
		$employee_active_status =  '1';
		
		
		$this->db->insert('employees', array('employee_name' => $employee_name,'employee_active_status' => $employee_active_status,'employee_pic' => $employee_pic));
		$data['employee_id'] = $this->db->insert_id();
		$data['user_name'] = $employee_name;
		
		
		$this->db->insert('users', $data);
		$id = $this->db->insert_id();
	
		$this->access->log_insert($id, 'User');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
	function registration_create($data,$employe)
	{
		$this->db->trans_start();
		$employee_name 	=  $employe['employee_name'];
		$employee_active_status =  '0';
		
		
		$this->db->insert('employees', array('employee_name' => $employee_name,'employee_active_status' => $employee_active_status));
		
		$data['employee_id'] = $this->db->insert_id();
		$data['user_name'] = $employee_name;
		
		
		$this->db->insert('users', $data);
		$id = $this->db->insert_id();
	
		

		return $this->db->trans_status();
	}
	
	
	
	

	function user_update($id, $data,$employe)
	{
	
		$this->db->trans_start();
		$employee_name	=  $employe['employee_name'];
		$employee_pic 	=  $employe['employee_pic'];
		$employee_id 	=  $employe['employee_id'];
		
		$this->db->where('employee_id', $employee_id); 
		$this->db->update('employees',  array('employee_name' => $employee_name,'employee_pic' => $employee_pic));
		
		$data['user_name'] = $employee_name;
		
		$this->db->where('user_id', $id); 
		$this->db->update('users', $data);
		
		
		$this->access->log_update($id, 'User');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function user_aproved_update($id, $data,$employe)
	{
	
		$this->db->trans_start();
		//$employee_pic 	=  $employe['employee_pic'];
		$employee_id 	=  $employe['employee_id'];
		$employee_active_status 	 =  1;
		
		$this->db->where('employee_id', $employee_id); 
		$this->db->update('employees',  array('employee_active_status' => $employee_active_status));
		
	
		
		$this->db->where('user_id', $id); 
		$this->db->update('users', $data);
		
		
		$this->access->log_update($id, 'User Aproved');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function user_delete($id)
	{		
		$data['user_is_active'] = "FALSE";
		
		$this->db->trans_start();
		$this->db->where('user_id', $id); // data yg mana yang akan di update
		$this->db->update('users', $data);
		
		$this->access->log_delete($id, 'User Dinonaktifkan');
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
	function user_activated($id)
	{		
		$data['user_is_active'] = "TRUE";
		
		$this->db->trans_start();
		$this->db->where('user_id', $id); // data yg mana yang akan di update
		$this->db->update('users', $data);
		
		$this->db->select('employee_id');
		$this->db->where('user_id', $id); // data yg mana yang akan di update
		$query = $this->db->get('users');
		$row = $query->row_array();
		$eid = $row['employee_id'];
		$this->db->update('employees', array('employee_active_status'=>'t'), array('employee_id'=>$eid));
		
		$this->access->log_update($id, 'Pengaktifan User');
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
	
	function user_read_id($id)
	{		
		$ci = & get_instance();
		$this->branch_id = $ci->access->branch_id;
		
		$this->db->select('a.*,c.employee_id,c.employee_pic', 1); // ambil seluruh data
	
		$this->db->from('users a');
		$this->db->join('employees c','a.employee_id = c.employee_id');
		//$this->db->where('c.branch_id',$this->branch_id);
		$this->db->where('a.user_id', $id);
		$this->db->where('a.user_is_active','1');
		$query = $this->db->get(); // parameter limit harus 1
		
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = $this->_user_renderer($row);
		return $result; 
	}
	function user_aproved_read_id($id)
	{		
		$ci = & get_instance();
		$this->branch_id = $ci->access->branch_id;
		$this->db->select('a.*,c.employee_id,c.employee_pic', 1); // ambil seluruh data
	
		$this->db->from('users a');
		$this->db->join('employees c','a.employee_id = c.employee_id');
		//$this->db->where('c.branch_id',$this->branch_id);
		$this->db->where('a.user_id', $id);
		//$this->db->where('a.user_is_active','1');
		$query = $this->db->get(); // parameter limit harus 1
		
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = $this->_user_renderer($row);
		return $result;
	}
	

	function user_read_name($keyword,$username,$employee)
	{		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->select('EXTRACT(EPOCH FROM user_last_login) AS user_last_login', 1); // date to epoch
		$this->db->select('EXTRACT(EPOCH FROM user_registered) AS user_registered', 1); // date to epoch		
		$this->db->where('user_login', $keyword);
		$this->db->where('user_is_active','TRUE');
		$this->db->or_where('user_name', $username);
		$this->db->where('user_is_active','TRUE');
		$this->db->or_where('employee_id', $employee);
		$this->db->where('user_is_active','TRUE');
		$query = $this->db->get('users', 1); // parameter limit harus 1
		//echo $this->db->last_query();exit;
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = $this->_user_renderer($row);		
		return $result;
	}
	
	function is_user_active($employee_id)
	{
		$this->db->select('user_id'); 
		$this->db->from('users');
		$this->db->where('employee_id', $employee_id);	
		//$this->db->where('user_is_active', 'TRUE');
		$query = $this->db->get();
		if($query->num_rows > 0)
		return $query->row_array();
	}
	
	function user_read_update($id,$keyword,$username,$employee)
	{		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->select('EXTRACT(EPOCH FROM user_last_login) AS user_last_login', 1); // date to epoch
		$this->db->select('EXTRACT(EPOCH FROM user_registered) AS user_registered', 1); // date to epoch		
		$this->db->where('user_login', $keyword);
		$this->db->where('user_id !=',$id);
		$this->db->where('user_is_active','TRUE');
		$this->db->or_where('user_name', $username);
		$this->db->where('user_id !=',$id);
		$this->db->where('user_is_active','TRUE');
		$this->db->or_where('employee_id', $employee);
		$this->db->where('user_id !=',$id);
		$this->db->where('user_is_active','TRUE');
		$query = $this->db->get('users', 1); // parameter limit harus 1
	
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = $this->_user_renderer($row);		
		return $result;
	}
	
	function _user_renderer($data)
	{
		// hanya rubah yang perlu dirubah
		$data['user_registered'] = date('d/m/Y H:m:s', strtotime($data['user_registered']));
		$data['user_last_login'] = date('d/m/Y H:m:s', strtotime($data['user_last_login']));
		// safer html
		return format_html($data);
	}
	
	function user_reset_id($id)
	{		
		$ci = & get_instance();
		$this->branch_id = $ci->access->branch_id;
		
		$this->db->select('a.*', 1); // ambil seluruh data
		$this->db->select('EXTRACT(EPOCH FROM a.user_last_login) AS user_last_login', 1); // date to epoch
		$this->db->select('EXTRACT(EPOCH FROM a.user_registered) AS user_registered', 1); // date to epoch
		$this->db->from('users a');
		$this->db->join('employees c','a.employee_id = c.employee_id');
		$this->db->where('c.branch_id',$this->branch_id);
		$this->db->where('a.employee_id', $id);
		$this->db->where('a.user_is_active','TRUE');
		$query = $this->db->get(); // parameter limit harus 1
			
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = $this->_user_renderer($row);
		return $result; 
	}
	
	function user_reset($id,$data)
	{
		$this->db->trans_start();
		$this->db->where('user_id', $id); // data yg mana yang akan di update
		$this->db->update('users', $data);
		$this->access->log_update($id, 'Ganti Password');
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	//====================================== USER NON AKTIF ===========================
	function userna_list_controller($param)
	{
		$ci = & get_instance();
		$this->branch_id = $ci->access->branch_id;
		
		$limit = $param['limit'];
		$offset = $param['offset'];
		$category = $param['category'];
		$keyword = $param['keyword'];
		
		$columns['nama'] = 'user_name';
		$columns['login'] = 'user_login';
		$columns['posisi'] = 'position_name';
		
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		$order_by_column[] = 'user_id';
		$order_by_column[] = 'user_login';
		$order_by_column[] = 'user_name';
		$order_by_column[] = 'position_name';
		$order_by_column[] = 'group_name';
		
		$order_by = $order_by_column[!$sort_column_index ? 0 : $sort_column_index] . $sort_dir;
		
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			$this->db->start_cache();
			$this->db->like($columns[$category], $keyword);
			$this->db->stop_cache();
		}

		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->from('users a');
		$this->db->join('groups b', 'a.user_group_id = b.group_id');	// join table untuk mengambil tipe buku	
		$this->db->join('employees c','a.employee_id = c.employee_id');
		$this->db->join('positions d','d.position_id = c.position_id');
		$this->db->where('c.branch_id',$this->branch_id);
		$this->db->where('a.user_is_active','FALSE');
		$this->db->where('c.employee_active_status','t');	
		$query	= $this->db->get(); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];	

		$this->db->select('a.*,b.*,d.position_name', 1); 
		$this->db->select('EXTRACT(EPOCH FROM a.user_last_login) AS user_last_login', 1);
		$this->db->select('EXTRACT(EPOCH FROM a.user_registered) AS user_registered', 1); 
		$this->db->from('users a');
		$this->db->join('groups b', 'a.user_group_id = b.group_id');	
		$this->db->join('employees c','a.employee_id = c.employee_id');
		$this->db->join('positions d','d.position_id = c.position_id');
		$this->db->where('c.branch_id',$this->branch_id);
		$this->db->where('a.user_is_active','FALSE');	
		$this->db->where('c.employee_active_status','t');	
		$this->db->order_by($order_by);
		if ($limit > 0) $this->db->limit($limit, $offset);
		$query = $this->db->get();
		
		$data = array();
		foreach($query->result_array() as $row) {
			
			$row = $this->_user_renderer($row);
			
			$data[] = array(
				$row['user_id'], 
				$row['user_login'], 
				$row['user_name'], 
				$row['position_name'], 
				$row['group_name']
			); 
		}
		
		return make_datatables_control($param, $data, $total);
	}

	function userna_read_id($id)
	{		
		$ci = & get_instance();
		$this->branch_id = $ci->access->branch_id;
		
		$this->db->select('a.*', 1); // ambil seluruh data
		$this->db->select('EXTRACT(EPOCH FROM a.user_last_login) AS user_last_login', 1); // date to epoch
		$this->db->select('EXTRACT(EPOCH FROM a.user_registered) AS user_registered', 1); // date to epoch
		$this->db->from('users a');
		$this->db->join('employees c','a.employee_id = c.employee_id');
		$this->db->where('c.branch_id',$this->branch_id);
		$this->db->where('a.user_id', $id);
		$this->db->where('a.user_is_active','FALSE');
		$query = $this->db->get(); // parameter limit harus 1
			
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = $this->_user_renderer($row);
		return $result; 
	}
	
	function userna_create($data)
	{
		$this->db->trans_start();
		$this->db->insert('users', $data);
		$id = $this->db->insert_id();
		$this->access->log_insert($id, 'User');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	function userna_update($id, $data)
	{
	
		$this->db->trans_start();
		$this->db->where('user_id', $id); 
		$this->db->update('users', $data);
		$this->access->log_update($id, 'User');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function userna_delete($id)
	{		
		$data['user_is_active'] = "FALSE";
		
		$this->db->trans_start();
		$this->db->where('user_id', $id); // data yg mana yang akan di update
		$this->db->update('users', $data);
		
		$this->access->log_delete($id, '');
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
	function password_reset($id,$data)
	{
		$this->db->trans_start();
		$this->db->where('user_id', $id); 
		$this->db->update('users', $data);
		//$this->access->log_update($id, 'User');
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	// MODEL untuk GRUP
	function group_list_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit = $param['limit'];
		$offset = $param['offset'];
		$category = $param['category'];
		$keyword = $param['keyword'];

		# order define columns start
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'group_id';
		$order_by_column[] = 'group_name';
		
		$order_by = $order_by_column[$sort_column_index] . $sort_dir;
		# order define column end
		
		$column['p1']			= 'group_name';

		$this->db->start_cache();
		if(array_key_exists($category, $column) && strlen($keyword) > 0)
		{
			if ($category == 'p1') $this->db->like($column[$category], $keyword, 'after'); else $this->db->like($column[$category], $keyword);
			
		}// end if
		$this->db->stop_cache();
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		//$this->db->where('group_is_active','TRUE');
		$this->db->where('group_id >', 1);
		$query	= $this->db->get('groups'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];		
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data				
		//$this->db->where('group_is_active','TRUE');
		$this->db->where('group_id >', 1);
		$this->db->order_by($order_by);
		$query = $this->db->get('groups', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$kode = $row['group_id'];
			
			$row = $this->_group_renderer($row);
			
			$data[] = array(
				$row['group_id'], 
				$row['group_name'], 
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function employee_list_control($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit = $param['limit'];
		$offset = $param['offset'];
		$category = $param['category'];
		$keyword = $param['keyword'];
		
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$query	= $this->db->get('employees'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];		
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data				
		$this->db->order_by('employee_id DESC');
		$query = $this->db->get('employees', $limit, $offset);
		
		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$kode = $row['employee_id'];
			
			$row = $this->_group_renderer($row);
			
			$data[] = array(
				$row['employee_id'],
				$row['employee_nik'], 
				$row['employee_name'], 
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	function _group_renderer($data)
	{
		return format_html($data);
	}
	
	
	function group_list_controller($param)
	{
		$limit = $param['limit'];
		$offset = $param['offset'];
		$category = $param['category'];
		$keyword = $param['keyword'];
		
		$columns['nama'] = 'group_name';
	
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		$order_by_column[] = 'group_id';
		$order_by_column[] = 'group_name';
		
		$order_by = $order_by_column[!$sort_column_index ? 0 : $sort_column_index] . $sort_dir;


		$this->db->start_cache();
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			$this->db->like($columns[$category], $keyword);

		}
		
		$this->db->where('group_is_active','TRUE');
		$this->db->where('group_id >', 1);
		$this->db->stop_cache();

		$this->db->select('COUNT(1) AS total', 1);
		
		$query	= $this->db->get('groups'); 
		
		$row 	= $query->row_array(); 
		$total 	= $row['total'];		
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data	
		$this->db->order_by($order_by);
		$query = $this->db->get('groups', $limit, $offset);

		$data = array(); // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row) {
			
			$row = $this->_group_renderer($row);
				$data[] = array(
				$row['group_id'], 
 				$row['group_name']
			); 
		}
		
		// kembalikan nilai dalam format datatables_control
		return make_datatables_control($param, $data, $total);
	}
	
	
	// [C] r u d - Create. return format: boolean
	// Scope : GROUP
	function group_create($data)
	{
	
		$this->db->trans_start();
		$this->db->insert('groups', $data);
		$this->db->trans_complete();
		$id = $this->db->insert_id();
		$this->access->log_insert($id, 'Group');
		return $this->db->trans_status();
	}
	
	// c r [U] d - Update. return format: boolean
	// Scope : GROUP
	function group_update($id, $data)
	{
	
		$this->db->trans_start();
		$this->db->where('group_id', $id); // data yg mana yang akan di update
		$this->db->update('groups', $data);
		
		$this->access->log_update($id, 'Group');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
	// c r u [D] - Delete. return format: boolean
	// Scope : GROUP
	function group_delete($id)
	{		
		if ($id == 1) return false;
		
		$data['group_is_active'] = "FALSE";
		$this->db->trans_start();
			$this->db->where(array('group_id' => $id, 'group_id >' => 1)); // data yg mana yang akan di update
			$this->db->update('groups', $data);
			$this->access->log_delete($id, '');
		$this->db->trans_complete();
		return $this->db->trans_status();
		
	}
	
	
	function group_read_id($id, $mode = 1)
	{		
		if (!$id) return NULL;
		
		$id = trim($id);
		if (empty($id)) return NULL;
		
		$this->db->start_cache();
		$this->db->select('e.*', 1); // ambil seluruh data
	
		$this->db->stop_cache();
		
		if ($mode == 1)
			$query = $this->db->get_where('groups e', array('group_id' => $id), 1);
		else
			$query = $this->db->get_where('groups e', array('group_name' => $id), 1);

		//log_message('error',$this->db->last_query());
		
		$result = NULL;
		foreach($query->result_array() as $row)	$result = $this->_group_renderer($row); 
		
		return $result;
	}
	
	function employee_read_id($id)
	{		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('employee_id', $id);
		//$this->db->where('employee_active_status', 'TRUE');
		$query = $this->db->get('employees', 1); // parameter limit harus 1
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = $this->_group_renderer($row);
		return $result; 
	}

	function group_read_name($keyword)
	{		

		$this->db->select('*', 1); // ambil seluruh data
		$this->db->like('group_name', $keyword);
		$this->db->where('group_is_active','TRUE');
		$query = $this->db->get('groups', 1); // parameter limit harus 1
		
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = $this->_group_renderer($row);		
		return $result;
	}
	
	
	function group_read_update($id,$keyword)
	{		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('group_name', $keyword);
		$this->db->where('group_id !=',$id);
		$this->db->where('group_is_active','TRUE');
		$query = $this->db->get('groups', 1); // parameter limit harus 1
		
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = $this->_group_renderer($row);		
		return $result;
	}
	
	// MODEL untuk PERMIT
	// @by : tanto
	function _permit_renderer($data)
	{
		return format_html($data);
	}
	
	
	function permit_list_controller($param)
	{
		// map parameter ke variable biasa agar mudah digunakan
		$limit 		= $param['limit'];
		$offset 	= $param['offset'];
		$category 	= $param['category'];
		$keyword 	= $param['keyword'];
		
		// map value dari combobox ke table
		// daftar kolom yang valid
		$columns['nama'] = 'group_name';
		$this->db->start_cache();
		
		// untuk sorting table
		$sort_column_index				= $param['sort_column'];
		$sort_dir						= $param['sort_dir'];
		
		$order_by_column[] = 'group_id';
		$order_by_column[] = 'group_name';
		
		$order_by = $order_by_column[!$sort_column_index ? 0 : $sort_column_index] . $sort_dir;
		// check apakah parameter search dari client valid, bila tidak anggap ambil semua data
		if (array_key_exists($category, $columns) && strlen($keyword) > 0) 
		{
			// daftarkan kriteria search ke seluruh query
			
			$this->db->like($columns[$category], $keyword);
			
			// bila query Anda tidak menggunakan ini, hapus dengan $this->db->flush_cache();
		}
		$this->db->stop_cache();
	
		// hitung total record
		$this->db->select('COUNT(1) AS total', 1); // pastikan ada AS total nya, 1 bila isinya adalah function (dalam hal ini COUNT)
		$this->db->where('group_id <> 1');
		$query	= $this->db->get('groups'); 
		$row 	= $query->row_array(); // fungsi ci untuk mengambil 1 row saja dari query
		$total 	= $row['total'];		
		
		// proses query sesuai dengan parameter
		$this->db->select('*', 1); // ambil seluruh data		
		$this->db->where('group_id <> 1');
		$this->db->order_by($order_by);
		$query = $this->db->get('groups', $limit, $offset);
		
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
	
	//// field2x dengan _read_ harus UNIQUE
	function permit_read_id($id)
	{		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('group_id', $id);
		$query = $this->db->get('groups', 1); // parameter limit harus 1
	
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = $this->_permit_renderer($row);
		return $result; 
	}
	
	// field2x dengan _read_ harus UNIQUE
	// return format : array data, jika tidak ada data null
	// Scope : GLOBAL
	function permit_read_name($keyword)
	{		
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('group_name', $keyword);
		$query = $this->db->get('groups', 1); // parameter limit harus 1
		
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = $this->_permit_renderer($row);		
		return $result;
	}
	
	// TRANSIENT MODEL UNTUK PERMIT
	// Untuk table transient
	function permit_transient_loader($group_id)
	{		
		// buat array kosong
		$result = array(); 
		
		
		$sql = "SELECT * 
				FROM modules m LEFT JOIN permits p 
				ON m.module_id = p.permit_module_id 
				AND p.permit_group_id = ? ORDER BY module_id ASC";
		
		$query = $this->db->query($sql,$group_id);
		
		foreach($query->result_array() as $row)
		{
			$result[] = $this->_permit_renderer($row); // render dulu dunk!
		}
		return $result;
	}
	
	// model untuk table transient
	function permit_transient_query($group_id, $data)
	{	
		#print_r($data);exit;
		// kurung semua perubahan dengan transaksi
		$this->db->trans_start();
			
			// hapus semua data lama
			$this->db->delete(
				'permits', 
				array(
					'permit_group_id' => $group_id
					)
			);
			
			// insert semua data baru
			foreach($data as $row)
			{
				$row['permit_group_id'] = $group_id;
				$this->db->insert('permits', $row); 
				# debug($this->db->last_query());
			}
			
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	function cek_menu($module_id)
	{
		$result;
		$this->db->select('menu_name');
		$this->db->where('module_id',$module_id);
		$query = $this->db->get('side_menus');
		
		if($query->num_rows() == 1)
		{
			$row 	= $query->row_array();
			$result = $row['menu_name'];
		}else
		{
			$result = '';
		}
		return $result;
	}
	# @tanto - untuk menu permit
	function menu_transient_loader($group_id)
	{		
		// buat array kosong
		$result = array(); 
		
		
		$sql = "SELECT * 
				FROM side_menus sm LEFT JOIN permits p 
				ON sm.module_id = p.permit_module_id 
				AND p.permit_group_id = ? ORDER BY menu_id ASC";
		
		$query = $this->db->query($sql,$group_id);
		
		#echo $this->db->last_query();exit;
		foreach($query->result_array() as $row)
		{
			$result[] = $this->_permit_renderer($row); // render dulu dunk!
		}
		return $result;
	}
	//// END FUNGSI PERMIT
	
	function log_data_insert($tipe, $module_id, $data_id, $ip, $user_id, $remark)
	{
		$this->db->insert('log_data', array(
			'log_data_type' => $tipe, 
			'log_data_time' => date("Y-m-d H:m:s"),
			'log_data_module_id' => $module_id,
			'log_data_data_id' => $data_id, 
			'log_data_ip' => $ip, 
			'log_data_remark' => $remark, 
			'log_data_user_id' => $user_id
		));	
	}
	
	function get_module_id($module_id)
	{
		$query = $this->db->get_where('modules', array('module_id' => $module_id));
		$result = null;
		foreach($query->result_array() as $row) return $row;
		return NULL;
	}
	
	function get_module_code($module_code)
	{
		$query = $this->db->get_where('modules', array('module_code' => $module_code));
		$result = null;
		foreach($query->result_array() as $row) return $row;
		return NULL;
	}
	
	var $log_type = array('DATA BARU', 'DI EDIT', 'DI HAPUS', 'UNKNOWN');
	
	function get_log_view($module_id, $data_id = '', $offset = 0, $limit = 4)
	{
		$this->db->select('a.*, b.user_name', 1); // ambil seluruh data
		//$this->db->select('EXTRACT(EPOCH FROM a.log_data_time) AS log_time', 1); // date to epoch	
		$this->db->where('a.log_data_module_id', $module_id);
		if($data_id){ $this->db->where('a.log_data_data_id', $data_id); }
		$this->db->from('log_data a');
		$this->db->join('users b', 'a.log_data_user_id = b.user_id');
		$this->db->order_by('log_data_time DESC, log_data_id DESC');
		$query = $this->db->get($offset, $limit); // parameter limit harus 1
		
		$result = array();
		foreach($query->result_array() as $key => $value)
		{
			//$result[$key]['time'] = format_epoch($value['log_data_time'], 'd/m/Y H:i');
			$result[$key]['time'] = $value['log_data_time'];
			$result[$key]['type'] = $this->log_type[$value['log_data_type']];
			$result[$key]['name'] = $value['user_name'];
			$result[$key]['remark'] = $value['log_data_remark'];
		}
		
		return $result;
	}
	function get_user_login_info()
	{
		$this->db->select('u.*,em.employee_id, em.employee_name, em.employee_nip, gp.group_name, gp.group_name ,t.last_time');
		//$this->db->select('EXTRACT(EPOCH FROM last_time) AS last_time', 1); // date to epoch	
		$this->db->from('users u');
		$this->db->join('groups gp', 'u.user_group_id = gp.group_id', 'left');
		$this->db->join('employees em', 'u.employee_id = em.employee_id', 'left');
		$this->db->join("(select max(log_sys_time) as last_time, log_sys_user_id from log_sys where log_sys_action='LOGOUT' group by log_sys_user_id) t", 't.log_sys_user_id=u.user_id', 'left');
		
		$this->db->where('user_id', $this->access->user_id, 1);
		
		
		$query = $this->db->get();
		//query();
		if ($query->num_rows() == 0) return NULL;
		$info = $query->row_array();
		return $info;

	}
	function get_user_approval()
	{
		$this->db->select('count(*) as total');
		$this->db->from('approval_voters');
		$this->db->where('employee_id', $this->access->info['employee_id'], 1);
		$this->db->where('approval_employee_status', 0);
		$this->db->where('approval_employee_exec', 't');
		$query = $this->db->get();
		$info = $query->row_array();
		return $info['total'];

	}
	function get_user_last_activity()
	{
		$this->db->select('d.*,t.log_action_type_name, s.menu_url');
		$this->db->from('log_data d');
		$this->db->join('log_action_types t', 't.log_action_type_id = d.log_data_type');
		$this->db->join('side_menus s', 's.module_id = d.log_data_module_id');
		$this->db->where('log_data_user_id', $this->access->user_id, 1);
		$this->db->order_by('log_data_id DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 0) return NULL;
		$info = $query->row_array();
		return $info;

	}
	function cek_unik_user($user, $id = 0)
	{
		if($id)$this->db->where('u.user_id !=', $id);
		
		$this->db->join('users u', 'e.employee_id = u.employee_id', 'left');
		$query = $this->db->get_where('employees e', array('trim(employee_nip)' => $user));
		if ($query->num_rows() == 0) return TRUE;
		else FALSE;
	}
	function cek_user_log_name($user_log, $id)
	{
		if($id)$this->db->where('u.user_id !=', $id);
			
		$this->db->join('employees e', 'e.employee_id = u.employee_id', 'left');
		$query = $this->db->get_where('users u', array('trim(u.user_login)' => $user_log));
		if ($query->num_rows() == 0) return TRUE;
		else FALSE;
		
	}
}

# -- end file -- #
