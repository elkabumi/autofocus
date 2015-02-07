<script type="text/javascript">	
$(function(){
	createLookUp({
		table_id		: "#lookup_table_workshop_service",
		table_width		: 400,
		listSource 		: "lookup/workshop_service_table_control",
		dataSource		: "lookup/workshop_service_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_workshop_service",
		filter_by		: [{id : "p1", label : "Nama"}],
		onSelect		: load_workshop_service
	});
	
	function load_workshop_service(id){
	
		if(id == ""){
			return;
		}
		
		var data ='workshop_service_id='+id; 
		
		$.ajax({
			type: 'POST',
			url: '<?=site_url('transaction/load_workshop_service')?>',
			data: data,
			dataType: 'json',
			success: function(data){					
				$('input[name="i_workshop_service_price"]').val(data.content['workshop_service_price']);
				$('input[name="i_workshop_service_job_price"]').val(data.content['workshop_service_job_price']);
				$('input[name="i_workshop_service_name"]').val(data.content['workshop_service_name']);
			}
			
		});
		
	}
	
			
	createDatePicker();
	
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table width="100%" cellpadding="4" class="form_layout">
	<tr>
   <td>Tanggal</td>
       
       <td><input name="i_transaction_detail_date" type="text" id="i_transaction_detail_date" value="<?= format_new_date($transaction_detail_date) ?>" class="date_input"/></td>
     </tr>
     <tr>
     <td>Jasa</td>
       <td>
       	 <span class="lookup" id="lookup_workshop_service">
        <input type="hidden" name="i_workshop_service_id" class="com_id" value="<?=$workshop_service_id ?>" />
         <div class="iconic_base iconic_search com_popup"></div>
         <span class="com_desc"></span>
        <input type="text" class="com_input" size="20" name="module" style="width:400px !important;" />
        <input type="hidden" name="i_index" value="<?=$index?>" />
        <input type="hidden" name="i_transaction_detail_id" value="<?=$transaction_detail_id?>" />
        
       </span>
          

</td>
     </tr>
    <tr>
     <td>Harga</td> 
       <td><input name="i_workshop_service_price" type="text" id="i_workshop_service_price" value="<?=$workshop_service_price ?>" readonly="readonly" size="10"/>
<input name="i_workshop_service_name" type="hidden" id="i_workshop_service_name" value="" readonly="readonly" size="10"/>
       </td>
     </tr>

      <tr>
     <td>Harga Borongan</td> 
       <td><input name="i_workshop_service_job_price" type="text" id="i_workshop_service_job_price" value="<?=$workshop_service_job_price ?>" readonly="readonly" size="10"/></td>
     </tr>
     <tr>
     <td>Progress</td> 
       <td><input name="i_transaction_detail_progress" type="text" id="i_transaction_detail_progress" value="<?=$transaction_detail_progress ?>" size="10"/> &nbsp;%</td>
     </tr>

</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Save" />
<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Cancel"  />
</div>
</form>
<div id="">
	<table id="lookup_table_workshop_service" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th>ID</th>
            	<th>Nama Jasa</th>
				<th>Harga</th>
				<th>Harga Borongan</th>
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



