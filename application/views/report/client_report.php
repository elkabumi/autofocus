<? $format; ?>

<body>
<table>
  <tr>
  <th>&nbsp;</th>
  <th>&nbsp;</th>
  <th>&nbsp;</th>
  <th>&nbsp;</th>
  </tr>
  </table>
<table width="100%"cellspacing="0" cellpadding="0" class="tab" border="1">
  <tr align="center" bgcolor="#00B0F0">
 	<td width="4%" height="20"><strong>No</strong></td>
    <td width="15%"><strong>customer number</strong></td>
    <td width="19%"><strong>customer name</strong></td>
    <td width="20%"><strong>customer phone</strong></td>
    <td width="22%"><strong>customer email</strong></td>
    <td width="20%"><strong>customer adres</strong></td>
  </tr>
 </table> <table width="100%"cellspacing="0" cellpadding="0" >
<?php $no=1;
   foreach($detail as $item): ?>
    <tr align="center">
 	<td ><?=$no;?></td>
    <td ><?=$item['customer_number']?></td>
    <td  ><?=$item['customer_name']?></td>
    <td ><?=$item['customer_phone']?></td>
    <td  ><?=$item['customer_email']?></td>
    <td ><?=$item['customer_address']?></td>
   </tr>
    <?php $no++; 
	 endforeach; ?>
     
</table>

</body>
