<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact",
		listSource 		: "registration/detail_list_loader/<?=$row_id?>",
		formSource 		: "registration/detail_form/<?=$row_id?>",
		controlTarget	: "registration/detail_form_action",
		onAdd		: function (){perhitungan();},	
		onTargetLoad: function (){perhitungan();} 
	});
	
	function perhitungan()
	{
		var transaction_total = 0;
		$('input[name="transient_transaction_detail_total_price[]"]').each(function()
		{
			transaction_total += parseFloat($(this).val());
		});
		$('input#transaction_total').val(formatMoney(transaction_total));
		$('input#i_transaction_final_total_price').val(transaction_total);
		$('input#i_transaction_total_price').val(transaction_total);
		
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

<div class="command_table" style="text-align:left;">
	 <table align="right">
          <tr>
            <td><span class="summary_total"> Total</span></td>
            <td><input id="transaction_total" value="<?= $transaction_total_price?>" type="text" readonly="readonly" class="format_money" size="50" />
           </td>
          </tr>
        </table>	
    <input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
    <input type="button" id="delete" value="Hapus"/>
   
</div>
<div id="editor"></div>
</form>
</div>