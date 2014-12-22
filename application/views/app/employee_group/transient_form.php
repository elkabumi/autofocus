<script type="text/javascript">	
$(function(){
	createLookUp({
		table_id		: "#lookup_table_employee",
		table_width		: 400,
		listSource 		: "lookup/employee_table_control",
		dataSource		: "lookup/employee_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_employee",
		filter_by		: [{id : "p1", label : "Nama"}],
		onSelect		: load_employee
	});
	
	function load_employee(id){
	
		if(id == ""){
			return;
		}
		
		var data ='employee_id='+id; 
		
		$.ajax({
			type: 'POST',
			url: '<?=site_url('employee_group/load_employee')?>',
			data: data,
			dataType: 'json',
			success: function(data){					
				$('input[name="i_nip"]').val(data.content['employee_nip']);
				$('input[name="i_name"]').val(data.content['employee_name']);
				$('input[name="i_address"]').val(data.content['employee_address']);
				$('input[name="i_phone"]').val(data.content['employee_phone']);
			}
			
		});
		
	}
	
	createDatePicker();
	
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table cellpadding="2" class="form_layout">
	<tr>
     <td>Employee</td>
        <td><span class="lookup" id="lookup_employee">
				<input type="text" name="i_employee_id" class="com_id" value="<?=$employee_id?>" />
                 <input type="hidden" name="i_index" value="<?=$index?>" />
                <input type="text" class="com_input" />
                <div class="iconic_base iconic_search com_popup"></div>
				</span>	
       </td>
     </tr>
     <tr>
     <td>Nip</td>
       <td><input name="i_nip" type="text" id="i_nip" value="<?=$employee_nip ?>" /></td>
     </tr>
     <tr>
     <td>Name</td>
       <td><input name="i_name" type="text" id="i_name" value="<?=$employee_name ?>" /></td>
     </tr>
     <tr>
     <td>Alamat</td>
       <td><input name="i_address" type="text" id="i_address" value="<?=$employee_address ?>" /></td>
     </tr>
     <tr>
     <td>Telepon</td>
       <td><input name="i_phone" type="text" id="i_phone" value="<?=$employee_phone ?>" /></td>
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
	<table id="lookup_table_employee" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
            	<th>Nip</th>
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



