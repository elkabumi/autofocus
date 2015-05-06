<script type="text/javascript">	
$(function(){
	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "coa/coa_form_action",
		backPage		: "coa/coa",
		nextPage		: "coa/coa"
	});
	
	//updateAll(); // tambahkan ini disetiap form
});</script>
<form id="id_form_nya">
<!-- panel loader status -->
<div class="form_area">

<!-- panel input -->
<table class="form_layout">
  <tr>
    <td width="150">Induk</td>
    <td><input type="hidden" id="row_id" name="row_id" value="<?=$row_id?>" />
      <input type="hidden" name="i_coa_hierarchy" value='<?=$coa_hierarchy?>' />
      <input type="hidden" name="i_coa_id" class="com_id" value="<?=$coa_id?>" />
      <input type="hidden" name="i_coa_level" value='<?=$coa_level?>' />
      <input type="hidden" name="i_coa_parent" value='<?=$parent_coa_id?>' />
      <input type="hidden" name="i_coa_group" value='<?=$coa_group?>' /><input type="text" name="i_parent_code" value='<?=$parent_code?>' size='15' readonly="readonly" />
      <input type="text" name="i_parent_name" value='<?=$parent_name?>' size='25' readonly="readonly" />
      </td>
  </tr>
  <tr>
    <td width="150">Peringkat</td>
    <td><input type="text" id="i_coa_level" size="1" value="<?=$coa_level?>" readonly="readonly"/>
    </td>
  </tr>
  <tr>
    <td width="150">Tipe</td>
    <td><?=form_dropdown('i_coa_type', $cbo_type)?>
        <input type="hidden" name="i_coa_old_type" value="<?=$coa_old_type?>" />
    </td>
  </tr>
   <tr>
    <td width="150">Normally</td>
    <td><?=form_dropdown('i_coa_normally', $cbo_normally, $coa_normally)?></td>
  </tr>
  <tr>
    <td width="150">No Account</td>
    <td><input name="i_coa_code" type="text" id="textfield10" value="<?=$coa_code?>" size="4" maxlength="<?=$length?>" />
    </td>
  </tr>
  <tr>
    <td width="150">Nama Account</td>
    <td><input name="i_coa_name" type="text" id="textfield10" value="<?=$coa_name?>" size="50" maxlength="50" />
    </td>
  </tr>
</table>
<!-- panel control -->
  <div class="command_bar">
		<input type="button" id="submit" value="Simpan"/>
		<input type="button" id="enable" value="Edit"/>
		<input type="button" id="delete" value="Hapus"/>
		<input type="button" id="cancel" value="Batal"/>
	</div>
</div>
</form>