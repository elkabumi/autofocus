<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "user_editor/user_form_action",
		backPage		: "user_editor/",
		nextPage		: "user_editor/"
	});
	
	createLookUp({
		table_id		: "#lookup_table1",
		table_width		: 300,
		listSource 		: "user_editor/group_table_control",
		dataSource		: "user_editor/group_lookup_id",	
		column_id 		: 0,
		component_id	: "#lookup_component1"
	});
	/*
	createLookUp({
		table_id	: "#lookup_table2",
		table_width	: 300,
		listSource 	: "trial/group_table_control",
		dataSource	: "trial/group_lookup_code",
		column_id 	: 0,
		component_id	: "#lookup_component2"
	});*/
	
	createDatePicker({ id : "#id_tanggal_nya" });
	
	updateAll(); // tambahkan ini disetiap form
	
});
</script>

<form class="form_class" id="id_form_nya">
<div class="ajax_status"></div>
<table class="form_layout">
	<tr>
		<td width="150">ID</td> <!-- baris <tr></tr> pertama td nya harus diberi nilai width -->
		<td>
			<input type="text" id="row_id" size="10" value="<?=$row_id?>" disabled="disabled" />
			<input type="hidden" id="row_id" name="row_id" value="<?=$row_id?>" />		</td>
	</tr>
	<tr>
		<td width="150">Group ID</td>
		<td>
			<span class="lookup" id="lookup_component1">
				<input type="hidden" name="i_group" class="com_id" value="<?=$user_group?>" />
				<input type="text" class="com_input" size="6" />
				<div class="iconic_base iconic_search com_popup"></div>
				<span class="com_desc"></span>			</span>		</td>
	</tr>
	<tr>
		<td width="150">Nama</td>
  <td>
	  <span class="lookup" id="lookup_component2"><span class="com_desc"></span>			</span>		<input type="text" name="i_nama" size="30"  maxlength="30" value="<?=$user_name?>" /></td>
	</tr>
	<tr>
		<td>User Login</td>
		<td><input type="text" name="i_login" size="10"  maxlength="12" value="<?=$user_login?>" /></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="i_sandi1" size="31"  maxlength="31" value="" /></td>
	</tr>
	<tr>
	  <td>Konfirmasi Password</td>
	  <td><input type="password" name="i_sandi2" size="31"  maxlength="31" value="" /></td>
    </tr>
</table>
<div class="form_category"></div>
<div class="form_panel">
	<input type="button" id="submit" value="Simpan"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="cancel" value="Batal" /> 
</div>
</form>

<div id="lookup_table1">
	<table id="table" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th width="10%">ID</th>
				
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
<!--
<div id="lookup_table2">
	<table id="table" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th width="10%">ID</th>
				<th width="30%">Kode</th>
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
</div>-->