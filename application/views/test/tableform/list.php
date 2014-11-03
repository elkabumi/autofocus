<script type="text/javascript">	
$(function(){
	createTable({
		id 		: "#table",
		listSource 	: "test/businessType_table_loader",
		formSource 	: "test/businessType_form",
		actionTarget	: "test/businessType_form_action",
		column_id	: 0
	});	
	
	$('#import').click(function(){
		window.location = site_url + "import_data/import_bt";
	});
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="10%">ID</th>
			<th width="30%">Kode</th>
			<th width="60%">Tipe Bisnis Rekanan</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command-table">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="refresh" value="Refresh"/>
	<input type="button" id="import" value="Import"/>
</div>
<div id="editor"></div>
</div>
