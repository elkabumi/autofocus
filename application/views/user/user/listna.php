<script type="text/javascript">	
$(function(){
	
	
	var otable2 = createTableAction({
		id 		: "#listna1",
		listSource 	: "user/user_table_controller",	
		formTarget	: "user/user_form",
		submitTarget	: "trial/warehouse_submit",
		column_id 	: 0,
		filter_by 	: [ {id : "nama", label : "Nama Lengkap"}, {id : "login", label : "User Login"}]
	});

	otable2.fnSetColumnVis(0, false);	

});
</script>
<div id="listna1">
<form>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th>ID</th>
			<th>User Login</th>
			<th>Nama Lengkap</th>
			<th>Jabatan</th>
			<th>Group</th>
			
		</tr> 
	</thead> 
	<tbody>	
	</tbody>
</table>
</form>
<div id="panel">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Lihat"/>
	<input type="button" id="refresh" value="Refresh"/>

</div>
</div>
