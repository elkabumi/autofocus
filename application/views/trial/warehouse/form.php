<script type="text/javascript">	
$(function(){

	createForm({
		id 		: "#id_form_nya", 
		actionTarget	: "trial/warehouse_form_action",
		backPage		: "trial/warehouse",
		nextPage		: "trial/warehouse"
	});
	createDatePicker();
	createLookUp({
		table_id	: "#lookup_table1",
		table_width	: 300,
		listSource 	: "trial/group_table_control",
		dataSource	: "trial/group_lookup_id",	
		column_id 	: 0,
		component_id	: "#lookup_component1",
		onSelect:function(){}
	});
	
	createLookUp({
		table_id	: "#lookup_table2",
		table_width	: 300,
		listSource 	: "trial/group_table_control",
		dataSource	: "trial/group_lookup_code",
		column_id 	: 0,
		component_id	: "#lookup_component2"
	});
	
	
	
	//updateAll(); // tambahkan ini disetiap form
	
});
</script>

<form id="id_form_nya">
<div class="form_area">
<table class="form_layout">
	<tr>
		<td width="150" req="req">ID</td> <!-- baris <tr></tr> pertama td nya harus diberi nilai width -->
		<td>
			<input type="text" id="row_id" size="10" value="<?=$row_id?>" readonly="readonly" />
			<input type="hidden" id="row_id" name="row_id" value="<?=$row_id?>" />
		</td>
	</tr>
	<tr>
		<td width="150" req="req">Group ID</td>
		<td>
			<span class="lookup" id="lookup_component1">
				<input type="hidden" name="i_group1" class="com_id" value="<?=$group1?>" />
				<input type="text" class="com_input" size="6" />
				<div class="iconic_base iconic_search com_popup"></div>
				<span class="com_desc"></span>				
			</span>
		</td>
	</tr>
	<tr>
		<td width="150" req="req">Group Kode</td>
		<td>
			<span class="lookup" id="lookup_component2">
				<input type="hidden" name="i_group2" class="com_id" value="<?=$group2?>" />
				<input type="text" class="com_input" size="4"  />
				<div class="iconic_base iconic_search com_popup"></div>
				<span class="com_desc"></span>				
			</span>
		</td>
	</tr>
	<tr>
		<td>Nama</td>
		<td><input type="text" name="i_nama" size="30"  maxlength="50" value="<?=$nama?>" class="required"/></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td><input type="text" name="i_alamat" size="70"  maxlength="100" value="<?=$alamat?>" /></td>
	</tr>
</table>
<div class="form_category">Keterangan Lain</div>
<table class="form_layout">
	<tr>
		<td width="150">Dibangun Pada</td> <!-- yang ini juga harus diberi width, karena pertama di table kedua -->
		<td>
			<input type="text" name="i_tanggal" class="date_input" value="<?=$tanggal?>"  size="8"/>
		</td>
	</tr>
	<tr>
		<td>Ukuran Gudang</td>
		<td>
			<span><label><input type="radio" name="i_ukuran" value="1" init="<?=$ukuran?>" /> Besar</label>
			&nbsp; &nbsp;
			<label><input type="radio" name="i_ukuran" value="2" /> Kecil</label></span>
		</td>
	</tr>
</table>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="cancel" value="Batal" /> 
</div>
</div>
</form>

<div>
	<table id="lookup_table1" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th ></th>
				<th >Kode</th>
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
				<th ></th>
				<th >Kode</th>
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
