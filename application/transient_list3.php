<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact2",
		listSource 		: "approved/detail_list_loader2/<?=$row2_id?>",
		formSource 		: "approved/detail_form2/<?=$row2_id?>",
		controlTarget	: "approved/detail_form_action2",
		
	});
	
	
});
</script>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact2"> 
	<thead>
		<tr>
			
			<th>nama foto</th>
            <th>foto</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div id="editor"></div>
</form>
</div>