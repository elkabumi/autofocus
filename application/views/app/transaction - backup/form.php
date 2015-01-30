<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "transaction/form_action",
		backPage		: "transaction",
		nextPage		: "transaction/form"
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
		filter_by		: [{id : "p1", label : "Nama"}]
	});
	
	createLookUp({
		table_id		: "#lookup_table_employee_group",
		table_width		: 400,
		listSource 		: "lookup/employee_group_table_control",
		dataSource		: "lookup/employee_group_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_employee_group",
		filter_by		: [{id : "p1", label : "Nama"}]
	});
	
	
	$('input[name="i_komponen"]').change(function(){
		
			var komponen = $('input[name="i_komponen"]').val();
			komponen = parseFloat(komponen);
			if(komponen > 100){
				alert("Keterangan bongkar Komponen  tidak boleh lebih dari 100%");
			}
		}
	);
	$('input[name="i_lasketok"]').change(function(){
			var lasketok = $('input[name="i_lasketok"]').val();
			lasketok = parseFloat(lasketok);
			if(lasketok > 100){
				alert("Keterangan  Lasketok  tidak boleh lebih dari 100%");
			}
		}
	);
	$('input[name="i_dempul"]').change(function(){
			var dempul = $('input[name="i_dempul"]').val();
			dempul = parseFloat(dempul);
			if(dempul > 100){
				alert("Keterangan  Dempul  tidak boleh lebih dari 100%");
			}
		}
	);
	$('input[name="i_cat"]').change(function(){
			var cat = $('input[name="i_cat"]').val();
			cat = parseFloat(cat);
			if(cat > 100){
				alert("Keterangan  Cat  tidak boleh lebih dari 100%");
			}
		}
	);
	$('input[name="i_poles"]').change(function(){
			var poles = $('input[name="i_poles"]').val();
			poles = parseFloat(poles);
			if(poles > 100){
				alert("Keterangan  Poles  tidak boleh lebih dari 100%");
			}
		}
	);
	$('input[name="i_rakit"]').change(function(){
			var rakit = $('input[name="i_rakit"]').val();
			rakit = parseFloat(rakit);
			if(rakit > 100){
				alert("Keterangan  Rakit  tidak boleh lebih dari 100%");
			}
		}
	);
	
	$('input[name="i_claim_type"]').change(function(){
		var asuransi = document.getElementById("asuransi");
		var no_klaim = document.getElementById("no_klaim");
		
		if($(this).val() == 1){
			asuransi.style.display = 'table';
			no_klaim.style.display = 'table';
	
		}else{
			asuransi.style.display = 'none';
			no_klaim.style.display = 'none';
			
		}
		
});

$('#print_spk').click(function(){
		
				location.href = site_url + 'spk/report/' + $('input[name="row_id"]').val();
			
	});
	
	$('#print_pkb').click(function(){
		
				location.href = site_url + 'pkb/report/' + $('input[name="row_id"]').val();
			
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
       <td><input name="i_last_date"   type="text" id="i_last_date" value="<?= format_new_date($transaction_plain_last_date) ?>" class="date_input"/></td>
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
     <td>Keterangan bongkar komponen %</td>
     <td>:</td>
       <td><input name="i_komponen"   type="text" id="i_komponen" value="<?=$transaction_komponen ?>"/></td>
     </tr>
     <tr>
     <td>Keterangan las/ketok %</td>
     <td>:</td>
       <td><input name="i_lasketok" type="text" id="i_lasketok" value="<?=$transaction_lasketok ?>" /></td>
     </tr>
     <tr>
     <td>Keterangan dempul %</td>
     <td>:</td>
       <td><input name="i_dempul" type="text" id="i_dempul" value="<?=$transaction_dempul ?>" /></td>
     </tr>
     <tr>
     <td>Keterangan cat %</td>
     <td>:</td>
       <td><input name="i_cat" type="text" id="i_cat" value="<?=$transaction_cat ?>" /></td>
     </tr>
     <tr>
     <td>Keterangan poles %</td>
     <td>:</td>
       <td><input name="i_poles" type="text" id="i_poles" value="<?=$transaction_poles ?>" /></td>
     </tr>
     <tr>
     <td>Keterangan rakit %</td>
     <td>:</td>
       <td><input name="i_rakit" type="text" id="i_rakit" value="<?=$transaction_rakit ?>" /></td>
     </tr>
     </table>
     </div>
	
	<div class="command_bar">
	
        <input type="button" id="enable" value="Edit"/>	
		<input type="button" id="submit" value="Simpan"/>
        <input type="button" id="cancel" value="Close"/>
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