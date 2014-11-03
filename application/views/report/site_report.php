
<? $format; ?>
<body>
<table>
  <tr>
  <th colspan="8">&nbsp;</th>
  </tr>
  </table>
<table width="100%"cellspacing="0" cellpadding="0" border="1">
  <tr align="center" bgcolor="#00B0F0" >
 	<td width="4%" height="20"><strong>No</strong></td>
    <td width="15%" height="20"><strong>Site code</strong></td>
    <td width="15%" height="20"><strong>Site name</strong></td>
    <td width="19%"><strong>Site Description</strong></td>
     <td width="20%"><strong>Site Date</strong></td>
    <td width="20%"><strong>Active Status</strong></td>
    <td width="20%"><strong>information</strong></td>
  </tr>
  </table>
  <table>
<?php $no=1;
   foreach($detail as $item): 
   	if($item['site_active_status'] == 1){
				$status = "Created by ".$item['created_name'];	
				$active = "Active";
			}else{
				$status = "Inactive by ".$item['inactive_name'];
				$active = "Inactive";	
			}
   ?>
    <tr align="center">
    <td ><?=$no;?></td>
    <td><?=$item['site_code']?></td>
    <td><?=$item['site_name']?></td>
    <td><?=$item['site_description']?></td>
   	<td><?=format_new_date($item['site_date'])?></td>
    <td><?=$active?></td>
    <td><?
			echo $status;
			?>
            
      </td>
</tr>
    <?php $no++; 
	 endforeach; ?>
     
</table>

</body>
