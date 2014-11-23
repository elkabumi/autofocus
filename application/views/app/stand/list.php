<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "stand/table_controller",
		formTarget 	: "stand/form",
		actionTarget: "stand/form_action",
		column_id	: 0,
		
		filter_by 	: [ 
		{id : "stand_code", label : "Kode"}, 
		{id : "stand_name", label : "Nama"}, 
		{id : "stand_email", label : "Email"},
		{id : "stand_phone", label : "Telepon"}],
		"aLengthMenu"		: [[50, 100, 250, 500], [50, 100, 250, 500]],
	});
	otable.fnSetColumnVis(0, false, false);
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th>ID</th>
            <th>Kode</th>
            <th>Nama Cabang</th>
			<th>Leader</th>
            <th>Telepon</th>
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
