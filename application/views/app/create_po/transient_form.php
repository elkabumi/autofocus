<script type="text/javascript">	
$(function(){

	
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
     <input type="hidden" name="i_rs_id" value="<?=$transient_rs_id?>" />
     </td>
    </tr>
    <tr>
     <td width="199" >Nama Parts
     </td>
     <td width="10" >:</td>
     <td width="704" ><input   readonly="readonly" name="i_rs_name" type="text" id="i_rs_name" value="<?=$transient_rs_name ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Qty
     </td>
     <td width="10" >:</td>
     <td width="704" ><input readonly="readonly" name="i_rs_qty" type="text" id="i_rs_qty" value="<?=$transient_rs_qty ?>" /></td>
    </tr>
    
    <tr>
     <td width="199" >Qty Ordered
     </td>
     <td width="10" >:</td>
     <td width="704" ><input readonly="readonly"  name="i_rs_qty_order" type="text" id="i_rs_qty_order" value="<?=$transient_rs_qty_order ?>" /></td>
    </tr>
    <tr>
  			
   	 <td width="199" >Type Order
     </td>
     <td width="10" >:</td>
     <td width="704" ><?php echo  form_dropdown('i_rs_status_id', $rs_status, $transient_rs_status)  ?></td>
    </tr>
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan" />
<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
