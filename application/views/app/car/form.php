<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "car/form_action",
		backPage		: "car",
		nextPage		: "car"
	});
	
	createLookUp({
		table_id		: "#lookup_table_car_model",
		table_width		: 400,
		listSource 		: "lookup/car_model_table_control",
		dataSource		: "lookup/car_model_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_car",
		filter_by		: [{id : "p1", label : "Vendor Mobil"}, {id : "p2", label : "Model Mobil"}]
	});
	
	createDatePicker();
});

</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	<tr>
     <td width="196" >Nopol</td>
       <td width="651"><input name="i_nopol" type="text" id="i_nopol" value="<?=$car_nopol ?>" />
     
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
   </tr>
   
    <tr>
     <td>Model</td>
       <td>
       <span class="lookup" id="lookup_car">
				<input type="hidden" name="i_car_model_id" class="com_id" value="<?=$car_model_id?>" />
              
				<input type="text" class="com_input" style="width:300px !important; "/>
				  <div class="iconic_base iconic_search com_popup"></div>
                    <span class="com_desc"></span>
				</span>
       </td>
     </tr>
      <tr>
     <td>No Mesin</td>
       <td><input name="i_no_machine" type="text" id="i_no_machine" value="<?=$car_no_machine ?>" size="70" /></td>
     </tr>
      <tr>
     <td>No Rangka</td>
       <td><input name="i_no_rangka" type="text" id="i_no_rangka" value="<?=$car_no_rangka ?>" size="70" /></td>
     </tr>
 
   <tr>
     <td>Warna</td> 
     <td><input name="i_color" type="text" id="i_color" value="<?=$car_color ?>" size="10"/></td>
   </tr>
   <tr>
     <td>Tipe Mobil</td> 
     <td><input name="i_type" type="text" id="i_type" value="<?=$car_type ?>" size="10"/></td>
   </tr>
    <tr>
     <td>Tahun</td> 
     <td><input name="i_year" type="text" id="i_year" value="<?=$car_year ?>" size="10" style="width:100px;"/></td>
   </tr>
  <tr>
    <td width="196" valign="top">Keterangan</td>
      <td><textarea name="i_description" id="i_description" cols="45" rows="5"><?= $car_description ?></textarea></td>
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
	<table id="lookup_table_car_model" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
            <th>Vendor Mobil</th>
			<th>Model Mobil</th>
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
