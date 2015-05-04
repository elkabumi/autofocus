
<? $format; ?>
<body>
<table>
<? 
$employee_group_name = '';
foreach($detail as $item):
	$employee_group_name = $item['employee_group_name'];
	endforeach;
 ?>
  <tr>
  <td>Nama Group</td>
  <td>:</td>
  <td colspan="3"><?=$employee_group_name?></td>
  </tr>
  <tr>
  <td></td>
  <td></td>
  <td colspan="3"></td>
  </tr>
  </table>
<table width="100%"cellspacing="0" cellpadding="0" border="2">
  <tr align="center" bgcolor="#1CBB9B" >
 	<td width="4%" height="20"><strong>No</strong></td>
    <td width="15%" height="20"><strong>Tanggal Registrasi</strong></td>
    <td width="15%" height="20"><strong>Nopol</strong></td>
    <td width="15%" height="20"><strong>Total Gabungan</strong></td>
    <td width="15%" height="20"><strong>Total Last</strong></td>

  </tr>
  </table>
  <table border="1px">
<?php 	$no=1;
		$total_gabungan_final = 0;
		$total_last_final = 0;
   foreach($detail as $item):
    
		$total_last = $item['total_last'] + $item['transaction_las_lain'];
		$total_gabungan = $item['total_gabungan'] + $item['transaction_gabungan_lain'];
				if($total_last == ''){
					 $last = 0 ;
					 }else{ 
					 $last = $total_last;
					 }
				
				if($total_gabungan == ''){
					 $gabungan = 0 ;
					 }else{ 
					 $gabungan = $total_gabungan;
					 }
   ?>
  <tr>
  	 	<td align="center"><?=$no;?></td>
         <td align="center"><?=format_new_date($item['registration_date'])?></td>
        <td align="center"><?=$item['car_nopol']?></td>
        <td><?=$gabungan?></td>
        <td><?=$last?></td>
 
</tr>
    <?php 
	$total_gabungan_final += $gabungan;
	$total_last_final += $last;
	$no++; 
	 endforeach; ?>
<tr>
		<td colspan="3"><strong>Total</strong></td>
        <td><?=$total_gabungan_final?></td>
        <td><?=$total_last_final?></td>
</tr>
</table>
<table width="100%" border="2px" cellspacing="0" cellpadding="4" style="font-size:14px;">
        <tr>
          <td colspan="3" bgcolor="#CCCCCC"><strong>Grand Total</strong></td>
          <td colspan="2" align="right" bgcolor="#CCCCCC"><strong>
            <?php
         echo $total_gabungan_final + $total_last_final;
		  ?>
            </strong></td>
          </tr>
        </table>

</body>
