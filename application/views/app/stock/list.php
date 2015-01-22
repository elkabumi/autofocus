<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "stock/table_controller",
		formTarget 	: "stock/form",
		actionTarget: "stock/form_action",
		column_id	: 0,
		
		filter_by 	: [ 
		{id : "product_code", label : "Kode"}, 
		{id : "product_name", label : "Nama"},
		{id : "stand_name", label : "Cabang"}, 
		],
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
            <th>Cabang</th>
			<th>Jumlah</th>
          
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">
	<!--<input type="button" id="add" value="Add"/>-->
	<input type="button" id="edit" value="Edit"/>
   	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
