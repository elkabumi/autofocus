<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
if (! function_exists('tool_money_format')) 
{
	function tool_money_format($number) 
	{
		return '<p class="table_format_money">' . format_money($number) . '</p>';
	}
}

if (! function_exists('format_money')) 
{
	function format_money($number) 
	{
		if (is_numeric($number)) return number_format($number, 2, ",",".") ;
		return $number;
		
	}
}
if ( ! function_exists('tool_clean_array'))
{
	function tool_clean_array($arr) 
	{
		if (!is_array($arr)) return str_replace(',', '&#44;', $arr);
		foreach($arr as $key => $value) $arr[$key] = tool_clean_array($value);
		return $arr;
	}
}
if ( ! function_exists('format_html'))
{
    function format_html($str_array) 
    {
       foreach($str_array as $key => $value)
       {
       		$str_array[$key] = htmlspecialchars(trim($value));
       }
       
       return $str_array;
    }		
}
if ( ! function_exists('send_json'))
{
    function send_json($json_array)
    {
    	
	    if (function_exists('json_encode'))
	    {
	    	$json_str = json_encode(tool_clean_array($json_array));
	    }
	    else 
	    {
	    	$json_str = 'json_encode is not supported';
	    }
	    
	    header("Content-length: ". strlen($json_str));
	    echo $json_str;
	    exit;
    }
}
if ( ! function_exists('send_json_message'))
{
	function send_json_message($type, $message, $param = '')
	{
		header("Content-type: application/json");
		$response['type']		= $type;
		$response['content']	= $message;
		$response['param']		= $param;
		echo json_encode($response);
		exit;
	}
}
if ( ! function_exists('send_json_error'))
{
      function send_json_error($message)
      {
	      	send_json_message('error', '<div class="error">' . $message . '</div>');
      }
}
if ( ! function_exists('send_json_redirect'))
{
      function send_json_redirect($url)
      {
      		if(is_ajax())send_json_message('redirect', $url );
		redirect($url);
		exit;
      }
}
if ( ! function_exists('send_json_action'))
{
      function send_json_action($is_ok, $success='Data Tersimpan', $failed='Data gagal Tersimpan', $param = '')
      {
      	if (!$is_ok) send_json_message('error',  $failed ); else send_json_message('success', $success, $param);
      	exit;
      }
}

if ( ! function_exists('get_datatables_control'))
{
    function get_datatables_control() 
    {
        $ci = & get_instance();
        $sort_column = $ci->input->get_post('iSortCol_0');
        $param['echo']	= $ci->input->get_post('sEcho');
        $param['offset'] = $ci->input->get_post('iDisplayStart');
        $param['limit'] = $ci->input->get_post('iDisplayLength');
        $param['sortColumn'] = $ci->input->get_post('iSortCol');
        $param['sortDirection'] = $ci->input->get_post('iSort');
        $param['category'] = $ci->input->get_post('kat');
	$param['keyword'] = trim($ci->input->get_post('q'));
	$param['more'] = trim($ci->input->post('more'));
		$param['sort_column'] = empty($sort_column) ? 0 : $sort_column;
	$param['sort_dir'] =  strcmp($ci->input->get_post('sSortDir_0'), 'asc') == 0 ? '' : ' DESC';
        
        return $param;
    }      
}

if ( ! function_exists('make_datatables_control'))
{
    function make_datatables_control($param, $data, $total, $number_column = NULL) 
    {
	if ($number_column && is_array($number_column)) 
    	{
    		foreach($data as $datakey => $row)
    		foreach($row as $key => $value) if (in_array($key, $number_column)) $data[$datakey][$key] = tool_money_format($value);
    	}
    	$result['aaData'] = $data;
        $result['iTotalRecords'] = $total;
        $result['iTotalDisplayRecords'] = intval($result['iTotalRecords']);
        $result['sEcho'] = intval($param['echo']);
        return $result;
    }		
}

if ( ! function_exists('make_datatables_list'))
{
    function make_datatables_list($data) 
    {
        $result['aaData'] = $data;
        return $result;
    }		
}

