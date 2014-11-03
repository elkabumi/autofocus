<script type="text/javascript">	
$(function(){
	createTableForm({
		id 		: "#table",
		listSource 	: "trial/book_table_loader/<?=$warehouse_id?>",
		formSource 	: "trial/book_form/<?=$warehouse_id?>",
		actionTarget	: "trial/book_form_action/<?=$warehouse_id?>"
	});
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="10%"></th>
			<th width="40%">Nama</th>
			<th width="15%">Dibeli</th>
			<th width="15%">Kadaluarsa</th>
			<th width="20%">Tipe Buku</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div class="command_table">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
