<script type="text/javascript">	
$(function(){
	createLookUp({
		table_id		: "#lookup_table_transaction_type",
		table_width		: 400,
		listSource 		: "lookup/transaction_type_table_control",
		dataSource		: "lookup/transaction_type_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_transaction_type",
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
     <td>Type Transaksi</td>
        <td><span class="lookup" id="lookup_transaction_type">
				<input type="hidden" name="i_transaction_type_id" class="com_id" value="<?=$transaction_type_id?>" />
                 <input type="hidden" name="i_index" value="<?=$index?>" />
                <input type="text" class="com_input" />
                <div class="iconic_base iconic_search com_popup"></div>
				</span>	
       </td>
     </tr>
     <tr>
     <td>Tanggal awal plain</td>
       <td><input name="i_first_date" type="text" id="i_first_date" value="<?=$transaction_detail_plain_first_date ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal akhir plain</td>
       <td><input name="i_last_date" type="text" id="i_last_date" value="<?=$transaction_detail_plain_last_date	 ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal Aktual</td>
       <td><input name="i_actual_date" type="text" id="i_actual_date" value="<?=$transaction_detail_actual_date ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Tanggal target selesai</td>
       <td><input name="i_target_date" type="text" id="i_target_date" value="<?=$transaction_detail_target_date ?>" class="date_input"/></td>
     </tr>
     <tr>
    <td width="189" valign="top">Keterangan</td>
      <td width="745"><textarea name="i_description" id="i_description" cols="45" rows="5"><?= $transaction_detail_description ?></textarea></td>
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
	<table id="lookup_table_transaction_type" cellpadding="0" cellspacing="0" border="0" class="display" > 
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



