<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_example",
		listSource 		: "trial/book_transient_loader/<?=$warehouse_id?>",
		formSource 		: "trial/book_transient_form/<?=$warehouse_id?>",
		controlTarget	: "trial/book_transient_control",	// add edit controller
		actionTarget	: "trial/book_transient_action/<?=$warehouse_id?>"	 // insert many data at once	
	});

});
</script>
<div id="transient_example">
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="50%">Nama</th>
			<th width="15%">Dibeli</th>
			<th width="15%">Kadaluarsa</th>
			<th width="20%">Tipe Buku</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
</form>
<div id="panel">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/> &nbsp; &nbsp;
    <input type="button" id="delete" value="Hapus"/>
	<input type="button" id="reset" value="Reset"/> &nbsp; &nbsp;
    <input type="button" id="submit" value="Simpan"/>
</div>
<div id="editor"></div>
</div>
