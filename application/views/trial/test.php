<script language="javascript">

$(function() {
	
	var ipungOnClick = function() {
		$('input[type="text"]').fadeIn(1000);
	}
	
	$('input[type="text"]').fadeOut(1000);
	$('#action').click(ipungOnClick);
		
});

</script>
<input type="text" id="ipung" value="nilai awal" />
<input type="text" id="setan" value="nilai awal" />
<input type="button" id="action" value="action" /> 
