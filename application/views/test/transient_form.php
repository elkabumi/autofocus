<script type="text/javascript">	
$(function(){
	
});
</script>
<form class="subform_area">
<table class="form_layout">
	<tr>
		<td  req="req">Target</td>
		<td>
			<input type="text" name="i_s" value="<?=$loa_target_id?>" />
			<input type="hidden" name="i_index" value="<?=$index?>" />
		</td>
	</tr>
	<tr>
		<td >Jumlah</td>
		<td>
			<input type="text" name="i_amount" size="10" value="<?=$amount?>" /> 
		</td>
	</tr>
	<tr>
		<td >Keterangan Jumlah anak</td>
		<td>
			<textarea cols="30" rows="5"></textarea> 
		</td>
	</tr>
</table>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan ke Table" />
	<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
