<style>
.asuransi{
	font-size:13px;
	font-weight:bold;
	font-family:"MS Serif", "New York", serif;
	padding:5px;
	padding-top:25px;
	}
.tanda_tangan{
	font-weight:bold;
	font-family:"MS Serif", "New York", serif;
	padding-top:100px;
}
</style>
<<table width="100%" cellpadding="4" class="form_layout">
	<tr>
			<td width="217">Periode
               
            </td>
			<td width="3" >:</td>
			<td  width="720" > <span class="lookup" id="lookup_period">
         <input type="hidden" name="i_period_id" class="com_id" value="<?=$period_id?>" />
         <input type="text" readonly="readonly" class="com_input" size="6" /> 
         <input type="hidden" name="row_id" value="<?=$row_id?>" />
         <div class="iconic_base iconic_search com_popup"></div>
       </span></td> 
		</tr>
   
   <tr>
      <td>Cabang
        		</td>
      <td>:</td>
      <td>  <span class="lookup" id="lookup_stand">
				<input type="hidden" name="i_stand_id" class="com_id" value="<?=$stand_id?>" />
               
				<input type="text" readonly="readonly" class="com_input" />
				<input type="hidden" name="i_registration_date2" class="date_input" size="15" value="<?=$registration_date?>" />
				 <div class="iconic_base iconic_search com_popup"></div>
				</span></td>
    </tr>
      <tr>
          <td width="217">Kode Transaksi</td>
          <td width="3">:</td>
          <td width="720"><input name="i_code" readonly="readonly" type="text" id="i_code" value="<?=$registration_code ?>" /></td>
        </tr>
    <tr>
      <td>Data Pelanggan
        </td>
      <td>:</td>
      <td> <span class="lookup" id="lookup_customer">
        <input type="hidden" name="i_customer_id" class="com_id" value="<?=$customer_id?>" />
        
        <input type="text" readonly="readonly" class="com_input" />
        <div class="iconic_base iconic_search com_popup"></div>
          <span class="com_desc"></span>
        </span></td>
    </tr>
    <tr>
      <td>Data Mobil</td>
      <td>:</td>
      <td> <span class="lookup" id="lookup_car">
				<input type="hidden" name="i_car_id" class="com_id" value="<?=$car_id?>" />
              
				<input type="text" readonly="readonly" class="com_input" />
				  <div class="iconic_base iconic_search com_popup"></div>
                    <span class="com_desc"></span>
				</span></td>
    </tr>
      <tr>
      <td>Klaim</td>
      <td>:</td>
      <td><label>
         <input type="radio" name="i_claim_type" readonly="readonly" value="1" id="i_claim_type" <?php if($claim_type == 1){ ?> checked="checked"<?php } ?> />
         Menggunakan Asuransi</label>
     <br />
       <label>
         <input name="i_claim_type" type="radio" readonly="readonly" id="i_claim_type" value="0" <?php if($claim_type == 0){ ?> checked="checked"<?php } ?>/>
         Pribadi
       </label></td>
    </tr>

 <tr>
      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="asuransi" style="width:100%;">
        <tr>
          <td width="24%">Asuransi</td>
          <td width="1%">:</td>
          <td width="75%"><span class="lookup" id="lookup_insurance">
				<input type="hidden" name="i_insurance_id" class="com_id" value="<?=$insurance_id?>" />
              
				<input type="text" readonly="readonly" class="com_input" />
				  <div class="iconic_base iconic_search com_popup"></div>
				</span></td>
        </tr>
      </table></td>
     </tr>   
      <tr>
     <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="no_klaim" style="width:100%;">
        <tr>
          <td width="24%">No Klaim</td>
          <td width="1%">:</td>
          <td width="75%"><input type="text" readonly="readonly" id="i_claim_no" name="i_claim_no" value="<?= $claim_no ?>" /></td>
        </tr>
      </table></td>
				
				
      </tr>
        <tr>
      <td>Tanggal Masuk   	  </td>
      <td>:</td>
      <td><input type="text" readonly="readonly" name="i_check_in"value="<?= format_new_date($check_in) ?>" /></td>
    </tr>
     <tr>
      <td>Tanggal Estimasi Keluar   	  </td>
      <td>:</td>
      <td><input type="text" readonly="readonly" name="i_registration_estimation_date" value="<?= format_new_date($registration_estimation_date) ?>" /></td>
    </tr>
       <tr>
    <td width="217" valign="top">Keterangan</td>
    <td width="3" valign="top">:</td>
    <td width="720" valign="top"><textarea name="i_registration_description" readonly="readonly" id="i_registration_description" cols="45" rows="5"><?=$registration_description?></textarea></td>
    </tr>
   
   
     </table>
