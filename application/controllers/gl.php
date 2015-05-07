<?
define('EDIT_CONTROL', 1, TRUE);
define('MEMO_CONTROL', 2, TRUE);
define('BACK_CONTROL', 4, TRUE);
define('PRINT_CONTROL', 8, TRUE);
class Gl extends CI_Controller 
{
	
	var $id ; 
	
	function __construct()
	{		
		parent::__construct();
		//$this->load->library('access');
		//$this->load->model('gl_model');
		//$this->load->library('render');
		//$this->load->helper('form');
		//$this->load->model('global_model');
		
		$this->load->library('render');
		$this->access->set_module('accounting.gl');	
		$this->access->user_page();
		$this->load->model('gl_model');
		$this->load->library('render');
		$this->load->helper('form');
		$this->load->model('global_model');
	}// end of function
	
	function index()
	{	
		$this->render->add_view('app/gl/list');
		$this->render->build('Daftar Jurnal Umum');
		$this->render->show('Jurnal Umum');
		
	}// end of function 
	
	function gl_table_controller()
	{
	
		$data = $this->gl_model->gl_list_controller(get_datatables_control());
		send_json($data); 
	
	}//end of function 
	
	function form($id=0)
	{
		$data = array();
		
		if($id == 0)
		{
		
			$data['row_id'] 					= '';
			$data['trans_type'] 				= $this->gl_model->get_trans_type(0);
			$data['period_id'] 					= '';
			$data['transaction_id'] 			= '';
			$data['transaction_correction_id'] 			= '';
			$data['transaction_description'] 	= '';
			$data['transaction_type_id'] 		= '';
			$data['transaction_code'] 			= format_code('gl_code','value','',7);
			$data['transaction_date'] 			= '';
			$data['show_control']		 = EDIT_CONTROL|BACK_CONTROL;
			
		}
		else
		{
			$result = $this->gl_model->gl_read_id($id);
			if ($result) // cek dulu apakah data ditemukan 
			{
				$data = $result;
				if($data['transaction_is_approved'] == 'f')$data['show_control']= EDIT_CONTROL|BACK_CONTROL|PRINT_CONTROL;	
				else $data['show_control']	= 	BACK_CONTROL;
				$data['row_id'] = $id;
				
			}
			
		}
		 		
		$this->load->model('global_model');	
		$this->load->helper('form');
		$data['row_id']					= $data['transaction_id'];
		$data['trans_type'] 			= $this->gl_model->get_trans_type();
		$data2 							= $this->gl_model->sum_item($id);
		$data['period'] 				= $this->global_model->get_period();
		
		$data2['total_debit'] = $id== ''?'0':$result['journal_debit'];
		$data2['total_kredit'] = $id== ''?'0':$result['journal_credit'];	
		
		$this->render->add_form('app/gl/form', $data);
		$this->render->build('Jurnal Umum');
		
		$data_type['tipe'] = $data['transaction_type_id'];
				
		$this->render->add_view('app/gl/journal/list', $data2);
		$this->render->build('Jurnal ');
		
		
		
		$this->access->generate_log_view($id);
		$this->render->show('Daftar Jurnal Umum');			
	}// end of function 
	
