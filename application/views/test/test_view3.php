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
	var selectedId1 = '';var selectedId2 = '';
	var tb1=$('#table01').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?=site_url('test/table_controller')?>"
	} );
	var tb2=$('#table02').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?=site_url('test/table_controller2')?>"
	} );
	$('#table1').find('#refresh').click(function(){
		
		var anSelected = fnGetSelected( tb1 );tb1.fnDraw();alert(selectedId1);
		//tb1.fnDeleteRow( anSelected[0] ,null,false);alert(anSelected[0]);
	});
	$('#table2').find('#refresh').click(function(){
		var anSelected = fnGetSelected( tb2 );
		//tb2.fnDeleteRow( anSelected[0] ,null,false);
		tb2.fnDraw();alert(selectedId2);
	});
	$("#table01 tbody").click(function(event) {
		$(tb1.fnSettings().aoData).each(function (){
			$(this.nTr).removeClass('row_selected');
		});
		$(event.target.parentNode).addClass('row_selected');
		var pos = tb1.fnGetPosition(event.target.parentNode);
		var data = tb1.fnGetData(pos);
		selectedId1 = data[0];
	});
	$("#table02 tbody").click(function(event) {
		$(tb2.fnSettings().aoData).each(function (){
			$(this.nTr).removeClass('row_selected');
		});
		$(event.target.parentNode).addClass('row_selected');
		var pos = tb2.fnGetPosition(event.target.parentNode);
		var data = tb2.fnGetData(pos);
		selectedId2 = data[0];
	});
	function fnGetSelected( oTableLocal )
{
	var aReturn = new Array();
	var aTrs = oTableLocal.fnGetNodes();
	
	for ( var i=0 ; i<aTrs.length ; i++ )
	{
		if ( $(aTrs[i]).hasClass('row_selected') )
		{
			aReturn.push( aTrs[i] );
		}
	}
	return aReturn;
}
} );
</script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table" width="400"> 
	<tr> <td width="200">xxx</td><td width="300">

<div id="table1">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table01" width="400"> 
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
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table02" width="400"> 
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
