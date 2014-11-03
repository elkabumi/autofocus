<script type="text/javascript">	
$(function(){
	createTableMovable({
		id 		: "#table_example",
		listSource 	: "trial/detail_loader",
		listTarget 	: "trial/detail_loader_target"
	});
});
</script>

<div id="table_example">
<form id="form1">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="15%">Kategori</th>
			<th width="10%">Nama</th>
			<th width="15%">Keterangan</th>
		</tr>
	</thead> 
	<tbody id="api_items">
		<tr>
			<td>1</td>
			<td>Zuka</td>
			<td>Terumo</td>
		</tr>
		<tr>
			<td>1</td>
			<td>Zuka</td>
			<td>Terumo</td>
		</tr>
	</tbody>
</table>
<div class="panel">
	<input type="button" id="add" value="Tambahkan"/> &nbsp; &nbsp;
	<input type="button" id="reset" value="Reset"/>	
</div>
</form>
<form id="form2">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table_target"> 
	<thead>
		<tr>
			<th width="15%">Kategori</th>
			<th width="10%">Nama</th>
		</tr>
	</thead> 
	<tbody id="api_items2"> 	
	</tbody>
</table>
<div class="panel">
	<input type="button" id="remove" value="Hapus"/>
	<input type="button" id="removeall" value="Hapus Semua"/>
	<input type="button" id="reset" value="Reset"/>	
</div>
</form>

</div>
<!-- end semua data -->
