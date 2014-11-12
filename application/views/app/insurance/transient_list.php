<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact",
		listSource 		: "insurance/detail_list_loader/<?=$row_id?>",
		formSource 		: "insurance/detail_form/<?=$row_id?>",
		controlTarget	: "insurance/detail_form_action"
	
	});
	
});
</script>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact"> 
	<thead>
		<tr>
			
			<th>Product Type name</th>
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