
<? $format; ?>
<body>
<table>
  <tr>
  <th colspan="8">&nbsp;</th>
  </tr>
  </table>
<table width="100%"cellspacing="0" cellpadding="0" border="1">
  <tr align="center" bgcolor="#1CBB9B" >
 	<td width="4%" height="20"><strong>No</strong></td>
    <td width="15%" height="20"><strong>Tanggal Registrasi</strong></td>
    <td width="15%" height="20"><strong>Nama Team</strong></td>
    <td width="15%" height="20"><strong>Total Gaji</strong></td>

  </tr>
  </table>
  <table>
<?php $no=1;
   foreach($detail as $item): 

   ?>
    <tr align="center">
  	 	<td ><?=$no;?></td>
         <td><?=format_new_date($item['registration_date'])?></td>
        <td><?=$item['employee_group_name']?></td>
        <td><?=$item['transaction_total']?></td>
 
</tr>
    <?php $no++; 
	 endforeach; ?>
     
</table>

</body>
