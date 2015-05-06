<script type="text/javascript">	
$(function(){
	
	otable = createTable({
		id 				: "#table",
		listSource 		: "coa/list_controller",	
		formTarget		: "coa/coa_form",
		sendIDTarget	: "coa/coa_add",
		actionTarget	: "coa/coa_form_action",
		column_id 		: 0,
		filter_by 		: [ {id : "account_num", label : "No"}, {id : "account_name", label : "Nama"} , {id : "account_grup", label : "Grup"}]
	});

	otable.fnSetColumnVis(0, false, false);
	
	$('#import').click(function(){
		window.location = site_url + "import_data/import_coa";
	});

});
</script>

<div id="example">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="display" id="table"> 
<thead>
		<tr>
		  <th width="32" nowrap="nowrap"></th>
          <th width="135" nowrap="nowrap">No Account </th>
          <th width="464" nowrap="nowrap">Nama Account </th>
          <th width="195" nowrap="nowrap">Group </th>
          <th width="126" nowrap="nowrap">Tipe </th>
	  </tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="add" value="Tambah"/>
	<input type="button" id="edit" value="Revisi"/>
	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>