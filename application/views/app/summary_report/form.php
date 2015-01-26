<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "summary_report/form_action",
		backPage		: "summary_report",
		nextPage		: "summary_report/form"
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
	
	
	
	
	$('#print_student').click(function(){
			if(confirm("Download Po Received Summary Report ?") == true){
				var phase 			= ($('input[name="i_phase_id"]').val()) ? $('input[name="i_phase_id"]').val() : "0";
				var project 		= ($('input[name="i_project_id"]').val()) ? $('input[name="i_project_id"]').val() : "0";
				var material_type	 = ($('input[name="i_product_category_id"]').val()) ? $('input[name="i_product_category_id"]').val() : "0";
				var po_received		 = ($('input[name="i_transaction_id"]').val()) ? $('input[name="i_transaction_id"]').val() : "0";
				
			
			location.href  = site_url + "summary_report/report/"+phase+"/"+project+"/"+material_type+"/"+po_received;
	}
	});
	*/
	
	createDatePicker();
	//updateAll(); 
});
</script>

<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
	<table width="100%" cellpadding="4" class="form_layout">
    <tr>
      <td width="196">Tanggal </td>
      <td width="651"><input name="i_date_1" type="text" id="i_date_1" value="<?= format_new_date($date_1) ?>" class="date_input"/> </td>
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

