<?php
class MY_Form_validation extends CI_Form_validation 
{
	function min_value($input, $param = 0)
	{
		$value = intval($input);
		$limit = intval($param);
		
		if ($value >= $limit) return true;
		return false;
	}
	
	function max_value($input, $param = 0)
	{
		$value = intval($input);
		$limit = intval($param);
		
		if ($value <= $limit) return true;
		return false;
	}
	
	function valid_date($str)
	{
		$segments = explode("/", $str);
		$segments = array_reverse($segments);
		if (count($segments) < 2) return false;
		if (!checkdate($segments[1], $segments[2], $segments[0])) return false; 
		
		return true;
	}
	
	function sql_date($str)
	{
		$segments = explode("/", $str);
		$segments = array_reverse($segments);
		if (count($segments) < 2) return '';
		if (!checkdate($segments[1], $segments[2], $segments[0])) return '';
		
		return implode("/", $segments);
	}
	
	
	function closing($str)
	{
		$ci = & get_instance();
		$query = $ci->db->get_where('periods', array('period_closed' => 't', 'period_id' => $str));
		if($query->num_rows() > 0)	
		{
			return false;
		}
		return true;
	}
	
	function zero_check($str)
	{
		if($str <= 0)
		{
			return false;
		}
		return true;
	}
	
	function numeric_check($str)
	{
		return (bool)preg_match('/^[0-9\.]+$/', $str);
	}
	
	function transient_mode($str)
	{
		if (strcmp($str, 'add') == 0 || strcmp($str, 'edit') == 0) return true;
		return false;
	}
	
	function doubles($str)
	{
		return (bool)preg_match('/^[0-9]+(?:\.[0-9]+)?$/im', $str);
		//return (bool)preg_match('/^[0-9]+([.][0-9])?$/', $str);
	}

	function payment($str)
	{
		return (bool)preg_match('/^([a-zA-Z]{3}+([.]))+[0-9]{7}$/', $str);
	}
	function money($str)
	{
		//debug("before $str");
		$segments = str_replace(',', '', $str);
		//debug("after $segments");
		return $segments;
	}
	
}
