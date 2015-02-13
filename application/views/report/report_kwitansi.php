<style>
.asuransi{
	font-size:13px;
	font-weight:bold;
	font-family:"MS Serif", "New York", serif;
	padding:5px;
	padding-top:25px;
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
<div class="table_title">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
   
    <td width="5%"><strong>No</strong></td>
    <td width="15%"><strong>Deskripsi</strong></td>
    <td width="30%" align="right"><strong>Jumlah</strong></td>
    </tr>
  </table>
</div>
  <div class="table_content">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
 
  <tr>
   
    <td width="22%">1</td>
    <td width="54%">Parts</td>
    <td width="24%" align="right">Rp</td>
    <td width="24%" align="right"><?= number_format($approved_sparepart_total_registration) ?></td>
    </tr>
  <tr>
    <td>2</td>
    <td>Labour (Materials &amp; Jasa)</td>
    <td align="right">Rp</td>
    <td align="right"><?= number_format($approved_total_registration) ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><hr class="hr_total"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">Rp</td>
    <td align="right">
    <?php
    $total = $approved_sparepart_total_registration + $approved_total_registration;
	echo number_format($total);
	?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Less Own Retention</td>
    <td align="right">Rp</td>
    <td align="right"><?= number_format($own_retention) ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Less PPH <?= $insurance_pph ?>% (on labour)</td>
    <td align="right">Rp</td>
    <td align="right">
    <?php
    $insurance_pph_value = $insurance_pph / 100 * $total;
	echo number_format($insurance_pph_value);
	?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><hr class="hr_total"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Total</td>
    <td align="right">Rp</td>
    <td align="right">
    <?php
    $total2 = $total - $own_retention - $insurance_pph_value;
	echo number_format($total2);
	?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><hr class="hr_total"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><em>Payable Amount (100.00%)</em></td>
    <td align="right">Rp</td>
    <td align="right"><?php
    $total2 = $total - $own_retention - $insurance_pph_value;
	echo number_format($total2);
	?></td>
  </tr>
  
  </table>
  </div>
 
 
<div class="table_footer">

<br />
</div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:10px;">
  <tr>
  <td width="100%" align="left"><div class="terbilang"><?php echo "(".Terbilang($total2)."Rupiah)" ?></div></td>
  </tr>
  </table>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:10px;">
  <tr>
  <td colspan="3" align="left"><em>Please bank-in payment to our bank account :</em></td>
  </tr>
  <tr>
    <td width="20%" align="left">Bank</td>
    <td width="1%" align="left">:</td>
    <td width="79%" align="left"><strong>PT Bank Panin</strong></td>
  </tr>
  <tr>
    <td align="left">Account No</td>
    <td align="left">:</td>
    <td align="left"><strong>4192015769</strong></td>
  </tr>
  <tr>
    <td align="left">Account Name</td>
    <td align="left">:</td>
    <td align="left"><strong>DIDIK PRIYANTO</strong></td>
  </tr>
  </table>
  
  <div class="tanda_tangan">
  <table>
  <tr>
  <td><div class="signature">Authorized Signatory / Stamp</div></td>
  </tr>
  </table>
  
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