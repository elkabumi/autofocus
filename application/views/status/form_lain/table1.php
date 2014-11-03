<script type="text/javascript">	
/*$.fn.dataTableExt.afnFiltering.push(
				function( oSettings, aData, iDataIndex ) {
					var kategori = document.getElementById('kategori').value;
					if ( kategori == "" )
					{
						return true;
					}
					return false;
				}
			);*/
$(function(){
	
		
	createTableAction({
		id 			: "#example",
		listSource 	: "status/fa_table_control",
		formTarget: "status/fa_form",
		submitTarget: "status/fa_submit",
		column_id : 0,
		filter_by : [{"id":"golongan","label":"Golongan"},{"id":"keterangan","label":"Keterangan"}]
	});

});
</script>
<div id="example">
<form>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="5%">ID</th>
			<th width="30%">Golongan</th>
			<th width="55%">Keterangan</th>
			<th width="5%">C</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
</form>
<div id="panel">
	<input type="button" id="submit" value="Bayar"/>
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Lihat"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
</div>

