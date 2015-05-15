<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "warehouse_material/form_action",
		backPage		: "warehouse_material",
		nextPage		: "warehouse_material"
	});
	createLookUp({
		table_id		: "#lookup_table_material",
		table_width		: 400,
		listSource 		: "lookup/material_table_control/1", //1 untuk type  bahan
		dataSource		: "lookup/material_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_material",
		filter_by		: [{id : "p1", label : "Nama"}],
		onSelect		: load_satuan
	});
	createLookUp({
		table_id		: "#lookup_table_stand",
		table_width		: 400,
		listSource 		: "lookup/stand_table_control",
		dataSource		: "lookup/stand_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_stand",
		filter_by		: [{id : "p1", label : "Nama Cabang"}]
	});
	
	
	function load_satuan()
	{
		var id 	= $('input[name="i_material_id"]').val();
		
		if(id == ""){
			return;
		}
		var data ='id='+id; 
		
		$.ajax({
			type: 'POST',
			url: '<?=site_url('warehouse_material/load_satuan')?>',
			data: data,
			dataType: 'json',
			success: function(data){	
				$('input[name="i_unit"]').val(data.content['unit_name']);				
		
			}
			
		});
	}
	createDatePicker();
});

</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	<tr>
   	<td width="17%">Nama Bahan
               
            </td>
			<td width="1%" >:</td>
			<td  width="82%" > <span class="lookup" id="lookup_material">
         <input type="hidden" name="i_material_id" class="com_id" value="<?=$material_id?>" />
         <input type="text" class="com_input" size="6" /> 
         <input type="hidden" name="row_id" value="<?=$row_id?>" />
         <div class="iconic_base iconic_search com_popup"></div>
       </span></td> 
		</tr>
    <tr>
      <td>Cabang
        		</td>
      <td>:</td>
      <td>  <span class="lookup" id="lookup_stand">
				<input type="hidden" name="i_stand_id" class="com_id" value="<?=$stand_id?>" />
               
				<input type="text" class="com_input" />
				 <div class="iconic_base iconic_search com_popup"></div>
				</span></td>
    </tr>
      <tr>
          <td width="17%">Qty</td>
          <td width="1%">:</td>
          <td width="82%"><input name="i_qty" type="text" id="i_qty" value="<?=$material_stock_qty	 ?>" /></td>
        </tr>
      <tr>
          <td width="17%">Satuan</td>
          <td width="1%">:</td>
          <td width="82%"><input name="i_unit" type="text" id="i_unit" value="<?=$unit_name ?>" readonly="readonly" />
      </td>
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
	<table id="lookup_table_stand" cellpadding="0" cellspacing="0" border="0" class="display" > 
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
<div id="">
	<table id="lookup_table_material" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
				<th>Nama</th>
                <th>Satuan</th>
            
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