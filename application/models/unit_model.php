<?php
class Unit_model extends CI_Model 
{
	function __construct()
	{
		//parent::Model();
		//$this->sek_id = $this->access->sek_id;
		
	}
		
		
	function list_loader()
	{		
		// buat array kosong
		$result = array(); 
		
		$this->db->select('*',1);
		$this->db->from('unit ');
		//query();
		$query = $this->db->get();
		foreach($query->result_array() as $row)
		{
			$row = format_html($row);
			$result[] = array(
				$row['unit_id'],
				$row['unit_name'],
				$row['unit_desc']
			
				); 
		}
		return $result;
	}
	function read_id($id)
	{
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('unit_id', $id);
		
		$query = $this->db->get('unit', 1); // parameter limit harus 1
		
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result;
	}
	function create($data)
	{
		$this->db->trans_start();
		$this->db->insert('unit', $data);

		$id = $this->db->insert_id();
		$this->access->log_insert($id, "Unit [$data[unit_name]]");
		
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
	function update($id, $data)
	{
		$this->db->trans_start();
		$this->db->where('unit_id', $id); // data yg mana yang akan di update
		$this->db->update('unit', $data);
		$this->access->log_update($id, "Unit [$data[unit_name]]");
		
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	function delete($id)
	{
		
		$this->db->trans_start();
		
		$this->db->where('unit_id', $id);
		$this->db->delete('unit');
		
		$this->access->log_delete($id, "Uom");
		$this->db->trans_complete();
		return $this->db->trans_status();
		
	}
function active($id){
		$this->db->trans_start();
		
		$data['unit_active_status'] = 1;
		$data['inactive_by_id'] =  $this->access->info['employee_id'];
		
		$this->db->where('unit_id', $id);
		$this->db->update('unit', $data);
		
		$this->access->log_update($id, "Uom");
		$this->db->trans_complete();
		return $this->db->trans_status();
	}


	
}
#
