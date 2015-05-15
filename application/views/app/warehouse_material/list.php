<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "warehouse_material/table_controller",
		formTarget 	: "warehouse_material/form",
		actionTarget: "warehouse_material/form_action",
		activeTarget: "warehouse_material/active",
		column_id	: 0,
	

		filter_by 	: [ 
		{id : "nama_bahan", label : "Nama Bahan"}, 
		{id : "nama_cabang", label : "Nama Cabang"},
		{id : "stock", label : "Stock"}

		],
		"aLengthMenu"		: [[50, 100, 250, 500], [50, 100, 250, 500]],
	});
	otable.fnSetColumnVis(0, false, false);
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th>ID</th>
            <th>Nama cat</th>
            <th>Nama cabang</th>
            <th>Jumlah Stock</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">

	 <input type="button" id="add" value="add"/>
  <input type="button" id="refresh" value="Refresh"/>
  <input type="button" id="delete" value="Delete"/>
</div>
<div id="editor"></div>
</div>
