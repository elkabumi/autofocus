<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "employee_group/form_action",
		backPage		: "employee_group",
		nextPage		: "employee_group/form"
	});

	$('#enable').click(function(){
			if(alert("Silahkan kilik tombol save untuk konfirmasi penyimpanan")){
	}
	});
	createDatePicker();
	//updateAll(); 
});
</script>
<form class="form_class" id="id_form_nya">	
<div class="form_area">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	<tr>
     <td width="196" >Nama Group</td>
       <td width="651"><input name="i_group_name" type="text" id="i_group_name" value="<?=$employee_group_name ?>" />
     
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
   </tr>
  <tr>
    <td width="189" valign="top">Keterangan</td>
      <td><textarea name="i_description" id="i_description" cols="45" rows="5"><?= $employee_group_description ?></textarea></td>
    </tr>
 </table>
 
 
    <table width="100%" cellpadding="2">
    <tr>
    <td>


   


   
	
	