	function gl_form_action($is_delete=0)
	{
		$this->load->library('form_validation');
		
		
		
		
		// selalu cek input dari client. ini kriterianya. perhatikan ada [] di nama field nya
		$this->form_validation->set_rules('i_kode', 'No. Transaksi', 'trim|required|max_length[20]'); 
		$this->form_validation->set_rules('i_tanggal', 'Tanggal', 'trim|required|valid_date|sql_date');// gunakan selalu trim di awal
		$this->form_validation->set_rules('i_desc', 'Keterangan', 'trim|required');		
		if($this->input->post('i_trans_type') == '81'){
			$this->form_validation->set_rules('i_transaction_correction_id', 'Transaksi', 'trim|required'); // gunakan selalu trim di awal
		
		}
		
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate(); // bila input tidak valid, exit dan kirim kesalahan
		// cek data 
		$coa_id 		= $this->input->post('transient_account');
		if(!$coa_id) send_json_error('Data jurnal belum ada');
		$sum_kredit 	= 0;
		$sum_debit 		= 0;
		
		$id = $this->input->post('row_id');

			$datatrans['transaction_code'] 			= $this->input->post('i_kode');
			$datatrans['period_id'] 				= $this->input->post('i_period');		
			$datatrans['transaction_type_id'] 		= $this->input->post('i_trans_type');
			$datatrans['transaction_date']			= $this->input->post('i_tanggal');
			$datatrans['transaction_description'] 	= $this->input->post('i_desc');
			$datatrans['transaction_is_approved'] 	= 1;
			
			if($datatrans['transaction_type_id'] == '81'){
				$datatrans['transaction_correction_id'] = $this->input->post('i_transaction_correction_id');
			}else{
				$datatrans['transaction_correction_id'] = 0;
			}
				
		// nilai post yang kirim adalah array karena terdiri dari banyak row. perhatikan tanpa[].
		$list_coa_id 		= $this->input->post('transient_account');
		$list_market_id 	= $this->input->post('transient_market');
		$list_debit 		= $this->input->post('transient_debit');
		$list_kredit 		= $this->input->post('transient_kredit');
		$list_desc 			= $this->input->post('transient_desc');
		
		$gl_code = $datatrans['transaction_code'] 	;
		// ubah input array ke data
		$data = array();
		foreach($list_coa_id as $key => $value)
		{
			$data[] = array(
				'coa_id'  				=> $list_coa_id[$key],
				'market_id'  			=> $list_market_id[$key],
				'journal_description' 	=> $list_desc[$key],
				'journal_debit' 		=> $list_debit[$key],
				'journal_credit' 		=> $list_kredit[$key]
			);
			$sum_kredit += $list_kredit[$key];
			$sum_debit += $list_debit[$key];
		}
		if($sum_kredit != $sum_debit) send_json_error('Jumlah debit harus sama dengan jumlah kredit');
		
		
		if($id)
		{
			$check_approved = $this->gl_model->check_approved($id);
			if($check_approved){
				send_json_error('Update data gagal. Transaksi sudah disetujui');
			}else{
			//$is_doc_closed = is_doc_closed($id, 'transactions', 'transaction_id', 'transaction_date');
			$error = $this->gl_model->update_transaction($id, $datatrans, $data, $sum_kredit);
			send_json_action($error, "Data telah direvisi", "Data gagal direvisi", $id);
			}
		}
		else 
		{
			$error = $this->gl_model->create_transaction($datatrans, $data, $sum_kredit, $gl_code);
			send_json_action($error, "Data telah disimpan", "Data gagal disimpan", $this->gl_model->insert_id);
		}
		
		
	}// end of function 
	
