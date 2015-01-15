<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "transaction_report/report",
		backPage		: "transaction_report",
		nextPage		: "transaction_report"
	});
	
	$('#print').click(function(){
			
				var date1 		= ($('input[name="i_date_1"]').val()) ? $('input[name="i_date_1"]').val() : "0";
				var date2 		= ($('input[name="i_date_2"]').val()) ? $('input[name="i_date_2"]').val() : "0";
				var trans 		= ($('select[name="i_transaction_type_name"]').val());
				
				var date1 =  date1.replace("/", "");
				var date1 =  date1.replace("/", "");
				var date2 =  date2.replace("/", "");
				var date2 =  date2.replace("/", "");
			location.href  = site_url + "salary_report/report/"+date1+"/"+date2;
		
	});
	
	createDatePicker();
});


</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
<table class="form_layout">
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
	<input type="button" id="print" value="Cetak"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="cancel" value="Batal" /> 
</div>
</div>
</form>



