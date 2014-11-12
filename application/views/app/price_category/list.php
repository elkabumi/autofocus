<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "price_category/table_controller",
		formTarget 	: "price_category/form",
		actionTarget: "price_category/form_action",
		activeTarget: "price_category/active",
		column_id	: 0,
		
		filter_by 	: [ 
	
		{id : "product_item_name", label : "product price name"},
		{id : "insurance_name", label : "Insurance name"}],
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
           
            <th>Prioce category name</th>
             <th>insurance name</th>
			<th>description</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="edit" value="add"/>
    
	<input type="button" id="edit" value="edit"/>
	<input type="button" id="delete" value="Inactive"/>
    <input type="button" id="active" value="active"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
