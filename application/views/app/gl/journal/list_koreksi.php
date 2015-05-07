<script type="text/javascript">
$(function(){
	
	
	
	
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
<form id="tform_koreksi" <?php if($tipe == '1'){ ?> style="display:none;"<?php } ?>>
<div>
<table height="21" border="0" cellpadding="0" cellspacing="0" class="display" id="transient_example_koreksi" width="100%">
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
  <tfoot class="summarybox">
    <tr>
      <td colspan="3" style="text-align:right"><b>Total &nbsp;</b></td>
      <td><input style="font-weight:bold" type="text" class="format_money" readonly="readonly" id="debit_koreksi" name="debit_koreksi" /></td>
      <td><input style="font-weight:bold" type="text" class="format_money" id="kredit_koreksi" name="kredit_koreksi"  readonly="readonly" /></td>
    </tr>
  </tfoot>
</table>
</form>
</div>
<div style="height:1px;"></div>
<!-- end semua data -->