<!-- table contact -->

</form>
<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
	<table width="100%" cellpadding="4" class="form_layout">
    <tr>
      <td width="23%">Tim Kerja</td>
      <td width="1%">:</td>
      <td width="76%"> <span class="lookup" id="lookup_employee_group">
				<input type="hidden" name="i_employee_group_id" class="com_id" value="<?=$employee_group_id?>" />
              	<input type="hidden" name="row_id" value="<?=$row_id?>" />
            	<input type="hidden" name="i_transaction_id" value="<?=$transaction_id?>" />
				<input type="text" class="com_input" />
				  <div class="iconic_base iconic_search com_popup"></div>
                    <span class="com_desc"></span>
				</span></td>
    </tr>
	<tr>
   <td>Tanggal awal plain</td>
         <td>:</td>
       <td><input name="i_first_date" type="text" id="i_first_date" value="<?= format_new_date($transaction_plain_first_date) ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal akhir plain</td>
     <td>:</td>
       <td><input name="i_last_date" type="text" id="i_last_date" value="<?= format_new_date($transaction_plain_last_date) ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal Aktual</td>
     <td>:</td>
       <td><input name="i_actual_date" type="text" id="i_actual_date" value="<?= format_new_date($transaction_actual_date) ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal target selesai</td>
     <td>:</td>
       <td><input name="i_target_date" type="text" id="i_target_date" value="<?= format_new_date($transaction_target_date) ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Keterangan bongkar komponen</td>
     <td>:</td>
       <td><input name="i_komponen" type="text" id="i_komponen" value="<?=$transaction_komponen ?>" /></td>
     </tr>
     <tr>
     <td>Keterangan las/ketok</td>
     <td>:</td>
       <td><input name="i_lasketok" type="text" id="i_lasketok" value="<?=$transaction_lasketok ?>" /></td>
     </tr>
     <tr>
     <td>Keterangan dempul</td>
     <td>:</td>
       <td><input name="i_dempul" type="text" id="i_dempul" value="<?=$transaction_dempul ?>" /></td>
     </tr>
     <tr>
     <td>Keterangan cat</td>
     <td>:</td>
       <td><input name="i_cat" type="text" id="i_cat" value="<?=$transaction_cat ?>" /></td>
     </tr>
     <tr>
     <td>Keterangan poles</td>
     <td>:</td>
       <td><input name="i_poles" type="text" id="i_poles" value="<?=$transaction_poles ?>" /></td>
     </tr>
     <tr>
     <td>Keterangan rakit</td>
     <td>:</td>
       <td><input name="i_rakit" type="text" id="i_rakit" value="<?=$transaction_rakit ?>" /></td>
     </tr>
     </table>
</div>
<div class="table_title">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   
    <td width="5%">No</td>
    <td width="15%">Deskripsi</td>
    <td width="16%" align="right">Qty</td>
    <td width="40%" align="right">Jumlah</td>
  </tr>
  </table>
  </div>
  <div class="table_content">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  $no = 1;
  foreach($data_detail as $item): ?>
  <tr>
   
    <td width="5%"><?=$no?></td>
    <td width="15%"><?=$item['product_name']." (".$item['product_category_name'].")"?></td>
    <td width="16%" align="right"><?=$item['detail_transaction_qty']?></td>
    <td width="40%" align="right"><?=number_format($item['detail_transaction_total_price'], 0)?></td>
  </tr>
  <?php 
    $no++;
  endforeach; 

  ?>
  </table>
  </div>
<div class="table_footer">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>TOTAL</strong></td>
    <td width="33%" align="right"><?=number_format($total_transaction, 0)?></td>
  </tr>
  <tr>
  <td width="100%" align="left"><?= "(".Terbilang($total_transaction).".Rupiah)" ?></td>
  </tr>
  <div class="tanda_tangan">
  <table width="100%">
  <tr>
  <td>Authorized Signatory / Stamp</td>
  </tr>
  </table>
  </div>
  </table>
</div>
</div>
<i><h6><b><u>Catatan (Untuk kepentingan asuransi):</u> Biaya Administrasi Sistem Rp. 5,344</h6></b></i> 


  ?>