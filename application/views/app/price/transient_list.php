<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact",
		listSource 		: "price/detail_list_loader/<?=$row_id?>",
		formSource 		: "price/detail_form/<?=$row_id?>",
		controlTarget	: "price/detail_form_action"
	
	});
	
});
</script>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact"> 
	<thead>
    <tr>
     <th>Item Name</th>
    <?php foreach($detail as $item): ?>
		
			<th><?=$item['product_type_name']." (".$item['pst_name'].") "?></th>
      
		
         <?
	 endforeach; ?>
     </tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>

<div class="command_table" style="text-align:left;">
    <!--<input type="button" id="add" value="Add"/>-->
	<input type="button" id="edit" value="Edit"/>
    <input type="button" id="delete" value="Delete"/>
   
</div>
<div id="editor"></div>
</form>
</div>