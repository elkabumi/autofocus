<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_panel",
		listSource 		: "transaction/detail_list_loader_panel/<?=$row_id?>",
		formSource 		: "transaction/detail_form/<?=$row_id?>",
		controlTarget	: "transaction/detail_form_action",
		
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
			<!---<th>Harga disetujui</th>-->
         
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div class="command_table" style="text-align:right;">

<span class="summary_total"> Total</span> <input id="rs_total" value="<?= $approved_total_registration?>" type="text" readonly="readonly" class="format_money" size="50" />
<br />

<span class="summary_total">Diskon %</span> <input id="rs_total_disc" value="<?= $approved_disc_panel?>" type="text" readonly="readonly" class="format_money" size="50" />
<br />
<span class="summary_total"> Total Setalah Diskon</span> <input id="rs_total_disc" value="<?= $approved_disc_panel_total?>" type="text" readonly="readonly" class="format_money" size="50" />

<!--<div align="left">     --<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
     <!--<input type="button" id="delete" value="Hapus"/>
    </div>-->
</div>
<div id="editor"></div>
</form>
</div>