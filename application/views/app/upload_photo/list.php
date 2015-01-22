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
		{id : "approved_name", label : "approved Code"}, 
		{id : "approved_addres", label : "approved Name"},
		{id : "approved_phone", label : "approved Type"},
		{id : "approved_date", label : "Create Date"}],
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
