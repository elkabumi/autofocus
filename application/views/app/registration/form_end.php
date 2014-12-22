<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya2", 
		actionTarget	: "registration/form_action",
		backPage		: "registration",
		nextPage		: "registration/report"
	});
	
	$('select[name="i_registration_payment_method"]').change(function(){
		id = $(this).val();
		var down_payment = document.getElementById("down_payment");
		
		if(id == 2){
			down_payment.style.display = 'inline';
		}else{
			down_payment.style.display = 'none';
		}
	});
	
	$('input[name="i_registration_sent_price"]').change(function(){
		
		var kirim = $('input[name="i_registration_sent_price"]').val();
		var total = $('input[name="i_registration_total_price"]').val();
		
		final_total = parseFloat(total) + parseFloat(kirim);
		
		$('input[name="i_registration_final_total_price"]').val(final_total);
		
		
	});
	
	$('input[name="i_registration_payed"]').change(function(){
		
		var dibayar = $('input[name="i_registration_payed"]').val();
		var final_total = $('input[name="i_registration_final_total_price"]').val();
		
		if(dibayar < final_total){
			alert('Pembayaran tidak boleh kurang dari harga total');
			$('input[name="i_registration_change"]').val(0);
		}else{
		
		kembali = parseFloat(dibayar) - parseFloat(final_total);
		
		$('input[name="i_registration_change"]').val(kembali);
		}
		
	});
	
	
	createDatePicker();
	//updateAll(); 
});
</script>

<form class="form_class" id="id_form_nya2">	
<div class="form_area">
<div class="form_area_frame">
<table class="form_layout">
	  <tr>
    <td width="70" valign="top">Jenis Pembayaran
       <?=form_dropdown('i_registration_payment_method', $cbo_registration_payment_method, $registration_payment_method_id)?></td>
    </tr>
   
     <tr>
      <td> <div id="down_payment" style="display:none;">Uang Muka
        <input type="text" name="i_registration_down_payment" size="15" value="<?=$registration_down_payment?>" /></div>	</td>
    </tr>
    
    <tr>
    <td width="70" valign="top">PPN
      <?=form_dropdown('i_registration_ppn', $cbo_registration_ppn, $registration_ppn)?>  
      </td>  
      </tr>
       <tr>
      <td>Ongkos Kirim
        <input type="text" name="i_registration_sent_price" size="15" value="<?=$registration_sent_price?>" />	</td>
    </tr>
      <tr>
      <td>Total
        <input name="i_registration_final_total_price" type="text" id="i_registration_final_total_price" value="<?=$registration_final_total_price?>" size="15" readonly="readonly" />
        <input name="i_registration_total_price" type="hidden" id="i_registration_total_price" value="<?=$registration_total_price?>" size="15" readonly="readonly" />
        </td>
    </tr>
      <tr>
      <td>Dibayar
        <input name="i_registration_payed" type="text" id="i_registration_payed" value="" size="15" />
        </td>
    </tr>
<tr>
      <td>Kembali
        <input name="i_registration_change" type="text" id="i_registration_change" value="" size="15" readonly="readonly" />
        </td>
    </tr>

      </table>
      </div>
	<div class="command_bar">
     <input type="hidden" name="row_id" value="<?=$row_id?>" />
		<input type="button" id="submit" value="Proses Transaksi" style="width:150px !important;"/>
		<input type="button" id="enable" value="Edit"/>
	
		<input type="button" id="cancel" value="Batal"/>
	</div>
</div>
<!-- table contact -->

</form>
