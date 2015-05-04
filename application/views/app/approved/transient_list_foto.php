<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact4",
		listSource 		: "approved/detail_list_foto/<?=$row_id?>",
		formSource 		: "approved/detail_form_foto/<?=$row_id?>",
		controlTarget	: "approved/detail_form_foto_action",
		
	});
	
	
});
</script>
<div class="transient_category">Data Foto Seblum Mobil Masuk </div>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact4"> 
	<thead>
		<tr>
			
			<th>Nama Foto</th>
            
            <th>Foto Sebelum Mobil Masuk</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div class="command_table" style="text-align:left;">
 <table align="right">
        
        </table>
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Edit"/>
    <input type="button" id="delete" value="Hapus"/>
   
</div>
<div id="editor"></div>
</form>
</div>