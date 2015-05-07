<script type="text/javascript">
$(function(){
	createTableFormTransient({
		id 					: "#transient_example",
		listSource 			: "gl/journal_loader/<?=$transaction_id?>",
		formSource 			: "gl/journal_form/<?=$transaction_id?>",
		controlTarget		: "gl/journal_control",	// add edit controller
		actionTarget		: "gl/journal_action/<?=$transaction_id?>",	 // insert many data at once	
		onAdd				: total,
		onComplete			: total,
		resetAfterSubmit 	: false,
		onFormSubmit		: 
							function(edtr)
							{
								edtr.find('#lookup_component_coa_journal').find('input').val('');
								edtr.find('.ajax_status').html('');
							},
	});
	
	
	
	function total(){
		var debit = 0;
		var kredit = 0;
		$('input[name="transient_debit[]"]').each(function(){
			debit += parseFloat($(this).val());
		});
		$('input[name="transient_kredit[]"]').each(function(){
			kredit += parseFloat($(this).val());
		});
		$('input[name="debit"]').val(formatMoney(debit));
		$('input[name="kredit"]').val(formatMoney(kredit));
	}
	//total();

});
</script>
<form id="tform">
<div>
<table height="21" border="0" cellpadding="0" cellspacing="0" class="display" id="transient_example">
  <thead>
    <tr>
      <th>No. Akun </th>
      <th>Nama Akun</th>
      <th>Tingkat Pendidikan</th>
      <th>Keterangan</th>
      <th>Debit</th>
      <th>Kredit</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
<div id="panel" class="command_table">
<table align="right">
          <tr>
            <td><span class="summary_total"> Total</span></td>
            <td><input id="debit" name="debit"  value="<?=$total_debit?>" type="text" readonly="readonly" class="format_money" size="50" /></td>
            <td><input id="kredit" name="kredit" value="<?=$total_kredit?>" type="text" readonly="readonly" class="format_money" size="50" /></td>
          </tr>
        </table>
	<input type="button" id="add" <?=$row_id?'style="display:none"':''?> value="Tambah"/>
	<input type="button" id="edit" <?=$row_id?'style="display:none"':''?> value="Revisi"/> &nbsp; &nbsp;
    	<input type="button" id="delete" <?=$row_id?'style="display:none"':''?> value="Hapus"/>    
    	<?php
    	if($row_id) {?>
    	<input type="button" id="printj" value="Cetak" onclick="location.href='<?=site_url('gl/print_jurnal/'.$row_id)?>'" />
    	<? } ?>
	<input type="button" id="reset" value="<?=$row_id?'Refresh':'Reset'?>"/> 	
	
</div>
<div id="editor"></div>
</form>
</div>

<!-- end semua data -->
