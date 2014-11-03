<script type="text/javascript">	
$(function(){
	createDatePicker({ id : "#datepicker_beli" });
	createDatePicker({ id : "#datepicker_kadaluarsa" });
	
	updateAll(); // tambahkan ini disetiap form
});
</script>
<form class="form_class">
<table class="form_layout">
	<tr>
		<td width="150">Nama Buku</td>
		<td>
        	<input type="text" name="i_nama" size="30" value="<?=$nama?>" />
            
            <!-- simpan data lain dari table -->
            <input type="hidden" name="i_warehouse_id" value="<?=$warehouse_id?>" />
            
            <!-- variable untuk transient form -->
            <input type="hidden" name="i_index" value="<?=$index?>" />  <!-- baris yang di edit. untuk add kosong. -->
        </td>
	</tr>
	<tr>
		<td width="150">Tanggal Beli</td>
		<td>			
			<span id="datepicker_beli">
				<input type="text" name="i_beli" class="cal_input" size="11" value="<?=$beli?>" />
				<div class="iconic_base iconic_calendar com_popup"></div>
				<span class="com_desc"></span>
			</span>
		</td>
	</tr>
	<tr>
		<td width="150">Tanggal Kadaluarsa</td>
		<td>
			<span id="datepicker_kadaluarsa">
				<input type="text" name="i_kadaluarsa" class="cal_input" size="11" value="<?=$kadaluarsa?>" />
				<div class="iconic_base iconic_calendar com_popup"></div>
				<span class="com_desc"></span>
			</span>		
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
<table class="form_layout">
	<tr>
		<td colspan="2">
			<input type="button" id="submit" value="Simpan ke Table" />
			<input type="reset" id="reset"  value="Reset" />
			<input type="button" id="cancel" value="Batal" />
		</td>
	</tr>
</table>
</form>