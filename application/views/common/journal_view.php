<script type="text/javascript">
$(function(){
	createTableFormTransient({
		id 		: "#transient_journal<?=$counter_id?>",
		listSource 	: "<?=$listSource?>",
		formSource 	: "<?=$formSource?>",
		controlTarget	: "<?=$controlTarget?>",	// add edit controller
		actionTarget	: "<?=$actionTarget?>",	 // insert many data at once	
		title		: '<?=$transaction_code?>',
		rtitle		: '<?=$transaction_date?>',
		onAdd		: total,
		onComplete	: total
	});
	function total()
	{
		var debit = 0;
		var kredit = 0;
		var envi = $("#transient_journal<?=$counter_id?>").parent();
		envi.find('input[name="transient_debit[]"]').each(function(){
			debit += parseFloat($(this).val());
		});
		envi.find('input[name="transient_kredit[]"]').each(function(){
			kredit += parseFloat($(this).val());
		});
		$('#debit').val(formatMoney(debit));
		$('#kredit').val(formatMoney(kredit));
	}
	$('#submit').click(function(){
		$('.ajax_status').html('');
	});
	$('#edit').click(function(){
		$('.ajax_status').html('');
	});
	$('#add').click(function(){
		$('.ajax_status').html('');
	});
	$('#delete').click(function(){
		$('.ajax_status').html('');
	});
	$('#reset').click(function(){
		$('.ajax_status').html('');
	});
	//total();

});
</script>
<form id="noaction">
<input type="hidden" name="i_transaction_id" value="<?=$transaction_id?>" />
<input type="hidden" name="i_data_id" value="<?=$data_id?>" />
<input type="hidden" name="i_module_id" value="<?=$module_id?>" />
<table border="0" cellpadding="0" cellspacing="0" class="display" id="transient_journal<?=$counter_id?>"> 

	<thead>
		<tr>
		  <th>No. Account</th>
		 <!-- <th>Pasar</th>-->
		  <th>Keterangan</th>
		  <th>Debit</th>
		  <th>Kredit</th>
		</tr>
	</thead> 
	<tbody> 	
	</tbody>
	<!--
	<tfoot class="summarybox">
		<tr>			
			<td style="text-align:right" colspan="3"><b>Total </b></td>
			<td style="text-align:right"><input type="text" class="format_money" readonly="readonly" id="debit" name="debit" size="15" /></td>
			<td style="text-align:right"><input type="text" class="format_money" id="kredit" name="kredit"  readonly="readonly" size="15" /></td> 
		</tr></tfoot>-->
	
</table>

<div class="summarybox">
<table align="right">
<td><b>Total </b></td>
			<td style="text-align:right"><input type="text" class="format_money" readonly="readonly" id="debit" name="debit" size="15" /></td>
			<td style="text-align:right"><input type="text" class="format_money" id="kredit" name="kredit"  readonly="readonly" size="15" /></td> 
</table>
</div>
<div id="panel" class="command_table">
		
	<input type="button" id="reset" value="<?=$readonly?'Refresh':'Reset'?>"/>
	<?php
	if($print_url)
	{	
	?>		
	<input type="button" <?=$is_gl?'':'disabled="disabled"'?> id="printj" value="Cetak" onclick="location.href='<?=site_url($print_url)?>'" /> &nbsp; &nbsp;
	<?
	}
	if(!$readonly){	
	if($enable_add) 
	{
		echo '<input type="button" id="add" value="Tambah"/> ';
	}
	echo '<input type="button" id="edit" value="Revisi"/> ';
	if($enable_add) 
	{
		echo '<input type="button" id="delete" value="Hapus"/> ';
	}
	?>
	&nbsp; &nbsp;<input type="button" id="submit" value="Simpan"/>
	<?php
	}
	
	?>
</div>
<div id="editor"></div>
</form>
<!-- end semua data -->
