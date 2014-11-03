<script type="text/javascript">
$(function() {
	$('#back').click(function() {
		window.location.href = site_url+'<?=$back_url?>';
	});
});
</script>

<table class="form_layout">
	<tr>
          <td req="req" width="150">File</td>
          <td><input id="fileToUpload" type="file" size="25" name="fileToImport" class="input">
			<p><em>*Hanya file format .txt dan .csv dengan pemisah tab</em>
		  </td>  
        </tr>
</table>
<div class="form_panel">
	<input type="submit" id="submit" value="Import"/> &nbsp;
	<?php
	if($back_url){
	?>
	<input type="button" id="back" value="Kembali"/>
	<?php
	}
	?>
</div>

