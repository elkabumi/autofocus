<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_panel",
		listSource 		: "po_received_report/detail_list_loader_panel/<?=$row_id?>",
		formSource 		: "po_received_report/detail_form/<?=$row_id?>",
		controlTarget	: "po_received_report/detail_form_action",
		
		onAdd		: function (){perhitungan();},	
		onTargetLoad: function (){perhitungan();} 
	});
	
	function perhitungan()
	{
		var registration_total = 0;
		$('input[name="transient_registration_detail_price[]"]').each(function()
		{
			registration_total += parseFloat($(this).val());
		});
		$('input#registration_total').val(formatMoney(registration_total));
		
	}
});
</script>
<div class="transient_category">Data Panel</div>

<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_panel"> 
	<thead>
		<tr>
			
			<th>Kode</th>
			<th>Jenis Perbaikan</th>
			<th>Harga</th>
			<th>Harga disetujui</th>
         
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>

<div class="command_table" style="text-align:right; padding:5px;">

	<span class="summary_total"> Total</span> <input id="registration_total" value="<?= $approved_total_registration?>" type="text" readonly="readonly" class="format_money" size="50" />

   
</div>
<div id="editor"></div>
</form>
</div>