<script type="text/javascript" charset="utf-8"> 
$(document).ready(function() {
	//createTable
	var otable = createTable({
		id : "#table",
		listSource : "test/table_controller",
		pageTarget : "test/form",
		dialogPage : "test/view_dialog",
		formTarget	 : "test/form",
		column_id	 : 0,
		aoColumnDefs	: [ {
				"sClass": "right",
				"aTargets": [0]
		} ],
		filter_by	 : [ {id : "nama", label : "Nama"}, {id : "alamat", label : "Alamat"}]
	});
	//otable.fnSetColumnVis(0, false);	
    //$("#dialog").dialog({autoOpen: false,modal: true, height:250, width:450});
} );
</script>
<div id="table1">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead> 
		<tr> 
			<th>ID</th>
			<th>NIK</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Email</th>
		</tr> 
	</thead> 
	<tbody> 		
	</tbody>
</table>
<div class="command_table">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Lihat"/>
	<input type="button" id="refresh" value="refresh"/>
</div>
</div>
