
<? $format; ?>


<body>
<table>
  <tr>
  <th colspan="8">&nbsp;</th>
  </tr>
  </table>
	 <table border="1" cellpadding="4" cellspacing="0" class="table table-bordered table-striped" id="example1">
                                  
                                            <tr bgcolor="#dddddd">
                                             	<th>&nbsp;&nbsp;&nbsp; No &nbsp;&nbsp;&nbsp;</th>
                                                <th>&nbsp;&nbsp;&nbsp; Code &nbsp;&nbsp;&nbsp;</th>
                                                <th>&nbsp;&nbsp;&nbsp; Nama &nbsp;&nbsp;&nbsp;</th>
                                                <th>&nbsp;&nbsp;&nbsp; Cabang &nbsp;&nbsp;&nbsp;</th>
                                               	<th>&nbsp;&nbsp;&nbsp; Jumlah &nbsp;&nbsp;&nbsp;</th>
                                              
                                            </tr>
                                        
  
		<?php $no=1;
           foreach($detail as $item): ?>
        								  <tr>
          		
                                               <th><?=$no?>.</th>
                                               <th align="center"><?=$item['product_code']?></th>
                                               <th><?=$item['product_name']?></th>
                                               	<th><?=$item['stand_name']?></th>
                                               <th align="right"><?=$item['product_stock_qty']?></th>
                                               
                                            </tr>
          
          </tr>
            <?php $no++; 
             endforeach; ?>
             
        </table>

</body>
