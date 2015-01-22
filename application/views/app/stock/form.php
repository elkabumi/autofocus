<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "stock/form_action",
		backPage		: "stock",
		nextPage		: "stock"
	});
	
	createDatePicker();
});

</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
	<table width="100%" cellpadding="4" class="form_layout">
	<tr>
     <td width="196" >Kode</td>
       <td width="651"><input readonly="readonly" name="i_code" type="text" id="i_code" value="<?=$product_code ?>" />
     
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
   </tr>
      <tr>
     <td>Nama</td>
       <td><input name="i_name" type="text" id="i_name" value="<?=$product_name ?>" readonly="readonly" size="70" /></td>
     </tr>
       <tr>
     <td>Cabang</td>
       <td><input name="i_stand_name" readonly="readonly" type="text" id="i_stand_name" value="<?=$stand_name ?>" size="70" /></td>
     </tr>
      <tr>
     <td>Jumlah</td>
       <td><input name="i_qty" type="text" id="i_qty" value="<?=$product_stock_qty ?>" size="70" /></td>
     </tr>
  
   </table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Save"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="cancel" value="Close" /> 
</div>
</div>
</form>

