<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "price/form_action",
		backPage		: "price",
		nextPage		: "price/form"
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
     <td width="196" >Insurance name</td>
        <td width="651"><input name="i_name" type="text" id="i_name" value="<?=$insurance_name ?>"  readonly="readonly"/>
     
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
   </tr>
 </table>
 
 
    <table width="100%" cellpadding="2">
    <tr>
    <td>


   


   
	
	
