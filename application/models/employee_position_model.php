<?php
class employee_position_model extends CI_Model 
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
		
		$this->db->select('*', 1); // ambil seluruh dat
		$this->db->order_by('employee_position_id asc'); // urutkan data dari yang terbaru		
		$query = $this->db->get('employee_positions'); // karena menggunakan from, maka get tidak diberi parameter
		//query();
		foreach($query->result_array() as $row)
		{
			$row = format_html($row); // render dulu dunk!
			
			$result[] = array(
				$row['employee_position_id'],
				$row['employee_position_name'],
				$row['employee_position_description']
				); 
		}
		return $result;
	}
	function read_id($id)
	{
		$this->db->select('*', 1); // ambil seluruh data
		$this->db->where('employee_position_id', $id);
		
		$query = $this->db->get('employee_positions', 1); // parameter limit harus 1
		
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = format_html($row); // render dulu dunk!
		return $result;
	}
	function create($data)
	{
		$this->db->trans_start();
		$this->db->insert('employee_positions', $data);

		$id = $this->db->insert_id();
		$this->access->log_insert($id, "Jabatan Pegawai [$data[employee_position_name]]");
		
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
	function update($id, $data)
	{
		$this->db->trans_start();
		$this->db->where('employee_position_id', $id); // data yg mana yang akan di update
		$this->db->update('employee_positions', $data);
		$this->access->log_update($id, "Jabatan Pegawai [$data[employee_position_name]]");
		
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	function delete($id)
	{
		$this->db->trans_start();
		$this->db->where('employee_position_id', $id); // data yg mana yang akan di delete
		$this->db->delete('employee_positions');
		$this->access->log_delete($id, 'Jabatan Pegawai');
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
}
#
