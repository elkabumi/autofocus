<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_cat",
		listSource 		: "upload_photo/detail_list_loader_cat/<?=$row_id?>",
		formSource 		: "upload_photo/detail_form_cat/<?=$row_id?>",
		controlTarget	: "upload_photo/detail_form_action_cat"
		
	});
	

});</script>
<div class="transient_category">Data Bahan / Cat</div>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_cat"> 
	<thead>
		<tr>
			
			<th>Nama Bahan / Cat</th>
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
            <td><input id="tm_total" value="<?= $transaction_material_total?>" type="text" readonly="readonly" class="format_money" size="50" />
           </td>
          </tr>
        </table>
    
   
</div>
<div id="editor"></div>
</form>
</div>