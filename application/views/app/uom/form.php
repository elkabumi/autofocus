<script type="text/javascript">	
$(function(){
	updateAll(); // tambahkan ini disetiap form
});
</script>
<form class="form_class">
<div class="form_class_frame">
<table width="100%" class="form_layout">
	<tr>
		<td width="224" req="req">Name
	    <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
		<td width="652" req="req"><input type="text" name="i_name" size="50" value="<?=$i_name?>" /></td>
	  </tr>
	
	
</table>
</div>
<div class="command_transient">
	<input type="button" id="submit" value="Save" />
	<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Close" />
</div>
</form>
