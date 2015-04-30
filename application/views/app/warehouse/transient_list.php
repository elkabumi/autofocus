<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact2",
		listSource 		: "warehouse/detail_list_loader/<?=$row_id?>",
		formSource 		: "warehouse/detail_form2/<?=$row_id?>",
		controlTarget	: "warehouse/detail_form_action2",
		
	});
	
	
});
</script>
<div class="transient_category">Detail History Parts</div>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact2"> 
	<thead>
		<tr>
			
			<th>Tanggal</th>
            <th>Type</th>
            <th>Jumlah</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div id="editor"></div>
</form>
</div>