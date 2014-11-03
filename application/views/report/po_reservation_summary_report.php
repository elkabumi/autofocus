
<? $format; ?>

<style>
body{
	font-size:8px;
	letter-spacing:1;
	font-family:calibri;
	text-transform:uppercase;
}
</style>
<body>
<table>
  <tr>
  	<th>&nbsp;</th>
  	<th>&nbsp;</th>
  	<th>&nbsp;</th>
  	<th>&nbsp;</th>
  </tr>
  </table>
<table width="155%"cellspacing="0" cellpadding="0" class="tab" border="1">
  <tr align="center" valign="middle"   bgcolor="#00B0f0">
 	<td width="2%" height="30"><strong> No </strong></td>
    <td width="3%"><strong> Project Phase : </strong></td>
    <td width="3%"><strong> Project Name : </strong></td>
    <td width="3%"><strong> Po Type : </strong></td>
    <td width="3%"><strong> Po Number :</strong></td>
     <td width="3%"><strong> Reservation Number :</strong></td>
 
 
    <td bgcolor="#92d050"><strong> Site ID :</strong></td>
    <td bgcolor="#92d050"><strong> Site Name :</strong></td>
    <td bgcolor="#92d050"><strong> Site ID Mapping :</strong></td>
    <td bgcolor="#92d050"><strong> Site Name Mapping :</strong></td>
   
    
   	<td width="7%" bgcolor="#FFFF00"><strong> Quantity Ordered </strong></td>
    <td width="7%" bgcolor="#FFFF00"><strong> Quantity BOQ </strong></td>
    <td width="7%" bgcolor="#FFFF00"><strong> Quantity SO </strong></td>
    <td width="7%" bgcolor="#FFFF00"><strong> Quantity BAST </strong></td>
    
	 <td width="9%" bgcolor="#B7DEE8"><strong> WPID ID </strong></td>
    <td width="9%" bgcolor="#B7DEE8"><strong> SO NO </strong></td>
    <td width="9%" bgcolor="#B7DEE8"><strong> BAST NO </strong></td>
    
    <td width="6%" bgcolor="#FCD5B4"><strong> Order VS BOQ </strong></td>
    <td width="9%" bgcolor="#FCD5B4"><strong> BOQ VS SO </strong></td>
    <td width="9%" bgcolor="#FCD5B4"><strong> So VS BAST </strong></td>
    

 
    <td width="7%"><strong> PO Date </strong></td>
    <td width="7%"><strong> PO Received Date: </strong></td>
    <td width="8%"><strong> Delivery Date </strong></td>
    <td width="7%"><strong> Created Date </strong></td>
    <td width="8%"><strong> Information </strong></td>
  </tr>
   </table>
  <table>
<?php $no=1;
   foreach($detail as $item): 
    $qty_order= $item['get_total_ordered'] - $item['return']; 
	 $style = '';
   if($type == '0'){
	   if($qty_order == '0'){
		   continue;
	   }
   }else if($type == '1'){
   		if($qty_order == '0'){
		   $style = 'style="color:#F40000"';
		}
   }
	?>
    <tr valign="middle" >
    <td width="25" height="20" <?= $style?>>&nbsp;<?=$no;?>&nbsp;</td>
    <td width="25" <?= $style?>>&nbsp;<?=$item['phase_name']?>&nbsp;</td>
    <td width="25" <?= $style?>>&nbsp;<?=$item['project_name']?>&nbsp;</td>
    <td width="25" <?= $style?>>&nbsp;<?=$item['product_category_name']?>&nbsp;</td>
    <td width="25" <?= $style?>>&nbsp;<?=$item['po_number']?>&nbsp;</td>
    <td width="25" <?= $style?>>&nbsp;<?=$item['transaction_code']?>&nbsp;</td>
   
   
    <td width="33" bgcolor="#92d050" <?= $style?>>&nbsp;<?=$item['site_id']?>&nbsp;</td>
    <td width="17" bgcolor="#92d050" <?= $style?>>&nbsp;<?=$item['site_name']?>&nbsp;</td>
    <td width="25" bgcolor="#92d050" <?= $style?>>&nbsp;<?=$item['site_map_id']?>&nbsp;</td>
    <td width="25" bgcolor="#92d050" <?= $style?>>&nbsp;<?=$item['site_map_name']?>&nbsp;</td>

    
    <td width="6" align="right" bgcolor="#FFFF00" <?= $style?>><?=$qty_order?></td>    
    <td width="6" align="right" bgcolor="#FFFF00" <?= $style?>><?=$item['get_qty_boq']?></td> 
    <td width="6" align="right" bgcolor="#FFFF00" <?= $style?>><?=$item['get_qty_so']?></td> 
    <td width="6" align="right" bgcolor="#FFFF00" <?= $style?>><?=$item['get_qty_bast']?></td> 

    

    <td width="6"  bgcolor="#B7DEE8" <?= $style?>><?=$item['transaction_wpid_no']?></td>
    <td width="6"  bgcolor="#B7DEE8" <?= $style?>><?=$item['transaction_so_no']?></td>
    <td width="6"  bgcolor="#B7DEE8" <?= $style?>><?=$item['transaction_bast_no']?></td>
    
  		<? if($qty_order != '0' or $item['get_qty_boq'] != '0' ){
			 	if($qty_order == $item['get_qty_boq']){
					$order_boq = "Match";
				}else{
					$order_boq = "Not Match";	
				}
			}else{
				$order_boq = "";
			}
		?>
    <td width="6"  bgcolor="#FCD5B4" <?= $style?>><?=$order_boq?></td>
    	<?  if($item['get_qty_boq'] != '0' or $item['get_qty_so'] != '0' ){
			 	if($item['get_qty_boq'] == $item['get_qty_so']){
					$boq_so = "Match";
				}else{
					$boq_so = "Not Match";	
				}
			}else{
				$boq_so = "";	
			}
		?>
    <td width="6"  bgcolor="#FCD5B4" <?= $style?>><?=$boq_so?></td>
        <?  if($item['get_qty_so'] != '0' or $item['get_qty_bast'] != '0' ){ 
				if($item['get_qty_so'] == $item['get_qty_bast']){
					$so_bast = "Match";
				}else{
					$so_bast = "Not Match";	
				}
			}else{
				$so_bast = "";	
			}
		?>
    <td width="6"  bgcolor="#FCD5B4" <?= $style?>><?=$so_bast?></td>
        


    <td width="25" <?= $style?>>&nbsp;<?=format_new_date($item['transaction_date'])?>&nbsp;</td>   
    <td width="33" <?= $style?>>&nbsp;&nbsp;<?=format_new_date($item['transaction_received_date'])?>&nbsp;&nbsp;</td>
    <td width="25" <?= $style?>>&nbsp;<?=format_new_date($item['transaction_delivery_date'])?>&nbsp;</td>
    <td width="25" <?= $style?>>&nbsp;<?=format_new_date($item['create_date'])?>&nbsp;</td>
    <td width="37" <?= $style?>>&nbsp;	<?
    		if($item['transaction_active_status'] == 1){
				$status = "Created by ".$item['created_name'];	
			}else{
				$status = "Inactive by ".$item['inactive_name'];	
			}
			echo $status;
			?>
            &nbsp;
  
   </tr>
    <?php $no++; 
	 endforeach; ?>
     
</table>

</body>
