<script type="text/javascript">	
$(function(){
	createTableFixed({
		id	: "#sampleTableFixed",
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
<table height="21" border="0" cellpadding="0" cellspacing="0" class="display" id="table"> 

	<thead>
		<tr>
		  <th>No.</th>
		  <th>Nama modul</th>
		</tr>
	</thead> 
	<tbody> <?
	for($i=0;$i<count($data);$i++)
	{
	?>
		<tr>
		  <td><?=($i+1)?></td>
		  <td><a href="<?=base_url().'manual/'.$data[$i]['url']?>"><?=$data[$i]['name']?></a></td>
		</tr>
		<?
		}
		?>
	</tbody>
</table>
</form>
</div>
