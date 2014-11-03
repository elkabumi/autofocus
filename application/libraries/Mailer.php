<?php

class Mailer 
{

	var $mail_error;
	
	function Mailer() {
		$ci = & get_instance();
		$ci->load->helper('email');
	}
	
	function send($to, $subject, $message)
	{
		$ci = & get_instance();
		
		if (!valid_email($to)) return false;
		$ci->load->library('email');

		$ci->email->initialize($ci->config->item('mailer'));
		$ci->email->set_newline("\r\n");

		$ci->email->from('kis.mailer@kopindosat.co.id', $ci->config->item('app_name'));
		$ci->email->to($to); 

		$ci->email->subject($subject);
		$ci->email->message($message);
		
		$this->mail_error = "";
		if (!$ci->config->item('use_mail')) return TRUE;
		
		$result = $ci->email->send();
		
		if (!$result) $this->mail_error = $ci->email->print_debugger();

		# debug("sending to $to : $subject - $message");
		return $result;
	}
	
	
	function send_approval_voter($approval_id)
	{
		$ci = & get_instance();		
		
		$ci->load->model('approval_model');
		$voter = $ci->approval_model->next_voter_from_approval($approval_id);
		
		if (!$voter) return FALSE;
		
		$user_id = $voter['user_id'];
		$to = $voter['employee_email'];
		$module = $voter['module_name'];
		$message = "Seseorang telah membuat dokumen yang memerlukan persetujuan Anda. Copy dan paste link dibawah ini.";
		$data = $voter['approval_data_id'];
		$link = $voter['module_approval_url'];
		
		$link = "$link/$data";
		
		$ci->load->model('redirect_model');		
		$mail = $ci->redirect_model->save($user_id, $link);
		
		return $this->send($to, "[$module] Lembar Persetujuan", "Dokumen: $module\n\n$message\n\n$mail");	
	}
	
	function send_rejection_voter($approval_id, $mails)
	{
		$ci = & get_instance();		
		
		foreach($mails as $mail) {
			
			$user_id = $mail['user_id'];
			$to = $mail['employee_email'];
			$module = $mail['module_name'];
			$message = "Seseorang telah MENOLAK dokumen yang telah Anda SETUJUI. Copy dan paste link dibawah ini.";
			$data = $mail['approval_data_id'];
			$link = $mail['module_approval_url'];
		
			$link = "$link/$data";
			$ci->load->model('redirect_model');		
			$mail = $ci->redirect_model->save($user_id, $link);
		
			$this->send($to, "[$module] Pemberitahuan PENOLAKAN dokumen", "Dokumen: $module\n\n$message\n\n$mail");	
		}
	}
	
	function send_rejection_user($to, $link, $module_name, $user_id) {
	
			$message = "Seseorang telah MENOLAK dokumen yang telah Anda BUAT. Copy dan paste link dibawah ini.";
			$ci = & get_instance();	
			$ci->load->model('redirect_model');		
			$mail = $ci->redirect_model->save($user_id, $link);
		
			$this->send($to, "[$module_name] Pemberitahuan PENOLAKAN dokumen", "Dokumen: $module_name\n\n$message\n\n$mail");
	}
	
}

#
