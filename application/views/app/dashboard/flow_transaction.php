<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
<table width="100%" cellpadding="4" >
     <tr>
    
		<td >PENDAPATAN UTAMA
	</td>
		<td ><input name="i_subject_value" type="text" class="required" id="i_subject_value" value="<?= number_format($pendapatan_utama, 2)?>" readonly="readonly" style="text-align:right;"  /></td>
      
	 </tr>
    <?php
   $detail_total = 0;
	foreach($list_flow_transaction as $item): 
	
	?>
	<tr>
    
		<td ><?= $item['coa_name']?>
	</td>
		<td >
        <?php
		
		$list_value = $this->dashboard_model->get_detail($active_period_id, $item['coa_id']);
		  foreach($list_value as $item_list): 
		 ?>
         
		
        <input name="i_subject_value2" type="text" class="required" id="i_subject_value2" value="<?= number_format($item_list['total'], 2)?>" readonly="readonly" style="text-align:right;" />
        <?php
		endforeach;  
		
		?>
      
        </td>
        
	</tr>
	
	 <?php
	
		$detail_total += $item_list['total'];
      	
	endforeach;
	?>
 <tr>
	  <td ><strong>TOTAL</strong></td>
	  <td ><input name="i_subject_value3" type="text" class="required" id="i_subject_value3" value="<?php $total = $pendapatan_utama + $detail_total;
	  echo number_format($total, 2);
	  ?>" readonly="readonly" style="text-align:right; font-weight:bold;" /></td>
	  </tr>
  </table>
</div>
  <div id="panel" class="command_table">
	 <input type="button" value="Detail" onclick="location.href='<?=site_url('flow_transaction/form/'.$active_period_id)?>'" />
	<input type="button" id="refresh" value="Print"/>
</div>
</div>
</form>