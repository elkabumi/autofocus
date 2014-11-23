<script type="text/javascript">	
$(function(){

	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "periode/form_action",
		backPage		: "periode",
		nextPage		: "periode"
	});	
});
</script>

<form id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
<table class="form_layout">
	<tr>
     <td width="10%">Kode</td>
     <td>
       <input type="hidden" name="row_id" value="<?=$row_id?>" />
       <input name="period_code" type="text" id="textfield7" readonly="readonly" class="required" value="<?=$period_code?>" size="4" maxlength="4" /></td>
     </tr>
   <tr>
     <td>Bulan</td>
     <td>
       <?=form_dropdown('period_month', $bulan, $period_month)?>
     </td>
     </tr>
   <tr>
     <td>Tahun</td>
     <td><input name="period_year" type="text" class="required" value="<?=$period_year?>" size="4" /></td>
     </tr>
     <tr>
     <td>Status</td>
     <td><p>
       <label style="margin-left:20%;">
         <input type="radio" name="period_closed" value="1" id="period_closed1" <?php if($period_closed == 1){?> checked="checked"<?php } ?> />
         Aktif</label>
       <br />
       <label style="margin-left:20%;">
         <input type="radio" name="period_closed" value="0" id="period_closed2" <?php if($period_closed == 0){?> checked="checked"<?php } ?> />
         Tidak Aktif</label>
      
     </p></td>
     </tr>
   <tr>
     <td>Keterangan</td>
     <td><textarea name="period_description"><?=$period_description?></textarea></td>
     </tr>   
</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="cancel" value="Batal" /> 
</div>
</div>
</form>

