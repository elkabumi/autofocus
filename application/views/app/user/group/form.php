<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "user/group_form_action",
		backPage		: "permit",
		nextPage		: "permit"
	});
	/*
	createLookUp({
		table_id		: "#lookup_table1",
		table_width		: 300,
		listSource 		: "user_editor/group_table_control",
		dataSource		: "user_editor/group_lookup_id",	
		column_id 		: 0,
		component_id	: "#lookup_component1"
	});
	
	createLookUp({
		table_id	: "#lookup_table2",
		table_width	: 300,
		listSource 	: "trial/group_table_control",
		dataSource	: "trial/group_lookup_code",
		column_id 	: 0,
		component_id	: "#lookup_component2"
	});*/
	
	createDatePicker({ id : "#id_tanggal_nya" });
	
	//updateAll(); // tambahkan ini disetiap form
	
});
</script>

<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
	<table width="100%" cellpadding="4" class="form_layout">
	<tr>
		<td  width="196"  req="req">Nama</td>
  <td width="651">
  <input type="hidden" id="row_id" name="row_id" value="<?=$row_id?>" />
	  <input type="text" name="i_nama" size="50"  maxlength="50" value="<?=$group_name?>" /></td>
	</tr>
	
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="cancel" value="Batal" /> 
</div>
</div>
</form>
<!--
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
