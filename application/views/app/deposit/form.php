<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "deposit/form_action",
		backPage		: "deposit",
		nextPage		: "deposit"
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
	 <input type="hidden" name="row_id" value="<?=$row_id?>" /></td>
 
   </tr>  
    <tr>
     <td>Jumlah Order</td>
       <td><input  readonly="readonly" name="i_order" type="text" id="i_order" value="<?=$tpd_detail_qty ?>" size="70" /></td>
     </tr>
     <tr>
     <td>Jumlah Received</td>
        <td><input name="i_received" type="text" id="i_received" value="<?=$tpd_detail_received ?>" size="70" /></td>
     </tr>
   
 </table>
</div>
<div class="command_bar">
	<input type="button" id="cancel" value="Close" /> 
</div>
</div>
</form>
