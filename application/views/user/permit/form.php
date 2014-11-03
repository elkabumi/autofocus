<script type="text/javascript">	
$(function(){

	createFormTransaction({
		id 				: "#id_form_nya", 
		actionTarget	: "user/permit_transient_action/<?=$group_id?>",
		backPage		: "user/permit",
		nextPage		: "user/permit"
	});
	
	
	createDatePicker({ id : "#id_tanggal_nya" });
	
	updateAll(); // tambahkan ini disetiap form
	
});
</script>

<form class="form_class" id="id_form_nya">
<div class="ajax_status"></div>
<table class="form_layout">
	<tr>
		<td width="150">Group ID</td> <!-- baris <tr></tr> pertama td nya harus diberi nilai width -->
		<td>
			<input type="text" id="row_id" size="10" value="<?=$row_id?>" disabled="disabled" />
			<input type="hidden" id="row_id" name="row_id" value="<?=$row_id?>" />		</td>
	</tr>
	<tr>
		<td width="150">Nama</td>
  <td>
	  <input type="text" name="i_nama" size="25"  maxlength="25" value="<?=$group_name?>" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
</table>

<div class="form_panel">
	
	<input type="button" id="submit" value="Simpan"/>
	<input type="button" id="enable" value="Edit"/>
	<!--
	<input type="button" id="delete" value="Hapus"/>
	-->
	
	<input type="button" id="cancel" value="Kembali" /> 
</div>
</form>