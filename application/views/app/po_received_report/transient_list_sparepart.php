<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_sparepart",
		listSource 		: "po_received_report/detail_list_loader_sparepart/<?=$row_id?>",
		formSource 		: "po_received_report/detail_form3/<?=$row_id?>",
		controlTarget	: "po_received_report/detail_form_action3",
		
		onAdd		: function (){perhitungan();},	
		onTargetLoad: function (){perhitungan();} 
	});
	
	function perhitungan()
	{
		var rs_total = 0;
		$('input[name="transient_rs_repair[]"]').each(function()
		{
			rs_total += parseFloat($(this).val());
		});
		$('input#rs_total').val(formatMoney(rs_total));
		
	}
});</script>
<div class="transient_category">Data Sparepart</div>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_sparepart"> 
	<thead>
		<tr>
			
			<th>Part No.</th>
            <th>Nama Part</th>
            <th>Qty</th>
            <th>Harga</th>
             <th>Harga Disetujui</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div class="command_table" style="text-align:right; padding:5px;">

	<span class="summary_total"> Total</span> <input id="rs_total" value="<?= $sparepart_total_registration?>" type="text" readonly="readonly" class="format_money" size="50" />

   
</div>
<div id="editor"></div>
</form>
</div>