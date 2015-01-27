<style>
.asuransi{
	font-size:13px;
	font-weight:bold;
	font-family:"MS Serif", "New York", serif;
	padding:5px;
	padding-top:25px;
	}
.tanda_tangan{
	font-weight:bold;
	font-family:"MS Serif", "New York", serif;
	padding-top:100px;
}
.text1{
	font-size:50px;
}
</style>
<table width="100%">
<tr>
<td align="center"><span class="judul_title">Laporan Detail Per Mobil</span></td>
</tr>
</table>
<br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
<tr>
    <td width="32%" height="15"><strong>Periode</strong></td>
    <td width="2%"><strong>:</strong></td>
    <td width="66%"><?=$period_name?></td>
</tr>
<tr>
    <td height="15"><strong>Cabang</strong></td>
    <td><strong>:</strong></td>
    <td><?=$stand_name?></td>
</tr>
<tr>
    <td height="15"> <strong>Kode Transaksi </strong></td>
    <td><strong>:</strong></td>
    <td><?=$registration_code?></td>
</tr>
<tr>
    <td height="15" > <strong>Data Pelanggan </strong></td>
    <td><strong>:</strong></td>
    <td><?=$customer_name?></td>
</tr>
<tr>
    <td height="15"  > <strong>Data Mobil </strong></td>
    <td><strong>:</strong></td>
    <td><?=$car_nopol?></td>
</tr>
<tr>
    <td height="15" > <strong>Klaim</strong></td>
    <td ><strong>:</strong></td>
    <td>
	<?php
    if($claim_type == '0'){
		$claim_type = 'Pribadi';
    }else{
		$claim_type = 'Asuransi';
    }
	echo $claim_type;
	?>
	</td>
    
</tr>

<tr>
    <td height="15" > <strong>Asuransi</strong></td>
    <td><strong>:</strong></td>
    <td><?=$insurance_name?></td>
</tr>
<tr>
    <td height="15"><strong>No Klaim</strong></td>
    <td><strong>:</strong></td>
    <td><?=$claim_no?></td>
</tr>
<tr>
    <td height="15"> <strong>Tanggal Masuk</strong></td>
    <td><strong>:</strong></td>
    <td><?=format_new_date($check_in)?></td>
</tr>
<tr>
    <td height="15"> <strong>Tanggal Estimasi Keluar </strong></td>
    <td><strong>:</strong></td>
    <td><?=format_new_date($check_out)?></td>
</tr>
<tr>
    <td rowspan="3" valign="top" height="15"> <strong>Keterangan </strong></td>
    <td rowspan="3" valign="top"><strong>:</strong></td>
    <td rowspan="3" valign="top" ><?=$registration_description?></td>
</tr>
</table>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
<tr>
    <td width="32%" height="15"><strong>Tim Kerja</strong></td>
    <td width="2%"><strong>:</strong></td>
    <td width="66%"><?=$employee_group_name?></td>
</tr>
<tr>
    <td height="15"><strong>Tanggal awal plain</strong></td>
    <td><strong>:</strong></td>
    <td><?=format_new_date($transaction_plain_first_date);?></td>
</tr>
<tr>
    <td height="15"><strong>Tanggal akhir plain</strong></td>
    <td><strong>:</strong></td>
    <td><?=format_new_date($transaction_plain_last_date)?></td>
</tr>
<tr>
    <td height="15"><strong>Tanggal Aktual</strong></td>
    <td><strong>:</strong></td>
    <td><?=format_new_date($transaction_actual_date)?></td>
</tr>
<tr>
    <td height="15"><strong>Tanggal target selesai</strong></td>
    <td><strong>:</strong></td>
    <td><?=format_new_date($transaction_target_date)?></td>
</tr>
<tr>
    <td height="15"><strong>Keterangan bongkar komponen %</strong></td>
    <td><strong>:</strong></td>
    <td><?=$transaction_komponen?></td>
</tr>
<tr>
    <td height="15"> <strong>Keterangan las/ketok %</strong></td>
    <td><strong>:</strong></td>
    <td><?=$transaction_lasketok?></td>
