<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "workshop_service/form_action",
		backPage		: "workshop_service",
		nextPage		: "workshop_service"
	});
	
	$('input[name="i_price"]').change(function(){
		var price 	= $('input[name="i_price"]').val();
		var job_price = price * 10 / 100;
		
		$('input[name="i_job_price"]').val(job_price);
		
	});
	
	createDatePicker();
});

</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	
   
    <tr>
     <td>Nama Pengerjaan</td>
       <td> <input type="hidden" name="row_id" value="<?=$row_id?>" /><input name="i_name" type="text" id="i_name" value="<?=$workshop_service_name ?>" size="70" /></td>
     </tr>

   <tr>
     <td>Harga</td> 
       <td><input name="i_price" type="text" id="i_price" value="<?=$workshop_service_price ?>" size="10"/></td>
     </tr>

      <tr>
     <td>Harga Borongan</td> 
       <td><input name="i_job_price" type="text" id="i_job_price" value="<?=$workshop_service_job_price ?>" size="10"/></td>
     </tr>
   
  <tr>
    <td width="189" valign="top">Keterangan</td>
      <td><textarea name="i_description" id="i_description" cols="45" rows="5"><?= $workshop_service_description ?></textarea></td>
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

