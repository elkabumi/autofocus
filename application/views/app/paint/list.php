<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "paint/table_controller",
		formTarget 	: "paint/form",
		actionTarget: "paint/form_action",
		filter_by 	: [ 
		{id : "material_name", label : "Nama cat"}, 
		{id : "unit_name", label : "Nama Satuan"},
		],
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
            <th>Nama Cat</th>
            <th>Satuan</th>
            <th>Keterangan</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="add" value="Add"/>
	<input type="button" id="edit" value="Edit"/>
	<input type="button" id="delete" value="Delete"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
