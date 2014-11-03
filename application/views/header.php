<? $format; ?>

<div class="report_area">
<div class="header">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">

  <tr>
     <? foreach($header as $item): ?>
    <td align="center"><?=$item['company_name']?></td>
  </tr>
  <tr>
    <td align="center"><?=$item['company_addres']?></td>
  </tr>
  <tr>  
    <td align="center"><?=$item['company_phone']?></td>
   </tr>
   <tr>
      <td align="center"><?=$item['company_email']?></td>
   
   </tr>
   <?  endforeach; ?>
  </tr>
 
</table>
</div>
<hr style="margin-top:0px;" />
</div>