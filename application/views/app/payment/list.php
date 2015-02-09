<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "payment/table_controller",
		formTarget 	: "payment/form",
		actionTarget: "payment/form_action",
		activeTarget: "payment/active",
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
            <th>Kode Transaksi</th>
            <th>Tanggal</th>
    		<th>Nopol</th>
            <th>Nama Customer</th>
            <th>Asuransi</th>
      		<th>No Klaim</th>
            <th>Status</th>
            <th>Config</th>

		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">
  <input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
