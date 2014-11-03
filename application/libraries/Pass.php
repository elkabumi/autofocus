<?php

class Pass 
{
	var $member_model = null;
	
	function set_model($model)
	{
		$this->member_model = $model;
	}
	
	function protect()
	{
		if ($this->member_model->valid_user()) 
		{
			$ci = & get_instance();
			
		}
	}
}

# --- end file --- #