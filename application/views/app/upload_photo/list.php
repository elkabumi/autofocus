<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "upload_photo/table_controller",
		formTarget 	: "upload_photo/form",
		actionTarget: "upload_photo/form_action",
		activeTarget: "upload_photo/active",
		column_id	: 0,
		
		filter_by 	: [ 
		{id : "registration_code", label : "Kode Transaksi"}, 
		{id : "registration_date", label : "Tanggal"},
		{id : "car_nopol", label : "Nopol"},
        {id : "customer_name", label : "Nama Customer"},
        {id : "insurance_name", label : "Nama Asuransi"},
		{id : "claim_no", label : "No Klaim"}],
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
            <th>Nama Asuransi</th>
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
