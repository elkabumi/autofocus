<div class="block_area">
<div class="block_title">Informasi User</div>
<div class="block_content">
<div><b>Nama user : </b><?=$nama?> (<?=$user_id?>)</div>
<div><b>Status user: </b>Guru</div>
<div><b>Waktu Login: </b><?=$login_time?date('h:i:s', $login_time):''?></div>
<p class="last"><a href="<?=site_url('login/logout/1')?>">Logout</a></p>
</div>

</div>
