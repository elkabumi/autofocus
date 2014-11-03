<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Printer extends CI_Controller {


	public function __construct(){

		parent::__construct();
	}

	public function index()
	{
    
	    //Load the library
	    $this->load->library('html2pdf');
	    $this->html2pdf->folder('dump/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename('reg.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper( 'a4', 'portrait');
	    
	    $data = "";

	    $mydata = $this->load->view('header.php',$data,TRUE) ;
	    $mydata .= $this->load->view('body.php',$data,TRUE) ;
	    $mydata .= $this->load->view('footer.php',$data,TRUE) ;
	    //Load html view
	    $this->html2pdf->html($mydata);
	    
	    if($this->html2pdf->create('save')) {
	    	header('Content-type: application/pdf');
			readfile('dump/reg.pdf');
	    }
  }


}

/* End of file printer.php */
/* Location: ./application/controllers/printer.php */