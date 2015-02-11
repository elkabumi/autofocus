<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "payment/form_action",
		backPage		: "payment",
		nextPage		: "payment"
	});
	createLookUp({
		table_id		: "#lookup_table_period",
		table_width		: 400,
		listSource 		: "lookup/period_table_control",
		dataSource		: "lookup/period_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_period",
		filter_by		: [{id : "p1", label : "Kode"},{id : "p2", label : "Nama"}]
	});

	createLookUp({
		table_id		: "#lookup_table_employee_group",
		table_width		: 400,
		listSource 		: "lookup/employee_group_table_control",
		dataSource		: "lookup/employee_group_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_employee_group",
		filter_by		: [{id : "p1", label : "Kode"},{id : "p2", label : "Nama"}]
	});
	
	
	createLookUp({
		table_id		: "#lookup_table_stand",
		table_width		: 400,
		listSource 		: "lookup/stand_table_control",
		dataSource		: "lookup/stand_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_stand",
		filter_by		: [{id : "p1", label : "Nama Cabang"}]
	});
	
	createLookUp({
		table_id		: "#lookup_table_customer",
		table_width		: 400,
		listSource 		: "lookup/customer_table_control",
		dataSource		: "lookup/customer_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_customer",
		filter_by		: [{id : "p1", label : "Nomor"}, {id : "p2", label : "Nama"}]
	});
	
	createLookUp({
		table_id		: "#lookup_table_car",
		table_width		: 400,
		listSource 		: "lookup/car_table_control",
		dataSource		: "lookup/car_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_car",
		filter_by		: [{id : "p1", label : "Nopol"}, {id : "p2", label : "No Rangka"}, {id : "p3", label : "No Mesin"}]
	});
	
	createLookUp({
		table_id		: "#lookup_table_insurance",
		table_width		: 400,
		listSource 		: "lookup/insurance_table_control",
		dataSource		: "lookup/insurance_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_insurance",
		filter_by		: [{id : "p1", label : "Nama"}],
		onSelect		: load_insurance_pph
	});
	
		
		
		
		
	$('input[name="i_claim_type"]').change(function(){
		var asuransi = document.getElementById("asuransi");
		var no_klaim = document.getElementById("no_klaim");
		var pribadi = document.getElementById("pribadi");
		var pph = document.getElementById("pph");
		
		if($(this).val() == 1){
			asuransi.style.display = 'table';
			no_klaim.style.display = 'table';
			pribadi.style.display = 'none';
			pph.style.display = 'table';
	
		}else{
			asuransi.style.display = 'none';
			no_klaim.style.display = 'none';
			pribadi.style.display = 'table';
			pph.style.display = 'none';
			
		}
		
		
	});
	
	$('input[name="i_bayar"]').change(function(){
		var total = $('input[name="i_belum_bayar"]').val();
		var bayar = $(this).val();
		var sisa = total - bayar;
		
			$('input[name="i_sisa"]').val(sisa);
		
		if(sisa == 0){
			$('input[name="i_status"]').val(0);
			}else{
				$('input[name="i_status"]').val(1);
				}
			
			
	});
		
		
	function load_insurance_pph()
	{
		var id 	= $('input[name="i_insurance_id"]').val();
		
		if(id == ""){
			return;
		}
		var data ='id='+id; 
		
		$.ajax({
			type: 'POST',
			url: '<?=site_url('registration/load_insurance_pph')?>',
			data: data,
			dataType: 'json',
			success: function(data){	
				$('input[name="i_insurance_pph"]').val(data.content['insurance_pph']);	
			}
			
		});
	}

	function cek_status(){
		var type = '<?= $claim_type ?>';//$('input[name="i_claim_type"]').val();
		
		if(type == 1){
			var or_sisa 	= $('input[name="i_own_retention_sisa"]').val();
			var pembayaran_sisa 	= $('input[name="i_pembayaran_sisa"]').val();

			if(or_sisa == 0 && or_sisa != ""){
				if(pembayaran_sisa == 0 && pembayaran_sisa != ""){
					$('input[name="i_status"]').val("1");
					$('input[name="i_status_name"]').val("LUNAS");
				}else{
					$('input[name="i_status"]').val("0");
					$('input[name="i_status_name"]').val("BELUM LUNAS");
				}
			}else{
				$('input[name="i_status"]').val("0");
				$('input[name="i_status_name"]').val("BELUM LUNAS");
			}
		}else{
			var pembayaran_sisa 	= $('input[name="i_pembayaran_sisa"]').val();
			if(pembayaran_sisa == 0 && pembayaran_sisa != ""){
				$('input[name="i_status"]').val("1");
				$('input[name="i_status_name"]').val("LUNAS");
			}else{
				$('input[name="i_status"]').val("0");
				$('input[name="i_status_name"]').val("BELUM LUNAS");
			}
			
		}
	}

	if($('input[name="i_claim_type"]').val() == 1){
		$('input[name="i_own_retention_dibayar"]').change(function(){
			var or_dibayar 	= $('input[name="i_own_retention_dibayar"]').val();
			var or = $('input[name="i_own_retention"]').val();
			
			sisa = or - or_dibayar;

			$('input[name="i_own_retention_sisa"]').val(sisa);

			cek_status();
			
		});
	}

	$('input[name="i_pembayaran_dibayar"]').change(function(){
		var pembayaran_dibayar 	= $('input[name="i_pembayaran_dibayar"]').val();
		var pembayaran = $('input[name="i_pembayaran"]').val();
		
		sisa = pembayaran - pembayaran_dibayar;

		$('input[name="i_pembayaran_sisa"]').val(sisa);

		cek_status();
		
	});

	createDatePicker();
	//updateAll(); 
});

