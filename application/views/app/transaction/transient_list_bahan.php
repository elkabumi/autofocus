<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html><script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_bahan",
		listSource 		: "transaction/detail_list_loader_bahan/<?=$row_id?>",
		formSource 		: "transaction/detail_form_bahan/<?=$row_id?>",
		controlTarget	: "transaction/detail_form_action_bahan",
		
		onAdd		: function (){perhitungan();},	
		onTargetLoad: function (){perhitungan();} 
	});
	
	function perhitungan()
	{
		var bahan_total = 0;
		$('input[name="transient_bahan_price[]"]').each(function()
		{
			bahan_total += parseFloat($(this).val());
		});
		$('input#bahan_total').val(formatMoney(bahan_total));
		
	}
});</script>
<div class="transient_category">Data Bahan</div>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_bahan"> 
	<thead>
		<tr>
			
			<th>Nama Bahan</th>
            <th>Qty</th>
            <th>Keterangan</th>
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
            <td><input id="bahan_total" value="<?= $transaction_material_total?>" type="text" readonly="readonly" class="format_money" size="50" />
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