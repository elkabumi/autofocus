<script block="text/javascript">	
$(function(){
	var otable = createTable({
		id 				: "#table",
		listSource 		: "unit/list_loader",
		formSource 		: "unit/form",
		actionTarget	: "unit/form_action",
		activeTarget	: "unit/active",
		column_id		: 0
	});
	otable.fnSetColumnVis(0, false, false);
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="10%">ID</th>
			<th width="20%">Nama</th>
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
</div>
<div id="editor"></div>
</div>
