<?php
class Menu_model extends CI_Model 
{
	function get_menu_data($group_id)
	{
		$ci = & get_instance();

		$this->db->select('m.*, p.permit_crud_mode');
		$this->db->from('side_menus m');
		$this->db->join('permits p', 'm.module_id = p.permit_module_id AND p.permit_group_id = ' . $group_id, 'left');
		$this->db->where('menu_active', 1);
		$this->db->order_by('m.menu_weight');
		$this->db->order_by('m.menu_id');
		//$this->db->where('m.menu_active', 't');
		$query = $this->db->get();
		
		//debug($this->db->last_query());
		//query();
		$raw = array();

		foreach($query->result_array() as $r) 
		{
			$i = $r['menu_id'];
			
			$crud = trim($r['permit_crud_mode']);
			$crud = ($ci->access->is_root() ? 'crud' : $crud);
			
			$raw[$i]['name'] = $r['menu_name'];
			$raw[$i]['url'] = $r['menu_url'];
			$raw[$i]['icon'] = $r['menu_icon'];
			$raw[$i]['parent'] = $r['menu_parent'];
			$raw[$i]['crud'] = $crud; 
			$raw[$i]['visible'] = strpos($crud, 'r') !== FALSE ? 1 : 0;
		}

		$root = array();
		foreach($raw as $key => $row) 
		{
			$parent_id = $row['parent'];
			$root[$parent_id][] = $key;
		}
		
#		echo nl2br(print_r($raw,1));
		

		return array($raw, $root);

	}

	function get_user_permit()
	{
		$ci = & get_instance();
		$user_id = $ci->access->user_id;


	}
	
}
#
