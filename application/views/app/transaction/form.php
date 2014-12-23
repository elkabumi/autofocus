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
			<td width="17%">Periode
               
            </td>
			<td width="1%" >:</td>
			<td  width="82%" > <span class="lookup" id="lookup_period">
         		<input type="hidden" name="i_period_id" class="com_id" value="<?=$period_id?>" />
         		<input readonly="readonly" type="text" class="com_input" size="6" /> 
         		<input type="hidden" name="row_id" value="<?=$row_id?>" />
        	 	<input type="hidden" name="i_transaction_id" value="<?=$transaction_id?>" />
         <div class="iconic_base iconic_search com_popup"></div>
       </span></td> 
		</tr>
   
   <tr>
      <td>Cabang
        		</td>
      <td>:</td>
      <td>  <span class="lookup" id="lookup_stand">
				<input type="hidden" name="i_stand_id" class="com_id" value="<?=$stand_id?>" />
               
				<input readonly="readonly" type="text" class="com_input" />
				<input type="hidden" name="i_registration_date2" class="date_input" size="15" value="<?=$registration_date?>" />
				 <div class="iconic_base iconic_search com_popup"></div>
				</span></td>
    </tr>
      <tr>
          <td width="17%">Kode Transaksi</td>
          <td width="1%">:</td>
          <td width="82%"><input readonly="readonly" name="i_code" type="text" id="i_code" value="<?=$registration_code ?>" /></td>
        </tr>
    <tr>
      <td>Data Pelanggan
        </td>
      <td>:</td>
      <td> <span class="lookup" id="lookup_customer">
        <input type="hidden" name="i_customer_id" class="com_id" value="<?=$customer_id?>" />
        
        <input readonly="readonly" type="text" class="com_input" />
        <div class="iconic_base iconic_search com_popup"></div>
          <span class="com_desc"></span>
        </span></td>
    </tr>
    <tr>
      <td>Data Mobil</td>
      <td>:</td>
      <td> <span class="lookup" id="lookup_car">
				<input type="hidden" name="i_car_id" class="com_id" value="<?=$car_id?>" />
              
				<input readonly="readonly" type="text" class="com_input" />
				  <div class="iconic_base iconic_search com_popup"></div>
                    <span class="com_desc"></span>
				</span></td>
    </tr>
      <tr>
      <td>Klaim</td>
      <td>:</td>
      <td><label >
         <input disabled="disabled" readonly="readonly" type="radio" name="i_claim_type" value="1" id="i_claim_type" <?php if($claim_type == 1){ ?> checked="checked"<?php } ?> />
         Menggunakan Asuransi</label>
     <br />
       <label>
         <input readonly="readonly" name="i_claim_type" type="radio" id="i_claim_type" value="0" <?php if($claim_type == 0){ ?> checked="checked"<?php } ?>/>
         Pribadi
       </label></td>
    </tr>

 <tr>
      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="asuransi" style="width:100%;">
        <tr>
          <td width="17%">Asuransi</td>
          <td width="1%">:</td>
          <td width="82%"><span class="lookup" id="lookup_insurance">
				<input type="hidden" name="i_insurance_id" class="com_id" value="<?=$insurance_id?>" />
              
				<input readonly="readonly" type="text" class="com_input" />
				  <div class="iconic_base iconic_search com_popup"></div>
				</span></td>
        </tr>
      </table></td>
     </tr>   
      <tr>
     <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="no_klaim" style="width:100%;">
        <tr>
          <td width="17%">No Klaim</td>
          <td width="1%">:</td>
          <td width="82%"><input readonly="readonly" type="text" id="i_claim_no" name="i_claim_no" value="<?= $claim_no ?>" /></td>
        </tr>
      </table></td>
				
				
      </tr>
        <tr>
      <td>Tanggal Masuk   	  </td>
      <td>:</td>
      <td><input readonly="readonly" type="text" name="i_check_in"  size="15" value="<?=$check_in?>" /></td>
    </tr>
     <tr>
      <td>Tanggal Estimasi Keluar   	  </td>
      <td>:</td>
      <td><input readonly="readonly" type="text" name="i_registration_estimation_date"  size="15" value="<?=$registration_estimation_date?>" /></td>
    </tr>
       <tr>
    <td width="158" valign="top">Keterangan</td>
    <td width="10" valign="top">:</td>
    <td width="745" valign="top"><textarea readonly="readonly" name="i_registration_description" id="i_registration_description" cols="45" rows="5"><?=$registration_description?></textarea></td>
    </tr>
   <tr>
      <td>Tim Kerja</td>
      <td>:</td>
      <td> <span class="lookup" id="lookup_employee_group">
				<input type="hidden" name="i_employee_group_id" class="com_id" value="<?=$employee_group_id?>" />
              
				<input type="text" class="com_input" />
				  <div class="iconic_base iconic_search com_popup"></div>
                    <span class="com_desc"></span>
				</span></td>
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