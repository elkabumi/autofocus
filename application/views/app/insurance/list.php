<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "insurance/table_controller",
		formTarget 	: "insurance/form",
		actionTarget: "insurance/form_action",
		activeTarget: "insurance/active",
		column_id	: 0,
		
		filter_by 	: [ 
		{id : "insurance_name", label : "Insurance Code"}, 
		{id : "insurance_addres", label : "Insurance Name"},
		{id : "insurance_phone", label : "Insurance Type"},
		{id : "insurance_date", label : "Create Date"}],
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
            <th>Nama Asuransi</th>
            <th>Telepon</th>
			<th>Alamat</th>
            <th>Tanggal</th>
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
