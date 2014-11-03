<script type="text/javascript">	
$(function(){
	
	var otable = createTableAction({
		id 		: "#apapun_namanya",
		listSource 	: "user_editor/user_table_controller",	
		formTarget	: "user_editor/user_form",
		submitTarget	: "trial/warehouse_submit",
		column_id 	: 0,
		filter_by 	: [ {id : "nama", label : "Nama Lengkap"}, {id : "login", label : "User Login"}]
	});

	otable.fnSetColumnVis(0, false);	

});
</script>
<div id="apapun_namanya">
<form>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="10%">ID</th>
			<th width="25%">User Login</th>
			<th width="40%">Nama Lengkap</th>
			<th width="20%">Dibangun</th>
			<th width="5%"></th>
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
	<input type="button" id="submit" value="Tambahkan Kebawah"/>
</div>
</div>
