<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_cat",
		listSource 		: "create_po_material/detail_table_loader/<?=$row_id?>",
		formSource 		: "create_po_material/detail_form/<?=$row_id?>",
		controlTarget	: "create_po_material/detail_form_action",
		
		onAdd		: function (){perhitungan();},	
		onTargetLoad: function (){perhitungan();} 
	});
	
	function perhitungan()
	{
		var tm_total = 0;
		$('input[name="transient_materials_price[]"]').each(function()
		{
			tm_total += parseFloat($(this).val());
		});
		$('input#tm_total').val(formatMoney(tm_total));
		
	}
});</script>
<div class="transient_category">Data Bahan</div>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_cat"> 
	<thead>
		<tr>
			
			<th>Nama Bahan</th>
            <th>Qty</th>
            <th>Harga</th
            
		></tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div class="command_table" style="text-align:left;">
 <table align="right">
          <tr>
            <td><span class="summary_total"> Total</span></td>
            <td><input id="tm_total" value="<?= $tpm_total_price?>" type="text" readonly="readonly" class="format_money" size="50" />
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