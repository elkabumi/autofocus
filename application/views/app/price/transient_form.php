<script type="text/javascript">	
$(function(){

	
	createLookUp({
		table_id		: "#lookup_table_product_category",
		table_width		: 400,
		listSource 		: "lookup/product_category_table_control",
		dataSource		: "lookup/product_category_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_product_category",
		filter_by		: [{id : "p1", label : "Nama"}]
	});
	
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table cellpadding="2" class="form_layout">
	<tr>
  
     <td width="222" req="req" >item name
     </td>
     <td width="633" >
    <input name="i_ist_name" type="text" id="i_ist_name" value="<?=$transient_ist_name ?>" />
   <input type="hidden" name="i_index" value="<?=$index?>" />
      </td>
    </tr>
       
     <tr>
     <td>Item Category</td>
        <td><span class="lookup" id="lookup_product_category">
				<input type="hidden" name="i_category_id" class="com_id" value="<?=$product_category_id?>" /><input type="text" class="com_input" />
                <div class="iconic_base iconic_search com_popup"></div>
				</span>	
       </td>
     </tr>
     <tr>
  
     <td width="222" req="req" >Price
     </td>
     <td width="633" >
    <input name="i_ist_name" type="text" id="i_ist_name" value="<?=$transient_ist_name ?>" />
   <input type="hidden" name="i_index" value="<?=$index?>" />
      </td>
    </tr>

 <tr>
	<tr>  
	  <td width="222" valign="top">Description</td>
	  <td width="633" valign="top"><textarea name="i_ist_description" id="i_ist_description" cols="45" rows="3"><?=$transient_ist_name?>
    </textarea></td>
	  </tr>
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Save" style="background-color:#da7a02 !important; border-color:#da7a02 !important;" />
<input type="reset" id="reset"  value="Reset" style="background-color:#da7a02 !important;  border-color:#da7a02 !important;" />
	<input type="button" id="cancel" value="Cancel"  style="background-color:#da7a02 !important;  border-color:#da7a02 !important;"  />
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

