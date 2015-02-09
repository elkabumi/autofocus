
<? $format; ?>


<body>
<table>
  <tr>
  <th colspan="11"><?= $title ?></th>
  </tr>
  <tr>
  <th colspan="11"></th>
  </tr>
  
  </table>
	 <table border="1" cellpadding="4" cellspacing="0" class="table table-bordered table-striped" id="example1">
                                  
                                            <tr bgcolor="#dddddd">
                                             	<th>&nbsp;&nbsp;&nbsp; No &nbsp;&nbsp;&nbsp;</th>
                                                                                       
                                                    <th>Kode Transaksi</th>
                                                    <th>Tanggal</th>
                                                    <th>Nopol</th>
                                                    <th>Nama Customer</th>
                                                    <th>Asuransi</th>
                                                    <th>No Klaim</th>
                                                    <th>Total Estimasi Biaya</th>
                                                    <th>Total Biaya Pengerjaan</th>
                                                    <th>Laba</th>
                                                    <th>Status</th>
           
                                            </tr>
                                        
  
		<?php $no=1;
           foreach($detail as $item):
		  
      if($item['status_registration_id']==1 || $item['status_registration_id'] == 2){
        $total_biaya_estimasi = $item['approved_sparepart_total_registration'] + $item['approved_total_registration'];
        $total_biaya_pengerjaan = 0;
        $laba = 0;
      }else{
        $total_biaya_estimasi = $item['approved_sparepart_total_registration'] + $item['approved_total_registration'];
        $total_biaya_pengerjaan = $item['approved_sparepart_total_registration'] + $item['transaction_total'] + $item['transaction_material_total'];
        $laba = $total_biaya_estimasi - $total_biaya_pengerjaan;
      }

		   $registration_date = format_new_date($item['registration_date']);
		 
		 
		 ?>
        								  <tr>
          		
                                               <th><?=$no?></th>
                                               <th align="center"><?=$item['registration_code']?></th>
                                               <th><?=$registration_date?></th>
                                               <th><?=$item['car_nopol']?></th>
                                               <th><?=$item['customer_name']?></th>
                                               <th><?=$item['insurance_name']?></th>
                                               <th><?=$item['claim_no']?></th>
                                              
                                               <th><?=tool_money_format($total_biaya_estimasi)?></th>
                                               <th><?=tool_money_format($total_biaya_pengerjaan)?></th>
                                               <th><?=tool_money_format($laba)?></th>
                                           
         <?php
													  
			switch($item['status_registration_id']){
				case 1:
				?>
                 <th bgcolor="#e74c3c">Menunggu Persetujuan</th>
              <?php
			    break;
				case 2:
			  ?> 
             	 <th bgcolor="#f1c40f">Sudah disetujui</th>
              
				<?php
				break;
                case 3:
				$this->load->model('summary_report_model'); 
				?>
                 <th bgcolor="#27ae60">Proses Pengerjaan <?=$item['transaction_progress']?>% </th>
                
                <?php
			 	break;
				case 4: 
				?>
                 <th bgcolor="#3498db">Pengerjaan Selesai</th>
                <?php
				break;
				?>
                 <th>Pengerjaan Selesai</th>
                <?
				 break;
				}
											  ?>
                                              
                                             
                                               
                                            </tr>
          
          </tr>
            <?php $no++; 
             endforeach; ?>
             
        </table>

</body>
