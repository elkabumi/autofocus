<script>
$(function() {
	var approval = $('#approval_form');
	approval.find('#cancel').click(function() {
		window.location.replace('<?=$back?>');
	});

});
</script>
<div class="padder" id="approval_form">
<form>
<table class="form_layout">
	<tr>
		<td colspan="2">
			Ini adalah halaman Approval dokumen. Anda sudah menggunakan halaman persetujuan ini.
			<input type="hidden" name="i_approval_id" value="<?=$id?>" />
		</td>
	</tr>
	<tr>
		<td width="100%" valign="top">Berikut yang harus approval dokumen ini:
			<table>
			<thead>
				<tr>
					<td></td><td><b>Nama</b></td><td></td>
				</tr>
			</thead>
			<tbody>
			<?php foreach($list as $value) : ?>
				<tr>
					<td width="20"><img src="<?=base_url()?>/images/iconic/approval_<?=$value['status']?>.png"></td>
					<td width="200"><?=$value['employee_name']?></td>
					<td><!--<?=$value['position_name']?> (<?=$value['loa_tag_name']?>)--></td>
					<td><?=$value['approval_employee_time']?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<input type="button" value="Kembali" id='cancel' class="btn_approval" />
		</td>
	<tr>
</table>
</form>
</div>
