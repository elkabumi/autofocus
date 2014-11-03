<script type="text/javascript" charset="utf-8"> 
$(document).ready(function() {
	createForm({	
		id 		: "#form_emp2",
		actionTarget	: "test/save",
		backPage	: "test",
		nextPage	: "test"
	});
} );
</script>
<form id="form_emp2" action="siswa/save">
<div class="form-area">
<table class="form_layout" width="100%">
	<tr>
		<td class="label">NIS</td> 
		<td><input type="hidden" name="id" value="<?=$employee_id?>" />
		<input type="text" name="i_nip" size="10" id="code" value="<?=$employee_nik?>" maxlength="10" required="required" /></td>
	</tr>
	<tr>
		<td class="label">Nama</td>
		<td><input type="text" name="i_nama" value="<?=$employee_name?>" required="required" /></td>
	</tr>
	
	<tr>
		<td class="label">Tempat Lahir</td>
		<td><input type="text" name="i_tmp_lahir" value="<?=$employee_birth_place?>" required="required" /></td>
	</tr>
	<tr>
		<td class="label">Alamat Asal</td>
		<td><textarea name="i_alamat" rows="5" cols="50"><?=$employee_address?></textarea></td>
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
</div>
</form>