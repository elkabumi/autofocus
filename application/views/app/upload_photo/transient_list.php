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
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact2"> 
	<thead>
		<tr>
			
			<th>nama foto</th>
            <th>Foto before</th>
            <th>Foto After</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>

<div class="command_table" style="text-align:left;">
  
	<input type="button" id="edit" value="Edit"/>
   
</div>
<div id="editor"></div>
</form>
</div>