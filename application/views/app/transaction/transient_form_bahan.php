<script type="text/javascript">	
$(function(){
createLookUp({
		table_id		: "#lookup_table_material_stock",
		listSource 		: "lookup/material_stock_table_control/1/" + $('input[name="i_stand_id"]').val(),
		dataSource		: "lookup/material_stock_lookup_id",
		component_id	: "#lookup_material_stock",
		filter_by		: [{id : "p1", label : "Cabang"}, {id : "p2", label : "Nama Cat"}, {id : "p3", label : "Stock"}, {id : "p4", label : "Satuan"}],
		onSelect		: load_satuan
	});
	
	function load_satuan()
	{
		var id 	= $('input[name="i_material_stock_id"]').val();
		var transaction_id 	= $('input[name="i_transaction_id"]').val();
		if(id == ""){
			return;
		}
		var data ='id='+id+'/'+transaction_id; 
		
		$.ajax({
			type: 'POST',
			url: '<?=site_url('transaction/load_detail_material')?>',
			data: data,
			dataType: 'json',
			success: function(data){	
				$('input[name="i_unit"]').val(data.content['tm_unit_name']);	
				$('input[name="i_name"]').val(data.content['tm_name']);	
				$('input[name="i_stock_qty"]').val(data.content['tm_stock_qty']);				
				$('input[name="i_count_tm_id"]').val(data.content['tm_id']);				
			}
			
		});
	}
	
	
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table width="100%" cellpadding="4" class="form_layout">
 	<tr>
		<td width="199" >Nama Bahan</td>
        <td width="10" >:</td>
		<td width="704" req="req"> <span class="lookup" id="lookup_material_stock">
         <input type="hidden" name="i_material_stock_id" class="com_id" value="<?=$bahan_stock_id?>" />
         <div class="iconic_base iconic_search com_popup" ></div>
         <span class="com_desc"></span>
        <input type="text" class="com_input" size="80" name="module" />
        <input type="hidden" name="i_index" value="<?=$index?>" />
        
           <input type="hidden" name="i_tm_id" value="<?=$tm_id?>" />
          <input type="hidden" name="i_name" value="<?=$bahan_name?>" />
           <input type="hidden" name="i_tm_qty" value="<?=$bahan_qty?>" />
           <input type="hidden" name="i_count_tm_id" value="<?=$count_tm_id?>" />
       </span></td>
	</tr>
       <tr>
     <td width="199" >Stock
     </td>
     <td width="10" >:</td>
     <td width="704" ><input  readonly="readonly"name="i_stock_qty" type="text" id="i_stock_qty" value="<?=$bahan_stock_qty ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Qty Pemakaian Sebelumnya
     </td>
     <td width="10" >:</td>
     <td width="704" ><input  readonly="readonly"name="i_qty" type="text" id="i_qty" value="<?=$bahan_qty ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Qty
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_tm_qty_form" type="text" id="i_tm_qty_form" value="<?=$bahan_qty_form?>" /></td>
    </tr>
      <tr>
          <td width="17%">Satuan</td>
          <td width="1%">:</td>
          <td width="82%"><input name="i_unit" type="text" id="i_unit" value="<?=$bahan_unit_name ?>" readonly="readonly" />
      </td>
      </tr>
    <tr>
     <td width="199" >Keterangan
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_tm_description" type="text" id="i_tm_description" style="width:400px !important;" value="<?=$bahan_description ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Harga
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_tm_price" type="text" id="i_tm_price" value="<?=$bahan_price ?>" /></td>
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
                <th>Nama Bahan</th>
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
