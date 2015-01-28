<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "summary_report/form_action",
		backPage		: "summary_report",
		nextPage		: "summary_report/form"
	});
	var otb = createTableFormTransient({
		id 				: "#transient_detail",
		listSource 		: "summary_report/detail_table_loader/0/0/0/0/0",
		formSource 		: "summary_report/detail_form/<?=$row_id?>",
		controlTarget	: "summary_report/detail_form_action",
	});
	$('#preview').click(function(){
	
			var date_1 		= ($('input[name="i_date_1"]').val()) ? $('input[name="i_date_1"]').val() : "0";
			var date_2 		= ($('input[name="i_date_2"]').val()) ? $('input[name="i_date_2"]').val() : "0";
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
					otb.fnSettings().sAjaxSource = site_url + "summary_report/detail_table_loader/1/"+new_date_1+"/"+new_date_2;
					otb.fnReloadAjax();
			}
	
	});
	/*
	var otb = createTableFormTransient({
		id 				: "#transient_detail",
		listSource 		: "summary_report/detail_table_loader/0/0/0/0/0",
		formSource 		: "summary_report/detail_form/<?=$row_id?>",
		controlTarget	: "summary_report/detail_form_action",
		//"iDisplayLength"	: 100
	});
	
	
	
	$('#preview').click(function(){
		
		var phase 			= ($('input[name="i_phase_id"]').val()) ? $('input[name="i_phase_id"]').val() : "0";
		var project 		= ($('input[name="i_project_id"]').val()) ? $('input[name="i_project_id"]').val() : "0";
		var material_type 	= ($('input[name="i_product_category_id"]').val()) ? $('input[name="i_product_category_id"]').val() : "0";
		var po_received 	= ($('input[name="i_transaction_id"]').val()) ? $('input[name="i_transaction_id"]').val() : "0";
			//alert(id);
			otb.fnSettings().sAjaxSource = site_url + "summary_report/detail_table_loader/1/"+phase+"/"+project+"/"+material_type+"/"+po_received;
			otb.fnReloadAjax();	
		
	});
	*/
	
	
	
	$('#print_student').click(function(){
			
				
			var date_1 		= ($('input[name="i_date_1"]').val()) ? $('input[name="i_date_1"]').val() : "0";
			var date_2 		= ($('input[name="i_date_2"]').val()) ? $('input[name="i_date_2"]').val() : "0";
			if(date_1 == 0){
				alert('Tanggal Mulai tidak boleh kosong');
			}
			if(date_2 == 0){
					alert('Tanggal Sampai tidak boleh kosong');
			}else{
				if(confirm("Download  Summary Report ?") == true){
					var explode_1  = date_1.split('/');
					var new_date_1  = explode_1[2]+"-"+explode_1[1]+"-"+explode_1[0];
				
					
					var explode_2  = date_2.split('/');
					var new_date_2  = explode_2[2]+"-"+explode_2[1]+"-"+explode_2[0];
				
				
			
			location.href  = site_url + "summary_report/report/"+new_date_1+"/"+new_date_2;
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
		<tr>
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
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
  
   </table>
     </div>
	
	<div class="command_bar">

	 <input type="button" id="print_student" value="download xls"  style="width:100px;" />
	<input type="button" id="preview" value="preview"   />

	 
	 
	</div>
</div>
<!-- table contact -->

</form>

