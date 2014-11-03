<?php 

function create_permit_item($level, $name, $module_code, $checked = array()) {

	if (!$module_code) $name = "<b>$name</b>";
	
	$checked_item = array('', '', '', '');
	
	$crud = array_key_exists($module_code ? $module_code : '#', $checked) ? $checked[$module_code] : '';
	
	if (strpos($crud, 'c') !== FALSE) $checked_item[0] = 'checked';
	if (strpos($crud, 'r') !== FALSE) $checked_item[1] = 'checked';
	if (strpos($crud, 'u') !== FALSE) $checked_item[2] = 'checked';
	if (strpos($crud, 'd') !== FALSE) $checked_item[3] = 'checked';
	
?>		
	<tr>
		<td><div  style="margin-left:<?php $width = $level * 20; echo $width."px; "?>"><?php echo $name; ?></div></td>
		<?php if ($module_code) { ?>
			<td>&nbsp;
				<input type="button" class="all_checked_button checked_full" value="F" title='Full' />
                <!--
                <input type="button" class="all_checked_button checked_limited" value="N" title='Create Read'/>
				<input type="button" class="all_checked_button checked_update" value="U" title='Update Read' />&nbsp;&nbsp;
				-->
                <input type="button" class="all_checked_button checked_clear" value="C" title='Clear / Reset'/>
				<!--<input type="button" class="all_checked_button checked_toggle" value="T" title='Checked Toggle' />-->
			</td>
			<td><input type="checkbox" name="ip_c[]"  value="<?php echo $module_code; ?>" <?php echo $checked_item[0]; ?> /></td>
			<td><input type="checkbox" name="ip_r[]" value="<?php echo $module_code; ?>" <?php echo $checked_item[1]; ?> /></td>
			<td><input type="checkbox" name="ip_u[]"  value="<?php echo $module_code; ?>" <?php echo $checked_item[2]; ?> /></td>
			<td><input type="checkbox" name="ip_d[]"  value="<?php echo $module_code; ?>" <?php echo $checked_item[3]; ?> /></td>
		<?php } else { ?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		<?php } ?>
	</tr>
<?php } ?>
<script type="text/javascript">
$(function() {
	
	$('.tree_list tbody tr:odd').addClass('odd');
	$('.tree_list tbody tr:even').addClass('even');
	
	$('.checked_limited').click(function() {
		$(this).parent().parent().find('input[type="checkbox"]').each(function() {
			this.checked = false;
		});
		$(this).parent().parent().find('input[type="checkbox"].limited').each(function() {
			this.checked = true;
		});
	});
	
	$('.checked_update').click(function() {
		$(this).parent().parent().find('input[type="checkbox"]').each(function() {
			this.checked = false;
		});
		$(this).parent().parent().find('input[type="checkbox"].update').each(function() {
			this.checked = true;
		});
	});
	
	$('.checked_full').click(function() {
		$(this).parent().parent().find('input[type="checkbox"]').each(function() {
			this.checked = true;
		});
	});
	
	$('.checked_clear').click(function() {
		$(this).parent().parent().find('input[type="checkbox"]').each(function() {
			this.checked = false;
		});
	});
	
	$('.checked_toggle').click(function() {
		$(this).parent().parent().find('input[type="checkbox"]').each(function() {
			this.checked = !this.checked;
		});
	});
	
	$('#btReset').click(function() {
		if (!window.confirm('Anda ingin me-reset form ini ke kondisi awal ?')) return;
		$('form').each(function() { this.reset(); });
	});
	
	$('#btSubmit').click(function() {
	
		var data = $('form input').serialize();

		var submitHandler = function(feedback) {
			if (feedback == null) return;
			if (feedback.type == 'success') {
				alert('Simpan Berhasil');
				window.location.href = '<?php echo $next_url; ?>';
			}
		}
		
		$.ajax({
			url 	: site_url + 'permit/action',
			dataType: "json",
			data	: data,
			type	: "POST",
			success	: submitHandler			
		});
		
	});
	
	$('#btKembali').click(function() {
		window.location.href = '<?php echo $next_url; ?>';
	});
 
});
</script>
<div class="tree_list">
<div class="form_area_frame">
<form>
<input type="hidden" name="ip_group_id" value="<?php echo $group_id; ?>" />
<table width="100%" cellspacing="0" cellpadding="4">
<thead>
	<tr>
		<th width="540">Modul</th>
		<th width="304">All</th>
		<th width="15">C</th>
		<th width="15">R</th>
		<th width="15">U</th>
		<th width="15">D</th>
	</tr>
</thead>
<tbody>
	<?php 
				/* ------ List Setup menu dashboard ------ */
		create_permit_item(2, 'Dashboard', 'master.dashboard', $checked); 
		
				/* ------ List Setup menu master ------ */
		create_permit_item(1, 'Master', '', $checked); 
			create_permit_item(2, 'Phase', 'master.phase', $checked);
			create_permit_item(2, 'Project name', 'master.project_name', $checked);
			create_permit_item(2, 'Material Type', 'master.product_category', $checked);
			create_permit_item(2, 'Material list', 'master.product', $checked);
			create_permit_item(2, 'Site', 'master.site', $checked);
			create_permit_item(2, 'uom', 'master.uom', $checked);
			
			/* ------ List Setup menu transaction ------ */
		create_permit_item(1, 'Transaction', '', $checked); 
			create_permit_item(2, 'PO received', 'transaction.po_received', $checked);
			create_permit_item(2, 'PO reservation', 'transaction.po_reservation', $checked);
			create_permit_item(2, 'PO retur', 'transaction.po_retur', $checked);
			create_permit_item(2, 'PO process', 'transaction.po_process', $checked);
			
			/* ------ List Setup menu tools ------ */
		create_permit_item(1, 'Tool', '', $checked); 
			create_permit_item(2, 'User', 'tool.user', $checked);
			create_permit_item(2, 'Permission', 'tool.permit', $checked);
			create_permit_item(2, 'User aproved', 'tool.user_aproved', $checked);
			//create_permit_item(2, 'Company Profile', 'tool.company_profile', $checked);
			
			/* ------ List Setup menu report ------ */
		create_permit_item(1, 'Report', '', $checked); 
			create_permit_item(2, 'Project report', 'report.project_report', $checked);
			create_permit_item(2, 'PO Received Summary Report', 'report.po_received_summary_report', $checked);
			create_permit_item(2, 'PO Received Report', 'report.po_received_report', $checked);
			create_permit_item(2, 'PO Reservation Summary Report', 'report.po_reservation_summary_report', $checked);
			create_permit_item(2, 'PO Reservation Report', 'report.po_reservation_report', $checked);
			create_permit_item(2, 'PO Phase Report', 'report.phase_report', $checked);
			create_permit_item(2, 'Material Report', 'report.material_report', $checked);
			
			
		
		
		
	?>
</tbody>
<tfoot>
	<tr>
		<td colspan="10" style="padding: 5px; " class="command_table">
			<div id="console"></div>
			<input type="button" id="btSubmit" value="Simpan" />
			<input type="button" id="btReset" value="Reset" />
			<input type="button" id="btKembali" value="Kembali" />
		</td>
	</tr>
</tfoot>
</table>
</form>
</div>
</div>
