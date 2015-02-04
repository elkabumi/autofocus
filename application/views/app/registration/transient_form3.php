<script type="text/javascript">	
$(function(){
ss
	
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table width="100%" cellpadding="4" class="form_layout">
 <tr>
     <td width="199" >No Parts
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_rs_no" type="text" id="i_rs_no" value="<?=$rs_part_number ?>"/>
     <input type="hidden" name="i_index" value="<?=$index?>" />
     </td>
    </tr>
    <tr>
     <td width="199" >Nama Parts
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_rs_name" type="text" id="i_rs_name" value="<?=$rs_name ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Qty
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_rs_qty" type="text" id="i_rs_qty" value="<?=$rs_qty ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Harga Parts
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_rs_repair" type="text" id="i_rs_repair" value="<?=$rs_repair ?>" /></td>
    </tr>
	
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan" />
<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
