<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact",
		listSource 		: "approved/detail_list_loader/<?=$row2_id?>",
		formSource 		: "approved/detail_form/<?=$row2_id?>",
		controlTarget	: "approved/detail_form_action",
		
		
		
		onAdd		: function (){perhitungan();},	
		onTargetLoad: function (){perhitungan();} 
	});
	
	function perhitungan()
	{
		var registration_total = 0;
		$('input[name="transient_registration_detail_approved_price[]"]').each(function()
		{
			registration_approved_total += parseFloat($(this).val());
		});
		$('input#registration_total').val(formatMoney(registration_approved_total));
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
			<th>Harga Approved</th>            
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>

<div class="command_table" style="text-align:left; height:60px;">
	 <table align="right">
          <tr>
            <td><span class="summary_total"> Total</span></td>
            <td><input id="registration_total" value="<?= $approved_total_registration 	?>" type="text" readonly="readonly" class="format_money" size="50" />
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