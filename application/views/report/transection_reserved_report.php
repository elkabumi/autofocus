
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

 
    <td bgcolor="#92d050"><strong> Site ID :</strong></td>
    <td bgcolor="#92d050"><strong> Site Name :</strong></td>
    <td bgcolor="#92d050"><strong> Site ID Mapping :</strong></td>
    <td bgcolor="#92d050"><strong> Site Name Mapping :</strong></td>
   
    <td width="4%"><strong> Material Type </strong></td>
    <td width="6%"><strong> Material Code </strong></td>
    <td width="5%"><strong> Material Description </strong></td>
    <td width="7%"><strong> Additional Information </strong></td>
  	<td width="4%"><strong> UoM </strong></td>
    
   	<td width="7%" bgcolor="#FFFF00"><strong> Quantity Ordered </strong></td>
    <td width="7%" bgcolor="#FFFF00"><strong> Quantity BOQ </strong></td>
    <td width="7%" bgcolor="#FFFF00"><strong> Quantity SO </strong></td>
    <td width="7%" bgcolor="#FFFF00"><strong> Quantity BAST </strong></td>
    
    <td width="6%" bgcolor="#B7DEE8"><strong> SITE ID </strong></td>
    <td width="9%" bgcolor="#B7DEE8"><strong> WPID ID </strong></td>
    <td width="9%" bgcolor="#B7DEE8"><strong> SO NO </strong></td>
    <td width="9%" bgcolor="#B7DEE8"><strong> BAST NO </strong></td>
    
    <td width="6%" bgcolor="#FCD5B4"><strong> Order VS BOQ </strong></td>
    <td width="9%" bgcolor="#FCD5B4"><strong> BOQ VS SO </strong></td>
    <td width="9%" bgcolor="#FCD5B4"><strong> So VS BAST </strong></td>
    
    <td width="6%" bgcolor="#BFBFBF"><strong> Remarks Project</strong></td>
    <td width="9%" bgcolor="#BFBFBF"><strong> Remarks GDC </strong></td>
    <td width="9%" bgcolor="#BFBFBF"><strong> Remarks SOC </strong></td>
    <td width="9%" bgcolor="#BFBFBF"><strong> Remarks CCM </strong></td>
 
    <td width="7%"><strong> PO Date </strong></td>
    <td width="7%"><strong> PO Received Date: </strong></td>
    <td width="8%"><strong> Delivery Date </strong></td>
    <td width="7%"><strong> Created Date </strong></td>
    <td width="8%"><strong> Information </strong></td>
         <td width="3%"><strong> Reservation Number :</strong></td>
  </tr>
  </table>
  <table>
