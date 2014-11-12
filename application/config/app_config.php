<?php

$config['app_name']		= 'Autofocus';
$config['app_client']		= 'Autofocus';

$config['is_production']	= false;
$config['is_debugging']		= false;

$extern_dir					= '../external/';

$config['log_mode']			= 'db';
$config['syslog_file']		= $extern_dir . 'logs/sys.log';
$config['datalog_file']		= $extern_dir . 'logs/data.log';

//$config['upload_mode']	= 'file';
//$config['upload_tmp']		= $extern_dir . 'upload/';
//$config['upload_cpath']	= $extern_dir . 'cpath/';

$config['report_proc_path']	= 'system/tmp/';
$config['report_bank_path']	= 'system/application/reports/';
$config['tools_path']		= 'system/tools/';

$config['upload_mode']		= 'file';
$config['upload_tmp']		= 'tmp/';
$config['upload_storage']	= 'storage/';

$config['upload_maxsize']	= 100;

$config['max_display_rows']	= 1000; 
$config['months']		= array('','Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
# mailer

$config['mailer']['useragent'] 	= $config['app_name'] . '_MAILER';
$config['mailer']['protocol']  	= 'smtp';
$config['mailer']['smtp_host'] 	= 'server.teramedia.co.id';
//$config['mailer']['smtp_host'] 	= 'localhost';
$config['mailer']['smtp_user'] 	= '';
$config['mailer']['smtp_pass'] 	= '';
$config['mailer']['charset'] 	= 'iso-8859-1';
$config['mailer']['wordwrap'] 	= TRUE;

// SETUP
$config['use_mail']		= false;

// LOA
$config['po_cc'] 					= 18; // dev : 37 -- cc khusus untuk procurement
$config['budget_cc'] 				= 11; // dev : 23 -- cc khusus untuk keuangan
$config['budget_relocation_cc']		= 11; // dev : 23 -- cc khusus untuk keuangan
$config['div_parent_region_cc'] 	= 55; // dev : 55 -- cc khusus untuk divisi yang membawai regional / wilayah

//
$config['rfp_settlement_cc'] 		= 11; // sit : Untuk menampilkan tombol settlement
$config['rfp_cc'] 					= 11; // sit : Untuk LOA
$config['ap_cc'] 					= 11; // sit : Untuk LOA
$config['ap_debit_cc'] 				= 11; // sit : Untuk LOA
$config['ap_credit_cc'] 			= 11; // sit : Untuk LOA
$config['closing_cc'] 				= 11; // sit : Untuk LOA
$config['coa_hutang_rfp'] 			= 216;
$config['coa_piutang_rfp'] 			= 58;

$config['sodl_cc']					= 11;
$config['ar_cc']					= 11; // ap_cc
$config['cm_ocr_cc']				= 8; //sama seperti cm_ap_cc
$config['overbook_cc']				= 8;
$config['cm_ar_cc']					= 8;
$config['transfercross_cc']			= 8;
$config['cm_overbook_cc']			= 8;


$config['cm_rfp_cc'] 				= 8;  // kis03 : untuk persetujuan cm_rfp
$config['cm_ap_cc'] 				= 8;
$config['arnonpo_cc']				= 11;
$config['cm_arnonpo_cc']			= 8;

$config['overbook_coa']				= 137;
$config['transfercross_coa']		= 137;
$config['cm_overbook_coa']			= 137;

$config['budget_is_open']			= true; // set false jika ingin menggunakan budget triwulan
$config['pos_menu']			= 1;
$config['layout']			= 'default';
# -- end file -- #
