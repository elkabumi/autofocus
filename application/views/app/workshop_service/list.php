<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "workshop_service/table_controller",
		formTarget 	: "workshop_service/form",
		actionTarget: "workshop_service/form_action",
		activeTarget		: "workshop_service/active",
		column_id	: 0,
		
		filter_by 	: [ 
	
		{id : "workshop_service_name", label : "Nama Pengerjaan"}],
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
            <th>Nama Pengerjaan</th>
		  	<th>Harga</th>
		  	<th>Harga Borongan</th>
            <th>Create Date</th>
            <th>Active Status</th>
            <th>Information</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="add" value="Add"/>
	<input type="button" id="edit" value="Edit"/>
	<input type="button" id="delete" value="Inactive"/>
    <input type="button" id="active" value="active"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
