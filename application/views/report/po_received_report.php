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
</style>
<table width="100%">
<tr>
<td align="center"><span class="judul_title">Laporan Detail Per Mobil</span></td>
</tr>
</table>

<div class="asuransi">
<table width="40%" cellpadding="0">
<tr>
<td align="left"><?=$insurance_name?></td>
</tr>
<tr>
<td align="left"><?=$insurance_addres?></td>
</tr>

</table>
</div>
<div class="report_area">
<div class="table_content">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Nomor Polisi</td>
    <td>:</td>
    <td><?=$car_nopol?></td>
  </tr>
  <tr>
    <td>Tertanggung</td>
    <td>:</td>
    <td><?=$customer_name?></td>
  </tr>
  <tr>
    <td>Model Kendaraan</td>
    <td>:</td>
    <td><?=$car_model_merk." - ".$car_model_name?>
    
    </td>
  </tr>
  <tr>
    <td>Check-in Date</td>
    <td>:</td>
    <td><?=($check_in)?></td>
  </tr>
    <tr>
    <td>Check-out Date</td>
    <td>:</td>
    <td><?=($check_out)?></td>
  </tr>
</table>
</div>
<div class="table_content"><b>Sperpart</b></div>
<div class="table_title">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   
    <td width="5%">No</td>
    <td width="15%">Qty</td>
    <td width="30%">Part No</td>
    <td width="45%">Nama Part</td>
	<td width="60%" align="right">Jumlah</td>
  </tr>
  </table>
  </div>
  <div class="table_content">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  $no = 1;
   $total_sperpart= 0;
  foreach($data_sperpart as $item): ?>
  <tr>
   
    <td width="5%"><?=$no?></td>
    <td width="15%"><?=$item['rs_qty']?></td>
    <td width="30%"><?=$item['rs_part_number']?></td>
    <td width="45%"><?=$item['rs_name']?></td>
    <td width="60%" align="right"><?=number_format($item['rs_repair'], 0)?></td>
  </tr>
  <?php 
  $total_sperpart = $total_sperpart + $item['rs_repair'];
    $no++;
  endforeach; 

  ?>
  </table>
  </div>
 
<div class="table_footer">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Total Parts (Rp)</strong></td>
    <td width="33%" align="right"><?=number_format($total_sperpart, 0)?></td>
  </tr>
  </table>
</div>
  <div class="table_content"><b>Panel</b></div>
<div class="table_title">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   
    <td width="5%">No</td>
    <td width="15%">Jenis Perbaikan</td>
    <td width="40%" align="right">Jumlah</td>
  </tr>
  </table>
  </div>
  <div class="table_content">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  $no = 1;
   $total_transaction= 0;
  foreach($data_detail as $item): ?>
  <tr>
   
    <td width="5%"><?=$no?></td>
    <td width="15%"><?=$item['product_name']?></td>
    <td width="40%" align="right"><?=number_format($item['detail_registration_price'], 0)?></td>
  </tr>
  <?php 
  $total_transaction = $total_transaction + $item['detail_registration_price'];
    $no++;
  endforeach; 

  ?>
  </table>
  </div>
  <div class="table_footer">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Total Panel(Rp)</strong></td>
    <td width="33%" align="right"><?=number_format($total_transaction, 0)?></td>
  </tr>
  </table>
  </div>
