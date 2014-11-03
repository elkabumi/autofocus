<div class="btheader"><img src="<?=base_url()?>images/gear-icon.png" width="12" height="12" align="left" hspace="5"/>Sys Info</div>
<div class="btcontent">
<p>
<?php foreach($list[0] as $key => $value) : ?>
    <b><?=$key?></b>&nbsp;<font color="red">&raquo;</font> <font color="blue"><?=$value?></font><br />
    <?php endforeach; ?>
    <?php foreach($list[1] as $key => $value) : ?>
    <b><?=$key?></b>&nbsp;<font color="blue">&raquo;</font> <font color="red"><?=$value?></font><br />
    <?php endforeach; ?>
</p>
</div>