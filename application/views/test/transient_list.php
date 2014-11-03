<script type="text/javascript">
$(function(){
	var otable2 = createTableFormTransient({
		id 				: "#transient_table",
		listSource 		: "test/detail_loader/<?=$employee_id?>",
		formSource 		: "test/detail_form/<?=$employee_id?>",
		controlTarget	: "test/detail_control",	// add edit controller
		actionTarget	: "test/detail_action/<?=$employee_id?>"
	});	
	otable2.fnSetColumnVis(0, false, false);
});
</script>
<div id="transient_example222">
<form id="tform">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="transient_table"> 
	<thead>
		<tr>
		  <th>ID</th>
		  <th>Target</th>
		  <th>Jumlah</th>
		</tr>
	</thead> 
	<tbody id="items"> 	
	</tbody>
</table>
<div class="command_table">	
<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/> &nbsp; &nbsp;
    <input type="button" id="delete" value="Hapus"/>
	<input type="button" id="reset" value="Reset"/>
</div>
<div id="editor"></div>
</form>


</div>
