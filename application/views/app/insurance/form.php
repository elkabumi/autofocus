<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "insurance/form_action",
		backPage		: "insurance",
		nextPage		: "insurance"
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
     <td width="196" >Nama Asuransi</td>
       <td width="651"><input name="i_name" type="text" id="i_name" value="<?=$insurance_name ?>" />
     
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
   </tr>
   <tr>
     <td>PPh %</td>
       <td><input name="i_pph" type="text" id="i_pph" value="<?=$insurance_pph ?>" size="70" /></td>
     </tr>
    <tr>
     <td>Alamat</td>
       <td><input name="i_addres" type="text" id="i_addres" value="<?=$insurance_addres ?>" size="70" /></td>
     </tr>
  <tr>
     <td>Telepon</td>
       <td><input name="i_phone" type="text" id="i_phone" value="<?=$insurance_phone ?>" size="70" /></td>
  </tr>
  <tr>
     <td>Create Date</td>
       <td><input name="i_date" type="text" id="i_date" value="<?=$insurance_date ?>" class="date_input" size="10"/></td>
   </tr>

   
  <tr>
    <td width="189" valign="top">Keterangan</td>
      <td><textarea name="i_description" id="i_description" cols="45" rows="5"><?= $insurance_description ?></textarea></td>
    </tr>
 </table>
 
 
    <table width="100%" cellpadding="2">
    <tr>
    <td>


   


   
	
	