<?php $no=1;
   foreach($detail as $item):
   $qty_order= $item['transaction_detail_ordered'] - $item['return']; 
   
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
    <td height="20" <?= $style; ?>>&nbsp;<?=$no;?>&nbsp;</td>
    <td <?= $style; ?> >&nbsp;<?=$item['phase_name']?>&nbsp;</td>
    <td <?= $style; ?>>&nbsp;<?=$item['project_name']?>&nbsp;</td>
    <td <?= $style; ?>>&nbsp;<?=$item['product_category_name']?>&nbsp;</td>
    <td <?= $style; ?>>&nbsp;<?=$item['po_number']?>&nbsp;</td>

   
    <td bgcolor="#92d050" <?= $style; ?>>&nbsp;<?=$item['site_id']?>&nbsp;</td>
    <td bgcolor="#92d050" <?= $style; ?>>&nbsp;<?=$item['site_name']?>&nbsp;</td>
    <td bgcolor="#92d050" <?= $style; ?>>&nbsp;<?=$item['site_map_id']?>&nbsp;</td>
    <td bgcolor="#92d050" <?= $style; ?>>&nbsp;<?=$item['site_map_name']?>&nbsp;</td>
   
    <td <?= $style; ?>>&nbsp;<?=$item['product_category_name']?>&nbsp;</td>
    <td <?= $style; ?>>&nbsp;<?=$item['product_code']?>&nbsp;</td>
    <td <?= $style; ?>>&nbsp;<?=$item['product_name']?>&nbsp;</td>
 	<td <?= $style; ?>>&nbsp;<?=$item['transaction_description']?>&nbsp;</td>
    <td <?= $style; ?>>&nbsp;<?=$item['uom_name']?>&nbsp;</td> 
    
    <td align="right" bgcolor="#FFFF00" <?= $style; ?>><?=$qty_order?></td>
     
    <td align="right" bgcolor="#FFFF00" <?= $style; ?>><?=$item['transaction_detail_quantity_boq']?></td> 
    <td align="right" bgcolor="#FFFF00" <?= $style; ?>><?=$item['transaction_detail_quantity_so']?></td> 
    <td align="right" bgcolor="#FFFF00" <?= $style; ?>><?=$item['transaction_detail_quantity_bast']?></td> 
    
    <td  bgcolor="#B7DEE8" <?= $style; ?>><?=$item['site_id']?></td>
    <td  bgcolor="#B7DEE8" <?= $style; ?>><?=$item['transaction_wpid_no']?></td>
    <td  bgcolor="#B7DEE8" <?= $style; ?>><?=$item['transaction_so_no']?></td>
    <td  bgcolor="#B7DEE8" <?= $style; ?>><?=$item['transaction_bast_no']?></td>
  		<? 
			if($qty_order != '0' or $item['transaction_detail_quantity_boq'] != '0' ){
				if($qty_order == $item['transaction_detail_quantity_boq']){
					$order_boq = "Match";
				}else{
					$order_boq = "Not Match";	
				}
			}else{
				$order_boq = "";
			}
		?>
    <td  bgcolor="#FCD5B4" <?= $style; ?>><?=$order_boq?></td>
    	<? 	if($item['transaction_detail_quantity_boq'] != '0' or $item['transaction_detail_quantity_so'] != '0' ){	
				if($item['transaction_detail_quantity_boq'] == $item['transaction_detail_quantity_so']){
					$boq_so = "Match";
				}else{
					$boq_so = "Not Match";	
				}
			}else{
				$boq_so = "";
			}
		?>
    <td  bgcolor="#FCD5B4" <?= $style; ?>><?=$boq_so?></td>
        <? if($item['transaction_detail_quantity_so'] != '0' or $item['transaction_detail_quantity_bast'] != '0'){
				if($item['transaction_detail_quantity_so'] == $item['transaction_detail_quantity_bast']){
					$so_bast = "Match";
				}else{
					$so_bast = "Not Match";	
				}
		}else{
				$so_bast = "";
			}
		?>
    <td  bgcolor="#FCD5B4" <?= $style; ?>><?=$so_bast?></td>
        
    <td  bgcolor="#BFBFBF" <?= $style; ?>><font color="#FF0000"><?=$item['transaction_detail_remarks_project']?></font></td>
    <td  bgcolor="#BFBFBF" <?= $style; ?>><?=$item['transaction_detail_remarks_gdc']?></td>
    <td  bgcolor="#BFBFBF" <?= $style; ?>><?=$item['transaction_detail_remarks_soc']?></td>
    <td  bgcolor="#BFBFBF" <?= $style; ?>><?=$item['transaction_detail_remarks_ccm']?></td>
      
    <td <?= $style; ?>>&nbsp;<?= format_new_date($item['transaction_date'])?>&nbsp;</td>   
    <td <?= $style; ?>>&nbsp;&nbsp;<?= format_new_date($item['transaction_received_date'])?>&nbsp;&nbsp;</td>
    <td <?= $style; ?>>&nbsp;<?= format_new_date($item['transaction_delivery_date'])?>&nbsp;</td>
    <td <?= $style; ?>>&nbsp;<?= format_new_date($item['create_date'])?>&nbsp;</td>
    <td <?= $style; ?>>&nbsp;	<?
    		if($item['transaction_active_status'] == 1){
				$status = "Created by ".$item['created_name'];	
			}else{
				$status = "Inactive by ".$item['inactive_name'];	
			}
			echo $status;
			?>
            &nbsp;
      <td <?= $style; ?>>&nbsp;<?=$item['transaction_code']?>&nbsp;</td>
   
   </tr>
    <?php $no++; 
	 endforeach; ?>
     
</table>

</body>