</script>
<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
	<table width="100%" cellpadding="4" class="form_layout">
	<tr>
			<td width="17%">Periode
               
            </td>
			<td width="1%" >:</td>
			<td  width="82%" > <span class="lookup" id="lookup_period">
         <input type="hidden" name="i_period_id" class="com_id" value="<?=$period_id?>" />
         <input type="text" readonly="readonly" class="com_input" size="6" /> 
         <input type="hidden" name="row_id" value="<?=$row_id?>" />

         <div class="iconic_base iconic_search com_popup"></div> <input type="hidden" name="i_transaction_id" value="<?=$transaction_id?>" />
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
          <td width="17%">Kode Transaksi</td>
          <td width="1%">:</td>
          <td width="82%"><input name="i_code" readonly="readonly" type="text" id="i_code" value="<?=$registration_code ?>" /></td>
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
         <input type="radio" name="i_claim_type"  readonly="readonly" value="1" id="i_claim_type" <?php if($claim_type == 1){ ?> checked="checked"<?php } ?> />
         Menggunakan Asuransi</label>
     <br />
       <label>
         <input name="i_claim_type" readonly="readonly" type="radio" id="i_claim_type" value="0" <?php if($claim_type == 0){ ?> checked="checked"<?php } ?>/>
         Pribadi
       </label></td>
    </tr>
