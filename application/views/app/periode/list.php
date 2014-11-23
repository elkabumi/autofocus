<script type="text/javascript">	
$(function(){
	otable = createTable({
		id 				: "#table",
		listSource 		: "periode/table_controller",
		formTarget 		: "periode/form",
		actionTarget	: "periode/form_action",
		column_id		: 0,
		filter_by 		: [ {id : "code", label : "Kode"}, {id : "bulan", label : "bulan"}, {id : "tahun", label : "tahun"}, {id : "deskripsi", label : "deskripsi"},]
	});
	otable.fnSetColumnVis(0, false, false);
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
        	<th width="10%">ID</th>
            <th width="10%">Kode</th>
			<th width="20%">Bulan</th>
			<th width="10%">Tahun</th>
			<th width="30%">Keterangan</th>
			<th width="5%">Aktif</th>			
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>

