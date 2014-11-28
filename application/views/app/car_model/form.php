<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "car_model/form_action",
		backPage		: "car_model",
		nextPage		: "car_model"
	});
	
	createDatePicker();
});

</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	<tr>
     <td width="196" >Vendor Mobil</td>
       <td width="651"><input name="i_merk" type="text" id="i_merk" value="<?=$car_model_merk ?>" />
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
   </tr>  
    <tr>
     <td>Model Mobil</td>
       <td><input name="i_name" type="text" id="i_name" value="<?=$car_model_name ?>" size="70" /></td>
     </tr>
     
 <tr>
     <td>Keterangan</td>
       <td><textarea name="i_description" type="text" id="i_description"><?=$car_model_description ?></textarea></td>
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
