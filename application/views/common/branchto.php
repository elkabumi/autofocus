<script language="javascript">
$(function() {
	updateAll();
});
</script>
<form action="<?=site_url('home/branch/1')?>"method="post">
<table class="form_layout">
	<tr>
		<td width="100">Pilih Cabang</td>
		<td>
			<select name="i_branch" init="<?=$branch_id?>">
				<?php foreach($list as $row) : ?>
					<option value="<?=$row['branch_id']?>"><?=$row['branch_name']?></option>
				<?php endforeach; ?>
			</select>
		</td> 
	<tr>
	<tr>
		<td colspan="2">
			<input type="submit" value="Pindah Cabang" />
			<input type="button" name="back" value="Batal" />
		</td> 
	<tr>
</table>
</form>

