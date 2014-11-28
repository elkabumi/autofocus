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
    <td><?=$car_model?></td>
    <td>Tipe Kendaraan</td>
    <td>:</td>
    <td><?=$car_type?></td>
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
<div class="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-weight:bold;">
  <tr>
   
    <td width="5%">No</b></td>
    <td width="15%">Deskripsi</td>
    <td width="16%" align="right">Kategori</td>

  </tr>
  </table>
  </div>
  <div class="">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  $no = 1;
  foreach($data_detail as $item): ?>
  <tr>
   
    <td width="5%"><?=$no?></td>
    <td width="15%"><?=$item['product_name']." (".$item['product_category_name'].")"?></td>
    <td width="16%" align="right"><?=$item['pst_name']?></td>
  
  </tr>
  <?php 
    $no++;
  endforeach; 

  ?>
  </table>
  </div>
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
