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
.detail{
	border-bottom:1px solid #999;
	padding-top:5px;
	}
</style>
<table width="100%">
<tr>
<td align="center"><span class="judul_title">Surat Perintah Kerja</span></td>
</tr>
</table>

<div class="">
<table width="40%" cellpadding="0" style="padding-top:50px;">
<tr>
<td>No SPK</td>
<td><?=$spk_no?></td>
</tr>
<tr>
<td>No Klaim</td>
<td><?=$claim_no?></td>
</tr>
<tr>
<td>Cabang</td>
<td><?=$stand_name?></td>
</tr>
<tr>
<td>Alamat</td>
<td><?=$stand_address?></td>
</tr>
</table>
</div>
<p>Kami kirimkan kendaraan untuk dilakukan perbaikan dengan data-data sebagai berikut: </p>
<div class="">
<div class="table_content">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="108">Tertanggung/THJ pihak III</td>
    <td width="10" >:</td>
    <td width="168"><?=$customer_name?></td>
    <td width="95">Polis No.</td>
    <td width="10">:</td>
    <td width="587"><?=$car_nopol?></td>
  </tr>
  <tr>
    <td>Merk Kendaraan</td>
    <td>:</td>
    <td><?=$car_model_merk?></td>
    <td>Tipe Kendaraan</td>
    <td>:</td>
    <td><?=$car_model_name?></td>
  </tr>
  <tr>
    <td>No Polisi</td>
    <td>:</td>
    <td><?=$car_nopol?>
    <td>Tahun</td>
    <td>:</td>
    <td><?=$car_id?>
    </td>
  </tr>
  <tr>
    <td>No Rangka</td>
    <td>:</td>
    <td><?=$car_no_rangka?></td>
    <td>No Mesin</td>
    <td>:</td>
    <td><?=$car_no_machine?></td>
  </tr>
    <tr>
    <td>OR</td>
    <td>:</td>
    <td><?=$check_out?></td>
  </tr>
</table>
</div>
<p><b>Detail Kerugian</b></p>
<div style="padding-top:50px" class="">
<div class=""><b>Sperpart</b></div>
<div class="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="border-bottom-style:solid">
   
    <td width="5%">No</td>
    <td width="15%">Qty</td>
    <td width="30%">Part No</td>
    <td width="45%">Nama Part</td>
	<td width="60%" align="right">Jumlah</td>
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
    <td width="60%" align="right"><?=number_format($item['rs_repair'], 0)?></td>
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
    <td width="40%" align="right">Jumlah</td>
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
    <td width="40%" align="right"><?=number_format($item['detail_registration_price'], 0)?></td>
  </tr>
  <?php 
  $total_transaction = $total_transaction + $item['detail_registration_price'];
    $no++;
  endforeach; 

  ?>
  </table>
</div>
</div>
<table style="bottom:250px; position:fixed; margin-bottom:50px">
<tr>
<td>Atas kerjasamanya yang baik, kami ucapkan terima kasih</td>
</tr>
<tr>
<td><?="Surabaya," ?></td>
</tr>
<tr>
<td>Hormat kami,</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Menyetujui,</td>
<td>&nbsp;&nbsp;&nbsp;Inspector,</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;&nbsp;_____________</td>
  <td>_____________</td>
</tr>
<tr>
  <td style="font-size:8px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Nama Jelas)</td>
  <td style="font-size:8px">&nbsp;&nbsp;&nbsp;&nbsp;(Nama Jelas)</td>
</tr>
</table>
