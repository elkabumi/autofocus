<script type="text/javascript">	
$(function(){
	createTableFormArray({
		id 		: "#example",
		listSource 	: "trial/book_table_loader/<?=$warehouse_id?>",
		formSource 	: "trial/book_form/<?=$warehouse_id?>",
		actionTarget	: "trial/book_form_action",
		column_id	: 0
	});	
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="10%">ID</th>
			<th width="40%">Nama</th>
			<th width="15%">Dibeli</th>
			<th width="15%">Kadaluarsa</th>
			<th width="20%">Tipe Buku</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
	<input type="button" id="del" value="Hapus"/>
	<input type="button" id="refr" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
