<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 	: "price/table_controller",
		formTarget 	: "price/form",
		actionTarget: "price/form_action",
		column_id	: 0,
		
		filter_by 	: [ 
            {id : "insurance_name", label : "Nama Asuransi"}, 
            {id : "insurance_addres", label : "Alamat Asuransi"},
            {id : "insurance_phone", label : "Telepon Asuransi"},
        ],
		"aLengthMenu"		: [[50, 100, 250, 500], [50, 100, 250, 500]],
	});
	otable.fnSetColumnVis(0, false, false);
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th>ID</th>
            <th>Nama Asuransi</th>
            <th>Alamat Asuransi</th>
			<th>Telepon Asuransi</th>
		</tr> 
	</thead> 
	<tbody> 	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="edit" value="Edit"/>
<<<<<<< HEAD
	
	<!--<input type="button" id="delete" value="Inactive"/>
    <input type="button" id="active" value="active"/>
-->
=======
	<!--<input type="button" id="delete" value="Inactive"/>
    <input type="button" id="active" value="active"/>-->
>>>>>>> 1c725a1accd44ce4c81138072141142d3cd37ce4
	<input type="button" id="refresh" value="Refresh"/>
</div>
<div id="editor"></div>
</div>
