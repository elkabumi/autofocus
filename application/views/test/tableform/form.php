<script type="text/javascript">	
$(function(){
	updateAll(); // tambahkan ini disetiap form
});
</script>
<form class="form_class">
<table class="form_layout">
	<tr>
		<td width="150">ID Tipe Bisnis Rekanan</td>
		<td>
			<input type="text" size="10" value="<?=$row_id?>" disabled="disabled" />
			<input type="hidden" name="row_id" value="<?=$row_id?>" />
		</td>
	</tr>
	<tr>
		<td width="150" req="req">Kode</td>
		<td><input type="text" name="i_code" size="30" value="<?=$i_code?>" /></td>
	</tr>
	<tr>
		<td width="150" req="req">Tipe Bisnis Rekanan</td>
		<td><input type="text" name="i_nama" size="50" value="<?=$i_nama?>" /></td>
	</tr>
</table>
<div class="command-transient">
	<input type="button" id="submit" value="Simpan" />
	<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
