<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact2",
		listSource 		: "registration/detail_list_loader2/<?=$row_id?>",
		formSource 		: "registration/detail_form2/<?=$row_id?>",
		controlTarget	: "registration/detail_form_action2",
		
	});
	
	
});
</script>
<div class="transient_category">Data Foto Mobil Sebelum Masuk Bengkel</div>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact2"> 
	<thead>
		<tr>
			
			<th>Nama Foto</th>
            <th>Foto Before</th>
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