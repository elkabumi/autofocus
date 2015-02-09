<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact2",
		listSource 		: "upload_photo/detail_list_loader/<?=$row_id?>",
		formSource 		: "upload_photo/detail_form/<?=$row_id?>",
		controlTarget	: "upload_photo/detail_form_action",
		
	});
	
	
});
</script>
<div class="transient_category">Data Foto Mobil Keluar Dan Perbandingan</div>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact2"> 
	<thead>
		<tr>
			
			<th>Nama foto</th>
            <th>Foto File</th>
            <th>Foto Type</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<?php
if($status_registration_id == '3' or $status_registration_id == '4'){
?>
<div class="command_table" style="text-align:left;">
      <input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
    <input type="button" id="delete" value="Hapus"/>
   
</div>
<?php } ?>
<div id="editor"></div>
</form>
</div>