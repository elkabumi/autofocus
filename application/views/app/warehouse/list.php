<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "warehouse/table_controller",
		formTarget 	: "warehouse/form",
		actionTarget: "warehouse/form_action",
		activeTarget: "warehouse/active",
		column_id	: 0,
	

		filter_by 	: [ 
		{id : "code", label : "Kode PO"}, 
		{id : "nama_part", label : "Nama Parts"},
		{id : "order", label : "Jumlah Order"},
		{id : "received", label : "Jumlah Received"},
		{id : "instal", label : "Jumlah Terpasang"},
		{id : "nopol", label : "Nopol Mobil"}

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
            <th>Kode PO</th>
            <th>Nama Parts</th>
            <th>Jumlah Order</th>
    		<th>Jumlah Received</th>
            <th>Jumlah Terpasang</th>
              <th>Jumlah Stock</th>
            <th>Nopol Mobil</th>
      		<th>Config</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">

  <!--<input type="button" id="add" value="add"/>
  <input type="button" id="refresh" value="Refresh"/>
    <input type="button" id="active" value="active"/>
  <input type="button" id="delete" value="Delete"/>-->
</div>
<div id="editor"></div>
</div>
