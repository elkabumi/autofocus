<script type="text/javascript">	
$(function(){

	createDatePicker();
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table width="100%" cellpadding="4" class="form_layout">
 <tr>
     <td width="199" >No Parts
     </td>
     <td width="10" >:</td>
     <td width="704" ><input readonly="readonly" name="i_rs_no" type="text" id="i_rs_no" value="<?=$transient_rs_part_number ?>"/>
     <input type="hidden" name="i_index" value="<?=$index?>" />
     <input type="hidden" name="i_tpd_id" value="<?=$transient_tpd_id?>" />
     
     <input type="hidden" name="i_rs_received" value="<?=$transient_rs_qty_received?>" />
     
     <input type="hidden" name="i_rs_install" value="<?=$transient_rs_qty_install?>" />
     
     <input type="hidden" name="i_rs_order" value="<?=$transient_rs_qty_order?>" />
     </td>
    </tr>
    <tr>
     <td width="199" >Nama Parts
     </td>
     <td width="10" >:</td>
     <td width="704" ><input   readonly="readonly" name="i_rs_name" type="text" id="i_rs_name" value="<?=$transient_rs_name ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Qty Sisa Ordered
     </td>
     <td width="10" >:</td>
     <td width="704" ><input readonly="readonly" name="i_qty_sisa_order" type="text" id="i_qty_sisa_order" value="<?=$transient_rs_qty_sisa_order ?>" /></td>
    </tr>
    
    <tr>
     <td width="199" >Qty received
     </td>
     <td width="10" >:</td>
     <td width="704" ><input  name="i_qty_received_form" type="text" id="i_qty_received_form" value="<?=$transient_rs_qty_received_form ?>" /></td>
    </tr>
    <tr>
  			
   	 <td width="199" >Type Order
     </td>
     <td width="10" >:</td>
    <td width="704" ><input readonly="readonly"  name="i_rs_status_id" type="text" id="i_rs_status_id" value="<?=$transient_rs_status ?>" /></td>
   
    </tr>
    <tr>
      <td>Tanggal Received  </td>
      <td width="10" >:</td>
      <td><input type="text" name="i_date" class="date_input" size="15" value="<?=$transient_received_date?>" /></td>
        
   </tr>
   <tr>
     <td>Keterangan</td>
     <td width="10" >:</td>
       <td><textarea name="i_description" type="text" id="i_description"><?=$transient_received_desc
	    ?></textarea></td>
     </tr>
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan" />
<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