</tr>
<tr>
    <td height="15" ><strong>Keterangan dempul %</strong></td>
    <td><strong>:</strong></td>
    <td><?=$transaction_dempul?></td>
</tr>
<tr>
    <td height="15"><strong>Keterangan cat %</strong></td>
    <td><strong>:</strong></td>
    <td><?=$transaction_cat?></td>
</tr>
<tr>
    <td width="32%" height="15"><strong>Keterangan poles %</strong></td>
    <td width="2%">:</td>
    <td width="66%"><?=$transaction_poles?><</td>
</tr>
<tr>
 <td width="32%" height="15"><strong>Keterangan rakit %</strong></td>
    <td width="2%"><strong>:</strong></td>
    <td width="66%"><?=$transaction_rakit?><-</td>
</tr>
<br /><br /><br />
</table>
 <table  width="100%" border="1"  cellspacing="-1"  cellpadding="5">   
<tr bgcolor="#dddddd">
			<td><strong>No.</strong></td>
            <td><strong>Jenis Perbaikan</strong></td>
            <td><strong>Bongkar Komponen</strong></td>
			<td><strong>Las/Ketok</strong></td>
			<td><strong>Dempul</strong></td>
            <td><strong>Cat</strong></td>
			<td><strong>Poles</strong></td>
            <td><strong>Rakit</strong></td>
            <td><strong>Tanggal Action</strong></td>
            <td><strong>Keterangan</strong></td>
            <td><strong>Jumlah</strong>
    </td>
</tr>
<?php 
  $no = 1;
  $total= 0;
  foreach($data_detail as $item): 
?>
<tr>
			<td><?=$no?>.</td>
            <td><?=$item['product_name']?></td>
            <td align="center"><?php
            	if($item['transaction_detail_bongkar_komponen'] == '0'){
					$item['transaction_detail_bongkar_komponen'] = 'On progress';
				}else{
					$item['transaction_detail_bongkar_komponen'] = 'Done';
				}
				echo ''.$item['transaction_detail_bongkar_komponen'].'';
				?>
                
               </td> 
			<td align="center">
            <?php
            	if($item['transaction_detail_lasketok'] == '0'){
					$item['transaction_detail_lasketok'] = 'On progress';
				}else{
					$item['transaction_detail_lasketok'] = 'Done';
				}
				echo ''.$item['transaction_detail_lasketok'].'';
				?>
            </td>
			<td align="center">
			  <?php
            	if($item['transaction_detail_dempul'] == '0'){
					$item['transaction_detail_dempul'] = 'On progress';
				}else{
					$item['transaction_detail_dempul'] = 'Done';
				}
				echo ''.$item['transaction_detail_dempul'].'';
				?>
			
			</td>
            <td align="center">
			  <?php
            	if($item['transaction_detail_cat'] == '0'){
					$item['transaction_detail_cat'] = 'On progress';
				}else{
					$item['transaction_detail_cat'] = 'Done';
				}
				echo ''.$item['transaction_detail_cat'].'';
				?>
			
			</td>
             <td align="center">
			  <?php
            	if($item['transaction_detail_poles'] == '0'){
					$item['transaction_detail_poles'] = 'On progress';
				}else{
					$item['transaction_detail_poles'] = 'Done';
				}
				echo ''.$item['transaction_detail_poles'].'';
				?>
			
			</td>
             <td align="center">
			  <?php
            	if($item['transaction_detail_rakit'] == '0'){
					$item['transaction_detail_rakit'] = 'On progress';
				}else{
					$item['transaction_detail_rakit'] = 'Done';
				}
				echo ''.$item['transaction_detail_rakit'].'';
				?>
			
			</td>
<td><?=$item['transaction_detail_date']?></td>
            <td><?=$item['transaction_detail_description']?></td>
            <td><?=tool_money_format($item['transaction_detail_total']);?></td>
</tr>
  <?php 
  		$total = $total + $item['transaction_detail_total'];
     $no++;
	  endforeach; 
  ?>
  <tr>
  <td colspan="10" align="right"><h2>Total:</h2></td>
  <td><?=tool_money_format($total);?></td>
  </tr>
</table>

