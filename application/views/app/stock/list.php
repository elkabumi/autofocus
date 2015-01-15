<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "stock/table_controller",
		formTarget 	: "stock/form",
		actionTarget: "stock/form_action",
		column_id	: 0,
		
		filter_by 	: [ 
		{id : "product_stock_kode", label : "Kode"}, 
		{id : "product_stock_name", label : "Nama"}],
		"aLengthMenu"		: [[50, 100], [50, 100]],
	});
	otable.fnSetColumnVis(0, false, false);
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th>ID</th>
            <th>Kode</th>
            <th>Nama</th>
			<th>Jumlah</th>
            <th>Keterangan</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="add" value="Add"/>
	<input type="button" id="edit" value="Edit"/>
   	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
