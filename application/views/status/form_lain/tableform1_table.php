<script type="text/javascript">	
	$(function(){
		createTableForm({
			id 			: "#example",
			listSource 	: "status/table1_list",
			formSource 	: "status/table1_form",
			actionTarget: "status/table1_action",
			column_id	: 0
		});	
	});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="5%">ID</th>
			<th width="30%">Golongan</th>
			<th width="65%">Keterangan</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
	<input type="button" id="del" value="Hapus"/>
	<input type="button" id="refr" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
