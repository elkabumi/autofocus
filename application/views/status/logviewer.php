This data action logs
<table border="1">
  <tr>
    <td>Timestamp</td>
    <td>By</td>
    <td>Action</td>
  </tr>
  <?php foreach($list as $item): ?>
  <tr>
    <td><?=$item['waktu']?></td>
    <td><?=$item['user_nama']?></td>
    <td><?=$item['aksi']?></td>
  </tr>
  <?php endforeach; ?>
</table>
