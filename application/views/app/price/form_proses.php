<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "price/form_action",
		backPage		: "price/form/<?=$insurance_id?>",
		nextPage		: "price/form",
		printTarget		: "price/ali_entry_value_print/<?=$row_id?>"
	});
	
	
	//updateAll(); 
});
</script>

<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">

  <table width="100%" cellpadding="4" >
    <?php
    
	for($i=0; $i<$no; $i++){
	
	?>
	<tr>
		<td width="254" req="req"><?= $subject_name[$i] ?></td>
		
		<td width="692"><input name="i_subject_value<?= $i?>" type="text" class="required" id="i_subject_value<?= $i?>" value="<?= $subject_value[$i]?>" size="10" />
	    <input type="hidden" id="i_subject_id<?= $i?>" name="i_subject_id<?= $i?>" value="<?=$subject_id[$i]?>" /></td>
	</tr>   <?php
	}
	?>
	<tr>
	  <td req="req">&nbsp;</td>
	  
	  <td><input type="hidden" id="row_id" name="row_id" value="<?=$row_id?>" />
       <input type="hidden" id="i_insurance_id" name="i_insurance_id" value="<?=$insurance_id?>" />
        <input type="hidden" id="i_no" name="i_no" value="<?=$no?>" /></td>
	  </tr>
 
  </table></div>
  <div class="command_bar">
	<input type="button" id="submit" value="Simpan"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="cancel" value="Batal" /> 
	</div>
</div>

<!-- table contact -->

</form>

