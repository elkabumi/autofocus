<div style="text-align: center"> 
<table class="dialog">
  <tr>
    <td><img src="<?=base_url()?>dsg/main/images/dialog_confirmation.gif" /></td>
    <td>
    	<h1><?=$title?></h1>
    	<h2><?=$message?></h2>
    </td>
  </tr>
    <tr>
    <td colspan="2" style="text-align: center">
		<?
			$no_target = $no_target ? "location.href='$no_target'" : "history.back();";
		?>
    	<input type="button" value="OK" onclick="location.href='<?=$yes_target?>'" /> &nbsp; 
		<input type="button" value="Batal"  onclick="<?=$no_target?>" />
	</td>
  </tr>
</table>
</div>