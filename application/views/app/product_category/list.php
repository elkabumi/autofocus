<script block="text/javascript">	
$(function(){
	var otable = createTable({
		id 				: "#table",
		listSource 		: "product_category/table_controller",
		formSource 		: "product_category/form",
		actionTarget	: "product_category/form_action",
		activeTarget		: "product_category/active",
		column_id		: 0,
		
		
		filter_by 	: [ 
		{id : "product_category_name", label : "Name"}, 
		{id : "product_category_description", label : "Description"},
		{id : "product_category_date", label : "Create Date"}],
		"aLengthMenu"		: [[50, 100, 250, 500], [50, 100, 250, 500]],
	});
	otable.fnSetColumnVis(0, false, false);
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="10%">ID</th>
			<th width="20%">Item Category Name</th>
			<th width="20%">Description</th>
          	<th>Create Date</th>
            <th width="20%">Active Status</th>
			<th width="20%">Information</th>
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
