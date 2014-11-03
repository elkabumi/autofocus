<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "employee/form_action",
		backPage		: "employee",
		nextPage		: "employee"
	});
	

	
	createLookUp({
		table_id		: "#lookup_table_employee_position",
		table_width		: 400,
		listSource 		: "lookup/employee_position_table_control",
		dataSource		: "lookup/employee_position_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_employee_position",
		filter_by		: [{id : "p2", label : "Nama"}]
	});
	
	createDatePicker();
});

</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
	<table width="100%" cellpadding="4" class="form_layout">
	<tr>
     <td width="196" >NIK</td>
    <td  width="651"><input name="i_nip" type="text" id="i_nip" value="<?=$employee_nip ?>" />
     
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
   </tr>
   
    <tr>
     <td>Name</td>
       <td><input name="i_name" type="text" id="i_name" value="<?=$employee_name ?>" /></td>
     </tr>
      <tr>
     <td>birth date</td>
       <td><input name="i_birth" type="text" id="i_birth" value="<?=$employee_birth ?>" class="date_input"/></td>
     </tr>
   <tr>
     <td>Jenis Kelamin</td>
       <td>
       <p>
       <label>
         <input type="radio" name="i_gender" value="1" id="i_gender1" <?php if($employee_gender == 1 || $employee_gender == ""){?> checked="checked"<?php } ?> />
         Male</label>
       <br />
       <label >
         <input type="radio" name="i_gender" value="2" id="i_gender2" <?php if($employee_gender == 2){?> checked="checked"<?php } ?> />
         Female</label>
      
     </p>
       </td>
     </tr>
       <tr>
     <td>Position</td>
    <td>    <span class="lookup" id="lookup_employee_position">
				<input type="hidden" name="i_position_id" class="com_id" value="<?=$employee_position_id?>" /><input type="text" class="com_input" />
                <div class="iconic_base iconic_search com_popup"></div>
				
				
				</span>	
       </td>
     </tr>

 <tr>
   <tr>
     <td>No KTP</td>
       <td><input name="i_ktp" type="text" id="i_ktp" value="<?=$employee_ktp ?>"/></td>
     </tr>
      <tr>
     <td>No Telepon</td>
       <td><input name="i_phone" type="text" id="i_phone" value="<?=$employee_phone?>" /></td>
     </tr>
   <tr>
     <td>Email</td>
       <td><input name="i_email" type="text" id="i_email" value="<?=$employee_email?>" /></td>
     </tr>
   
   
  <tr>
    <td width="70" valign="top">Addres</td>
      <td><textarea name="i_address" id="i_address" cols="45" rows="5"><?= $employee_address?></textarea></td>
    </tr>

</table>
<div class="form_category">Bank</div>

	<table width="100%" cellpadding="4" class="form_layout">
	<tr>
     <td  width="196">Rekening Bank</td>
     <td  width="651"><input name="i_bank_number" type="text" id="i_bank_number" value="<?=$employee_bank_number?>" />
     </td>
   </tr>
   <tr>
     <td >Nama Bank</td><td><input name="i_bank_name" type="text" id="i_bank_name" value="<?=$employee_bank_name?>" />
     </td>
   </tr>
   <tr>
     <td >Atas Nama</td><td><input name="i_bank_beneficiary" type="text" id="i_bank_beneficiary" value="<?=$employee_bank_beneficiary?>" />
     </td>
   </tr>
   </table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Save"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="cancel" value="Close" /> 
</div>
</div>
</form>





<div id="">
	<table id="lookup_table_employee_position" cellpadding="0" cellspacing="0" border="0" class="display" > 
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
		<input type="button" id="choose" value="Select Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>