<script type="text/javascript">	
$(function(){
	
	var otable = createTable({
		id		 : "#table",
		listSource	 : "trial/warehouse_table_controller",	
		formTarget	 : "trial/warehouse_form",
		submitTarget	 : "trial/warehouse_submit",
		sendIDTarget	 : "trial/warehouse_form", // optional, untuk mengirim id ke form
		column_id	 : 0,
		filter_by	 : [ {id : "nama", label : "Nama"}, {id : "alamat", label : "Alamat"}]
	});

	otable.fnSetColumnVis(0, false); // hidden colomn 1
});
</script>
<div id="apapun_namanya">
<form>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="10%">ID</th>
			<th width="25%">Nama</th>
			<th width="40%">Alamat</th>
			<th width="20%">Dibangun</th>
			<th width="5%"></th>
		</tr> 
	</thead> 
	<tbody>	
	</tbody>
</table>

<div class="command_table">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Lihat"/>
	<input type="button" id="refresh" value="Refresh"/>
	<input type="button" id="send" value="Add ID"/> <!-- untuk mentrigger send ID target -->
</div>
</form>
</div>


