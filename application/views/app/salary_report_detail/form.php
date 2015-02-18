<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "salary_report_detail/form_action",
		backPage		: "salary_report_detail",
		nextPage		: "salary_report_detail/form"
	});
	var otb = createTableFormTransient({
		id 				: "#transient_detail",
		listSource 		: "salary_report_detail/detail_table_loader/0/0/0/0/0",
		formSource 		: "salary_report_detail/detail_form/<?=$row_id?>",
		controlTarget	: "salary_report_detail/detail_form_action",
	});
	
	createLookUp({
		table_id		: "#lookup_table_employee_group",
		table_width		: 400,
		listSource 		: "lookup/employee_group_table_control",
		dataSource		: "lookup/employee_group_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_employee_group",
		filter_by		: [{id : "p1", label : "Kode"},{id : "p2", label : "Nama"}]
	});
	
	
	$('#preview').click(function(){
	
			var date_1 		= ($('input[name="i_date_1"]').val()) ? $('input[name="i_date_1"]').val() : "0";
			var date_2 		= ($('input[name="i_date_2"]').val()) ? $('input[name="i_date_2"]').val() : "0";
			var employee_group_id = ($('input[name="i_employee_group_id"]').val()) ? $('input[name="i_employee_group_id"]').val() : "0";
		
			if(date_1 == 0){
				alert('Tanggal Mulai tidak boleh kosong');
			}
			if(date_2 == 0){
					alert('Tanggal Sampai tidak boleh kosong');
			}else{
					var explode_1  = date_1.split('/');
					var new_date_1  = explode_1[2]+"-"+explode_1[1]+"-"+explode_1[0];
				
					
					var explode_2  = date_2.split('/');
					var new_date_2  = explode_2[2]+"-"+explode_2[1]+"-"+explode_2[0];
					otb.fnSettings().sAjaxSource = site_url + "salary_report_detail/detail_table_loader/1/"+new_date_1+"/"+new_date_2+"/"+employee_group_id;
					otb.fnReloadAjax();
			}
	
	});
	
	$('#print_student').click(function(){
			
				
			var date_1 		= ($('input[name="i_date_1"]').val()) ? $('input[name="i_date_1"]').val() : "0";
			var date_2 		= ($('input[name="i_date_2"]').val()) ? $('input[name="i_date_2"]').val() : "0";
			var employee_group_id = ($('input[name="i_employee_group_id"]').val()) ? $('input[name="i_employee_group_id"]').val() : "0";
		
			if(date_1 == 0){
				alert('Tanggal Mulai tidak boleh kosong');
			}
			if(date_2 == 0){
					alert('Tanggal Sampai tidak boleh kosong');
			}else{
				if(confirm("Download  Laporan Gaji Harian ?") == true){
					var explode_1  = date_1.split('/');
					var new_date_1  = explode_1[2]+"-"+explode_1[1]+"-"+explode_1[0];
				
					
					var explode_2  = date_2.split('/');
					var new_date_2  = explode_2[2]+"-"+explode_2[1]+"-"+explode_2[0];
				
				
			
			location.href  = site_url + "salary_report_detail/report/"+new_date_1+"/"+new_date_2+"/"+employee_group_id;
			}
		}
	});
	
	
	createDatePicker();
	//updateAll(); 
});
</script>

<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
	 <table>
    <tr>
		 <td><input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
  	 </tr>
     <tr>
         <td>Mulai</td>
         <td width="1%">:</td>
         <td><input name="i_date_1" type="text" id="i_date_1" value="<?=$date_1 ?>" class="date_input" size="10"/></td>
     </tr>
     <tr>
   		<td>Sampai</td>
   		<td width="1%">:</td>
       	<td><input name="i_date_2" type="text" id="i_date_2" value="<?=$date_1 ?>" class="date_input" size="10"/></td>
     </tr>
     <tr>
          <td width="23%">Tim Kerja</td>
          <td width="1%">:</td>
          <td width="76%"> <span class="lookup" id="lookup_employee_group">
                    <input type="hidden" name="i_employee_group_id" class="com_id" value="<?=$employee_group_id?>" />
                    <input type="hidden" name="row_id" value="<?=$row_id?>" />
                    <input type="text" class="com_input" />
                      <div class="iconic_base iconic_search com_popup"></div>
                        <span class="com_desc"></span>
                    </span></td>
     </tr>
   </table>
     </div>
	
	<div class="command_bar">

	 <input type="button" id="print_student" value="download xls"  style="width:100px;" />
	<input type="button" id="preview" value="preview"   />

	 
	 
	</div>
</div>
<!-- table contact -->

</form>

<div id="">
	<table id="lookup_table_employee_group" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
			<th>ID</th>
				<th>Nama</th>
				<th>Keterangan</th>
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