<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modul
{
  protected 	$ci;

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	function table($data =''){
		$result ="	
					
					<div class='box box-info'>
						<div style='height:10px;'></div>";
						
                    $result .= "   <!-- /.panel-heading -->
                        <div >

                            <div class='box-body table-responsive'>
                                <table id='example1' class='table table-bordered table-striped'>
                                    <thead>
                                        <tr style='text-transform:capitalize; font-weight:bold;'>";
                                            if (@$data['caption'] <> null ){
                                            
                                            for( $i=0;$i <= count( $data['caption'])  - 1; $i++ ){
                                                $result .= "<th width='". $data['width'][$i] ."' >".$data['caption'][$i]."</th>";
                                            }

                                        }
					  if($data['link'][0] != "" || $data['link'][1] != ""){
        $result .="                  <th style='text-align:center;'>ACTION</th>";
					}
		$result .="
        								</tr>
        								</thead>
                                    <tbody>";


                   
                     foreach ($data['data'] as $key) 
                        {
							
							
                            $result .="<tr class='odd gradeX'>";
                                for($i = 0; $i <= count( $data['field']) - 1; $i++ )
                                {

                                    $isidata = $key->$data['field'][$i];
									
									$format_number = ($data['is_number_format']) ? $data['field_format_number'][$i] : 0;
									
									if($format_number == 1){
										$result .= "<td style='text-align:right'>". number_format($isidata, 2) ."</td>";
									}else{
										$result .= "<td>". $isidata ."</td>";
									}
                                }
 
                                if($data['link'][0] != "" || $data['link'][1] != ""){
								   $result .="<td class='new_td'>";
								 
								if($data['link'][0]){
                                  	$result .="<a href='".base_url($data['link'][0].$key->$data['id'])."'><button class='btn btn-info' type='button' style='width:35px !important;'>
<i class='fa fa-edit'></i>
</button></a> &nbsp;"; 
								}
								
								if($data['link'][1]){
                                    $result .="<a href='".base_url($data['link'][1].$key->$data['id'])."'><button class='btn btn-info' type='button'>
<i class='fa fa-trash-o'></i>
</button></a>";
								}
									$result .= "</td>";
								   }
                                 
								   

                            $result .= "</tr>";
                          }
                

        $result .="                </tbody>
                                </table>

                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
						<div class='form-group'></div>
						";
				if($data['add']){
					$result .="<div class='box-footer'><a href='".base_url(@$data['add'])."' class='btn btn-primary'>
										<i class='fa fa-plus'></i> Add
									</a></div>";
					}
				$result .="
						
                    </div>
			";

         return $result;
	}

    function save($urls){
    
    $result ="
    <script type='text/javascript'>
        $(document).ready(function() { 
        var options = { 
    
            url:       '$urls',      
            type:      'POST',        
            dataType:  'html',
            clearForm: true, 
            success: function(data){
                $('.tampung').html(data);
            }
        }; 
     

    $('#myform').submit(function() { 
        $(this).ajaxSubmit(options); 
        return false; 
    }); 
	
    });  
</script>";    

 return $result;

    }
	
	 function save_redirect($data){
    
    $result ="
    <script type='text/javascript'>
        $(document).ready(function() { 
        var options = { 
    
            url:       '".$data['url']."',      
            type:      'POST',        
            dataType:  'html',
            success : function(data){
                $('.tampung').html(data);
                window.location = '".$data['callback']."';
            }
        }; 
    
    $('#myform').submit(function() { 
        $(this).ajaxSubmit(options); 
        return false; 
    }); 

    });  
</script>

";    

 return $result;

    }	

    function message($data){
       echo $result = "<script type='text/javascript'> alert('$data') </script>";
    }



    function get_code($data){
            $this->ci->load->model('global_model');
            $code['column'] = $data['column'];
            $code['where']  = $data['where'];
            $code['table']  = $data['table'];
            $cout_code = $this->ci->global_model->get_code( $code );

            $long_code = strlen( intval( $cout_code + 1 ) );
            $max_long_code = 7;
            $zero_man_code = '';
            for ( $i=1; $i <= ( $max_long_code - $long_code ); $i++ ){
                $zero_man_code .= "0";
            }
            $be_code = $data['code'].$zero_man_code. ($cout_code + 1);

            return $be_code;
    }

	

}

/* End of file Modul.php */
/* Location: ./application/libraries/Modul.php */
