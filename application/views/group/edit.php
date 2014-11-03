<?=form_open('group/update')?>
<input type="hidden" name="group_id" value="<?=$group_id?>" />
<table>
  <tr>
    <td>Group Name</td>
    <td><input type="text" name="nama_lengkap" value="<?=$nama?>" /></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" value="Submit" /></td>
  </tr>
</table>
<?=form_close()?>
