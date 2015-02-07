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
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact"> 
	<thead>
		<tr>
			
			<th>Kode</th>
			<th>Jenis Perbaikan</th>
			<th>Harga</th>
         
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>

<div class="command_table" style="text-align:left;">
	 <table align="right">
          <tr>
            <td><span class="summary_total"> Total</span></td>
            <td><input id="registration_total" value="<?= $registration_total_price?>" type="text" readonly="readonly" class="format_money" size="50" />
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