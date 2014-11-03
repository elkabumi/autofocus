<script type="text/javascript">	
$(function(){
	createForm({
		id 		: "#freeform1", 
		actionTarget	: "status/table1_action",
		backPage	: "status/fa_test",
		nextPage	: "status/fa_test"
	});	

	createLookUp({
		table_id	: "#lookup_table",
		table_width	: 400,
		listSource 	: "status/fa_table_control",
		descSource	: "status/fa_lookup_id",
		column_id 	: 0,
		component_id	: "#lookup_component",
		spaceFiller	: { length : 6, character : "0" }
	});
	
	createLookUp({
		table_id	: "#finder_table",
		table_width	: 400,
		listSource 	: "status/fa_table_control",
		descSource	: "status/fa_lookup_golongan",
		column_id 	: 1,
		component_id	: "#finder_component"
	});
	
	createDatePicker({ id : "#datepick" });
	
});
</script>

<form class="form_class" id="freeform1">
<div class="ajax_status"></div>
<table class="form_layout">
	<tr>
		<td width="150">ID</td>
		<td>
			<input type="text" id="row_id" size="10" value="<?=$row_id?>" disabled="disabled" />
			<input type="hidden" id="row_id" name="row_id" value="<?=$row_id?>" />
		</td>
	</tr>
	<tr>
		<td width="150">Lookup ID</td>
		<td>
			<span class="lookup" id="lookup_component">
				<input type="text" name="golongan" id="com_input" size="6" value="<?=$row_id?>" />
				<div class="iconic_base iconic_search" id="com_popup"></div>
				<span id="com_desc"></span>
			</span>
		</td>
	</tr>
	<tr>
		<td>Tanggal</td>
		<td>
			<span id="datepick">
				<input type="text" name="tanggal" id="cal_input" size="11" value="<?=$tanggal?>" />
				<div class="iconic_base iconic_calendar" id="com_popup"></div>
				<span id="com_desc"></span>
			</span>
		</td>
	</tr>
	<tr>
		<td>Lookup Keyword</td>
		<td>
			<span class="finder" id="finder_component">
				<input type="text" name="golongan" id="com_input" size="25" value="<?=$golongan?>" />
				<div class="iconic_base iconic_search" id="com_popup"></div>
				<span id="com_desc"></span>
			</span>
		</td>
	</tr>
</table>
<div class="form_category">Category Sample A</div>
<table class="form_layout">
	<tr>
		<td width="150">CheckBox Singles</td>
		<td>
			<label><input type="checkbox" name="boom" value="1" init="1"/> Pilihan 1</label>
			<label><input type="checkbox" name="boom" value="2" init="on"/> Pilihan 2</label>
			<label><input type="checkbox" name="boom" value="3" init="0"/> Pilihan 3</label>
			<label><input type="checkbox" name="boom" value="4" init="off"/> Pilihan 4</label>
		</td>
	</tr>
	<tr>
		<td>CheckBox Array</td>
		<td id="checkboxgroup" value="[1,0,1,0]">
			<label><input type="checkbox" name="boom" value="1" /> Pilihan 1</label>
			<label><input type="checkbox" name="boom" value="2" /> Pilihan 2</label>
			<label><input type="checkbox" name="boom" value="3" /> Pilihan 3</label>
			<label><input type="checkbox" name="boom" value="4" /> Pilihan 4</label>
		</td>
	</tr>
</table>
<div class="form_category">Category Sample B</div>
<table class="form_layout">
	<tr>
		<td width="150">Radio</td>
		<td>
			<label><input type="radio" name="radeeo" value="1" init="<?=$pilihan?>"/> Pilihan 1</label>
			<label><input type="radio" name="radeeo" value="2" /> Pilihan 2</label>
			<label><input type="radio" name="radeeo" value="3" /> Pilihan 3</label>
			<label><input type="radio" name="radeeo" value="4" /> Pilihan 4</label>
		</td>
	</tr>
</table>
<div class="form_panel">
	<input type="button" id="submit" value="Simpan"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="cancel" value="Batal" />
</div>
</form>

<div id="lookup_table">
	<table id="table" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th width="5%">ID</th>
				<th width="30%">Golongan</th>
				<th width="55%">Keterangan</th>
				<th width="5%">C</th>
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

<div id="finder_table">
	<table id="table" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th width="5%">ID</th>
				<th width="30%">Golongan</th>
				<th width="55%">Keterangan</th>
				<th width="5%">C</th>
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
