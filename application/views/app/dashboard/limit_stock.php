
<form id="id_form_nya">

  <table width="100%" border="0" cellspacing="0" cellpadding="4" class="new_table">
    <tr class="title">
    <td>Cabang</td>
    <td >Kode </td>
      <td >Nama</td>
      <td align="left">Kategori</td>
    
      <td align="left">Tipe</td>
      <td>Stok</td>
    </tr>
    <?php 
	$no = 1;
	foreach($list_limit_stock as $item): ?>
             <tr <?php if($no%2 == 0){ echo 'class="tr_1"'; }else{ echo 'class="tr_2"'; }?>>
             <td><?= $item['stand_name'] ?></td>
      <td><?= $item['product_code']?></td>
      <td><?= $item['product_name']?></td>
     
      <td><?= $item['product_category_name']?></td>
       <td><?= $item['product_type_name']?></td>
        <td><?= $item['product_stock_qty']?></td>
    </tr>
			<?php 
			$no++;
			endforeach; ?>
  
  </table>

 <div id="panel" class="command_table">
	 <input type="button" value="Detail" onclick="location.href='<?=site_url('limit_stock')?>'" />
	<input type="button" id="refresh" value="Print"/>
</div>
</form>