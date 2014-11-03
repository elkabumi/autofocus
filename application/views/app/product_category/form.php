<script type="text/javascript">	
$(function(){
	updateAll(); // tambahkan ini disetiap form
});
</script>
<form class="form_class">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	<tr>
		<td width="217"  req="req">Name</td>
	    <td width="647"><input type="hidden" name="row_id" value="<?=$row_id?>" />	      <input type="text" name="i_name" size="30" value="<?=$i_name?>" /></td>
	  </tr>
	<tr>
		<td width="217" valign="top" req="req">Description</td>
	    <td><textarea name="i_description" id="i_description" cols="45" rows="5"><?= $i_description ?></textarea></td>
	  </tr>
	
</table>
</div>
<div class="command_transient">
	<input type="button" id="submit" value="Save" />
	<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Close" />
</div>
</form>
