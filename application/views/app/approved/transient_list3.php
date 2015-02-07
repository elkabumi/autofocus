<script type="text/javascript">	
$(function(){
	createTableFormTransient({
		id 				: "#transient_contact3",
		listSource 		: "approved/detail_list_loader3/<?=$row_id?>",
		formSource 		: "approved/detail_form3/<?=$row_id?>",
		controlTarget	: "approved/detail_form_action3"
	});
	
	
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
            <th>Harga Approved Part</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
    
</table>
<div class="command_table" style="text-align:left;">
 <table align="right">
        
        </table>
      <!--<input type="button" id="add" value="Tambah"/>-->
	<input type="button" id="edit" value="Revisi"/>
     <!--<input type="button" id="delete" value="Hapus"/>-->
   
</div>
<div id="editor"></div>
</form>
</div>