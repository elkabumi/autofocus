<script type="text/javascript">	
$(function(){
	var otable = createTable({
		id 		: "#table",
		listSource 		: "user_aproved/table_controller",	
		formTarget		: "user_aproved/user_aproved_form",
		actionTarget	: "user_aproved/user_aproved_form_action",
		submitTarget	: "trial/warehouse_submit",
		column_id 	: 0,
		filter_by 	: [ {id : "nama", label : "Full Name"}, {id : "login", label : "User Name"}, {id : "email", label : "Email"}, {id : "phone", label : "Phone"}, {id : "job_title", label : "Job Title"}, {id : "company", label : "Company"}]
	});
	otable.fnSetColumnVis(0, false, false);
});
</script>
<div id="example">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
        	<th>ID</th>
			<th>User Name</th>
			<th>Full Name</th>
          	<th>Email</th>
            <th>Phone</th>
            <th>Job Title</th>
            <th>Company</th>
         
		</tr> 
	</thead> 
	<tbody>	
	</tbody>
</table>
<div id="panel" class="command_table">
	<input type="button" id="edit" value="View"/>
	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="refresh" value="Refresh"/>
</div>
</div>
