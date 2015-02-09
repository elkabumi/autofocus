<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_foto",
		listSource 		: "transaction/detail_list_loader_foto/<?=$row_id?>",
		formSource 		: "transaction/detail_form_foto/<?=$row_id?>",
		controlTarget	: "transaction/detail_form_action_foto",
		
	});
	
	
});
</script>
<div class="transient_category">Data Foto Mobil</div>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_foto"> 
	<thead>
		<tr>
			
			<th>Nama Foto</th>
			<th>Jenis Foto</th>
            <th>Foto</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div class="command_table" style="text-align:left;">
      <input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
    <input type="button" id="delete" value="Hapus"/>
   
</div>
<div id="editor"></div>
</form>
</div>