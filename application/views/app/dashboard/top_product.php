
<form id="id_form_nya">

  <table width="100%" border="0" cellspacing="0" cellpadding="4" class="new_table">
    <tr class="title">
    <td align="center">No </td>
      <td align="center">Kode </td>
      <td align="left">Nama </td>
      <td align="left">Tipe </td>
    
      <td align="left">Total</td>
    </tr>
    <?php 
	$no = 1;
	foreach($list_top_product as $item): ?>
             <tr <?php if($no == 1){ ?> class="tr_no1" <?php }elseif($no%2 == 0){ echo 'class="tr_1"'; }else{ echo 'class="tr_2"'; }?>>
             <td align="center"><?php
			 if($no == 1){
			 	?>
                <div class="no1">1<span style="font-size:small">st</span></div>
                <?php
			 }else{ 
			  echo $no; 
			 }?></td>
      <td align="center"><?= $item['product_code']?></td>
      <td><?= $item['product_name']?></td>
      <td><?= $item['product_type_name']?></td>
      
      <td><?= $item['qty'] ?></td>
    </tr>
			<?php 
			$no++;
			endforeach; ?>
  
  </table>
  <div id="panel" class="command_table">
	
	<input type="button" id="refresh" value="Print"/>
</div>


</form>

   <script type="text/javascript">
            $(function() {
                "use strict";
  			//BAR CHART
                var bar = new Morris.Bar({
                    element: 'bar-chart',
                    resize: true,
                   data: [
                        {y: '2011 Q1', item1: 2666, item2: 2666},
                        {y: '2011 Q2', item1: 2778, item2: 2294},
                        {y: '2011 Q3', item1: 4912, item2: 1969},
                        {y: '2011 Q4', item1: 3767, item2: 3597},
                        {y: '2012 Q1', item1: 6810, item2: 1914},
                        {y: '2012 Q2', item1: 5670, item2: 4293},
                        {y: '2012 Q3', item1: 4820, item2: 3795},
                        {y: '2012 Q4', item1: 6000, item2: 5967},
                        {y: '2013 Q1', item1: 10687, item2: 4460},
                        {y: '2013 Q2', item1: 8432, item2: 5713}
                    ],
                    xkey: 'y',
                    ykeys: ['item1'],
                    labels: ['Item 1'],
                    lineColors: ['#a0d0e0', '#3c8dbc'],
                    hideHover: 'auto'
                });
            });
        </script>