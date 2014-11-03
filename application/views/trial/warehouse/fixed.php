<script type="text/javascript">	
$(function(){
	createTableFixed({
		id	: "#table2",
		// untuk metode pilih
		formTarget : "trial/warehouse_form",
		// untuk metode submit
		submitTarget : "trial/warehouse_action",
		nextPage : "trial/warehouse_action",
	});	

});
</script>

<div id="sampleTableFixed">
<form>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table2"> 
	<thead>
		<tr>
			<th width="10%">ID</th>
			<th>Nama</th>
            <th width="10%"></th>
		</tr> 
	</thead> 
	<tbody>
    	<tr>
			<td>1</td>
			<td>Nama1</td>
            <td><input type="checkbox" name="opsi"></td>
		</tr>
        <tr>
			<td>2</td>
			<td>Nama2</td>
            <td><input type="checkbox" name="opsi"></td>
		</tr> 
		<tr>
			<td>5</td>
			<td>Nama2</td>
            <td><input type="checkbox" name="opsi"></td>
		</tr> 
		<tr>
			<td>3</td>
			<td>Nama2</td>
            <td><input type="checkbox" name="opsi"></td>
		</tr> 
	</tbody>
</table>
<div class="command_table">
	<!-- pilih salah satu ato 22 nya -->
	<input type="button" id="choose" value="Pilih"/>
    <input type="button" id="submit" value="Submit"/>
</div>
</form>
</div>
