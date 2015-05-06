<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact3",
		listSource 		: "approved/detail_list_loader3/<?=$row_id?>",
		formSource 		: "approved/detail_form3/<?=$row_id?>",
		controlTarget	: "approved/detail_form_action3",
			
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
		var rs_total_disc = 0;
		$('input[name="transient_rs_repair[]"]').each(function()
		{
			rs_total_disc += parseFloat($(this).val());
		});
		$('input#rs_total_disc').val(formatMoney(rs_total_disc));
		
	}
});</script>
<div class="transient_category">Data Sparepart</div>

<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact3"> 
	<thead>
		<tr>
			
			<th>Part No.</th>
            <th>Nama Part</th>
            <th>qty</th>
            <th>Harga Part</th>
            <!--<th>Harga Approved Part</th>-->
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div class="command_table" style="text-align:right;">

<span class="summary_total"> Total</span> <input id="rs_total" value="<?= $sparepart_total_registration?>" type="text" readonly="readonly" class="format_money" size="50" />
<br />

<span class="summary_total">Diskon</span> <input id="rs_total_disc" value="<?= $approved_disc_sparepart?>"  type="text" readonly="readonly" class="format_money" size="50" />
<br />
<span class="summary_total"> Total Setalah Diskon</span> <input id="rs_total_disc" value="<?= $approved_disc_sparepart_total?>" type="text" readonly="readonly" class="format_money" size="50" />

<div align="left">     <!--<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
     <!--<input type="button" id="delete" value="Hapus"/>-->
    </div>
</div>
<div id="editor"></div>
</form>
</div>