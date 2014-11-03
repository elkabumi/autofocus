<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "product/form_action",
		backPage		: "product",
		nextPage		: "product"
	});
	
	createLookUp({
		table_id		: "#lookup_table_product_category",
		table_width		: 400,
		listSource 		: "lookup/product_category_table_control",
		dataSource		: "lookup/product_category_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_product_category",
		filter_by		: [{id : "p1", label : "Nama"}]
	});
	
	
	createDatePicker();
});

</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	<tr>
     <td width="196" >Material Code</td>
       <td width="651"><input name="i_code" type="text" id="i_code" value="<?=$product_code ?>" />
     
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
   </tr>
   
    <tr>
     <td>Material Name</td>
       <td><input name="i_name" type="text" id="i_name" value="<?=$product_name ?>" size="70" /></td>
     </tr>
     <tr>
     <td>Material Type</td>
        <td><span class="lookup" id="lookup_product_category">
				<input type="hidden" name="i_category_id" class="com_id" value="<?=$product_category_id?>" /><input type="text" class="com_input" />
                <div class="iconic_base iconic_search com_popup"></div>
				</span>	
       </td>
     </tr>
   
   <tr>
    <td>Create Price</td>
       <td><input name="i_price" type="text" id="i_price" value="<?=$product_price ?>" class="date_input" size="10"/></td>
     </tr>
     <td>Create Date</td>
       <td><input name="i_date" type="text" id="i_date" value="<?=$product_date ?>" class="date_input" size="10"/></td>
     </tr>
 
   <tr style="display:none;">
     <td>Harga</td> 
       <td><input name="i_price" type="text" id="i_price" value="<?=$product_price ?>" size="10"/></td>
     </tr>
   
  <tr>
    <td width="189" valign="top">Notes</td>
      <td><textarea name="i_description" id="i_description" cols="45" rows="5"><?= $product_description ?></textarea></td>
    </tr>

</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Save"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="cancel" value="Close" /> 
</div>
</div>
</form>

<div id="">
	<table id="lookup_table_product_category" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
				<th>Nama</th>
            
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

