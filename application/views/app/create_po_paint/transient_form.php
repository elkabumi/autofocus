<script type="text/javascript">	
$(function(){
	createLookUp({
		table_id		: "#lookup_table_material_stock",
		listSource 		: "lookup/material_stock_table_control/2/" + $('input[name="i_stand_id"]').val(),
		dataSource		: "lookup/material_stock_lookup_id",
		component_id	: "#lookup_material_stock",
		filter_by		: [{id : "p1", label : "Cabang"}, {id : "p2", label : "Nama Cat"}, {id : "p3", label : "Stock"}, {id : "p4", label : "Satuan"}],
		onSelect		: load_satuan
	});
	
	function load_satuan()
	{
		var id 	= $('input[name="i_material_stock_id"]').val();
		
		if(id == ""){
			return;
		}
		var data ='id='+id; 
		
		$.ajax({
			type: 'POST',
			url: '<?=site_url('create_po_paint/load_satuan')?>',
			data: data,
			dataType: 'json',
			success: function(data){	
				$('input[name="i_unit"]').val(data.content['transient_unit_name']);	
				$('input[name="i_name"]').val(data.content['transient_materials_name']);				
		
			}
			
		});
	}
	
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table cellpadding="2" class="form_layout">
	<tr>
		<td width="199" >Nama Cat</td>
        <td width="10" >:</td>
		<td width="704" req="req"> <span class="lookup" id="lookup_material_stock">
         <input type="hidden" name="i_material_stock_id" class="com_id" value="<?=$transient_materials_stock_id?>" />
         <div class="iconic_base iconic_search com_popup" ></div>
         <span class="com_desc"></span>
        <input type="text" class="com_input" size="80" name="module" />
        <input type="hidden" name="i_index" value="<?=$index?>" />
          <input type="hidden" name="i_name" value="<?=$transient_materials_name?>" />
       </span></td>
	</tr>
   
      <tr>
     <td width="199" >Qty
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_qty" type="text" id="i_qty" value="<?=$transient_materials_qty ?>" /></td>
    </tr>
     <tr>
          <td width="17%">Satuan</td>
          <td width="1%">:</td>
          <td width="82%"><input name="i_unit" type="text" id="i_unit" value="<?=$transient_unit_name ?>" readonly="readonly" />
      </td>
      </tr>
    <tr>
     <td width="199" >Harga
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_price" type="text" id="i_price" value="<?=$transient_materials_price ?>" /></td>
    </tr>
	
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan" />
<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
<div id="">
	<table  id="lookup_table_material_stock" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th width="10%">ID</th>
				<th>Cabang</th>
                <th>Nama Cat</th>
                <th>Stock</th>
                <th>Unit</th>
     
           
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
