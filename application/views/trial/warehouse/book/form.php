<script type="text/javascript">	
$(function(){
	createDatePicker();
	
	//updateAll(); // tambahkan ini disetiap form
});
</script>
<form class="subform_area">
<table class="form_layout">
	<tr>
		<td width="150">ID</td>
		<td>
			<input type="text" size="10" value="<?=$row_id?>" disabled="disabled" />
			<input type="hidden" name="row_id" value="<?=$row_id?>" />
			<input type="hidden" name="i_warehouse_id" value="<?=$warehouse_id?>" />
		</td>
	</tr>
	<tr>
		<td width="150">Nama Buku</td>
		<td><input type="text" name="i_nama" size="30" value="<?=$nama?>" /></td>
	</tr>
	<tr>
		<td width="150">Tanggal Beli</td>
		<td>			
			<input type="text" name="i_beli" class="date_input" size="11" value="<?=$beli?>" />
		</td>
	</tr>
	<tr>
		<td width="150">Tanggal Kadaluarsa</td>
		<td>
			<input type="text" name="i_kadaluarsa" class="date_input" size="11" value="<?=$kadaluarsa?>" />
		</td>
	</tr>
	<tr>
		<td width="150">Tipe Buku</td>
		<td>
			<select name="i_tipe" init="<?=$tipe?>">
			<?php foreach($tipe_select_data as $row) : ?>
				<option value="<?=$row['trial_book_type_id']?>"><?=$row['trial_book_type_name']?></option>
			<?php endforeach; ?>
			</select>
		</td>
	</tr>
</table>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan" />
	<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
