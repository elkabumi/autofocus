<script type="text/javascript">	
$(function(){		
	var otable = createTable({
		id 		: "#table",
		listSource 	: "permit/group_table_controller",	
		formTarget	: "permit/form_group",
		submitTarget	: "permin/action",
		sendIDTarget	: "permit/form",
		column_id 	: 0,
		filter_by 	: [{id : "nama", label : "Nama Group"}]
	});

	otable.fnSetColumnVis(0, false, false);
});
</script>
<div id="apapun_namanya">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="25%">ID Group</th>
			<th width="25%">Nama Group</th>
		</tr> 
	</thead> 
	<tbody>	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
	<input type="button" id="send" value="Akses"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
</div>
