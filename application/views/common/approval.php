<script>
$(function() {

	var approval = $('#approval_form');
	var app_status = approval.find('#status');

	approval.find('.approval_reason').hide();
	
	approval.find('#approve').click(function() {
		$('.approval_reason').hide();
		app_status.val('1');
		$(this).addClass('highlight_btn_green');
		approval.find('#reject').removeClass('highlight_btn_red');
	});
	
	approval.find('#reject').click(function() {
		$('.approval_reason').fadeIn(500)
		app_status.val('2');
		$(this).addClass('highlight_btn_red');
		approval.find('#approve').removeClass('highlight_btn_green');
	});
	
	approval.find('#submit').click(function() {
		if (app_status.val() == 0) {
			alert('Mohon pilih salah satu, SETUJU atau MENOLAK.');
			return;
		}
		
		if (app_status.val() == 2) {
			var sArea = $('#i_reason').val();
			sArea = $.trim(sArea);
			if (sArea.length == 0) {
				alert('Mohon sebutkan alasan kenapa Anda menolak dokumen ini.');
				return;
			}
		}
		
		var data = 'i_data_id='+$('#i_data_id').val()+'&i_reason='+$('#i_reason').val()+'&i_status='+app_status.val();
		//alert(data);
		postJSONAsync('<?=$action?>', data, function(data) {
			
			if (data.type == 'success') {
				if (app_status.val() == 1) alert('Persetujuan Anda Tersimpan.'); else alert('Penolakan Anda Tersimpan.'); 
			} else {
				 alert('Proses gagal.'); 
			}
			
			window.location.replace('<?=$back?>');
		});
	});

	approval.find('#cancel').click(function() {
		//window.location.replace('<?=$back?>');
	});
	
});	
</script>

<div class="padder" id="approval_form">
<form class="form_class" id="id_form_approval">	
<div class="form_area">
<table class="form_layout" width="400">
	<tr>
		<td colspan="2" align="justify">
			Ini adalah halaman Approval dokumen. Bila Anda dapat mengakses halaman ini, berarti Anda termasuk dalam List of Authority atas dokumen ini. Anda harus memilih antara Setuju atau Menolak. 
			<input type="hidden" name="i_data_id" id="i_data_id" value="<?=$id?>" />
		</td>
	</tr>
	<tr>
		<td valign="top">
			<span style="color: #AA0000;" class="approval_reason">Bila Anda menolak, tuliskan alasannya dengan jelas. </span>
			<div class="approval_reason">
				<textarea name="i_reason" id="i_reason" cols="40" rows="6"></textarea>
			</div>
		</td>
		<td valign="top">Berikut yang harus approval dokumen ini:
			<table>
			<thead>
				<tr>
					<td></td><td><b>Nama</b></td><td></td><td></td>
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
		<td colspan="2">
			<table>
				<tr>
				
					<td nowrap="nowrap">
					
						<input type="hidden" name="i_status" value="0" id="status" />
						<input type="button" value="Setuju" class="btn_approval" id="approve" />
						<input type="button" value="Menolak" class="btn_approval" id="reject" />
					</td>
					<td width="100%">&nbsp;</td>
					<td nowrap="nowrap">
						<!--<input type="button" value="Kembali" class="btn_approval" id='cancel' />-->
						<input type="button" value="Simpan" class="btn_approval" id='submit' />
					</td>
				</tr>
			</table>
		</td>
	<tr>
</table>
</div>
</form>
</div>
