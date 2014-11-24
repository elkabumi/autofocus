<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "product/form_action",
		backPage		: "product",
		nextPage		: "product"
	});
	
	createDatePicker();
});

</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	<tr>
     <td width="196" >Customer Ktp Number</td>
       <td width="651"><input name="i_ktp" type="text" id="i_code" value="<?=$customer_ktp_number ?>" />
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
   </tr>  
    <tr>
     <td>Customer Name</td>
       <td><input name="i_name" type="text" id="i_name" value="<?=$customer_name ?>" size="70" /></td>
     </tr>
     <tr>
     <td>Customer Addres</td>
        <td><input name="i_addres" type="text" id="i_addres" value="<?=$customer_addres ?>" size="70" /></td>
     </tr>
	<tr>
     <td width="196" >Customer Phone Number</td>
        <td><input name="i_phone" type="text" id="i_phone" value="<?=$customer_phone_number ?>" size="70" /></td>
   </tr>
 <tr>
     <td>Keterangan</td>
       <td><input name="i_description" type="text" id="i_description" value="<?=$customer_description ?>" size="70" /></td>
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
