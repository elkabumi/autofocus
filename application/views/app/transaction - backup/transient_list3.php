<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact2",
		listSource 		: "transaction/detail_list_loader3/<?=$row_id?>",
		formSource 		: "transaction/detail_form3/<?=$row_id?>",
		controlTarget	: "transaction/detail_form_action3",
		
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
            <th>Foto id</th>
		    
            <th>Foto After</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div class="command_table" style="text-align:left; height:60px;">
	
   	<input type="button" id="edit" value="Edit"/>
   
</div>
<div id="editor"></div>

</form>
</div>