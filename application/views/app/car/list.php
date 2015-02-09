<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "car/table_controller",
		formTarget 	: "car/form",
		actionTarget: "car/form_action",
		activeTarget		: "car/active",
		column_id	: 0,
		
		filter_by 	: [ 
		{id : "car_nopol", label : "Nopol"}, 
		{id : "car_model_merk", label : "Vendor Mobil"},
		{id : "car_model_name", label : "Model Mobil"},
		{id : "car_no_machine", label : "No Mesin"},
		{id : "car_no_rangka", label : "No Rangka"},
		{id : "car_year", label : "Tahun"}],
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
            <th>Nopol</th>
            <th>Model</th>
			<th>No Mesin</th>
            <th>No Rangka</th>
            <th>Warna</th>
            <th>Tipe</th>
            <th>Tahun</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="add" value="Add"/>
	<input type="button" id="edit" value="Edit"/>
	
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
