<script type="text/javascript">	
$(function(){

	
	
	
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table cellpadding="2" class="form_layout">
	<tr>
  
     <td width="222" req="req" >Price sub category name
     </td>
     <td width="633" >
    <input name="i_pst_name" type="text" id="i_pst_name" value="<?=$transient_pst_name ?>" />
   <input type="hidden" name="i_index" value="<?=$index?>" />
      </td>
    </tr>
	<tr>  
	  <td width="222" valign="top">Description</td>
	  <td width="633" valign="top"><textarea name="i_pst_description" id="i_pst_description" cols="45" rows="3"><?=$transient_pst_description?>
    </textarea></td>
	  </tr>
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Save" style="background-color:#da7a02 !important; border-color:#da7a02 !important;" />
<input type="reset" id="reset"  value="Reset" style="background-color:#da7a02 !important;  border-color:#da7a02 !important;" />
	<input type="button" id="cancel" value="Cancel"  style="background-color:#da7a02 !important;  border-color:#da7a02 !important;"  />
</div>
</form>

