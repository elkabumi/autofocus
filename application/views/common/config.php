<script type="text/javascript">	
$(function(){
	var is_hit = 0;
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "config/form_action",
		backPage		: "config",
		nextPage		: "config"
	});
	createLookUp({
		table_id	: "#lookup_table2",
		table_width	: 400,
		listSource 	: "config/employee_table_control",
		dataSource	: "config/employee_lookup_id",
		column_id 	: 0,
		useDetail 	: true,
		component_id	: "#lookup_component2",
		filter_by		: [{id : "p2", label : "Nama"}]
	});
	createLookUp({
		table_id		: "#lookup_table3",
		listSource 		: "lookup/coa_table_control",
		dataSource		: "lookup/coa_lookup_hierarchy",
		component_id	: "#lookup_component3",
		filter_by		: [{id : "p1", label : "Kode"}, {id : "p2", label : "Nama"}]
	});
	createLookUp({
		table_id		: "#lookup_table4",
		listSource 		: "lookup/coa_table_control",
		dataSource		: "lookup/coa_lookup_hierarchy",
		component_id	: "#lookup_component4",
		filter_by		: [{id : "p1", label : "Kode"}, {id : "p2", label : "Nama"}]
	});
});

</script>

<form id="id_form_nya">
<div class="form_area">
<table width="509" class="form_layout">
  <tr>
    <td valign="top">Pengajuan Aproval</td>
    <td><input type="hidden" id="row_id" name="row_id" />
	<span class="lookup" id="lookup_component2">
				<input type="hidden" name="i_approval_to" class="com_id" value="<?=$approval_to?>" />
				<input type="text" class="com_input" size="6" />
				<div class="iconic_base iconic_search com_popup"></div>
				<span class="com_desc"></span>
		</span></td>
  </tr>
  <tr>
		<td width="150" req="req">Coa Hutang Uang Muka</td>
		<td><span class="lookup" id="lookup_component3">
        <input type="hidden" name="i_rfp_hutang" class="com_id" value="<?=$rfp_hutang?>" />
        <input type="text" class="com_input" size="6" />
        <div class="iconic_base iconic_search com_popup"></div>
		<span class="com_desc"></span></span>		</td>
	</tr>
	<tr>
		<td width="150" req="req">Coa Piutang Uang Muka</td>
		<td><span class="lookup" id="lookup_component4">
        <input type="hidden" name="i_rfp_piutang" class="com_id" value="<?=$rfp_piutang?>" />
        <input type="text" class="com_input" size="6" />
        <div class="iconic_base iconic_search com_popup"></div>
		<span class="com_desc"></span></span>		</td>
	</tr>
</table>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan"/>
</div>
</div>
</form>
<div id="">
	<table id="lookup_table2" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				
				<th width="5%">ID</th>
				<th width="15%">Nik</th>
				<th width="30%">Nama</th>
                <th width="30%">Keterangan</th>
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
	<table id="lookup_table3" cellpadding="0" cellspacing="0" border="0" class="display" > 
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
	<table id="lookup_table4" cellpadding="0" cellspacing="0" border="0" class="display" > 
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