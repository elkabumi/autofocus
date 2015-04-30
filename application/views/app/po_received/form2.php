<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "warehouse/form_action",
		backPage		: "warehouse",
		nextPage		: "warehouse"
	});
	
	createDatePicker();
});

</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
<table  width="100%" cellpadding="4" class="form_layout">
	<tr>
     <td width="196" >Nama Parts</td>
       <td width="651"><input  readonly="readonly" name="i_name" type="text" id="i_name" value="<?=$rs_name ?>" />
	 <input type="hidden" name="row_id" value="<?=$row_id?>" />
      <input type="hidden" name="i_order_received" value="<?=$order_received?>" /></td>
   </tr>  
    <tr>
     <td>Jumlah Sisa Order</td>
       <td><input  readonly="readonly" name="i_order" type="text" id="i_order" value="<?=$order ?>" size="70" /></td>
     </tr>
     <tr>
     <td>Jumlah Received</td>
        <td><input name="i_received" type="text" id="i_received" value="<?=$received ?>" size="70" /></td>
     </tr>
	<tr>
      <td>Tanggal Received</td>
        <td><input type="text" name="i_date" class="date_input" size="15" value="<?=$tpdh_date?>" /></td>
        
   </tr>
     <td>Keterangan</td>
       <td><textarea name="i_description" type="text" id="i_description"><?=$tpdh_desc ?></textarea></td>
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
