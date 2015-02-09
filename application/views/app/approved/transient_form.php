<script type="text/javascript">	
$(function(){
	createLookUp({
		table_id		: "#lookup_table_product_price",
		listSource 		: "lookup/product_price_table_control/" + $('input[name="i_insurance_id"]').val(),
		dataSource		: "lookup/product_price_lookup_id",
		component_id	: "#lookup_product_price",
		filter_by		: [{id : "p1", label : "Jenis Perbaikan"}]
	});
	

	
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table width="100%" cellpadding="4" class="form_layout">
	<tr>
		<td width="199" req="req">Produk
	 </td>
		<td width="10" req="req">:</td>
		<td width="704" req="req"><span class="lookup" id="lookup_product_price">
        <input type="hidden" name="i_product_price_id" class="com_id" value="<?=$transient_product_price_id?>" />
         <div class="iconic_base iconic_search com_popup"></div>
         <span class="com_desc"></span>
        <input type="text" class="com_input" size="6" name="module" />
        <input type="hidden" name="i_index" value="<?=$index?>" />
       
        
       </span></td>
	</tr>
    <tr>
     <td width="199" >Harga
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_detail_registration_price" type="text" id="i_detail_registration_price" value="<?=$transient_reg_price ?>" readonly="readonly" />
     
     <input name="i_detail_registration_id" type="text" id="i_detail_registration_id" value="<?=$transient_detail_registration_id ?>" readonly="readonly" />
     <input name="i_product_code" type="hidden" id="i_product_code" value="<?=$transient_product_code ?>" readonly="readonly" />
     <input name="i_product_name" type="hidden" id="i_product_name" value="<?=$transient_product_name ?>" readonly="readonly" />
        
     </td>
    </tr>
   <tr>
     <td width="199" >Harga Approved
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_detail_registration_approved_price" type="text" id="i_detail_registration_approved_price" value="<?=$transient_reg_aproved_price ?>"/></td>
    </tr>   
	
</table>
</div>

<div class="command_bar">
	<input type="button" id="submit" value="Simpan" />
	<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>

</form>
<div>
	<table  id="lookup_table_product_price" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th width="10%">ID</th>
				<th>Jenis Perbaikan</th>
                <th>Tipe</th>
                <th>Sub Tipe</th>
                <th>Harga</th>
           
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>
