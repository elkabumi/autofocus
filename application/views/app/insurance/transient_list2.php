<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact2",
		listSource 		: "insurance/detail_list_loader2/<?=$row_id?>",
		formSource 		: "insurance/detail_form2/<?=$row_id?>",
		controlTarget	: "insurance/detail_form_action2"
	
	});
	
});
</script>
<div>
<form id="">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact2"> 
	<thead>
		<tr>
			
					<th>Price Sub Category Name</th>
            <th>Additional Information</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>

<div class="command_table" style="text-align:left;">
    <input type="button" id="add" value="Add"/>
	<input type="button" id="edit" value="Edit"/>
    <input type="button" id="delete" value="Delete"/>
   
</div>
<div id="editor"></div>
</form>
</div>