if ( ! function_exists('is_ajax'))
{
	function is_ajax ()
	{
	    if (
	        isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
	        && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") 
	        return true;
	    return false;
	} 
}

if ( ! function_exists('show')) {
    function show($view, $title = '', $data = array()) {
        $ci = &get_instance();
        $data['title'] = $ci->config->item('app_name') . ' | ' . $title;
        $data['view'] = $view;
        $data['layout'] = $ci->config->item('page_layout');
        $ci->load->view('layout/layout', $data);
    }
}
function encrypt($sData){ 
    $sResult = ''; 
	$ci = & get_instance();
	$sKey=$ci->session->userdata('session_id');
    for($i=0;$i<strlen($sData);$i++){ 
        $sChar    = substr($sData, $i, 1); 
        $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
        $sChar    = chr(ord($sChar) + ord($sKeyChar)); 
        $sResult .= $sChar; 
    } 
    $sBase64 = base64_encode($sResult); 
    return strtr($sBase64, '+/', '-_'); 
} 

function decrypt($sData){ 
    $sResult = ''; 
	$ci = & get_instance();
	$sKey=$ci->session->userdata('session_id');
	$sBase64 = strtr($sData, '-_', '+/'); 
    $sData   =  base64_decode($sBase64);
    for($i=0;$i<strlen($sData);$i++){ 
        $sChar    = substr($sData, $i, 1); 
        $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
        $sChar    = chr(ord($sChar) - ord($sKeyChar)); 
        $sResult .= $sChar; 
    } 
    return $sResult; 
} 


function encode_base64($sData){ 
    $sBase64 = base64_encode($sData); 
    return strtr($sBase64, '+/', '-_'); 
} 

function decode_base64($sData){ 
    $sBase64 = strtr($sData, '-_', '+/'); 
    return base64_decode($sBase64); 
}  
function check($key, $val){
	return ($key==$val)?'checked="checked"':'';
}
if ( ! function_exists('send_json_validate'))
{
    function send_json_validate()
    {
		if (FALSE === ($OBJ =& _get_validation_object()))
		{
			return '';
		}
		$errors = $OBJ->_error_array;

      	if (!empty($errors)) 
		{
		$errmsg = validation_errors('<li>', '</li>');
      	$response['errmsg'] = '<ul>'.$errmsg.'</ul>';
      	
		$response['type'] = 'error';
		$i=0;
		foreach ($errors as $key => $val)
		{
			if ($val != '')
			{
				$response['field'][$i]	= $key;
				$response['msg'][$i]	= $val;
				$i++;
			}
		}
		send_json($response);
		}
      	exit;
    }
}

if ( ! function_exists('format_epoch'))
{
	//$unix_timestamp = mktime($unix_timestamp, date("d")+1);
    function format_epoch($unix_timestamp, $format = 'd/m/Y') 
    {
		
		if(!$unix_timestamp)return '';
        return date($format, $unix_timestamp);
		
		/*$tgl = date('Y-m-d', $unix_timestamp);
		list($thn, $bln, $tgl) = explode("-", $tgl);
		$timestamp = mktime(0,0,0,$bln,$tgl+1,$thn);
        return date($format, $timestamp);*/
    }		
}

if ( ! function_exists('format_new_date'))
{
	//$unix_timestamp = mktime($unix_timestamp, date("d")+1);
    function format_new_date($unix_timestamp, $format = 'd/m/Y') 
    {
		
		if(!$unix_timestamp)return '';
        return date($format, strtotime($unix_timestamp));
		
		/*$tgl = date('Y-m-d', $unix_timestamp);
		list($thn, $bln, $tgl) = explode("-", $tgl);
		$timestamp = mktime(0,0,0,$bln,$tgl+1,$thn);
        return date($format, $timestamp);*/
    }		
}

if ( ! function_exists('debug') ) 
{
	function debug($out = NULL, $spacer = 0) 
	{
		$ci = & get_instance();
		$msg = '';
		if (!$out) {
			if(isset($ci->db))$msg = $ci->db->last_query();
		} 
		else if (is_array($out)) $msg = print_r($out, 1);
		else $msg = $out;		
		log_message('error', $msg);
	}
}
if ( ! function_exists('error') ) 
{
	function error($out = NULL, $spacer = 0) 
	{
		$ci = & get_instance();
		$msg = '';
		if (!$out) {
			if(isset($ci->db))$msg = $ci->db->last_query();
		} 
		else if (is_array($out)) $msg = print_r($out, 1);
		else $msg = $out;		
		log_message('ERROR', $out);
	}
}
if ( ! function_exists('null_default') ) 
{
	function null_default($input, $default) 
	{
		$data = $input;
		if (!$input || empty($input)) $data = $default;
		return $data;
	}
}
if ( ! function_exists('short_str') ) 
{
function short_str($str, $count = 50)
	{
		return strlen($str);
		$mystr = $str;
		if(strlen(trim($str)) <= $count)return $mystr;
		if(strlen($str)>$count)
		{
			$str_short = substr($str,0,$count);
			$end = $count;
			if($str[$count]!=' ')
			{
				$i=0;
				while(true)
				{
					if($str[$count+$i]==' '){$end=$count+$i;break;}
					if($str[$count-$i]==' '){$end=$count-$i;break;}
					$i++;
				}
				$str_short = substr($str,0,$end);
			}
			$str_short .= '...';
			$mystr = form_transient_pair('transient_desc', $str_short, null, null, $str);
		}
		return $mystr;
	}
}
if ( ! function_exists('form_transient_pair'))
{
    function form_transient_pair($name, $display_value, $hidden_value = null, $other_value_pair = array(), $hint = null) 
    {
		$hidden_pairs = "";
		$hidden_hints = "";
		
		// bila hidden_value ngga di sebutkan/null maka disamakan sama display value
		$hidden_value = (!isset($hidden_value) ? $display_value : $hidden_value);
		
		if ($other_value_pair)
		foreach($other_value_pair as $key => $value) 
		{
			$hidden_pairs .= sprintf("<input type=\"hidden\" name=\"%s[]\" value=\"%s\" />", $key, $value);
		}
		
		if ($hint) {
			$hidden_hints = sprintf("<input type=\"hidden\" id=\"hidden_hint\" value=\"$hint\" />"); 
		}
		
		return sprintf("%s <input type=\"hidden\" name=\"%s[]\" value=\"%s\" /> $hidden_pairs $hidden_hints", $display_value, $name, $hidden_value);
    }		
}
if ( ! function_exists('query'))
{
	function query()
	{	
		$ci = &get_instance();
		echo $ci->db->last_query();exit;
	}
}
if ( ! function_exists('send_json_error_feedback'))
{
      function send_json_error_feedback()
      {
      	send_json(array('status' => 'error', 'id' => '', 'value' => '', 'desc' => ''));
      }
}
if ( ! function_exists('send_json_lookup_feedback'))
{
      function send_json_lookup_feedback($id, $value, $desc, $detail = '')
      {
            send_json(array('id' => $id, 'value' => $value, 'desc' => $desc, 'status' => 'ok', 'detail' => $detail));
      }
}
if ( ! function_exists('format_zero_padding'))
{
    function format_zero_padding($int, $width) 
    {
       return sprintf("%0" . $width . "d", $int);
    }		
}
if ( ! function_exists('send_json_transient'))
{
      function send_json_transient($index, $data)
      {
            $transient_data = array(
				'mode' => (strlen(trim($index)) == 0 ? 'add' : 'edit'),
				'index' => $index, 
				'data' => $data			
			);
			send_json($transient_data);
      }
}
if (! function_exists('format_code')) {
	function format_code($table, $column, $prefix = '', $code_length = 4, $separator = '')
	{
		$number = 0;
		$code = array();
		
		$code[] = $prefix;
		$fixed_length = strlen($prefix) + 1;
		
		$ci = & get_instance();
		$ci->db->select($column);
		if($prefix)$ci->db->like($column, $prefix, 'after');
		//if($condition)$ci->db->where($condition);
		$ci->db->order_by($column, 'desc');
		$query = $ci->db->get($table, 1);
		/*
		$where = '';
		if($prefix){
		$where = "where $column like '%$prefix%'";
		}
		
		$sql = "
		select * from $table
		$where  order by $column desc
			";

		
		$query = $this->db->query($sql);
		*/
		if ($query->num_rows() != 0) 
		{
			$row 	= $query->row_array();
			if($prefix)$number = intval(substr($row[$column], $fixed_length, $code_length));
			else $number = intval($row[$column]);
		}
		
		$code[] = format_zero_padding($number + 1, $code_length);
		return implode($separator, $code);
	
	}
} 
if (! function_exists('code_generator'))
{
	function code_generator($len)
	{
		$alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
		
		$code = '';
		for($i = 0; $i < $len; $i++)
		{
			$index = rand(0, strlen($alpha)-1);
			$code .= substr($alpha, $index, 1);			
		} # forde
		
		return $code;
		
	} # function
	
}
if (! function_exists('get_gender')) {
	function get_gender($id = '')
	{
		if($id == 1) return 'Laki-laki';
		else return 'Perempuan';
	}
} 
if ( ! function_exists('format_date'))
{
    function format_date($dt) 
    {
		if(strlen($dt)<10)return '1970-01-01';
		$tm_arr = explode('/',$dt);
        return $tm_arr[2].'-'.$tm_arr[1].'-'.$tm_arr[0];
    }		
}
if ( ! function_exists('ppn_mode_dropdown'))
{
	function ppn_mode_dropdown($name, $selected = '2', $extra = '')
	{
		return form_dropdown($name, $options = array('Tanpa PPN', 'PPN'), $selected, $extra);
	}
}
if (! function_exists('get_coa_product')) {
	function get_coa_product($pc)
	{		
		$ci = & get_instance();
		$ci->db->select('*');
		$ci->db->where('product_cat_id', $pc);
		$ci->db->where('module_id', $ci->access->module_id);
		$query = $ci->db->get('product_category_items', 1);
		
		$row['debit_ac_no'] = 0;
		$row['credit_ac_no'] = 0;
		if ($query->num_rows() != 0) 
		{
			$row 	= $query->row_array();
		}
		
		return $row;
	
	}
} 
if (! function_exists('get_coa_tax')) {
	function get_coa_tax($tax_type_id)
	{		
		$ci = & get_instance();
		$ci->db->select('*');
		$ci->db->where('tax_type_id', $tax_type_id);
		$query = $ci->db->get('tax_types', 1);
		
		$result = 0;
		if ($query->num_rows() != 0) 
		{
			$row 	= $query->row_array();
			$result = $row['coa_id'];
		}
		else debug('Coa pajak ppn tidak ditemukan');
		return $result;
	
	}
} 

if (! function_exists('show_checkbox_status')) {
	function show_checkbox_status($status = '0')
	{
		if($status == 0)
		{
			return '<input type="checkbox" disabled="disabled" />';
			//return "Inactive";
		}
		else
		{
			return '<input type="checkbox" disabled="disabled" checked="true" />';
			//return "Active";
		}
	}
}



if ( ! function_exists('login_redirect'))
{
	function login_redirect($url)
	{
		header("Content-type: application/json");
		$response['aaData']	= array();
		$response['status']= 1;
		$response['nRow']= 0;
		$response['iDisplayIndex']= 0;
		$response['url']= $url;
		echo json_encode($response);
		exit;
	}
}
if ( ! function_exists('get_collectors'))
{
	function get_collectors($market_id)
	{
		$ci = & get_instance();
		$ci->db->select('collector_id', 1);
		$ci->db->where('market_id', $market_id);
		$query = $ci->db->get('collectors');
		$data = array();
		foreach($query->result_array() as $row)
		{
			$data[] = $row['collector_id'];
		}
		return $data;
	}
}
/* End of file ajax_helper.php */
/* Location: ./application/helpers/ajax_helper.php */
