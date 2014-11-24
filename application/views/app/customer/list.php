<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "customer/table_controller",
		formTarget 	: "customer/form",
		actionTarget: "customer/form_action",
		column_id	: 0,
		
		filter_by 	: [ 
		{id : "product_code", label : "Material Code"}, 
		{id : "product_name", label : "Material Name"},
		{id : "product_category_name", label : "Material Type"},
		{id : "product_date", label : "Create Date"}],
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
            <th>Nomor Ktp</th>
            <th>Nama</th>
			<th>Addres</th>
            <th>Telepon</th>
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