<?php
		if($claim_type == 1){
?>
 <tr>
      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="4" id="asuransi" style="width:100%;">
        <tr>
          <td width="17%">Asuransi</td>
          <td width="1%">:</td>
          <td width="82%"><span class="lookup" id="lookup_insurance">
				<input type="hidden" name="i_insurance_id" class="com_id" value="<?=$insurance_id?>" />
              
				<input type="text"  readonly="readonly" class="com_input" />
				  <div class="iconic_base iconic_search com_popup"></div>
				</span></td>
        </tr>
        <tr>
          <td width="17%">PIC Asuransi</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" readonly="readonly" id="i_pic_asuransi" name="i_pic_asuransi" value="<?=$pic_asuransi?>" /></td>
        </tr>
      </table></td>
     </tr>   
      <tr>
     <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="no_klaim" style="width:100%;">
        <tr>
          <td width="17%">No Klaim</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" readonly="readonly" id="i_claim_no" name="i_claim_no" value="<?=$claim_no?>"/></td>
        </tr>
      </table></td>
      
				
				
      </tr>
       <tr>
     <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="pph" style="width:100%;">
        <tr>
          <td width="17%">PPh %</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" readonly="readonly" id="i_insurance_pph" name="i_insurance_pph" value="<?=$insurance_pph?>" readonly="readonly" /></td>
        </tr>
      </table></td>
      
<?php } 
		if($claim_type == 0){
?>
				
      </tr>
            <tr>
     <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="pribadi" style="width:100%;">
        <tr>
          <td width="17%">Bayar Dp</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" id="i_registration_dp" readonly="readonly" name="i_registration_dp" value="<?=$registration_dp?>" /></td>
        </tr>
      </table></td>
				
		<?php } ?>		
      </tr>
       <tr>
          <td width="17%">No SPK</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" id="i_spk_no" readonly="readonly" name="i_spk_no"  value="<?=$spk_no?>" /></td>
        </tr>
        <tr>
          <td width="17%">No PKB</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" id="i_pkb_no"  readonly="readonly" name="i_pkb_no" value="<?=$pkb_no?>" /></td>
        </tr>
        <?php
		if($claim_type == 1){
?>
          <tr>
          <td width="17%">Own Retention (OR)</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" readonly="readonly" id="i_own_retention" name="i_own_retention" value="<?=$own_retention?>"  /></td>
        </tr>
        <?php } ?>
        <tr>
      <td>Tanggal Masuk</td>
      <td>:</td>
      <td><input type="text" readonly="readonly" name="i_check_in" class="date_input" size="15" value="<?=$check_in?>" /></td>
    </tr>
     <tr>
      <td>Tanggal Estimasi Keluar   	  </td>
      <td>:</td>
      <td><input type="text" readonly="readonly" name="i_registration_estimation_date" class="date_input" size="15" value="<?=$registration_estimation_date?>" /></td>
    </tr>
     <tr>
      <td>Tanggal SPK  </td>
      <td>:</td>
      <td><input type="text" name="i_spk_date" readonly="readonly" class="date_input" size="15" value="<?=$spk_date?>" /></td>
    </tr>
       <tr>
    <td width="158" valign="top">Keterangan</td>
    <td width="10" valign="top">:</td>
    <td width="745" valign="top"><textarea name="i_registration_description" readonly="readonly" id="i_registration_description" cols="45" rows="5"><?=$registration_description?></textarea></td>
    </tr>
   
   
     </table>

<div class="form_category">Total Biaya</div>
	<table width="800" cellpadding="4" class="form_layout">
    <tr>
      <td width="23%">Tanggal Pembayaran</td>
      <td width="1%">:</td>
      <td width="76%"><input type="text" readonly="readonly" name="i_payment_date" class="date_input" size="15" value="<?=$payment_date?>" /></td>
    </tr>
