<script>
$(function() {
	var tbl = createTableReport({
		id	: "#sampleTableFixed",
		formTarget : "<?=$target_url?>",
		nextPage : "gl_balance",
		column_id:2
	});
	tbl.fnSetColumnVis(2, false);
});	


</script>
<div id="sampleTableFixed">
<form>
<div class="form_area">

	<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th width="50">No.</th>
			<th>Nama Laporan </th>
			<th>URL</th>
		</tr> 
	</thead> 
	<tbody>
	<?php
	for($i=0;$i<count($data);$i++)
	{
		$row = $data[$i];
		echo '<tr><td>'.($i+1).'</td><td>'.$row['name'].'<input type="hidden" value="'.$row['url'].'" name="val[]" />';
		echo '</td><td>'.$row['url'].'</td></tr>';
	}
	?>
    	
	</tbody>
</table>

<div class="command_bar">
    <input type="button" id="choose" value="Buat"/>
</div>
</div>
</form>
</div>
