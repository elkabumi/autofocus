
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%"> Nomor Transaksi</td>
    <td width="2%">:</td>
    <td width="78%"><?=$transaction_code?></td>
  </tr>
  <tr>
    <td>Tipe Transaksi</td>
    <td>:</td>
    <td><?=$transaction_type_name?></td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>:</td>
    <td><?=date('d/m/Y', $transaction_date)?></td>
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
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<div class="table_title">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="27%">Kode Produk</td>
    <td width="28%">Nama Produk</td>
    <td width="15%" align="right">Harga</td>
    <td width="10%" align="right">Qty</td>
    <td width="20%" align="right">Jumlah Harga</td>
  </tr>
  </table>
  </div>
 <table width="100%" border="0" cellspacing="0" cellpadding="4">
  <?php foreach($data_detail as $item): ?>
  <tr>
    <td  width="27%"><?=$item['product_code']?></td>
    <td width="28%"><?=$item['product_name']?></td>
    <td width="15%" align="right"><?=number_format($item['transaction_detail_price'], 2)?></td>
    <td width="10%" align="right"><?=$item['transaction_detail_qty']?></td>
    <td width="20%" align="right"><?=number_format($item['transaction_detail_total_price'], 2)?></td>
  </tr>
  <?php endforeach; ?>
  </table>
<div class="table_footer">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
   <tr>
    <td width="41%"></td>
    <td width="40%" align="right"><strong>TOTAL</strong></td>
    <td width="19%" align="right"><?=number_format($transaction_total_price, 2)?></td>
  </tr>
  <tr>
    <td width="41%"></td>
    <td width="40%" align="right"><strong>Biaya Kirim</strong></td>
    <td width="19%" align="right"><?=number_format($transaction_sent_price, 2)?></td>
  </tr>
  <tr>
    <td width="41%"></td>
    <td width="40%" align="right"><strong>PPN</strong></td>
    <td width="19%" align="right"><?=number_format($transaction_ppn_value, 2)?></td>
  </tr>
  <tr>
    <td width="41%"></td>
    <td width="40%" align="right"><strong>Total Seluruhnya</strong></td>
    <td width="19%" align="right"><?=number_format($transaction_final_total_price, 2)?></td>
  </tr>
  <?php
  if($transaction_payment_method_id == 2){ ?>
   <tr>
    <td width="41%"></td>
    <td width="40%" align="right"><strong>Uang Muka</strong></td>
    <td width="19%" align="right"><?=number_format($transaction_down_payment, 2)?></td>
  </tr>
   <tr>
    <td width="41%"></td>
    <td width="40%" align="right"><strong>Sisa Pembayaran</strong></td>
    <td width="19%" align="right"><?=number_format($transaction_sisa, 2)?></td>
  </tr>
  <?php
  }
  ?>
</table>
</div>
<hr />
