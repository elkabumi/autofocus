<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact",
		listSource 		: "po_received_report/detail_list_loader/<?=$row_id?>",
		formSource 		: "po_received_report/detail_form/<?=$row_id?>",
		controlTarget	: "po_received_report/detail_form_action",
		onAdd		: function (){perhitungan();},	
		onTargetLoad: function (){perhitungan();} 
	});
	
	function perhitungan()
	{
		var payment_total = 0;
		$('input[name="transient_workshop_service_job_price[]"]').each(function()
		{
			payment_total += parseFloat($(this).val());
		});
		$('input#i_transaction_total').val(formatMoney(payment_total));
		
	}
});
</script>
<div class="transient_category">Data Progress Pengerjaan</div>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact"> 
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>Jenis Perbaikan</th>
            <th>Harga</th>
			<th>Harga Borongan</th>
			<th>Progress (%)</th>
			
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>

<div class="command_table" style="text-align:left; height:60px;">
	 <table align="right">
          <tr>
            <td><span class="summary_total"> Total</span></td>
            <td><input name="i_transaction_total" id="i_payment_total" value="<?=$transaction_total?>" type="text" readonly="readonly" class="format_money" size="50" />
           </td>
          </tr>
        </table>	
</div>  
<div id="editor"></div>
</form>
</div>