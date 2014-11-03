<script>
/*$(function() {
	var tbl = createTableJournal({
		id	: "#sampleTableFixed",
		column_id:2
	});
	tbl.fnSetColumnVis(0, false);
});	
*/

</script>
<div id="sampleTableFixed">
<form>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="table"> 
	<thead>
		<tr>
			<th nowrap class="ui-state-default" align="center">Account</th>
			<th nowrap class="ui-state-default" align="center">Cost Center</th>
			<th nowrap class="ui-state-default" align="center">Kode Proyek</th>
			<th nowrap class="ui-state-default" align="center">Keterangan</th>
			<th nowrap class="ui-state-default" align="center">Debit</th>
			<th nowrap class="ui-state-default" align="center">Kredit</th>
		</tr> 
	</thead> 
	<tbody>
	<?php
	for($i=0;$i<count($data_journal);$i++)
	{
		$row = $data_journal[$i];
		 $class = ($i%2==1)?'class="even"':'class="odd"';
		echo '<tr '.$class.'><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.tool_money_format($row[5]).'</td><td>'.tool_money_format($row[6]).'</td></tr>';
	}
	?>
    	
	</tbody>
</table>
</form>
