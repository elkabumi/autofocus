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
     <td width="704" ><input readonly="readonly" name="i_rs_no" type="text" id="i_rs_no" value="<?=$rs_part_number ?>"/>
     <input type="hidden" name="i_index" value="<?=$index?>" />
     <input type="hidden" name="i_tpd_id" value="<?=$tpd_id?>" />
     <input type="hidden" name="i_rs_qty_received" value="<?=$rs_qty_received?>" />
     <input type="hidden" name="i_rs_repair" value="<?=$rs_repair?>" />
     <input type="hidden" name="i_rs_qty" value="<?=$rs_qty?>" />
    
     <input type="hidden" name="i_rs_stock" value="<?=$rs_qty_stock?>" />
    </td>
    </tr>
    <tr>
     <td width="199" >Nama Parts
     </td>
     <td width="10" >:</td>
     <td width="704" ><input   readonly="readonly"name="i_rs_name" type="text" id="i_rs_name" value="<?=$rs_name ?>" /></td>
    </tr>
	<tr>
    <td width="199" >Stock
     </td>
     <td width="10" >:</td>
     <td width="704" ><input readonly="readonly" name="i_rs_stock_form" type="text" id="i_rs_stock_form" value="<?=$rs_qty_stock ?>" /></td>
    </tr>
   	<tr>
     <td width="199" >Jumlah Telah Terpassangx
     </td>
     <td width="10" >:</td>
     <td width="704" ><input readonly="readonly" name="i_rs_qty_install" type="text" id="i_rs_qty_install" value="<?=$rs_qty_install ?>" /></td>
    </tr>
    <tr>
    <td width="199" >Jumlah Pemasangan
     </td>
     <td width="10" >:</td>
     <td width="704" ><input  name="i_rs_install_form" type="text" id="i_rs_install_form" value="<?=$rs_qty_install_form ?>" /></td>
    </tr>
    <tr>
   	<td>Tanggal Pemasangan</td>
       <td width="10" >:</td>
       <td><input name="i_rs_install_date" type="text" id="i_rs_install_date" value="<?= format_new_date($rs_install_date) ?>" class="date_input"/></td>
     </tr>
     <tr>
	  <td width="158" valign="top">Keterangan</td>
    <td width="10" valign="top">:</td>
    <td width="745" valign="top"><textarea name="i_rs_install_desc" id="i_rs_install_desc" cols="45" rows="5"><?=$rs_install_desc?></textarea></td>
   	</tr>
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan" />
<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>
