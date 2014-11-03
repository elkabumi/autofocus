<?=form_open('group/update_access');?>
<table width="356" border="1" cellpadding="0" cellspacing="0" >
  <tr align="center">
  <input type="hidden" name="group_id" value="<?=$group_id?>"/>
    <td width="196">Daftar Akses</td>
    <td width="35">c</td>
    <td width="40">r</td>
    <td width="35">u</td>
    <td width="38">d</td>
  </tr>
  <?PHP 
  	$i = 0;
  	foreach($data as $row):?>
  <tr>
    <td><?=$row['nama']?><input type="hidden" name="mod_id[<?=$i?>]" value="<?=$row['mod_id']?>"/></td>
    <td><input name="akses_c[<?=$i?>]" type="checkbox" value="c" <?PHP if(strstr($row['crud_mode'],'c')){echo 'checked';}?>></td>
    <td><input name="akses_r[<?=$i?>]" type="checkbox" value="r" <?PHP if(strstr($row['crud_mode'],'r')){echo 'checked';}?>></td>
    <td><input name="akses_u[<?=$i?>]" type="checkbox" value="u" <?PHP if(strstr($row['crud_mode'],'u')){echo 'checked';}?>></td>
    <td><input name="akses_d[<?=$i?>]" type="checkbox" value="d" <?PHP if(strstr($row['crud_mode'],'d')){echo 'checked';}?>></td>
  </tr>
  <?PHP 
  	$i++;
	endforeach;?>
  <tr>
    <td colspan="5">
      <input type="submit" name="act" value="cancel">
      <input type="submit" name="act" value="save"></td>
  </tr>
</table>
<?=form_close()?>