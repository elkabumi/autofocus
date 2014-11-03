<?php

define('BLOB_ALLOW_IMAGES', 'gif|jpg|png|bmp|tiff|tif', TRUE);
define('BLOB_ALLOW_DOCUMENTS', 'docx|doc|xlsx|xls|pptx|ppt|txt|pdf', TRUE);
define('BLOB_ALLOW_ALL', 'gif|jpg|png|bmp|tiff|tif|docx|doc|xlsx|xls|pptx|ppt|txt|pdf', TRUE);

define('BLOB_GENERATE', 0, TRUE);
define('BLOB_DOWNLOAD', 1, TRUE);

class Blob 
{
	var $error = "";
	var $is_error = false;
	
	function get($blob_id, $method = BLOB_GENERATE)
	{
		
		$ci = & get_instance();
		$query = $ci->db->get_where('blobs', array('blob_id' => $blob_id));
		
		$data = null;	
		foreach($query->result_array() as $row) $data = $row;
		
		if ($data == null) return false;
		
		header('Last-Modified: '.gmdate('D, d M Y H:i:s', mktime()).' GMT');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header('Content-Description: File Transfer');
			
		if ($method == BLOB_DOWNLOAD) 
		{			
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . $data['blob_file_name']);
			header('Content-Length: ' . $data['ukuran']);
			header('Content-Transfer-Encoding: binary');
		}
		else
		{
			header('Content-Disposition: inline; filename=' . $data['blob_file_name']);
			header('Content-Type: ' . $data['blob_mime']);
		}	
		
		if ($ci->config->item('upload_mode') == 'file')
		{
			$cpath = $ci->config->item('upload_storage');
			$cfile = $cpath . $data['blob_id'];

			if (file_exists($cfile)) return readfile($cfile); 
		} 
		else
		{
			return $this->get_db($data['blob_id'], $data['blob_loid']);
		}

		return 0;
	}

	function get_db($blob_id, $loid)
	{
		$ci = & get_instance();
		$bn = $ci->config->item('upload_tmp').'para_';
		$no  = 0;
		
		for($i=0; $i < 1000; $i++) 
		{
			$no = $i;
			if (!file_exists($bn . $i)) break;
		}

		$tmpfile = $bn . $no;

		$query = $ci->db->query("SELECT lo_export($loid, '$tmpfile') AS is_ok");
		foreach($query->result() as $row) $data = $row;
		
		if ($data != null)
		{
			if ($data->is_ok)
			{
				if (readfile($tmpfile) === true) return true;
			}
		
			echo "export failed";		
			return false;
		}

		echo "query failed";
		return false;	
	}
	
	function add_db($data, $server_file)
	{
		$ci = & get_instance();
		
		$nama_file  = $data['orig_name'];
		$mime		= $data['file_type'];
		$size 		= $data['file_size'];
			
		$str = "INSERT INTO blobs (blob_file_name, blob_mime, blob_loid, blob_size) VALUES ('$nama_file', '$mime', lo_import('$server_file'), $size)";
		$ci->db->query($str);

		@unlink($server_file);

		return $ci->db->insert_id();
	}
	
	function add_fs($data, $server_file, $photo = 0)
	{	
		$ci = & get_instance();	
		$ci->db->insert('blobs', array('blob_file_name' => $data['orig_name'], 'blob_mime' => $data['file_type'], 'blob_size' => $data['file_size']));
		$id = $ci->db->insert_id();		
		$cpath = $ci->config->item('upload_storage');
		if($photo)
		{
			$ci->load->library('image');
			$ci->image->load($server_file);
			$ci->image->resizeToPhoto();
			$ci->image->save($cpath . $id);
			@unlink($server_file);
			return $id;
		}
		else {rename($server_file, $cpath . $id); return $id;}
					
		return 0;
	}
	
	function send($field, $type_allow = BLOB_ALLOW_ALL, $photo = 0)
	{
		$ci = & get_instance();
		
		$config['upload_path'] 	 = $ci->config->item('upload_tmp');
		$config['allowed_types'] = $type_allow;
		$config['max_size']	 = $ci->config->item('upload_maxsize');
		$config['encrypt_name']	 = true;
		
		$ci->load->library('upload', $config);
	
		if ( ! $ci->upload->do_upload($field))
		{
			$is_error = true;
			$error = $ci->upload->display_errors();
			echo $ci->config->item('upload_tmp') . "" . $error;
			return null;
		}	
		else
		{
			$is_error = false;
			$data = $ci->upload->data();
			$server_file = $config['upload_path'] . $data['file_name'];
			
			$ret = 0;
			if ($ci->config->item('upload_mode') == 'file') 
			{
				$ret = $this->add_fs($data, $server_file, $photo);
			}
			else
			{
				$ret = $this->add_db($data, $server_file);
			}
			
			return array('id' => $ret, 'data' => $data) ;
		}
	}
	
	function is_error()
	{
		return $is_error;
	}
	
	function get_message()
	{
		return $error;
	}
}

# -- end file -- #
