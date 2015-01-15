<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "transaction/form_action",
		backPage		: "transaction",
		nextPage		: "transaction/form2"
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
       <td><input name="i_first_date" type="text" id="i_first_date" value="<?=$transaction_plain_first_date ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal akhir plain</td>
     <td>:</td>
       <td><input name="i_last_date" type="text" id="i_last_date" value="<?=$transaction_plain_last_date ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal Aktual</td>
     <td>:</td>
       <td><input name="i_actual_date" type="text" id="i_actual_date" value="<?=$transaction_actual_date ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal target selesai</td>
     <td>:</td>
       <td><input name="i_target_date" type="text" id="i_target_date" value="<?=$transaction_target_date ?>" class="date_input"/></td>
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
	
	<div class="command_bar">
	
        <input type="button" id="enable" value="Edit"/>	
		<input type="button" id="submit" value="Simpan"/>
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