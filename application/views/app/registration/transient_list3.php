<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact3",
		listSource 		: "registration/detail_list_loader3/<?=$row_id?>",
		formSource 		: "registration/detail_form3/<?=$row_id?>",
		controlTarget	: "registration/detail_form_action3",
		
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
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact3"> 
	<thead>
		<tr>
			
			<th>Part No.</th>
            <th>Nama Part</th>
            <th>qty</th>
            <th>Harga Part</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div class="command_table" style="text-align:left;">
 <table align="right">
          <tr>
            <td><span class="summary_total"> Total</span></td>
            <td><input id="rs_total" value="<?= $sparepart_total_registration?>" type="text" readonly="readonly" class="format_money" size="50" />
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