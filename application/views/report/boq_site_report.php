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
    <td width="15%"><strong>PO Type:</strong></td>
    <td width="19%"><strong>Material Type:</strong></td>
    <td width="20%"><strong>Material Code</strong></td>
    <td width="22%"><strong>Material Description</strong></td>
    <td width="20%"><strong>UoM</strong></td>
    <td width="20%"><strong>Quantity PO</strong></td>
    <td width="20%"><strong>Quantity Ordered</strong></td>
    <td width="20%"><strong>PO Number :</strong></td>
    <td width="20%"><strong>WPID No</strong></td>
    <td width="20%"><strong>SO No</strong></td>
  </tr>
 </table> <table width="100%"cellspacing="0" cellpadding="0" >
<?php $no=1;
   foreach($detail as $item): ?>
    <tr>
 	<td><?=$no;?></td>
    <td><?=$item['product_category_name']?></td>
    <td><?=$item['product_category_name']?></td>
        <td  ><?=$item['product_code']?></td>
    <td  ><?=$item['product_name']?></td>
    <td ><?=$item['uom_name']?></td>
     <td ><?=$item['transaction_detail_qty']?></td>
      <td ><?=$item['transaction_detail_ordered']?></td>
          <td ><?=$item['transaction_code']?></td>
          <td ><?=$item['transaction_detail_wpid_no']?></td>
          <td ><?=$item['transaction_detail_so_no']?></td>
   </tr>
    <?php $no++; 
	 endforeach; ?>
     
</table>

</body>
