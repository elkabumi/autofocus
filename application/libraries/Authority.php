<?php
class Authority 
{
	var $user_id;

	var $company_id;
	var $region_group_id;
	var $region_id;
	var $branch_id;
	var $ccc;
	var $module_id;
	
	var $is_ho;
	var $is_region_ho;
	
	var $region_ho_branch_id;
	var $ho_branch_id;
	
	var $first_director;

	var $scope;
	var $type;
	var $amount;
	var $description;
	var $use_transaction;
	var $approval_members = array();
	var $error_message;
	var $doc_created;

	function Authority() 
	{
	
		$ci = & get_instance();

		if (!isset($ci->access)) return;

		$this->user_id = $ci->access->user_id;
		//$this->branch_id = $ci->access->branch_id;
		$this->module_id  = $ci->access->module_id;

		// trial on module PR, costcenter = 1
		$ci = & get_instance();		
		$ci->load->model('authority_model');
	}

	function _get_parameters()
	{
		$ci = & get_instance();
		
		// get info
		$info = $ci->authority_model->get_branch_info($this->branch_id);
		if (!$info) return FALSE;

		$this->company_id = $info['company_id'];
		$this->region_group_id = $info['region_group_id'];
		$this->region_id = $info['region_id'];
		$this->is_ho = strcmp($info['is_ho'], 't') == 0 ? true : false;
		$this->is_region_ho = strcmp($info['is_region_ho'], 't') == 0 ? true : false;
		

		// head offices	
		if ($this->is_ho) $this->ho_branch_id = $this->branch_id; 
		else $this->ho_branch_id = $ci->authority_model->get_headoffice($this->company_id);

		if ($this->is_region_ho) $this->region_ho_branch_id = $this->branch_id;
		else $this->region_ho_branch_id = $ci->authority_model->get_region_headoffice($this->region_id);

	}

	function _get_targets($type, $scope, $amount)
	{
		$ci = & get_instance();
		$targets = $ci->authority_model->get_targets(
			$this->module_id,
			$type,
			$scope,
			$amount
		);

		return $targets;
	}

	function _rules($target)
	{
#		debug("target: " . $target . " is_ho: " . $this->is_ho);
		
		$result = NULL;
		
		if ($this->is_ho)
		{
		
			switch ($target) 
			{
				case 4: $result = $this->_rule11(); break; // departement head
				case 5: $result = $this->_rule12(); break; // division head
				case 6: $result = $this->_rule13(); break; // 1st director
				case 7: $result = $this->_rule14(); break; // 2nd director
				case 8: $result = $this->_rule15(); break; // 3rd director
				case 9: $result = $this->_rule26(); break; // supervisor
			}
			
		} 
		else 
		{
			switch ($target) 
			{
				case 1: $result = $this->_rule01(); break; // region head
				case 5: $result = $this->_rule02(); break; // region division head
				case 6: $result = $this->_rule03(); break; // 1st director
				case 7: $result = $this->_rule04(); break; // 2nd director
				case 8: $result = $this->_rule05(); break; // 3rd director
								
#				case 2: $result = $this->_rule02(); break; // region head
#				case 3: $result = $this->_rule03(); break; // region director
				case 9: $result = $this->_rule26(); break; // supervisor
			}
		}
		return $result;
	}
	
	// ALL
	function _rule26()
	{
		$ci = & get_instance();
		return $ci->authority_model->get_supervisor($ci->access->branch_id, $this->cc_id);
	}
	
	// HO
	// departement head
	function _rule11()
	{
		if (!$this->cc_id) {
			debug("Error input: cc_id empty");
			return "FATAL: Costcenter tidak terdefinisi";

		}
		
#		debug("go rule11");
		
		$ci = & get_instance();
		return $ci->authority_model->get_departement_head($this->cc_id);
	}
	// division head
	function _rule12()
	{
		$ci = & get_instance();
		return $ci->authority_model->get_division_head($this->cc_id);
	}
	// director
	function _rule13()
	{
		if (!$this->cc_id) {
			debug("Error input: cc_id empty");
			return "FATAL: Costcenter tidak terdefinisi";
		}
		
		$ci = & get_instance();
		$result = $ci->authority_model->get_director($this->cc_id);
		
		return $result;
	}
	
	// 2 director
	function _rule14()
	{
		$ci = & get_instance();
		return $ci->authority_model->get_director_other();
	}
	
	// president director
	function _rule15()
	{
		$ci = & get_instance();
		return $ci->authority_model->get_president();
	}
	
	// WILAYAH
	// kepala wilayah
	function _rule01()
	{
		$ci = & get_instance();
		return $ci->authority_model->get_branch_head($this->branch_id, $this->region_id);
	}
	
	
	// kepala divisi regional
	function _rule02()
	{
		$ci = & get_instance();		

		// wilayah, kadiv
		return $ci->authority_model->get_reg_division_head();

	}

	// direktur regional
	function _rule03()
	{
		$ci = & get_instance();
		return $ci->authority_model->get_reg_director();
	}
	
	// direktur lainya
	function _rule04()
	{
		$ci = & get_instance();
		return $ci->authority_model->get_director_other();
	}
	
