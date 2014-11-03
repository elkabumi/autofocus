<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/demo_table_jui.css" media="screen">
<link rel="stylesheet" type="text/css" href="http://127.0.0.1/citest/assets/css/superfish.css" media="screen"> 
<link rel="stylesheet" type="text/css" href="http://127.0.0.1/citest/assets/css/superfish-vertical.css" media="screen"> 
<link href="http://127.0.0.1/citest/assets/css/flick/jquery-ui-1.8.12.custom.css" rel="stylesheet" type="text/css" /> 
<link href="http://127.0.0.1/citest/assets/css/custom-app.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="http://127.0.0.1/citest/assets/js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="http://127.0.0.1/citest/assets/js/jquery.dataTables.js"></script> 
<script type="text/javascript" src="http://127.0.0.1/citest/assets/js/jquery-ui-1.8.12.custom.min.js"></script> 
<script type="text/javascript" src="http://127.0.0.1/citest/assets/js/app.js"></script> 
<script type="text/javascript" src="http://127.0.0.1/citest/assets/js/superfish.js"></script> 
<script type="text/javascript" src="http://127.0.0.1/citest/assets/js/jquery.hoverIntent.minified.js"></script> 
<script type="text/javascript" charset="utf-8"> 
var site_url = '<?=site_url()?>';
$(document).ready(function() {
	
	createTableAction({
		id : "#datatable2",
		listSource : "test/table_controller2",
		pageTarget : "test/form2",
		dialogPage : "test/form_dialog",
		formTarget	 : "test/form2",
		column_id	 : 0,
		filter_by	 : [ {id : "nama", label : "Nama"}, {id : "alamat", label : "Alamat"}]
	});
	var otable = createTableAction({
		id : "#datatable1",
		listSource : "test/table_controller",
		pageTarget : "test/form",
		dialogPage : "test/form_dialog",
		formTarget	 : "test/form",
		column_id	 : 0,
		filter_by	 : [ {id : "nama", label : "Nama"}, {id : "alamat", label : "Alamat"}]
	});
} );
</script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table" width="400"> 
	<tr> <td width="200">xxx</td><td width="300">

<div id="table1">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="datatable1" width="400"> 
	<thead> 
		<tr> 
			<th width="10%" align="right">ID</th>
			<th width="10%">NIK</th>
			<th width="25%">Nama</th>
			<th width="40%">Alamat</th>
			<th width="20%">Email</th>
		</tr> 
	</thead> 
	<tbody> 		
	</tbody>
</table>
<div class="command-table">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Lihat"/><input type="button" id="refresh" value="refresh"/>
</div>
<div id="dialog">
</div>
</div>
<div id="table2">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="datatable2" width="400"> 
	<thead> 
		<tr> 
			<th width="10%" align="right">ID</th>
			<th width="25%">Nama Vendor</th>
			<th width="40%">Alamat</th>
		</tr> 
	</thead> 
	<tbody> 		
	</tbody>
</table>
<div class="command-table">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Lihat"/><input type="button" id="refresh" value="refresh"/>
</div>
<div id="dialog">
</div>
</div>
</td><td width="200">xxx</td>
</tr>
</table>	
