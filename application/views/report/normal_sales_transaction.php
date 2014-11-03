	<div class="report_area">
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="36%"> Nomor </td>
    <td width="3%">:</td>
    <td width="61%"><?=$transaction_code?></td>
  </tr>
  <tr>
    <td>Tipe </td>
    <td>:</td>
    <td><?=$transaction_type_name?></td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>:</td>
    <td><?=date('d/m/Y', $transaction_date)?>&nbsp;
    <?=date('H:m:s', $transaction_datetime)?>
    </td>
  </tr>
  <tr>
    <td>Pelanggan</td>
    <td>:</td>
    <td><?=$customer_name?></td>
  </tr>
    <tr>
    <td>Pembayaran</td>
    <td>:</td>
    <td><?=$transaction_payment_method_name?></td>
  </tr>
</table>
<div class="table_title">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   
    <td width="32%">Nama </td>
    <td width="25%" align="right">Harga</td>
    <td width="16%" align="right">Qty</td>
    <td width="27%" align="right">Jumlah</td>
  </tr>
  </table>
  </div>
  <div class="table_content">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php foreach($data_detail as $item): ?>
  <tr>
   
    <td width="31%"><?=$item['product_name']?></td>
    <td width="26%" align="right"><?=number_format($item['transaction_detail_price'], 0)?></td>
    <td width="16%" align="right"><?=$item['transaction_detail_qty']?></td>
    <td width="27%" align="right"><?=number_format($item['transaction_detail_total_price'], 0)?></td>
  </tr>
  <?php endforeach; ?>
  </table>
  </div>
<div class="table_footer">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>TOTAL</strong></td>
    <td width="33%" align="right"><?=number_format($transaction_total_price, 0)?></td>
  </tr>
  <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Biaya Kirim</strong></td>
    <td width="33%" align="right"><?=number_format($transaction_sent_price, 0)?></td>
  </tr>
  <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>PPN</strong></td>
    <td width="33%" align="right"><?=number_format($transaction_ppn_value, 0)?></td>
  </tr>
  <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Total Seluruhnya</strong></td>
    <td width="33%" align="right"><?=number_format($transaction_final_total_price, 0)?></td>
  </tr>
  <?php
  if($transaction_payment_method_id == 2){ ?>
   <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Uang Muka</strong></td>
    <td width="33%" align="right"><?=number_format($transaction_down_payment, 0)?></td>
  </tr>
   <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Sisa Pembayaran</strong></td>
    <td width="33%" align="right"><?=number_format($transaction_sisa, 0)?></td>
  </tr>
  <?php
  }
  ?>
   <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Dibayar</strong></td>
    <td width="33%" align="right"><?=number_format($transaction_payed, 0)?></td>
  </tr>
   <tr>
    <td width="15%"></td>
    <td width="52%" align="right"><strong>Kembali</strong></td>
    <td width="33%" align="right"><?=number_format($transaction_change, 0)?></td>
  </tr>
</table>

</div>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="10" align="center">Terima kasih atas kunjungan Anda</td>
    </tr>
  </table>
  <hr />
</div>