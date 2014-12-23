<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact",
		listSource 		: "transaction/detail_list_loader/<?=$row_id?>",
		formSource 		: "transaction/detail_form/<?=$row_id?>",
		controlTarget	: "transaction/detail_form_action",
		onAdd		: function (){perhitungan();},	
		onTargetLoad: function (){perhitungan();} 
	});
	
	function perhitungan()
	{
		var registration_total = 0;
		$('input[name="transient_registration_detail_total_price[]"]').each(function()
		{
			registration_total += parseFloat($(this).val());
		});
		$('input#registration_total').val(formatMoney(registration_total));
		$('input#i_registration_final_total_price').val(registration_total);
		$('input#i_registration_total_price').val(registration_total);
		
	}
});
</script>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact"> 
	<thead>
		<tr>
			
			<th>Kode</th>
			<th>Jenis Perbaikan</th>
			<th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>

<div class="command_table" style="text-align:left; height:60px;">
	 <table align="right">
          <tr>
            <td><span class="summary_total"> Total</span></td>
            <td><input id="registration_total" value="<?= $total_registration?>" type="text" readonly="readonly" class="format_money" size="50" />
           </td>
          </tr>
        </table>	
   
   
</div>
<div id="editor"></div>
</form>
</div>