<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "material/form_action",
		backPage		: "material",
		nextPage		: "material"
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
	
	createDatePicker();
});

</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	<tr>
       <td width="17%">Nama Bahan</td>
      <td  width="1%">:</td>
     <td width="82%"><input name="i_name" type="text" id="i_name" value="<?=$material_name ?>" />
	 <input type="hidden" name="row_id" value="<?=$row_id?>" />
     </td>
   </tr>  
   <tr>
       <td>Satuan</td>
      <td>:</td>
      <td>  <?php echo  form_dropdown('i_unit_id', $unit,$unit_id)  ?>
     </td>
   </tr>
      <tr>
    <td width="158" valign="top">Keterangan</td>
    <td width="10" valign="top">:</td>
    <td width="745" valign="top"><textarea name="i_description" id="i_description" cols="45" rows="5"><?=$material_desc?></textarea></td>
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
