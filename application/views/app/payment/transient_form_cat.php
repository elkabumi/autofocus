<script type="text/javascript">	
$(function(){

	
});
</script>
<form class="subform_area">
<div class="form_area_frame">
<table width="100%" cellpadding="4" class="form_layout">
 <tr>
     <td width="199" >Nama Bahan / Cat
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_tm_name" type="text" id="i_tm_name" value="<?=$tm_name ?>" style="width:400px !important;"/>
     <input type="hidden" name="i_index" value="<?=$index?>" />
     </td>
    </tr>
    <tr>
     <td width="199" >Qty
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_tm_qty" type="text" id="i_tm_qty" value="<?=$tm_qty ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Keterangan
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_tm_description" type="text" id="i_tm_description" style="width:400px !important;" value="<?=$tm_description ?>" /></td>
    </tr>
    <tr>
     <td width="199" >Harga
     </td>
     <td width="10" >:</td>
     <td width="704" ><input name="i_tm_price" type="text" id="i_tm_price" value="<?=$tm_price ?>" /></td>
    </tr>
	
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan" />
<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
