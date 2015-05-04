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
<td align="center"><span class="judul_title"><?= $title ?></span></td>
</tr>
</table>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="asuransi">
<table width="40%" cellpadding="0">
<tr>
<td align="left"><?=$insurance_name?></td>
</tr>
<tr>
<td align="left"><?=$insurance_addres?></td>
</tr>
</table>
</div>

</td>
    <td align="right" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:25px">
      <tr>
        <td width="49%">No Kwitansi</td>
        <td width="3%">:</td>
        <td width="48%"><?=$registration_code?></td>
      </tr>
      <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td><?=$registration_date?></td>
      </tr>
    </table></td>
  </tr>
</table>


<div class="report_area">
<div class="table_content">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="19%">Nomor Polisi</td>
    <td width="1%">:</td>
    <td width="29%"><?=$car_nopol?></td>
    <td width="15%">&nbsp;</td>
    <td width="16%">Tanggal Kejadian</td>
    <td width="1%">:</td>
    <td width="19%"><?=($incident_date)?></td>
  </tr>
  <tr>
    <td>Tertanggung</td>
    <td>:</td>
    <td><?=$customer_name?></td>
    <td>&nbsp;</td>
    <td>Tipe Klaim</td>
    <td>:</td>
    <td><?=$claim_type_name?></td>
  </tr>
  <tr>
    <td>Model Kendaraan</td>
    <td>:</td>
    <td><?=$car_model_merk." - ".$car_model_name?>
    
    </td>
    <td>&nbsp;</td>
    <td>No. Polis</td>
    <td>:</td>
    <td><?=$claim_no?></td>
  </tr>
  <tr>
    <td>Check-in Date</td>
    <td>:</td>
    <td><?=($check_in)?></td>
    <td>&nbsp;</td>
    <td>Check-out Date</td>
    <td>:</td>
    <td><?=($check_out)?></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>
</div>
<div class="title_report1"><b>Kerusakaan</b></div>
  <div class="table_content"><b>Panel</b></div>
<div class="table_title">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   
    <td width="10%">No</td>
    <td width="50%">Jenis Perbaikan</td>
    <td width="20%" align="right"></td>
    <td width="20%" align="right"></td>
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
   
    <td width="10%"><?=$no?></td>
    <td width="50%"><?=$item['product_name']?></td>
    <td width="20%" align="right"></td>
    <td width="20%" align="right"></td>
  </tr>
  <?php 
  $total_transaction = $total_transaction + $item['detail_registration_approved_price'];
    $no++;
  endforeach; 

  ?>
  </table>
  </div>



<div class="title_report1" style="margin-top:17px;"><b>Biaya Pengerjaan</b></div>

<div class="table_content"><b>Data Progres Pengerjaan</b></div>
<? 
$employee_group_name = '';
$employee_group_name2 = '';
$gabungan_lain = '';
$last_lain = '';
foreach($data_jasa as $item):
	$employee_group_name = $item['employee_group_name'];
	$employee_group_name2 = $item['team_last'];
	$gabungan_lain = $item['transaction_gabungan_lain'];
	$last_lain = $item['transaction_las_lain'];
	endforeach;
 ?>
<div class="table_content"><b>Team Gabungan : <?=$employee_group_name?></b></div>
<div class="table_title">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   
    <td width="5%">No</td>
    <td width="15%">Tanggal</td>
    <td width="40%">Jenis Perbaikan</td>
    <td width="10%"></td>
    <td width="10%"></td>
    <td width="20%" align="right">Harga Borongan</td>
  </tr>
  </table>
  </div>
  <div class="table_content">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  $no = 1;
  $gabungan = 0;
  $total_gabungan= 0;
  foreach($data_jasa as $item): ?>
  <tr>
   <? if($item['workshop_service_type'] == 1){ ?>
    <td width="5%"><?=$no?></td>
    <td width="15%"><?=$item['transaction_detail_date']?></td>
    <td width="40%"><?=$item['workshop_service_name']?></td>
    <td width="10%"></td>
    <td width="10%"></td>
    <td width="20%" align="right"><?=number_format($item['workshop_service_job_price'], 0)?></td>
  </tr>
  <?php 
   
  $gabungan += $item['workshop_service_job_price'];
    $no++;
	}
  endforeach; 

  ?>
  </table>
  </div>
  <div class="table_footer">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Gabungan Lain-Lain(Rp)</strong></td>
    <td width="33%" align="right"><?=number_format($gabungan_lain, 0)?></td>
  </tr>
   <tr>
   <?
   $total_gabungan = $gabungan + $gabungan_lain;
   ?>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Total Harga Borongan(Rp)</strong></td>
    <td width="33%" align="right"><?=number_format($total_gabungan, 0)?></td>
  </tr>
  </table>
  </div>
  <div class="table_content"><b>Team Last : <?=$employee_group_name2?></b></div>
<div class="table_title">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   
    <td width="5%">No</td>
    <td width="15%">Tanggal</td>
    <td width="40%">Jenis Perbaikan</td>
    <td width="10%"></td>
    <td width="10%"></td>
    <td width="20%" align="right">Harga Borongan</td>
  </tr>
  </table>
  </div>
  <div class="table_content">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  $no = 1;
   $last= 0;
   $total_last = 0;
  foreach($data_jasa as $item): ?>
  <tr>
   <? if($item['workshop_service_type'] == 2){ ?>
    <td width="5%"><?=$no?></td>
    <td width="15%"><?=$item['transaction_detail_date']?></td>
    <td width="40%"><?=$item['workshop_service_name']?></td>
    <td width="10%"></td>
    <td width="10%"></td>
    <td width="20%" align="right"><?=number_format($item['workshop_service_job_price'], 0)?></td>
  </tr>
  <?php 
   
  $last += $item['workshop_service_job_price'];
    $no++;
	}
  endforeach; 

  ?>
  </table>
  </div>

   <div class="table_footer">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Last Lain-Lain(Rp)</strong></td>
    <td width="33%" align="right"><?=number_format($last_lain, 0)?></td>
  </tr>
   <tr>
   <?
   $total_last = $last + $last_lain;
   ?>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Total Harga Last(Rp)</strong></td>
    <td width="33%" align="right"><?=number_format($total_last, 0)?></td>
  </tr>
  </table>
  </div>
  <br />
  <br />
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="54%" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="70%">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td bgcolor="#FFFFFF"><table style="margin-bottom:0px; bottom:0px;">
          <tr>
            <td><div class="signature">Authorized Signatory / Stamp</div></td>
            </tr>
        </table></td>
        </tr>
    </table></td>
    <td width="46%" align="right">
      <table width="100%" border="0" cellspacing="0" cellpadding="4" style="font-size:16px;">
        <tr>
          <td bgcolor="#CCCCCC"><strong>Grand Total</strong></td>
          <td align="right" bgcolor="#CCCCCC"><strong>
            <?php
         echo $total_gabungan + $total_last;
		  ?>
            </strong></td>
          </tr>
        </table>
     </td>
  </tr>
  </table>

  
</div>  <table>
  <tr>
  <td width="100%" align="left"><?php // "(".Terbilang($grand_total).".Rupiah)" ?></td>
  </tr>
  </table>
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
