<script type="text/javascript">	
$(function(){
	
	var otb;
	
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "gl/gl_form_action",
		backPage		: "gl",
		nextPage		: "gl/form"
	});
		
	
	$('select[name="i_trans_type"]').change(function(){
		var frame_transaksi = document.getElementById("lookup_transaction");
		var tform_koreksi = document.getElementById("tform_koreksi");
		
		if($(this).val() == 1){
			frame_transaksi.style.display = 'none';
			tform_koreksi.style.display = 'none';
		}else{
			
			frame_transaksi.style.display = 'inline';
			tform_koreksi.style.display = 'inline';
		}
		//alert($(this).val());
	});
	
	var otb = createTableFormTransient({
		id 				: "#transient_example_koreksi",
		listSource 		: "gl/journal_loader_koreksi/"+$('input[name="i_transaction_correction_id"]').val(),
		onComplete			: total_koreksi,
	});
	
	function select_item(id)
	{
		if(id.toString().length>0)
		{
			//alert(id);
			otb.fnSettings().sAjaxSource = site_url + "gl/journal_loader_koreksi/"+$('input[name="i_transaction_correction_id"]').val();
			otb.fnReloadAjax();	
		}
		total_koreksi();
	}
	
	function total_koreksi(){
		var debit_koreksi = 0;
		var kredit_koreksi = 0;
		$('input[name="transient_debit_koreksi[]"]').each(function(){
			debit_koreksi += parseFloat($(this).val());
		});
		$('input[name="transient_kredit_koreksi[]"]').each(function(){
			kredit_koreksi += parseFloat($(this).val());
		});
		$('input[name="debit_koreksi"]').val(formatMoney(debit_koreksi));
		$('input[name="kredit_koreksi"]').val(formatMoney(kredit_koreksi));
	}
	
	createDatePicker();
	//updateAll();
	
		$('#enable').click(function(){
		$('input[type="button"][id="add"]').show();
		$('input[type="button"][id="edit"]').show();
		$('input[type="button"][id="delete"]').show();
	});
	$('#new').click(function(){
		location.href = site_url + "gl/form";
	});
});
</script>

<form class="form_class" id="id_form_nya">	
<div class="form_area">

<!-- panel input -->
<table class="form_layout">
	<!--<tr>
		 <td width="150">ID</td> 
		<td>
			<input type="text" id="row_id" size="10" value="<?=$transaction_id?>" disabled="disabled" />
			
		</td>
	</tr>-->
	
	<tr>
		<td width="150" req="req">No. Transaksi</td>	
		<td>
			<input type="text" name="i_kode"  value="<?=$transaction_code?>" />		</td>
	</tr>
	
	<tr>
	  <td req="req">Periode</td>
	  <td><?=form_dropdown('i_period', $period, $period_id)?></td>
    </tr>
	<tr>
		<td width="150" req="req">Tanggal</td>
		<td>			
			<input type="hidden" id="row_id" name="row_id" value="<?=$transaction_id?>" />
			<input type="text" value="<?=$transaction_date?>"  name="i_tanggal" class="date_input" size="11" />		</td>
	</tr>
    <tr>
		<td width="150" req="req">Tipe Jurnal</td>	
		<td>
     
			<?=form_dropdown('i_trans_type', $trans_type, $transaction_type_id)?>	
            <br />
            	</td>
	</tr>
	<tr>
		<td width="150" req="req">Keterangan Jurnal</td>
		<td>
			<textarea name="i_desc" cols="40" rows="3"><?=$transaction_description?></textarea>		</td>
	</tr>
</table>


<div class="command_bar">
		<input type="button" id="submit" value="Simpan"/>
		
		<?php
		if($show_control & EDIT_CONTROL) 
		{
			echo '<input type="button" id="enable" value="Edit"/> &nbsp;';
			
		}
			
		if($show_control & BACK_CONTROL) echo '<input type="button" id="cancel" value="Kembali" /> &nbsp;';
		
		?>
	</div>
    </div>
</form>

