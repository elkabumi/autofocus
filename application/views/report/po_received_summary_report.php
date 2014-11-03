
<? //$format; ?>

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
    <td width="3%"><strong> Phase : </strong></td>
    <td width="3%"><strong> Project Name : </strong></td>
    <td width="3%"><strong> Po Type : </strong></td>
    <td width="3%"><strong> Po Number :</strong></td>
	<td width="6%"><strong> PO Date : </strong></td>
    <td width="9%"><strong> PO Received Date : </strong></td>
    <td width="9%"><strong> Delivery Date </strong></td>
 
   	<td width="7%"><strong> Qty PO </strong></td>
    <td width="7%" bgcolor="#FFFF00"><strong> Quantity Ordered </strong></td>
   	<td width="7%" bgcolor="#FFFF00"><strong> Delta Qty </strong></td>
	 <td width="9%"><strong> %Complete </strong></td>
     
    <td width="9%"><strong>Status Itemm PO </strong></td>
                
    <td width="7%"><strong> Created Date </strong></td>
    <td width="8%"><strong> Information </strong></td>
  </tr>
  </table>
  <table>
<?php $no=1;
   foreach($detail as $item): 
   $qty_order = $item['get_total_ordered']- $item['return']?>
    <tr align="center" valign="middle" >
    <td height="20">&nbsp;<?=$no;?>&nbsp;</td>
    <td>&nbsp;<?=$item['phase_name']?>&nbsp;</td>
    <td>&nbsp;<?=$item['project_name']?>&nbsp;</td>
    <td>&nbsp;<?=$item['product_category_name']?>&nbsp;</td>
    <td>&nbsp;<?=$item['transaction_code']?>&nbsp;</td>
	<td>&nbsp;&nbsp;<?=format_new_date($item['transaction_date'])?>&nbsp;&nbsp;</td>
    <td>&nbsp;&nbsp;<?=format_new_date($item['transaction_received_date'])?>&nbsp;&nbsp;</td>
    <td>&nbsp;<?=format_new_date($item['transaction_delivery_date'])?>&nbsp;</td>
    

  	<td align="right"><?=$item['get_total_qty']?></td> 
    <td align="right" bgcolor="#FFFF00"><?=$qty_order?></td> 
    <td align="right" bgcolor="#FFFF00"><? $field=$no+2;   echo "=i$field-j$field";?> </td> 	
 	
    <td><? echo "=(100/I$field)*J$field" ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;<?=$item['create_date']?>&nbsp;</td>
    <td>&nbsp;	<?
    		if($item['transaction_active_status'] == 1){
				$status = "Created by ".$item['create_by_name'];	
			}else{
				$status = "Inactive by ".$item['inactive_by_name'];	
			}
			echo $status;
			?>
            &nbsp;
      </td> 
   </tr>
    <?php $no++; 
	 endforeach; ?>
     
</table>

</body>
