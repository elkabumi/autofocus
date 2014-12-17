<style>
.asuransi{
	font-size:13px;
	font-weight:bold;
	font-family:"MS Serif", "New York", serif;
	padding:5px;
	padding-top:25px;
	}
.proses{
	bottom:300px; 
	position:fixed;
}
.pkb{
	
	border-bottom-style:dotted;
	}
</style>
<table width="100%">
<tr>
<td align="center"><span class="judul_title">Formulir Perintah Kerja Bengkel (PKB)</span></td>
</tr>
</table>

<div class="pkb">
<table width="100%" cellpadding="0" style="padding-top:50px;">
<tr>
<td width="8%">No PKB</td>
<td width="1%">:</td>
<td width="27%"><?=$pkb_no?></td>
<td width="10%">Status Mobil</td>
<td width="1%">:</td>
<td width="26%"><? echo 'Masuk'?></td>
<td width="5%">Area</td>
<td width="1%">:</td>
<td width="21%"><?=$stand_address?></td>
</tr>
</table>
</div>
<div class="pkb">
<div class="table_content">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="71">NOPOL</td>
    <td width="10" >:</td>
    <td width="108"><?=$car_nopol?></td>
    <td width="52">Asuransi</td>
    <td width="10">:</td>
    <td width="105"><?=$insurance_name ?></td>
    <td width="84">Tgl Masuk</td>
    <td width="10">:</td>
    <td width="528"><?=$check_in?></td>
  </tr>
  <tr>
    <td>Tipe Kendaraan</td>
    <td>:</td>
    <td><?=$car_model_name?></td>
    <td>No Chek list</td>
    <td>:</td>
    <td><? ?></td>
    <td>Tgl Selesai</td>
    <td>:</td>
    <td><?=$check_out?></td>
  </tr>
</table>
</div>
</div>
<div class="">
<h3>Jasa:</h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-weight:bold;">
  <tr>
   
    <td width="30%">No</b></td>
    <td width="60%">Deskripsi</td>
    <td width="25%">No</td>
    <td width="40%">Deskripsi</td>
    

  </tr>
  </table>
</div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  $no_jasa = 1;
  foreach($data_detail as $item):
  switch($no_jasa % 2 . $item['product_category_id']) {
	  	case '12':
  ?>
  <tr>
    <td width="30%"><?=$no_jasa?></td>
    <td width="60%"><?=$item['product_name']." (".$item['product_category_name'].")"?></td>
    <? 
		$no_jasa++;
		break;
		case '02':
	?>
    <td width="25%"><?=$no_jasa?></td>
    <td width="40%"><?=$item['product_name']." (".$item['product_category_name'].")"?></td>
  </tr>
  <?php 
  $no_jasa++;
		break;
  }
  endforeach;
  ?>
  </table>
 <div class="">
 <h3>Sperpart:</h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-weight:bold;">
  <tr>
   
    <td width="30%">No</b></td>
    <td width="60%">Deskripsi</td>
    <td width="25%">No</td>
    <td width="40%">Deskripsi</td>

  </tr>
  </table>
</div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php
  $no_sperpart = 1;
  foreach($data_detail as $item):
  switch($no_sperpart % 2 . $item['product_category_id']) {
  		case '11':
  ?>
  <tr>
    <td width="30%"><?=$no_sperpart?></td>
    <td width="60%"><?=$item['product_name']." (".$item['product_category_name'].")"?></td>
    <? 
		$no_sperpart++;
		break;
		case '01':
	?>
    <td width="25%"><?=$no_sperpart?></td>
    <td width="40%"><?=$item['product_name']." (".$item['product_category_name'].")"?></td>
  </tr>
  <?php 
  $no_sperpart++;
		break;
  }
  endforeach;
  ?>
  </table>
</div>

<div class="proses">
<hr style="margin-top:0px">
<table width="100%" border="1" cellspacing="-1">
  <tr>
    <td width="2%" rowspan="2" align="center">No</td>
    <td width="19%" rowspan="2" align="center">Proses</td>
    <td colspan="2" align="center">Tgl Plain</td>
    <td width="11%" rowspan="2" align="center">Tgl Actual</td>
    <td width="49%" rowspan="2" align="center">Keterangan</td>
  </tr>
  <tr>
    <td width="9%" align="center">Awal</td>
    <td width="10%" align="center">Akhir</td>
  </tr>
  <tr>
    <td>1</td>
    <td>Bongkar Komponen</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Las/Ketok</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>3</td>
    <td>Dempul</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>4</td>
    <td>Cat</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>5</td>
    <td>Poles</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>6</td>
    <td>Rakit</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="1" cellspacing="-1" style="margin-top:3px">
  <tr>
    <td colspan="2">Target selesai :</td>
    <td colspan="2">Target selesai :</td>
  </tr>
  <tr>
    <td colspan="2">Actual :</td>
    <td colspan="2">Actual :</td>
  </tr>
  <tr>
    <td width="38%">Keterangan :</td>
    <td width="12%" align="center">Ttd</td>
    <td width="38%">Keterangan :</td>
    <td width="12%" align="center">Ttd</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
</table>
<h5>Note: 1. PKB ini harus selalu bersama dengan SPK  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2. PKB ini harus selalu berada di kendaraan dan ditandatangani oleh masing2 pekerja yang mengerjakan</h5><br>
<h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3. Selalu perhatika target penyelesaian kendaraan  &nbsp; 4. Rangkap 3 (1 lbr Asli:CS,1 lbr Copy:Bengkel,1 lbr:Admin Gudang)</h5>
</div>

