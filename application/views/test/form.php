<script type="text/javascript" charset="utf-8"> 
$(document).ready(function() {
	createForm({	
		id 		: "#form_emp",
		actionTarget	: "test/save",
		backPage	: "test",
		nextPage	: "test"
	});
	createDatePicker(); 
	createLookUp({
		table_id		: "#lookup_table1",
		listSource 		: "test/module_table_control",
		dataSource		: "test/module_lookup_id",	
		component_id	: "#lookup_component1",
		filter_by		: [{id : "p1", label : "Nama"}]
	});
	createLookUp({
		table_id		: "#lookup_table2",
		listSource 		: "test/module_table_control",
		dataSource		: "test/module_lookup_id",	
		component_id	: "#lookup_component2",
		filter_by		: [{id : "p1", label : "Nama"}]
	});
} );
</script>
<form id="form_emp" action="siswa/save">
<div class="form_area">
<table class="form_layout" width="100%">
	<tr>
		<td class="label">NIS</td> 
		<td><input type="hidden" name="id" value="<?=$employee_id?>" />
		<input type="hidden" name="row_id" value="<?=$employee_id?>" />
		<input type="text" name="i_nip" size="10" id="code" value="<?=$employee_nik?>" maxlength="10" class="required" /></td>
	</tr>
	<tr>
		<td class="label">Nama</td>
		<td><input type="text" name="i_nama" value="<?=$employee_name?>" class="required" /></td>
	</tr>
	<tr>
		<td class="label">Modul</td>
		<td>
		<span class="lookup" id="lookup_component1">
        <input type="hidden" name="i_module" class="com_id" value="<?=$module_id?>" />
        <input type="text" class="com_input" size="6" name="module" />
        <div class="iconic_base iconic_search com_popup"></div>
        <span class="com_desc"></span></span>
        </td>
	</tr>	<tr>
		<td class="label">Modul2</td>
		<td>
		<span class="lookup" id="lookup_component2">
        <input type="hidden" name="i_module" class="com_id" value="<?=$module_id?>" />
        <input type="text" class="com_input" size="6" name="module" />
        <div class="iconic_base iconic_search com_popup"></div>
        <span class="com_desc"></span></span>
        </td>
	</tr>	
	<tr>
		<td class="label">Jenis Kelamin</td>
		<td> <select name="i_jk">
		<option value="L" <?=($employee_gender=='L')?'selected="selected"':''?> /> Laki-laki </option>
		<option value="P" <?=($employee_gender=='P')?'selected="selected"':''?> /> Perempuan </option>
		</select>
		</td>
	</tr>
	<tr>
		<td class="label">Tempat Lahir</td>
		<td><input type="text" name="i_tmp_lahir" value="<?=$employee_birth_place?>" class="required" /></td>
	</tr>
	<tr>
		<td class="label">Tanggal Lahir</td>
		<td><input type="text" name="i_tgl_lahir" value="<?=$employee_birth?>" size="8" class="date_input" class="required" /></td>
	</tr>
	<tr>
		<td class="label">Alamat Asal</td>
		<td><textarea name="i_alamat" rows="5" cols="50"><?=$employee_address?></textarea></td>
	</tr>
	<tr>
		<td class="label">Tanggal Masuk</td>
		<td><input type="text" name="i_tgl_masuk" value="<?=$employee_in_date?>" readonly="readonly" class="date_input" size="8" /></td>
	</tr>
	<tr>
		<td class="label">Telepon</td>
		<td><input type="text" name="i_telepon" value="<?=$employee_phone?>" /></td>
	</tr>
	<tr>
		<td class="label">Email</td>
		<td><input type="text" size="30" name="i_email" value="<?=$employee_email?>" /></td>
	</tr>
</table>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan"/>
	<input type="button" id="edit" value="Edit"/>
	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="cancel" value="Kembali" />
	<input type="reset" value="Reset"/>
</div>
</div>
</form>
<div>
	<table id="lookup_table1" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th width="10%"></th>
				<th width="30%">Hirarki</th>
				<th>Nama</th>
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>
<div>
	<table id="lookup_table2" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th width="10%"></th>
				<th width="30%">Hirarki</th>
				<th>Nama</th>
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>