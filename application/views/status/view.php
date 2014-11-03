<script type="text/javascript"> 
$(function() {
	$('.flex').flexigrid({width:'auto', height:'auto', buttons : [
	                                              				{name: 'Add', bclass: 'add', onpress : test},
	                                            				{name: 'Delete', bclass: 'delete', onpress : test},
	                                            				{separator: true}
	                                            				],
	                                            	singleSelect:true});	
});
</script>
<table class="flex">
	<thead>
		<tr> 
			<th width="100">Col 1</th> 
			<th width="100">Col 2</th> 
			<th width="100">Col 3 is a long header name</th> 
			<th width="300">Col 4</th> 
		</tr> 
	</thead>
	<tbody>
		<tr> 
			<td>This is data 1 with overflowing content</td> 
			<td>This is data 2</td> 
			<td>This is data 3</td> 
			<td>This is data 4</td> 
		</tr> 
		<tr> 
			<td>This is data 1</td> 
			<td>This is data 2</td> 
			<td>This is data 3</td> 
			<td>This is data 4</td> 
		</tr> 
		<tr> 
			<td>This is data 1</td> 
			<td>This is data 2</td> 
			<td>This is data 3</td> 
			<td>This is data 4</td> 
		</tr> 
	</tbody>
</table>
<div class="tbwin">
<div class="h1"><div><div><div>
<div class="h2"><div><div><div>
<div>
<table class="tableform">
<tr><td>Nama</td><td><input type="text" size="20"/></td></tr>
<tr><td>Alamat</td><td><input type="text" size="50"/></td></tr>
<tr><td>Ponsel</td><td><input type="text" size="10"/></td></tr>
<tr><td colspan="2"><input type="button" value="Submit" /></td></tr>
</table>
</div>
</div></div></div></div>
</div></div></div></div>
</div>
