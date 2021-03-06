<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "create_po_material/table_controller",
		formTarget 	: "create_po_material/form",
		actionTarget: "create_po_material/form_action",
		activeTarget: "create_po_material/active",
		column_id	: 0,
	

		filter_by 	: [ 
		{id : "code", label : "Kode PO Bahan"}, 
		{id : "date", label : "Tanggal Create PO Bahan<"},
		{id : "harga", label : "Total Harga PO"}

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
            <th>Kode PO Bahan</th>
            <th>Tgl Create PO Bahan</th>
            <th>Total Harga PO</th>
      		
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">

  <input type="button" id="add" value="add"/>
  
  <input type="button" id="edit" value="view"/>
  <!--<input type="button" id="refresh" value="Refresh"/>
    <input type="button" id="active" value="active"/>
  <input type="button" id="delete" value="Delete"/>-->
</div>
<div id="editor"></div>
</div>
