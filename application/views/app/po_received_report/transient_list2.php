<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact2",
		listSource 		: "transaction/detail_list_loader2/<?=$transaction_id?>",
		formSource 		: "transaction/detail_form/<?=$transaction_id?>",
		controlTarget	: "transaction/detail_form_action"
	
	});
	
});
</script>
<div>
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_contact2"> 
	<thead>
		<tr>
        	<th>Type transaksi</th>
			<th>Tanggal plain awal</th>
			<th>Tanggal plain akhir</th>
            <th>Tanggal aktual</th>
            <th>Tanggal target selesai</th>
            <th>Keterangan</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>

<div class="command_table" style="text-align:left;">
    <input type="button" id="add" value="Add"/>
	<input type="button" id="edit" value="Edit"/>
    <input type="button" id="delete" value="Delete"/>
   
</div>
<div id="editor"></div>
</form>
</div>