<div class="table_content"><b>Data Progres Pengerjaan</b></div>
<div class="table_title">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   
    <td width="5%">No</td>
    <td width="15%">Tanggal</td>
    <td width="15%">Jenis Perbaikan</td>
    <td width="15%">Harga</td>
    <td width="15%">Progress(%)</td>
    <td width="40%" align="right">Harga Borongan</td>
  </tr>
  </table>
  </div>
  <div class="table_content">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  $no = 1;
   $total_jasa= 0;
  foreach($data_jasa as $item): ?>
  <tr>
   
    <td width="5%"><?=$no?></td>
    <td width="15%"><?=$item['transaction_detail_date']?></td>
    <td width="15%"><?=$item['workshop_service_name']?></td>
    <td width="15%"><?=$item['workshop_service_price']?></td>
    <td width="15%"><?=$item['transaction_detail_progress']?></td>
    <td width="40%" align="right"><?=number_format($item['workshop_service_job_price'], 0)?></td>
  </tr>
  <?php 
  $total_jasa = $total_jasa + $item['workshop_service_job_price'];
    $no++;
  endforeach; 

  ?>
  </table>
  </div>
   <div class="table_footer">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Total Harga Borongan(Rp)</strong></td>
    <td width="33%" align="right"><?=number_format($total_jasa, 0)?></td>
  </tr>
  </table>
  </div>
  <div class="table_content"><b>Data Cat</b></div>
<div class="table_title">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   
    <td width="5%">No</td>
    <td width="15%">Nama Bahan/Cat</td>
    <td width="30%">Qty</td>
    <td width="45%">Keterangan</td>
	<td width="60%" align="right">Harga</td>
  </tr>
  </table>
  </div>
  <div class="table_content">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  $no = 1;
   $total_cat= 0;
  foreach($data_cat as $item): ?>
  <tr>
   
    <td width="5%"><?=$no?></td>
    <td width="15%"><?=$item['tm_name']?></td>
    <td width="30%"><?=$item['tm_qty']?></td>
    <td width="45%"><?=$item['tm_description']?></td>
    <td width="60%" align="right"><?=number_format($item['tm_price'], 0)?></td>
  </tr>
  <?php 
  $total_cat = $total_cat + $item['tm_price'];
    $no++;
  endforeach; 

  ?>
  </table>
  </div>
 
<div class="table_footer">
<?
$grand_total = $total_cat + $total_jasa + $total_transaction + $total_sperpart;

?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Total Parts (Rp)</strong></td>
    <td width="33%" align="right"><?=number_format($total_cat, 0)?></td>
  </tr>
   <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Grand Total(Rp)</strong></td>
    <td style="border-top:1px solid #999" width="33%" align="right"><?=number_format($grand_total, 0)?></td>
  </tr>
  </table>
</div>
  <table>
  <tr>
  <td width="100%" align="left"><?= "(".Terbilang($grand_total).".Rupiah)" ?></td>
  </tr>
  <div class="tanda_tangan">
  <table width="100%">
  <tr>
  <td>Authorized Signatory / Stamp</td>
  </tr>
  </table>
</div>
</div>

<?php
function Terbilang($x){
$x = floor($x);
$bil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
if($x<1&& $x>0){
$que = "nol";
}elseif ($x < 12){
$que = " " . $bil[$x];
}elseif ($x < 20){
$que = Terbilang($x - 10) . " belas";
}elseif ($x < 100){
$que = Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
}elseif ($x < 200){
$que = " seratus" . Terbilang($x - 100);
}elseif ($x < 1000){
$que = Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
}elseif ($x < 2000){
$que = " seribu" . Terbilang($x - 1000);
}elseif ($x < 1000000){
$que = Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
}elseif ($x < 1000000000){
$que = Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
}elseif($x < 1000000000000){
$b = floor($x/1000000000);
$c = $x-($b*1000000000);
$que = Terbilang($x / 1000000000)." milyar ".Terbilang($c);
}elseif($x<1000000000000000){
$b = floor($x/1000000000000);
$c = $x-($b*1000000000000);
$que = Terbilang($x / 1000000000000)." Trilyun".Terbilang($c);
}
return $que;
}
function Desimal($x){
$bil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
$real = floor($x);
$decimal = $x - $real;
$dec = explode(".",$decimal);
$u = $dec[1];
if($u<12){
$in = $bil[$dec[1]];
}elseif($u<100){
$o1 = floor($u/10);
$o2 = $u%10;
$in = $bil[$o1]." ".$bil[$o2];
}else{
$o1 = substr($u,0,1);
$o2 = substr($u,1,1);
$in = $bil[$o1]." ".$bil[$o2+1];
}
return $in;
}


  ?>