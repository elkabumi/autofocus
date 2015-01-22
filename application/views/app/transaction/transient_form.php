<script type="text/javascript">	
$(function(){
	createLookUp({
		table_id		: "#lookup_table_transaction_type",
		table_width		: 400,
		listSource 		: "lookup/transaction_type_table_control",
		dataSource		: "lookup/transaction_type_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_transaction_type",
		filter_by		: [{id : "p1", label : "Nama"}],
		onSelect		: load_employee
	});
	
	function load_employee(id){
	
		if(id == ""){
			return;
		}
		
		var data ='employee_id='+id; 
		
		$.ajax({
			type: 'POST',
			url: '<?=site_url('employee_group/load_employee')?>',
			data: data,
			dataType: 'json',
			success: function(data){					
				$('input[name="i_nip"]').val(data.content['employee_nip']);
				$('input[name="i_name"]').val(data.content['employee_name']);
				$('input[name="i_address"]').val(data.content['employee_address']);
				$('input[name="i_phone"]').val(data.content['employee_phone']);
			}
			
		});
		
	}
	
	$('input[name="c_bongkar_komponen"]').change(function(){
		var bongkar = $('input[name="i_bongkar_komponen"]').val();
		var total = $('input[name="i_total"]').val();
		var cek1 = $('input[name="i_cek1"]').val();
		
		if(cek1 == 0){
			var pembayaran = parseFloat(total) + parseFloat(bongkar);
			$('input[name="i_cek1"]').val(1);
			$('input[name="i_total"]').val(pembayaran);
		}else{
			var pembayaran = parseFloat(total) - parseFloat(bongkar);
			$('input[name="i_cek1"]').val(0);
			$('input[name="i_total"]').val(pembayaran);
		}
	});
	
	$('input[name="c_lasketok"]').change(function(){
		var bongkar = $('input[name="i_las"]').val();
		var total = $('input[name="i_total"]').val();
		var cek2 = $('input[name="i_cek2"]').val();
		
		if(cek2 == 0){
			var pembayaran = parseFloat(total) + parseFloat(bongkar);
			$('input[name="i_cek2"]').val(1);
			$('input[name="i_total"]').val(pembayaran);
		}else{
			var pembayaran = parseFloat(total) - parseFloat(bongkar);
			$('input[name="i_cek2"]').val(0);
			$('input[name="i_total"]').val(pembayaran);
		}
	});
	
	$('input[name="c_dempul"]').change(function(){
		var dempul = $('input[name="i_dem"]').val();
		var total = $('input[name="i_total"]').val();
		var cek3 = $('input[name="i_cek3"]').val();
		
		if(cek3 == 0){
			var pembayaran = parseFloat(total) + parseFloat(dempul);
			$('input[name="i_cek3"]').val(1);
			$('input[name="i_total"]').val(pembayaran);
		}else{
			var pembayaran = parseFloat(total) - parseFloat(dempul);
			$('input[name="i_cek3"]').val(0);
			$('input[name="i_total"]').val(pembayaran);
		}
	});
	
	$('input[name="c_cat"]').change(function(){
		var cat = $('input[name="i_ca"]').val();
		var total = $('input[name="i_total"]').val();
		var cek4 = $('input[name="i_cek4"]').val();
		
		if(cek4 == 0){
			var pembayaran = parseFloat(total) + parseFloat(cat);
			$('input[name="i_cek4"]').val(1);
			$('input[name="i_total"]').val(pembayaran);
		}else{
			var pembayaran = parseFloat(total) - parseFloat(cat);
			$('input[name="i_cek4"]').val(0);
			$('input[name="i_total"]').val(pembayaran);
		}
	});
	
	$('input[name="c_poles"]').change(function(){
		var poles = $('input[name="i_pol"]').val();
		var total = $('input[name="i_total"]').val();
		var cek5 = $('input[name="i_cek5"]').val();
		
		if(cek5 == 0){
			var pembayaran = parseFloat(total) + parseFloat(poles);
			$('input[name="i_cek5"]').val(1);
			$('input[name="i_total"]').val(pembayaran);
		}else{
			var pembayaran = parseFloat(total) - parseFloat(poles);
			$('input[name="i_cek5"]').val(0);
			$('input[name="i_total"]').val(pembayaran);
		}
	});
	
	$('input[name="c_rakit"]').change(function(){
		var rakit = $('input[name="i_rak"]').val();
		var total = $('input[name="i_total"]').val();
		var cek6 = $('input[name="i_cek6"]').val();
		
		if(cek6 == 0){
			var pembayaran = parseFloat(total) + parseFloat(rakit);
			$('input[name="i_cek6"]').val(1);
			$('input[name="i_total"]').val(pembayaran);
		}else{
			var pembayaran = parseFloat(total) - parseFloat(rakit);
			$('input[name="i_cek6"]').val(0);
			$('input[name="i_total"]').val(pembayaran);
		}
	});
			
	createDatePicker();
	
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table width="100%" cellpadding="4" class="form_layout">
     <tr>
     <td>Nama Panel</td>
       <td>
       	  <input name="i_product_name" readonly="readonly" type="text" id="i_product_name" value="<?=$product_name ?>" />
          <input type="hidden" name="i_index" value="<?=$index?>" />
          <input type="hidden" name="i_detail_registration_id" value="<?=$detail_registration_id?>" />

</td>
     </tr>
     <?
	$sql = "select * from transaction_types";
	$query = $this->db->query($sql);
	
	foreach($query->result_array() as $row){
	 switch($row['transaction_type_id']){
		case 1: 
		?>
		<tr>
		<td>Bongkar komponen</td>
       <td><input name="i_bongkar_komponen" type="text" id="i_bongkar_komponen" style="text-align:right;" value="<?=$row['transaction_type_price']?>" size="15" readonly="readonly" />
      <input name="c_bongkar_komponen" type="checkbox" id="c_bongkar_komponen" value="1" <?php if($transaction_detail_bongkar_komponen != 0){ ?> checked="checked" <?php }?> />
      <input type="hidden" name="i_cek1" value="<?=$transaction_detail_bongkar_komponen?>"/></td>
     </tr>
		<?
		break;
		case 2:
		?>
		<tr>
		<td>Las/Ketok</td>
       <td><input name="i_las" type="text" id="i_las" style="text-align:right;" value="<?=$row['transaction_type_price']?>" size="15" readonly="readonly" />
      <input name="c_lasketok" type="checkbox" id="c_lasketok" value="2" <?php if($transaction_detail_lasketok != 0){ ?> checked="checked" <?php }?> />
      <input type="hidden" name="i_cek2" value="<?=$transaction_detail_bongkar_komponen?>"/></td>
     </tr>
		<?
		break;
		case 3:
		?>
        <tr>
     <td>Dempul</td>
       <td><input name="i_dem" type="text" id="i_dem" style="text-align:right;" value="<?=$row['transaction_type_price']?>" size="15" readonly="readonly" />
      <input name="c_dempul" type="checkbox" id="c_dempul" value="3" <?php if($transaction_detail_dempul != 0){ ?> checked="checked" <?php }?> />
      <input type="hidden" name="i_cek3" value="<?=$transaction_detail_dempul?>"/></td>
     </tr>
        <?
		break;
		case 4:
		?>
        <tr>
     <td>Cat</td>
       <td><input name="i_ca" type="text" id="i_ca" style="text-align:right;" value="<?=$row['transaction_type_price']?>" size="15" readonly="readonly" />
      <input name="c_cat" type="checkbox" id="c_cat" value="4" <?php if($transaction_detail_cat != 0){ ?> checked="checked" <?php }?> />
      <input type="hidden" name="i_cek4" value="<?=$transaction_detail_cat?>"/></td>
     </tr>
        <?
		break;
		case 5:
		?>
         <tr>
     <td>Poles</td>
       <td><input name="i_pol" type="text" id="i_pol" style="text-align:right;" value="<?=$row['transaction_type_price']?>" size="15" readonly="readonly" />
      <input name="c_poles" type="checkbox" id="c_poles" value="5" <?php if($transaction_detail_poles != 0){ ?> checked="checked" <?php }?> />
      <input type="hidden" name="i_cek5" value="<?=$transaction_detail_poles?>"/></td>
     </tr>
        <?
		break;
		case 6:
		?>
		<tr>
     <td>Rakit</td>
       <td><input name="i_rak" type="text" id="i_rak" style="text-align:right;" value="<?=$row['transaction_type_price']?>" size="15" readonly="readonly" />
      <input name="c_rakit" type="checkbox" id="c_rakit" value="6" <?php if($transaction_detail_rakit != 0){ ?> checked="checked" <?php }?> />
      <input type="hidden" name="i_cek6" value="<?=$transaction_detail_rakit?>"/></td>
     </tr>
		<?
		 }
	 }
	 ?>
     <!--<tr>
     <td>Tanggal awal plain</td>
       <td><input name="i_first_date" type="text" id="i_first_date" value="<?=$transaction_detail_plain_first_date ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal akhir plain</td>
       <td><input name="i_last_date" type="text" id="i_last_date" value="<?=$transaction_detail_plain_last_date	 ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal Aktual</td>
       <td><input name="i_actual_date" type="text" id="i_actual_date" value="<?=$transaction_detail_actual_date ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal target selesai</td>
       <td><input name="i_target_date" type="text" id="i_target_date" value="<?=$transaction_detail_target_date ?>" class="date_input"/></td>
     </tr>-->
     <tr>
     <td>Tanggal Action</td>
      <td><input name="i_date" type="text" id="i_date" value="<?= format_new_date($transaction_detail_date) ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Jumlah</td>
     <?
     if($transaction_detail_total == ''){?>
	  <td><input name="i_total" type="text" id="i_total" value="0"/></td>
	 <? }else{?>
	  <td><input name="i_total" type="text" id="i_total" value="<?= $transaction_detail_total ?>"/></td>
	 <?
	 }
	 ?>
     </tr>
     <tr>
    <td width="189" valign="top">Keterangan</td>
      <td width="745"><textarea name="i_description" id="i_description" cols="45" rows="5"><?= $transaction_detail_description ?></textarea></td>
      </tr>
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Save" style="background-color:#da7a02 !important; border-color:#da7a02 !important;" />
<input type="reset" id="reset"  value="Reset" style="background-color:#da7a02 !important;  border-color:#da7a02 !important;" />
	<input type="button" id="cancel" value="Cancel"  style="background-color:#da7a02 !important;  border-color:#da7a02 !important;"  />
</div>
</form>
<div id="">
	<table id="lookup_table_transaction_type" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
            	<th>Type</th>
				<th>Harga</th>
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>



