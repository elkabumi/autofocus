
<? $format; ?>


<body>
<table>
  <tr>
  <th colspan="8">&nbsp;</th>
  </tr>
  </table>
<table width="100%"cellspacing="0" cellpadding="0" border="1">
  <tr align="center" valign="middle" bgcolor="#00B0F0">
 	<td width="4%"height="20"><strong>No</strong></td>
    <td width="22%"><strong>Material Type</strong></td>
    <td width="15%"><strong>Material Code </strong></td>
    <td width="19%"><strong>Material Descrription</strong></td>
    <td width="20%"><strong>Notes</strong></td>
    <td width="20%"><strong>Created date</strong></td>
    <td width="20%"><strong>action</strong></td>
    <td width="20%"><strong>iinformation</strong></td>
  </tr>
  </table>
  <table>
<?php $no=1;
   foreach($detail as $item): ?>
    <tr align="center">
    <td height="24"><?=$no;?></td>
    <td><?=$item['product_code']?></td>
    <td><?=$item['product_category_name']?></td>
    <td><?=$item['product_name']?></td>
    <td><?=$item['product_description']?></td>
   	<td><?=format_new_date($item['product_date'])?></td>
    	<?
    		if($item['product_active_status'] == 1){
				$status = "Created by ".$item['created_name'];	
				$action = "&radic;";
			}else{
				$status = "Inactive by ".$item['inactive_name'];
				$action = "x";	
			}
			?>
            
    <td><?=$action;?></td>
    <td><?=$status;
			?>
            
      </td>
</tr>
    <?php $no++; 
	 endforeach; ?>
     
</table>

</body>
