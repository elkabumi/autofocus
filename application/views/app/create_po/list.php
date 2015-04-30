<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "create_po/table_controller",
		formTarget 	: "create_po/form",
		actionTarget: "create_po/form_action",
		activeTarget: "create_po/active",
		column_id	: 0,
	

		filter_by 	: [ 
		{id : "code", label : "Kode Transaksi"}, 
		{id : "date", label : "Tanggal Registrasi"},
		{id : "nopol", label : "Nopol"},
		{id : "customer_name", label : "Nama Customer"},
		{id : "insurance_name", label : "Nama Asuransi"},
		{id : "claim_no", label : "No Klaim"}

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
              <th>Tgl Create PO</th>
              <th>kode Transaksi</th>
    		<th>Nopol</th>
            <th>Nama Customer</th>
            <th>Nama Asuransi</th>
      		
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
