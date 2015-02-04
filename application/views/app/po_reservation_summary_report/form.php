<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "po_reservation_summary_report/form_action",
		backPage		: "po_reservation_summary_report",
		nextPage		: "po_reservation_summary_report/form"
	});
	

	var otb = createTableFormTransient({
		id 				: "#transient_detail",
		listSource 		: "po_reservation_summary_report/detail_table_loader",
		formSource 		: "po_reservation_summary_report/detail_form/<?=$row_id?>",
		controlTarget	: "po_reservation_summary_report/detail_form_action"
	});
	
	$('#preview').click(function(){

			var stand 		= ($('select[name="i_stand_id"]').val()) ? $('select[name="i_stand_id"]').val() : "0";
			//alert(id);
			otb.fnSettings().sAjaxSource = site_url + "po_reservation_summary_report/detail_table_loader/1/"+stand;
			otb.fnReloadAjax();	
	});
	
	/*function load_material(i_material)
	{
		if(i_material == 0){
			var material 	= 0;
		}else if($('select[name="i_material_id"]').val() == ""){
			var material 	= 0;
		}else{
			var material = $('select[name="i_material_id"]').val();
		}
		
			otb.fnSettings().sAjaxSource = site_url + "material_report/detail_table_loader/1/"+material;
			otb.fnReloadAjax();	
	}
	
	
	$('select[name="i_material_id"]').change(function(){
		load_material(1);
		//alert('test');
	});*/

	
	$('#print_student').click(function(){
			if(confirm("Download Laporan Data Stock ") == true){	
			var stand 	= ($('select[name="i_stand_id"]').val()) ? $('select[name="i_stand_id"]').val() : "0";
			//alert(id);
			location.href  = site_url + "po_reservation_summary_report/report/"+stand;
		}
	});
	
	
	createDatePicker();
	//updateAll(); 
});
</script>

<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
<table width="100%" cellpadding="4" class="form_layout">
    <tr>
        <td width="27%">Nama Cabang</td>
		<td width="73%"><?php echo  form_dropdown('i_stand_id', $stand_id)  ?>
          				<input type="hidden" name="row_id" value="<?=$row_id?>" />
    	</td>
	</tr>
</table>
     </div>
	<div class="command_bar">

	<input type="button" id="print_student" value="Download Excel"  style="width:150px;" />
		<input type="button" id="preview" value="Preview"   />

	 
	</div>
</div>
<!-- table contact -->

</form>
