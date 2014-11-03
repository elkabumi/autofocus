<script type="text/javascript">
$(function(){
	$('input[name="mode"]').change(function(){
		var val = $(this).val();
		if(val==1)$('select[name="download_to"]').attr('disabled','');
		else $('select[name="download_to"]').attr('disabled','disabled');		
	});
	$('input[name="mode"]').change();
	$('.form_area').find('input').each(function() {
		if($(this).hasClass('required'))$(this).after(' <span style="color:red">*</span>');
	});
	$('.form_area').find('select').each(function() {
		if($(this).hasClass('required'))$(this).after(' <span style="color:red">*</span>');
	});
});
</script>
<form class="form_class" id="id_form_nya" method="POST" action="<?=site_url($action_url)?>">
<div class="form_area">
	<div class="ajax_status"></div>
	<?=$branch?>
	<?=$content?>
	<div class="form_category">Proses</div>
	<table class="form_layout">
		<tr>
			<td width="150"></td>
			<td>
				<label><input type=radio name=mode value=0 <?=($default_action==0) ? 'checked="checked"':''?> >Print</label>
				<label><input type=radio name=mode value=1 <?=($default_action!=0) ? 'checked="checked"':''?> >Download</label>
				<label><select disabled="disabled" name="download_to"><option value="pdf">Pdf<option value="xls">Excel</select></label>
			</td>
		</tr>
	</table>
	<div class="command_bar">
		<input type="submit" id="submit" value="Proses"/>&nbsp;
		<input type="button" onclick="location.href='<?=site_url($back_url)?>'" id="button" value="Kembali"/>
	</div>
</div>
</form>
