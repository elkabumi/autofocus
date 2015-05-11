<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_sparepart",
		listSource 		: "transaction/detail_list_loader_sparepart/<?=$row_id?>",
		formSource 		: "transaction/detail_form_sparepart/<?=$row_id?>",
		controlTarget	: "transaction/detail_form_action_sparepart",
		
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
            <th>Terpasang</th>
            <th>Stock</th>
            <th>Harga</th>
            <!--<th>Harga Disetujui</th>-->
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div class="command_table" style="text-align:right;">

<span class="summary_total"> Total</span> <input id="rs_total" value="<?= $sparepart_total_registration?>" type="text" readonly="readonly" class="format_money" size="50" />
<br />

<span class="summary_total">Diskon %</span> <input id="rs_total_disc" value="<?= $approved_disc_sparepart?>"  type="text" readonly="readonly" class="format_money" size="50" />
<br />
<span class="summary_total"> Total Setalah Diskon</span> <input id="rs_total_disc" value="<?= $approved_disc_sparepart_total?>" type="text" readonly="readonly" class="format_money" size="50" />

<div align="left">    
	<!--<input type="button" id="add" value="Pasang"/>-->
	<input type="button" id="edit" value="Pasang"/>
     <!--<input type="button" id="delete" value="Hapus"/>-->
    </div>
</div>
<div id="editor"></div>
</form>
</div>