<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "employee/table_controller",
		formTarget 	: "employee/form",
		actionTarget: "employee/form_action",
		column_id	: 0,
		
		filter_by 	: [ 
		{id : "employee_nip", label : "NIP"}, 
		{id : "employee_name", label : "Nama"}, 
		{id : "employee_position_name", label : "Jabatan"}],
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
            <th>NIP</th>
            <th>Name</th>
			<th>Position</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="add" value="Add"/>
	<input type="button" id="edit" value="Revisi"/>
	<input type="button" id="delete" value="Delete"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
