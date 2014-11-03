<?=form_open('group/op')?>
<table width="281" border="1">
  <tr>
    <td width="223">Nama</td>
    <td width="42"><input type="radio" name="grup_id" value="0" /></td>
  </tr>
  <?php foreach($data as $row) : ?>
  <tr>
    <td><?=$row['nama']?></td>
    <td><input type="radio" name="group_id" value="<?=$row['group_id']?>" /></td>
  </tr>
  <?php endforeach ?>
  <tr>
    <td colspan="2">
    	<input type="submit" name="act" value="add" /> &nbsp; 
    	<input type="submit" name="act" value="access" /> &nbsp;
        <input type="submit" name="act" value="edit" /> &nbsp; 
        <input type="submit" name="act" value="delete" /></td>
  </tr>
</table>
<?=form_close()?>
