<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "car_model/table_controller",
		formTarget 	: "car_model/form",
		actionTarget: "car_model/form_action",
		column_id	: 0,
		
		filter_by 	: [ 
		{id : "car_model_merk", label : "Vendor Mobil"}, 
		{id : "car_model_name", label : "Model Mobil"},
		{id : "car_model_description", label : "Keterangan"}
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
            <th>Vendor Mobil</th>
            <th>Model Mobil</th>
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
