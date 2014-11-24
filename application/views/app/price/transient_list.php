<script type="text/javascript">	
$(function(){
	
	var otable = createTableFixed({
		id	: "#table_price",
		"useSearch" : true
	}, {
		"bPaginate" : true,
		"bAutoWidth": false,
		"sPaginationType": "full_numbers",
		"bFilter": true,
	});	
	//otable.fnSetColumnVis(0, false, false);
});
</script>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table_price"> 
	<thead>
    <tr>
     <th>Item Name</th>
    <?php foreach($list as $item): ?>
		
			<th><?=$item['product_type_name']." (".$item['pst_name'].") "?></th>
      
		
         <?
	 endforeach; ?>
     <th>Config</th>
     </tr> 
	</thead> 
	<tbody> 
    <?php foreach($data_product as $item_product): ?>
    	<tr>
        <td><?= $item_product['product_name'] ?></td>
         <?php foreach($list as $item2): ?>
		
			<td align="right">
             <?php
            $item_price = $this->price_model->get_item_price($item_product['product_id'], $item2['product_type_id'], $item2['pst_id']);
			
			$item_price = ($item_price) ? $item_price : 0;
			echo number_format($item_price, 0); 
			?>
            </td>
      
		
         <?
	 endforeach; ?>
     	<td><a href="<?=site_url('price/form_proses/'.$item_product['product_id'])?>" class="link_input"> EDIT </a></td>
      </tr>
        
         <?
	 endforeach; ?>
        </tbody>
       
    
</table>

<div id="editor"></div>
</form>
</div>