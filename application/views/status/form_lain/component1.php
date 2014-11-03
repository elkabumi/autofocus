<script type="text/javascript">	
	$(function(){
		createForm({
			id 			: "#freeform1",
			actionTarget: "status/table1_action",
			backPage	: "status/fa_test",
			nextPage	: "status/fa_test"
		});	
	});
</script>

<form id="freeform1">
<div class="ajax_status"></div>
<table class="form_table">
	<tr>
		<td width="150">ID</td>
		<td>
			<input type="text" id="row_id" size="10" value="<?=$row_id?>" disabled="disabled" />
			<input type="hidden" id="row_id" name="row_id" value="<?=$row_id?>" />
		</td>
	</tr>
	<tr>
		<td width="150">Golongan</td>
		<td><input type="text" name="golongan" size="30" value="<?=$golongan?>" /></td>
	</tr>
</table>

<div class="form_category">Category</div>

<table class="form_table">
	<tr>
		<td width="150">Keterangan</td>
		<td><input type="text" name="keterangan" size="20" value="<?=$keterangan?>" /></td>
	</tr>	
	<tr>
		<td colspan="2">
			<input type="button" id="submit" value="Simpan" />
			<input type="button" id="delete" value="Hapus" />
			<input type="button" id="enable" value="Edit" />			
			<input type="button" id="cancel" value="Batal" />
		</td>
	</tr>
</table>
</form>