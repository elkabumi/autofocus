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
		var transaction_total = 0;
		$('input[name="transient_transaction_detail_total[]"]').each(function()
		{
			transaction_total += parseFloat($(this).val());
		});
		$('input#i_transaction_total').val(formatMoney(transaction_total));
		
	}
});
</script>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact"> 
	<thead>
		<tr>
			<th>Jenis Perbaikan</th>
            <th>Bongkar Komponen</th>
			<th>Las/Ketok</th>
			<th>Dempul</th>
            <th>Cat</th>
			<th>Poles</th>
            <th>Rakit</th>
			<!--<th>Tanggal plain awal</th>
			<th>Tanggal plain akhir</th>
            <th>Tanggal aktual</th>
            <th>Tanggal target selesai</th>-->
            <th>Tanggal Action</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>

<div class="command_table" style="text-align:left; height:60px;">
	 <table align="right">
          <tr>
            <td><span class="summary_total"> Total</span></td>
            <td><input name="i_transaction_total" id="i_transaction_total" value="<?=$transaction_total?>" type="text" readonly="readonly" class="format_money" size="50" />
           </td>
          </tr>
        </table>	
   	<input type="button" id="edit" value="Edit"/>
   
</div>  
<div id="editor"></div>
</form>
</div>