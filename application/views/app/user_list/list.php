<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 		: "list_user/table_controller",	
		formTarget		: "list_user/user_form",
		actionTarget	: "list_user/user_form_action",
		submitTarget	: "trial/warehouse_submit",
		column_id 	: 0,
		filter_by 	: [ {id : "login", label : "User Name"}]
	});
	otable.fnSetColumnVis(0, false, false);
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
        	<th>ID</th>
			<th>User Name</th>
            <th>Status</th>
		</tr> 
	</thead> 
	<tbody>	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="hidden" id="add" value="Tambah"/>
	<input type="hidden" id="edit" value="Revisi"/>
	<input type="hidden" id="delete" value="Hapus"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
</div>