	// direktur lainya
	function _rule05()
	{
		$ci = & get_instance();
		return $ci->authority_model->get_president();
	}
	
	function test($module_id, $cc_id, $type, $description, $amount)
	{
		$this->type = $type;
		$this->cc_id = $cc_id;
		$this->module_id = $module_id;
		$this->description = $description;
		$this->amount = $amount;
		
		$ci = & get_instance();	
		
		if (!is_numeric($module_id)) {
			debug("Error input: module_id empty");
			return "FATAL: Module tidak terdefinisi";
		}

		if (!is_numeric($type)) {
			debug("Error input: type empty") ;
			return "FATAL: Tipe transaksi tidak terdefinisi";
		}
		
		if (empty($description)) {
			debug("Error input: description empty");
			return "FATAL: Deskripsi tidak terdefinisi";
		}
		
		if (!is_numeric($amount)) {
			debug("Error input: amount empty");
			return "FATAL: Jumlah tidak terdefinisi";
		}
		
		debug("PARAMETER LOA YANG DI-ASSIGN");
		debug("module_id: " . $this->module_id);
		debug("cc_id: " . $this->cc_id . "-" . $ci->authority_model->get_cc_name($this->cc_id));
		debug("type_id: " . $type . "-" . $ci->authority_model->get_budget_type_name($type));
		debug("description: " . ($description ? $description : "Empty String"));
		debug("amount: " . $amount);
		
		# dapatkan parameter turunan
		$this->_get_parameters();
		
		debug("PARAMETER TURUNAN");
		debug("scope_id: " . ($this->is_ho ? '1-HO' : '2-WILAYAH'));
		debug("branch_id: " . $this->branch_id);	
		debug("region_id: " . $this->region_id);	
		debug("region_group_id:" . $this->region_group_id);	
		debug("company_id: " . $this->company_id);
		debug("ho_branch_id: " . $this->ho_branch_id);	
		debug("region_ho_branch_id: " . ($this->region_ho_branch_id ? $this->region_ho_branch_id : 'Undefined'));	
		debug("is_ho: " . ($this->is_ho ? 'true' : 'false'));
		debug("is_region_ho: " . ($this->is_region_ho ? 'true' : 'false'));	
		
		# dapatkan target nya		
		$targets = $this->_get_targets($type, $this->is_ho ? 1 : 2, $amount);
		debug("targets: " . print_r($targets, 1));
		if (!$targets || (count($targets) == 0)) return "LOA tidak ditemukan untuk transaksi ini.";
		
		# tentukan employee untuk tiap target
		$is_employee_ok = TRUE;
		$employees = array();
		foreach($targets as $target)
		{
			$result = $this->_rules($target);
			if ($result) $employees[] = $result; else { $employees[] = NULL; $is_employee_ok = FALSE; }
		}
		
		debug("employees: " . print_r($employees, 1));
				
		if (!$is_employee_ok) return "Ada employee dalam LOA yang tidak ditemukan.";
	}

	function set($module_id, $description, $amount, $doc_created, $period_id=0, $use_transaction = FALSE)
	{
		$this->module_id = $module_id;
		$this->description = $description;
		$this->amount = $amount;
		$this->use_transaction = $use_transaction;
		//$this->approval_members = array('1');
		$this->doc_created = $doc_created;
		
		$ci = & get_instance();	
		$this->approval_members = $ci->authority_model->get_approval_members();
	}
	function is_error()
	{
		if (!is_numeric($this->module_id)) {
			debug("Error input: module_id empty");
			$this->error_message = "FATAL: Module tidak terdefinisi";
			return "FATAL: Module tidak terdefinisi";
		}

		if (empty($this->description)) {
			debug("Error input: description empty");
			$this->error_message = "FATAL: Deskripsi tidak terdefinisi";
			return "FATAL: Deskripsi tidak terdefinisi";
		}
		
		if (!is_numeric($this->amount)) {
			debug("Error input: amount empty");
			$this->error_message = "FATAL: Jumlah tidak terdefinisi";
			return "FATAL: Jumlah tidak terdefinisi";
		}
		
		if (count($this->approval_members)==0) 
		{
			debug("Error input: employee empty");
			$this->error_message = "Tidak ada pegawai yang akan diminta approval.";
			return "Tidak ada pegawai yang akan diminta approval.";
		}
		return NULL;
	}
	function blast($data_id)
	{
		if (empty($data_id)) {
			debug("Error input: data id empty");
			return "FATAL: data id tidak terdefinisi";
		}
		$ci = & get_instance();	
		$result = $ci->authority_model->send($this->module_id, $data_id, $this->approval_members, $this->description, $this->amount, $this->user_id, $this->doc_created, $this->use_transaction);
		debug('blast done');
		return NULL;
	}
	
	function kill($data_id)
	{
		if (empty($data_id)) {
			debug("Error input: data id empty");
			return "FATAL: data id tidak terdefinisi";
		}
		$ci = & get_instance();
		$result = $ci->authority_model->kill($this->module_id, $data_id, $this->use_transaction); // use transaction for test
		return $result;
	}

}
#
