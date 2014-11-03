<?php 

define('APPROVAL_WAITING', 0);
define('APPROVAL_APPROVED', 1);
define('APPROVAL_REJECTED', 2);

class Approval
{
	var $module_id;
	var $data_id;
	
	function Approval()
	{
		$ci = & get_instance();
		if (!isset($ci->render)) $ci->load->library('render');
		$this->module_id = $ci->access->module_id;
		
	}
	
	function set_module($module_code) {
		$ci = & get_instance();
		$query = $ci->db->get_where('modules', array('module_code' => $module_code));
		$row = $query->row_array();
		$this->module_id = $row['module_id'];
	}

	function is_no_approval($data_id, $back_url = '', $type = 0)
	{
		$ci = & get_instance();
		$ci->load->model('approval_model');
		$ci->approval_model->set_module_id($this->module_id);
		
		if (!$ci->approval_model->is_approval_user($data_id, $type)) 
		{
			$ci = & get_instance();
			$ci->load->library('dialog');
			$ci->dialog->flash_note('Approval', 'Maaf, Tidak ada approval ditujukan untuk Anda saat ini', $back_url);

			$this->render->show('blank', 'Approval');		
			return true;
		}

		return false;
	}

	function show($data_id, $action_url, $back_url)
	{
		$ci = & get_instance();
		$ci->load->model('approval_model');		
		$ci->approval_model->set_module_id($this->module_id);
		
		$data = $ci->approval_model->list_user_by_id($data_id);
		
		$ci->render->add_view($data['is_voted'] ? 'common/approval_ro' : 'common/approval' , 
			array(
				'list' => $data['list'], 
				'id' => $data_id,
				'action' => site_url($action_url),
				'back' => site_url('approval')
			)
		);
		$ci->render->build('Approval');
	}

	function submit($back_url, $data_creator_id = NULL)
	{
	
		$ci = & get_instance();
		$ci->load->model('approval_model');
		$ci->approval_model->set_module_id($ci->access->module_id);

		$message = $ci->input->post('i_reason');
		$mode = $ci->input->post('i_status');
		$data_id = $ci->input->post('i_data_id');
		$this->data_id = $data_id;
		
		if (!$ci->approval_model->is_approval_user($data_id)) return FALSE;
		
		
		if ($mode == 1)
		{
			return $ci->approval_model->approve($data_id);
		}
		else if ($mode == 2)
		{
			return $ci->approval_model->reject($data_id, $message);
		}
		
		return FALSE;

	}
	
	function status() 
	{
		$ci = & get_instance();
		$ci->load->model('approval_model');
		$ci->approval_model->set_module_id($ci->access->module_id);
		
#		debug('status');
		
		return $ci->approval_model->get_status($this->data_id);
	}
	
	

}

# -- end file -- #
