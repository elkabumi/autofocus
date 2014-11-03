<form class="form_class">
<table class="form_layout">
	<tr>
		<td width="150">ID</td>
		<td>
			<input type="text" size="10" value="<?=$row_id?>" disabled="disabled" />
			<input type="hidden" name="row_id" value="<?=$row_id?>" />
		</td>
	</tr>
	<tr>
		<td width="150">Golongan</td>
		<td><input type="text" name="golongan" size="30" value="<?=$golongan?>" /></td>
	</tr>
</table>

<div class="form_category">Category</div>

<table class="form_layout">
	<tr>
		<td width="150">Keterangan</td>
		<td><input type="text" name="keterangan" size="20" value="<?=$keterangan?>" /></td>
	</tr>	
	<tr>
		<td colspan="2">
			<input type="button" id="submit" value="Simpan" />
			<input type="reset"	 id="reset"  value="Reset" />
			<input type="button" id="cancel" value="Batal" />
		</td>
	</tr>
</table>
</form>