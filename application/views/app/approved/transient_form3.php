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
     <td width="704" ><input   readonly="readonly"name="i_rs_name" type="text" id="i_rs_name" value="<?=$transient_rs_name ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Qty
     </td>
     <td width="10" >:</td>
     <td width="704" ><input  readonly="readonly" name="i_rs_qty" type="text" id="i_rs_qty" value="<?=$transient_rs_qty ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Harga Parts
     </td>
     <td width="10" >:</td>
     <td width="704" ><input   readonly="readonly" name="i_rs_repair" type="text" id="i_rs_repair" value="<?=$transient_rs_repair ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Harga Approved Parts
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_rs_approved_repair" type="text" id="i_rs_repair" value="<?=$transient_rs_approved_repair ?>" /></td>
    </tr>
	
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan" />
<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
