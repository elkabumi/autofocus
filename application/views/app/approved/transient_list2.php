<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact2",
		listSource 		: "approved/detail_list_loader2/<?=$row_id?>",
		formSource 		: "approved/detail_form2/<?=$row_id?>",
		controlTarget	: "approved/detail_form_action2",
		
	});
	
	
});
</script>
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
<div id="editor"></div>
</form>
</div>