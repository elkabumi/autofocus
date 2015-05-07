<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 			: "#table",
		listSource 		: "gl_balance/list_loader",	
		formSource		: "gl_balance/form",
		actionTarget		: "gl_balance/form_action",
		column_id 		: 0,
		filter_by 		: [{id : "code", label : "Kode"}, 
				{id : "name", label : "Nama Rekening"}, 
				{id : "period", label : "Periode [mm/yyyy]"}]
	});
	otable.fnSetColumnVis(0, false, false);

});
</script>
<div id="gl_balance_content">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th>ID</th>
			<th>Periode</th>
            <th>Kode Pasar</th>
			<th>Kode</th>
			<th>Nama Rekening</th>
			<th>Debit</th>
			<th>Kredit</th>
		</tr> 
	</thead> 
	<tbody>	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
