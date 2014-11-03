<script type="text/javascript">	
$(function(){

	createTableFormTransient({
		id	: "#sampleTableFixed",
		// untuk metode pilih
		formTarget : "user/permit_transient_form",
		// untuk metode submit
		submitTarget : "user/permit_transient_action/<?=$group_id?>",
		nextPage : "user/permit"
	});	

});
</script>

<div id="sampleTableFixed">
<form>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="30%">Nama Modul</th>
			<th width="15%">Modul ID</th>
			<th width="8%">Create</th>
			<th width="8%">Read</th>
			<th width="8%">Update</th>
			<th width="8%">Delete</th>
		</tr> 
	</thead> 
	<tbody>
	<? foreach($result_ac as $row=>$value)
	{?>
    	<tr>
			<td>
				<?=$value['module_name']?>
				<input type="hidden" name="i_group_id[]" value="<?=$value['permit_group_id']?>" />
			</td>
			<td>
				<?=$value['module_id']?>
				<input type="hidden" name="i_modul_id[<?=$row?>]" value="<?=$value['module_id']?>" />
				<!-- baris yang di edit. untuk add kosong. -->
				<input type="hidden" name="i_index[<?=$row?>]" value="<?=$row?>" />
			</td>
			<td><input type="checkbox" name="i_create[<?=$row?>]" value="c" init="<?=$value['crud_create']?>"/></td>
			<td><input type="checkbox" name="i_read[<?=$row?>]" value="r" init="<?=$value['crud_read']?>" /></td>
			<td><input type="checkbox" name="i_update[<?=$row?>]" value="u" init="<?=$value['crud_update']?>" /></td>	
			<td><input type="checkbox" name="i_delete[<?=$row?>]" value="d" init="<?=$value['crud_delete']?>" /></td>
		</tr> 
	<? }?>
	</tbody>
</table>
</form>
<div id="panel">
	<!-- pilih salah satu ato 22 nya -->
	<!--<input type="button" id="choose" value="Pilih"/>-->
    <input type="button" id="submit" value="Submit"/>
</div>
</div>