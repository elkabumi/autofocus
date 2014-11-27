<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "customer/table_controller",
		formTarget 	: "customer/form",
		actionTarget: "customer/form_action"
		
	});
	
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
