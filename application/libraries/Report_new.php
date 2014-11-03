<?php
//Load the library
class Report_new{
	function report_new(){
		$ci = $this->ci = & get_instance();
	}
	function create_report($content, $data){
		
	    $this->load->library('html2pdf');
	    $this->html2pdf->folder('dump/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename('reg.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper( 'a4', 'portrait');
	    
	   	

	    $mydata = $this->load->view('header.php',$data,TRUE) ;
	    $mydata .= $this->load->view($content, $data,TRUE) ;
	    $mydata .= $this->load->view('footer.php',$data,TRUE) ;
	    //Load html view
	    $this->html2pdf->html($mydata);
	    
	    if($this->html2pdf->create('save')) {
	    	header('Content-type: application/pdf');
			readfile('dump/reg.pdf');
	    }
	}
}
?>