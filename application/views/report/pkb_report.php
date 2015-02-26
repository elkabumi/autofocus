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
<td width="8%" valign="top">No PKB</td>
<td width="1%" valign="top">:</td>
<td width="27%" valign="top"><?=$pkb_no?></td>
<td width="10%" valign="top">Status Mobil</td>
<td width="1%" valign="top">:</td>
<td width="26%" valign="top"><? echo 'Masuk'?></td>
<td width="5%" valign="top">Area</td>
<td width="1%" valign="top">:</td>
<td width="21%" valign="top"><?=$stand_address?></td>
</tr>
</table>
</div>
<div class="pkb">
<div class="table_content">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="71" valign="top">NOPOL</td>
    <td width="10" valign="top" >:</td>
    <td width="108" valign="top"><?=$car_nopol?></td>
    <td width="52" valign="top">Asuransi</td>
    <td width="10" valign="top">:</td>
    <td width="105" valign="top"><?=$insurance_name ?></td>
    <td width="84" valign="top">Tgl Masuk</td>
    <td width="10" valign="top">:</td>
    <td width="528" valign="top"><?=$check_in?></td>
  </tr>
  <tr>
    <td valign="top">Tipe Kendaraan</td>
    <td valign="top">:</td>
    <td valign="top"><?=$car_model_name?></td>
    <td valign="top">No Chek list</td>
    <td valign="top">:</td>
    <td valign="top"><? ?></td>
    <td valign="top">Tgl Selesai</td>
    <td valign="top">:</td>
    <td valign="top"><?=$check_out?></td>
  </tr>
</table>
</div>
</div>
<div style="padding-top:50px" class="">
<div class=""><b>Sperpart</b></div>
<div class="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="border-bottom-style:solid">
   
    <td width="5%">No</td>
    <td width="15%">Qty</td>
    <td width="30%">Part No</td>
    <td width="45%">Nama Part</td>
	
  </tr>
  </table>
  </div>
  <div class="">
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
    
  </tr>
  <?php 
  $total_sperpart = $total_sperpart + $item['rs_repair'];
    $no++;
  endforeach; 

  ?>
  </table>
  </div>
<div style="padding-top:10px">
<div class=""><b>Jasa</b></div>
<div class="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   
    <td width="5%">No</td>
    <td width="15%">Nama jasa</td>
      </tr>
  </table>
  </div>
  <div class="">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  $no = 1;
   $total_transaction= 0;
  foreach($data_detail as $item): ?>
  <tr>
   
    <td width="5%"><?=$no?></td>
    <td width="15%"><?=$item['product_name']?></td>
    
  </tr>
  <?php 
  $total_transaction = $total_transaction + $item['detail_registration_price'];
    $no++;
  endforeach; 

  ?>
  </table>
  </div>
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