	function journal_loader($transaction_id=0)
	{
		if($transaction_id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->gl_model->transient_loader($transaction_id);

		foreach($data as $key => $value) 
		{	
			$debit = $value['journal_debit']==0?'':tool_money_format($value['journal_debit']);
			$credit = $value['journal_credit']==0?'':tool_money_format($value['journal_credit']);
			$data[$key] = array(
				form_transient_pair('transient_account', $value['coa_hierarchy'], $value['coa_id'], null, $value['coa_name']),
				form_transient_pair('transient_coa_name',$value['coa_name'], $value['coa_name']), 
				form_transient_pair('transient_market', $value['market_name'], $value['market_id']),
				form_transient_pair('transient_desc',$value['journal_description']),
				form_transient_pair('transient_debit', $debit, $value['journal_debit']), 
				form_transient_pair('transient_kredit', $credit, $value['journal_credit'])
			);
		}
		
		send_json(make_datatables_list($data)); 
	}
	
	function journal_loader_koreksi($transaction_id=0)
	{
		if($transaction_id == 0)send_json(make_datatables_list(null)); 
				
		$data = $this->gl_model->transient_loader($transaction_id);

		foreach($data as $key => $value) 
		{	
			$debit = $value['journal_debit']==0?'':tool_money_format($value['journal_debit']);
			$credit = $value['journal_credit']==0?'':tool_money_format($value['journal_credit']);
			$data[$key] = array(
				form_transient_pair('transient_account_koreksi', $value['coa_hierarchy'], $value['coa_id'], null, $value['coa_name']), 
				form_transient_pair('transient_coa_name_koreksi', $value['coa_name'], $value['coa_name']),
				form_transient_pair('transient_market_koreksi', $value['market_name'], $value['market_id']),
				form_transient_pair('transient_desc_koreksi',$value['journal_description']),
				form_transient_pair('transient_debit_koreksi', $debit, $value['journal_debit']), 
				form_transient_pair('transient_kredit_koreksi', $credit, $value['journal_credit'])
			);
		}
		
		send_json(make_datatables_list($data)); 
	}
	
	
	
	function journal_form($transaction_id = 0) // jika id tidak diisi maka dianggap create, else dianggap edit
	{
		$this->load->library('render');
		
		$data['transaction_id'] 	= $transaction_id;
		$index = $this->input->post('transient_index');
		
		if (strlen(trim($index)) == 0) {
					
			// TRANSIENT CREATE - isi form dengan nilai default / kosong
			$data['index']			= '';
			$data['tipe'] 			= 0;
			$data['coa_id'] 		= 0;
			$data['market_id']		= 0;
			$data['desc'] 			= '';
			$data['amount'] 		= 0;
		} else {

			// TRANSIENT EDIT - ambil data dari table yg dikirim dari client kemudian tampilkan
			// karena data yang dikirim adalah array, untuk mengambilnya menggunakan array_shift saja.
			$data['index'] 			= $index;
			$data['coa_id'] 		= array_shift($this->input->post('transient_account'));
			$data['market_id']		= array_shift($this->input->post('transient_market'));
			$data['desc'] 			= array_shift($this->input->post('transient_desc'));
			$debit					= array_shift($this->input->post('transient_debit'));
			$kredit					= array_shift($this->input->post('transient_kredit'));
			if($debit != 0){
				$data['amount'] 	= $debit;
				$data['tipe'] 		= 0;
			}
			else{
				$data['amount'] 	= $kredit;
				$data['tipe'] 		= 1;
			}
		}
		
		$this->render->add_form('app/gl/journal/form', $data);
		$this->render->show_buffer();
	}
	
	function journal_control()
	{
		
		$this->load->library('form_validation');
		
		// selalu cek input dari client. ini kriterianya
		$this->form_validation->set_rules('i_transaction_id', 'Data Transaksi', 'trim|integer|required');
		$this->form_validation->set_rules('i_account', 'Account', 'trim|required'); // gunakan selalu trim di awal
		$this->form_validation->set_rules('i_market', 'Unit Pasar', 'trim|required'); 
		$this->form_validation->set_rules('i_keterangan', 'Keterangan', 'trim');
		$this->form_validation->set_rules('i_jumlah', 'Jumlah', 'trim|numeric|required'); 
				
		// cek data berdasarkan kriteria
		if ($this->form_validation->run() == FALSE) send_json_validate();
			
		// cek dulu apa warehouse / parent table nya ada
		$index 			= $this->input->post('i_index');
		$transaction_id	= $this->input->post('i_transaction_id');
		$coa_id 		= $this->input->post('i_account');
		$market_id 		= $this->input->post('i_market');
		$desc 			= $this->input->post('i_keterangan');
		$jumlah 		= $this->input->post('i_jumlah');
		$tipe 			= $this->input->post('i_tipe');
		
		if($coa_id == 0 || $market_id ==0)send_json_error('Data belum lengkap');
		
		$coa = $this->global_model->get_coa($coa_id);
		$market = $this->global_model->get_market_value($market_id);
		//$job = $this->global_model->get_job($job_id);
				
		if($tipe == 0)
		{
			$debit = $jumlah;
			$kredit = 0;
		}
		else
		{
			$debit = 0;
			$kredit = $jumlah;
		}
		$debit_display 	= $debit==0?'':tool_money_format($debit);
		$credit_display = $kredit==0?'':tool_money_format($kredit);
		$data = array(
			form_transient_pair('transient_account', $coa['coa_hierarchy'], $coa_id), 
			form_transient_pair('transient_coa_name',$coa['coa_name']), 
			form_transient_pair('transient_market', $market['market_code'], $market_id),
			form_transient_pair('transient_desc', $desc),
			form_transient_pair('transient_debit', $debit_display, $debit), 
			form_transient_pair('transient_kredit', $credit_display, $kredit),
			//form_transient_pair('transient_tipe', $tipe)
		);
		
		$sum_debit 		= $debit;
		$sum_kredit 	= $kredit;
		$list_coa_id 	= $this->input->post('transient_account');
		$list_debit 	= $this->input->post('transient_debit');
		$list_kredit 	= $this->input->post('transient_kredit');
		
		if($list_coa_id)
		{
			foreach($list_coa_id as $key => $value)
			{
				$sum_debit 	= $sum_debit + $list_debit[$key];
				$sum_kredit = $sum_kredit + $list_kredit[$key];			
			}
		}
		/*echo "<script>$('#debit').val('$sum_debit');</script>";*/
		send_json_transient($index, $data);
		
	}
	
	function periods() {
	
		$this->load->library('render');
		$this->render->add_view('app/gl/period');
		$this->render->build('Daftar Periode Penutupan');
		
		$this->render->show('blank', 'Daftar Periode Penutupan');
		
	}
	
	function periods_control()
	{
		$data = $this->gl_model->period_list(get_datatables_control());
		send_json($data); 
	}
	
	/*
	
	lookup
	
	*/
	function coa_table_control()
	{
		$this->access->set_module('gl.journal');
		$this->access->user_page();
		$this->load->library('dtc');
		$this->dtc->coa_control();
	}
	function coa_lookup_hierarchy()
	{
		$this->access->set_module('gl.journal');
		$this->access->user_page();
		$this->load->library('dtc');
		$this->dtc->coa_get();
	}
		
	function announcer()
	{
		$this->access->set_module('gl.journal');
		$this->access->user_page();
		$data = $this->gl_model->get_announcer();
		if($data)
		{
			$data['aktif'] = ($data['status_active']=='t')?1:0;
		}
		else 
		{
		$data['aktif'] = 1;
		$data['closing_period_m'] = intval(date('m'));
		$data['closing_period_y'] = date('Y');
		$data['closing_date'] = date('d/m/Y');
		$data['closing_hour'] = 0;
		$data['closing_minute'] = 0;
		$data['announce_text'] = '';
		}
		$data['cbo_month'] = month_array();
		
		$this->render->add_form('freeform','app/gl/form_announcer', $data);
		$this->render->build('Pengumuman Tutup Buku');
		
		$this->render->show('blank', 'Tutup Buku');
	}
	
	function announce_action($is_delete=0)
	{
		$this->access->set_module('gl.journal');
		$this->access->user_page();
		$id = $this->input->post('row_id');
		
		if($is_delete)
		{	
			send_json_error('Data tidak boleh dihapus');			
			
		}// end if 
		$this->load->library('form_validation');
		$this->form_validation->set_rules('i_tanggal', 'Tanggal', 'trim|required|valid_date|sql_date');
		if ($this->form_validation->run() == FALSE) send_json_validate();
		
		$data['aktif'] = $this->input->post('i_aktif');
		$data['closing_period_m'] = $this->input->post('i_period_m');
		$data['closing_period_y'] = $this->input->post('i_period_y');
		$data['closing_date'] = $this->input->post('i_tanggal');
		$data['closing_hour'] = $this->input->post('i_hour');
		$data['closing_minute'] = $this->input->post('i_minute');
		$data['status_active'] = $data['aktif']?'t':'f';
		$data['announce_text'] = $this->input->post('i_desc');
		$success = $this->gl_model->update_announcer($data);
		send_json_action($success, "Data telah disimpan", "Data gagal disimpan");
	}
	
	function print_jurnal($id) 
	{		
		$this->load->library('regen');		
		$this->regen->set_title('GL21', 'JURNAL UMUM', '');
		$this->regen->add_parameter('INPUT_ID', $id, REGEN_INTEGER);
		//$branch = $this->access->branch_id;
		//$this->regen->add_parameter('INPUT_BRANCH1', $branch, REGEN_INTEGER);
		$this->regen->build_show('gl/print_jurnal');
	}
	function print_jurnal_sl($id) 
	{		
		$this->load->library('regen');
		$this->regen->set_title('GL21', 'JURNAL UMUM', '');
		$branch = $this->access->branch_id;
		//print_r($branch);exit
		$is_sl = "_sl";
		$this->regen->add_parameter('INPUT_ID', $id, REGEN_INTEGER);	
		$this->regen->add_parameter('IS_SL', $is_sl, REGEN_STRING);	
		//$this->regen->add_parameter('INPUT_BRANCH1', $branch, REGEN_INTEGER);
		$this->regen->build_show('gl/print_jurnal');
	}
	function form_approval($id = 0)
	{
		$data = array();
		$this->load->library('approval');
		
		$data = array();
		$data = $this->gl_model->gl_read_id($id);
		if (!$data) // cek dulu apakah data ditemukan 
		{
			$this->load->library('dialog');
			$this->dialog->flash_note('Error','Data tidak ditemukan', 'gl');	
			return;
		}
		$this->load->model('global_model');
		$this->load->helper('form');
		$data['row_id']					= $data['transaction_id'];
		$data['trans_type'] 			= $this->gl_model->get_trans_type();
		$data2 							= $this->gl_model->sum_item($id);
		$data['period'] 				= $this->global_model->get_period();
		$data['show_control']	= 0;
		$data['row_id'] = $id;
		$this->render->add_form('app/gl/form', $data);
		$this->render->build('Jurnal Umum');
		
		
		$data_type['tipe'] = $data['transaction_type_id'];
		$this->render->add_view('app/gl/journal/list_koreksi', $data_type);
		
		$this->render->add_view('app/gl/journal/list', $data2);
		$this->render->build('Jurnal');
		$this->approval->show($id, 'gl/approval_submit', 'gl/form_approval'.$id);
		$this->render->show('Daftar Jurnal Umum');			
	}
	
	function approval_submit()
	{	
		$this->load->library('approval');
		$is_ok = $this->approval->submit('gl'); 
		
		if ($is_ok) 
		{
			switch($this->approval->status())
			{
				case 0:
					// menunggu approval
					// harusnya tidak melakukan apa2x
				break;
				case 1:
					// telah di approve semua
					// flag is_approved di-set ke TRUE
#					debug('accepted');
				
				$this->gl_model->approve($this->approval->data_id, $this->input->post('i_trans_type'));
				break;
				
				case 2:
					// ada yg menolak
					//$this->business_patcher_license_model->reject($this->approval->data_id);
				break;				
			}			
		}
		send_json_action($is_ok, "Persetujuan tersimpan", "Persetujuan gagal di simpan");
	}
	
	function create_gl(){
		$query = $this->gl_model->lihat_gl();
		$t=count($query);
		for($i=0; $i<$t;$i++){
			$adri =  $query[$i];
			$this->gl_model->create_gl($adri[4], $sum_kredit, $transaction_date, $period_id);
		}
	}
}
// END General Journal Class

/* End of file gl.php */
/* Location: ./application/controllers/gl.php */
