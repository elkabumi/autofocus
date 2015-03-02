<style>

body{
	font-size:11px;
	font-family:Arial, Helvetica, sans-serif;
	
}

.judul_title_2{
	font-size:18px;
	font-weight:bold;
	color:#000;
	margin-top:5px;
	margin-bottom:5px;
	

}

.tr_title{
	height:30px;
	padding-top:10px;
	width:100%;
}
.table_title{
	border-top:1px solid #999;
	border-bottom:1px solid #999;
	width:96%;
	margin:auto;
}
.table_footer{
	border-top:1px solid #999;;
	width:96%;
	margin:auto;
}
.report_area{
	border-top:2px solid #999;
	border-bottom:2px solid #999;
	border-left:2px solid #999;
	border-right:2px solid #999;

}
.table_content{
	padding:5px;
	width:96%;
	margin:auto;
	font-size:12px;

}
.title_report1{
	margin-top:10px;
	margin-bottom:10px;
	text-align:center;
	font-size:13px;
	text-transform: uppercase;


.terbilang{
	text-transform:uppercase;
	font-weight:bold;
}
.block{
	background-color:#D7D7D7;
	height:20px;
	color:#000;
	padding:3px;
}
</style>

<div class="report_area">
<div class="table_content">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php
  if($claim_type == '1'){
  	$jumlah = $own_retention;
  }else if($claim_type == '0'){
  	$jumlah = $registration_dp;
  }
  ?>
  		<td colspan="3">
       	<div class="judul_title_2"><b>KWITANSI</b></div>
		</td>
  </tr>
  <tr>
        <td width="20%" height="15">Terima dari</td>
        <td width="1%">:</td>
        <td width="79%" align="left"><b><?=$customer_name?></b></td>

  </tr>
  <tr>
        <td height="15">Uang sebanyak</td>
        <td>:</td>
        <td><div class="block"><b><?= "(".Terbilang($jumlah).".Rupiah)" ?></b></div></td>
  </tr>

  <tr>
    <td height="15">Untuk Pembayaran</td>
    <td>:</td>
	<td>&nbsp;</td>
  </tr>
</table>

<table width="100%" border="1" cellspacing="-1" cellpadding="0">
	<tr>
    	<td height="60">&nbsp;</td>
    </tr>
</table>
<br>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
    	<td width="50%" height="15"><div class="block"><b><?= number_format($jumlah); ?></b></div></td>
        <td width="20%">&nbsp;</td>
        <td width="40%" align="right">SURABAYA, ....................................  .......</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td align="right">Penerima,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    	<td align="right">Yang Menyerahkan</td>
    </tr>
     <tr>
    	<td height="40" valign="bottom"><span style="font-size:9px;">Lembar ke 1: Customer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lembar ke 2 : File</span></td>
    	<td align="right" valign="bottom">.......................................</td>
    	<td align="right" valign="bottom">..............................................</td>
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
}elseif($x < 1000000000000000){
$b = floor($x/ 1000000000000);
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

