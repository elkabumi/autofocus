<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "stand/form_action",
		backPage		: "stand",
		nextPage		: "stand"
	});
	
	createLookUp({
		table_id		: "#lookup_table_employee",
		table_width		: 400,
		listSource 		: "lookup/employee_table_control/",
		dataSource		: "lookup/employee_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_employee",
		filter_by		: [{id : "p1", label : "Kode"},{id : "p2", label : "Nama"}]
	});
	
	createDatePicker();
});

</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	<tr>
     <td width="196">Kode</td>
     <td width="651"><input name="i_code" type="text" id="i_code" value="<?=$stand_code ?>" />
     <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
   </tr>
   
    <tr>
     <td width="196">Nama</td>
     <td width="651"><input name="i_name" type="text" id="i_name" value="<?=$stand_name ?>" size="10"/></td>
     </tr>
     <tr>
     <td req= "req">Leader</td>
        <td><span class="lookup" id="lookup_employee">
				<input type="hidden" name="i_leader" class="com_id" value="<?=$stand_leader?>" />
				<input type="text" class="com_input" name="i_employee_name"/>
				<div class="iconic_base iconic_search com_popup"></div>
				</span>	
       </td>
     </tr>
 <tr>
   <tr>
     <td width="196">Telepon</td>
     <td width="651"><input name="i_phone" type="text" id="i_phone" value="<?=$stand_phone ?>" size="10"/></td>
     </tr>
   
   
     <td width="196">Alamat</td>
     <td width="651"><textarea name="i_address" id="i_address" cols="45" rows="5"><?= $stand_address ?></textarea></td>
     </tr>
  <tr>
    <td width="196">Keterangan</td>
    <td width="651"><textarea name="i_description" id="i_description" cols="45" rows="5"><?= $stand_description ?></textarea></td>
    </tr>

</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="cancel" value="Batal" /> 
</div>
</div>
</form>

<div id="">
	<table id="lookup_table_employee" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
				<th>NIK </th>
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