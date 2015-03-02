<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "approved/form_approved_action",
		backPage		: "approved",
		nextPage		: "approved"
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
		$('#print_estimasi').click(function(){
		
				location.href = site_url + 'registration/report/' + $('input[name="row_id"]').val();
			
		});
		
		$('#print_kwitansi').click(function(){
			location.href = site_url + 'approved/report_kwitansi/' + $('input[name="row_id"]').val();
			
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
         <input type="text" class="com_input" size="6" /> 
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
               
				<input type="text" class="com_input" />
				<input type="hidden" name="i_registration_date2" class="date_input" size="15" value="<?=$registration_date?>" />
				 <div class="iconic_base iconic_search com_popup"></div>
				</span></td>
    </tr>
      <tr>
          <td width="17%">Kode Transaksi</td>
          <td width="1%">:</td>
          <td width="82%"><input name="i_code" type="text" id="i_code" value="<?=$registration_code ?>" /></td>
        </tr>
    <tr>
      <td>Data Pelanggan
        </td>
      <td>:</td>
      <td> <span class="lookup" id="lookup_customer">
        <input type="hidden" name="i_customer_id" class="com_id" value="<?=$customer_id?>" />
        
        <input type="text" class="com_input" />
        <div class="iconic_base iconic_search com_popup"></div>
          <span class="com_desc"></span>
        </span></td>
    </tr>
    <tr>
      <td>Data Mobil</td>
      <td>:</td>
      <td> <span class="lookup" id="lookup_car">
				<input type="hidden" name="i_car_id" class="com_id" value="<?=$car_id?>" />
              
				<input type="text" class="com_input" />
				  <div class="iconic_base iconic_search com_popup"></div>
                    <span class="com_desc"></span>
				</span></td>
    </tr>
      <tr>
      <td>Klaim</td>
      <td>:</td>
      <td><label>
         <input type="radio" name="i_claim_type" value="1" id="i_claim_type" <?php if($claim_type == 1){ ?> checked="checked"<?php } ?> />
         Menggunakan Asuransi</label>
     <br />
       <label>
         <input name="i_claim_type" type="radio" id="i_claim_type" value="0" <?php if($claim_type == 0){ ?> checked="checked"<?php } ?>/>
         Pribadi
       </label></td>
    </tr>
<?php
		if($claim_type == 1){
			$kwitansi ='OR';
?>
 <tr>
      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="4" id="asuransi" style="width:100%;">
        <tr>
          <td width="17%">Asuransi</td>
          <td width="1%">:</td>
          <td width="82%"><span class="lookup" id="lookup_insurance">
				<input type="hidden" name="i_insurance_id" class="com_id" value="<?=$insurance_id?>" />
              
				<input type="text" class="com_input" />
				  <div class="iconic_base iconic_search com_popup"></div>
				</span></td>
        </tr>
        <tr>
          <td width="17%">PIC Asuransi</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" id="i_pic_asuransi" name="i_pic_asuransi" value="<?=$pic_asuransi?>" /></td>
        </tr>
      </table></td>
     </tr>   
      <tr>
     <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="no_klaim" style="width:100%;">
        <tr>
          <td width="17%">No Klaim</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" id="i_claim_no" name="i_claim_no" value="<?=$claim_no?>"/></td>
        </tr>
      </table></td>
      
				
				
      </tr>
       <tr>
     <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="pph" style="width:100%;">
        <tr>
          <td width="17%">PPh %</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" id="i_insurance_pph" name="i_insurance_pph" value="<?=$insurance_pph?>" readonly="readonly" /></td>
        </tr>
      </table></td>
      
<?php } 
		if($claim_type == 0){
			$kwitansi ='DP';
?>
				
      </tr>
            <tr>
     <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="pribadi" style="width:100%;">
        <tr>
          <td width="17%">Bayar Dp</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" id="i_registration_dp" name="i_registration_dp" value="<?=$registration_dp?>" /></td>
        </tr>
      </table></td>
				
		<?php } ?>		
      </tr>
       <tr>
          <td width="17%">No SPK</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" id="i_spk_no" name="i_spk_no"  value="<?=$spk_no?>" /></td>
        </tr>
        <tr>
          <td width="17%">No PKB</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" id="i_pkb_no" name="i_pkb_no" value="<?=$pkb_no?>" /></td>
        </tr>
        <?php
		if($claim_type == 1){
?>
          <tr>
          <td width="17%">Own Retention (OR)</td>
          <td width="1%">:</td>
          <td width="82%"><input type="text" id="i_own_retention" name="i_own_retention" value="<?=$own_retention?>"  /></td>
        </tr>
        <?php } ?>
        <tr>
      <td>Tanggal Masuk   	  </td>
      <td>:</td>
      <td><input type="text" name="i_check_in" class="date_input" size="15" value="<?=$check_in?>" /></td>
    </tr>
     <tr>
      <td>Tanggal Estimasi Keluar   	  </td>
      <td>:</td>
      <td><input type="text" name="i_registration_estimation_date" class="date_input" size="15" value="<?=$registration_estimation_date?>" /></td>
    </tr>
     <tr>
      <td>Tanggal SPK  </td>
      <td>:</td>
      <td><input type="text" name="i_spk_date" class="date_input" size="15" value="<?=$spk_date?>" /></td>
    </tr>
       <tr>
    <td width="158" valign="top">Keterangan</td>
    <td width="10" valign="top">:</td>
    <td width="745" valign="top"><textarea name="i_registration_description" id="i_registration_description" cols="45" rows="5"><?=$registration_description?></textarea></td>
    </tr>
   
   
     </table>
     </div>
	
	<div class="command_bar">
		<input type="button" id="submit" value="Simpan Registrasi"/>
		<input type="button" id="enable" value="Setujui"/>
	
		<input type="button" id="cancel" value="Batal"/>
        <input type="button" id="print_estimasi" value="Cetak Estimasi"  />
        <input type="button" id="print_kwitansi" value="Cetak Kwitansi <?= $kwitansi?>"  />
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