<!--
	<tr>
   <td>Total Sperpart</td>
         <td>:</td>
       <td><input name="i_total_sperpart" readonly="readonly" type="text" id="i_total_sperpart" value="<?=$approved_sparepart_total_registration?>" /></td>
     </tr>
     <tr>
     <td>Total Jasa</td>
     <td>:</td>
       <td><input name="i_total_jasa" readonly="readonly" type="text" id="i_total_jasa" value="<?=$transaction_total ?>" /></td>
     </tr>
     <tr>
     <td>Total Cat</td>
     <td>:</td>
       <td><input name="i_total_cat" readonly="readonly" type="text" id="i_total_cat" value="<?=$transaction_material_total ?>"/></td>
     </tr>
     <? if($claim_type == 1){
		  	 $grand_total = $own_retention;
			 $ansuransi = $approved_sparepart_total_registration + $transaction_total + $transaction_material_total - $own_retention;
			 ?>
		<tr>
          <td>Dibayar Ansuransi</td>
          <td>:</td>
          <td><input type="text" readonly="readonly" id="i_own_retention" name="i_own_retention" value="<?=$ansuransi?>"  /></td>
        </tr>
			 <?
		 }else{?>
			 <tr>
          <td>Bayar Dp</td>
          <td>:</td>
          <td><input type="text" readonly="readonly" id="i_registration_dp" name="i_registration_dp" value="<?=$registration_dp?>" /></td>
        </tr>
		<?
			 $grand_total = $approved_sparepart_total_registration + $transaction_total + $transaction_material_total - $registration_dp;
			 }
    
	 ?>
     <tr>
     <td>Grand Total</td>
     <td>:</td>
       <td><input name="i_grand_total" readonly="readonly" type="text" id="i_grand_total" value="<?=$grand_total ?>"/></td>
     </tr>
     <? 
	 if($sisa <> 0){
     	 $total_pembayaran = $sisa;
		 ?>
		 <tr>
     <td>Sudah di bayar</td>
     <td>:</td>
       <td><input name="i_sudah_bayar" readonly="readonly" type="text" id="i_sudah_bayar" value="<?=$dibayar ?>"/></td>
     </tr>
     
	 <?
	 }else{
		 $total_pembayaran = $grand_total;
		 }
	 ?>
     <tr>
     <td>Belum di bayar</td>
     <td>:</td>
       <td><input name="i_belum_bayar" readonly="readonly" type="text" id="i_belum_bayar" value="<?=$total_pembayaran ?>"/></td>
     </tr>
     <tr>
     <td>Dibayar</td>
     <td>:</td>
       <td><input name="i_bayar" type="text" id="i_bayar" value="0"/><input name="i_status" type="hidden" id="i_status" value=""/></td>
     </tr>
     <tr>
     <td>Sisa Pembayaran</td>
     <td>:</td>
       <td><input name="i_sisa" readonly="readonly" type="text" id="i_sisa" value="<?=$total_pembayaran ?>"/></td>
     </tr>
     -->
     <tr>
   <td>Total Sparepart</td>
         <td>:</td>
       <td><input name="i_approved_sparepart_total_registration" readonly="readonly" type="text" id="i_approved_sparepart_total_registration" value="<?=$approved_sparepart_total_registration?>" /></td>
     </tr>

      <tr>
   <td>Total Jasa</td>
         <td>:</td>
       <td><input name="i_approved_total_registration" readonly="readonly" type="text" id="i_approved_total_registration" value="<?=$approved_total_registration?>" /></td>
     </tr>
    
	<tr>
   <td>Total Biaya</td>
         <td>:</td>
       <td><input name="i_total_biaya_estimasi" readonly="readonly" type="text" id="i_total_biaya_estimasi" value="<?=$total_biaya_estimasi?>" /></td>
     </tr>

     <tr>
   <td>PPH</td>
         <td>:</td>
       <td><input name="i_insurance_pph_value" readonly="readonly" type="text" id="i_insurance_pph_value" value="<?=$insurance_pph_value?>" /></td>
     </tr>
      <td>Total Biaya setelah PPH</td>
         <td>:</td>
       <td><input name="i_total_biaya_estimasi_after_pph" readonly="readonly" type="text" id="i_total_biaya_estimasi_after_pph" value="<?=$total_biaya_estimasi_after_pph?>" />
 <input type="hidden" name="i_payment_id" class="com_id" value="<?=$payment_id?>" />
       </td>
     </tr>
   </table>


 <? if($claim_type == 1){ ?>

<div class="form_category">Pembayaran OR</div>
	<table width="800" cellpadding="4" class="form_layout">
   <tr>
   <td width="23%">Own Retention</td>
         <td width="1%">:</td>
       <td width="76%"><input name="i_own_retention" readonly="readonly" type="text" id="i_own_retention" value="<?=$own_retention?>" /></td>
     </tr>
      <tr>
   <td>Dibayar</td>
         <td>:</td>
       <td><input name="i_own_retention_dibayar" type="text" id="i_own_retention_dibayar" value="<?=$own_retention_dibayar?>" /></td>
     </tr>
       <tr>
   <td>Sisa OR</td>
         <td>:</td>
       <td><input name="i_own_retention_sisa" readonly="readonly" type="text" id="i_own_retention_sisa" value="<?=$own_retention_sisa?>" /></td>
     </tr>
   
      </table>	
      <div class="form_category">Pembayaran Asuransi</div>
	<table width="800" cellpadding="4" class="form_layout">
   <tr>
   <td width="23%">Biaya Ditanggung Asuransi</td>
         <td width="1%">:</td>
       <td width="76%"><input name="i_pembayaran" readonly="readonly" type="text" id="i_pembayaran" value="<?=$pembayaran?>" /></td>
     </tr>
      <tr>
   <td>Dibayar</td>
         <td>:</td>
       <td><input name="i_pembayaran_dibayar"  type="text" id="i_pembayaran_dibayar" value="<?=$pembayaran_dibayar?>" /></td>
     </tr>
      <tr>
   <td>Sisa Ditanggung Asuransi</td>
         <td>:</td>
       <td><input name="i_pembayaran_sisa" readonly="readonly" type="text" id="i_pembayaran_sisa" value="<?=$pembayaran_sisa?>" /></td>
     </tr>
     <tr>
   <td>Status</td>
         <td>:</td>
       <td><input name="i_status" readonly="readonly" type="hidden" id="i_status" value="<?= $status ?>" />
<input name="i_status_name" readonly="readonly" type="text" id="i_status_name" value="<?= $status_name ?>" />
       </td>
     </tr>
      </table>	
 <?php }else{ ?>

  <div class="form_category">Pembayaran Pribadi</div>
	<table width="800" cellpadding="4" class="form_layout">
   <tr>
   <td width="23%">DP</td>
         <td width="1%">:</td>
       <td width="76%"><input name="i_registration_dp" readonly="readonly" type="text" id="i_registration_dp" value="<?=$registration_dp?>" /></td>
     </tr>
      <tr>
   <td>Dibayar</td>
         <td>:</td>
       <td>
<input name="i_pembayaran"  type="hidden" id="i_pembayaran" value="<?=$pembayaran?>" />
       	<input name="i_pembayaran_dibayar"  type="text" id="i_pembayaran_dibayar" value="<?=$pembayaran_dibayar?>" /></td>
     </tr>
      <tr>
   <td>Sisa</td>
         <td>:</td>
       <td><input name="i_pembayaran_sisa" readonly="readonly" type="text" id="i_pembayaran_sisa" value="<?=$pembayaran_sisa?>" /></td>
     </tr>
     <tr>
   <td>Status</td>
         <td>:</td>
       <td><input name="i_status" readonly="readonly" type="hidden" id="i_status" value="<?= $status ?>" />
		<input name="i_status_name" readonly="readonly" type="text" id="i_status_name" value="<?= $status_name ?>" />
       </td>
     </tr>
      </table>	
    
<?php
}
?>
     </div>
	
	<div class="command_bar">
		<input type="button" id="submit" value="Simpan"/>
		<input type="button" id="enable" value="Edit"/>
	
		<input type="button" id="cancel" value="Batal"/>
	</div>
</div>
<!-- table contact -->

</form>


<div id="">
	<table id="lookup_table_customer" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
            <th>Nomor</th>
				<th>Nama</th>
            
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>


<div id="">
	<table id="lookup_table_car" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
            <th>Nopol</th>
			<th>Model</th>
            <th>No Rangka</th>
            <th>No Mesin</th>
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>

<div id="">
	<table id="lookup_table_insurance" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
				<th>Nama</th>
            
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>

<div id="">
	<table id="lookup_table_stand" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
				<th>Nama</th>
            
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>


<div id="">
	<table id="lookup_table_period" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
				<th>Periode</th>
				<th>Status</th>
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>


<div id="">
	<table id="lookup_table_employee_group" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
				<th>Nama</th>
				<th>Keterangan</th>
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>