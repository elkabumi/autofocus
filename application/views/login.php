<script language="javascript">
function cek() {
		if(!$('#i_user').val() || !$('#i_pass').val()){
			alert('Masukkan username dan password.');
			return false;
		}
	}
$(function() {
	function getCaptchaURL() {
		var d = new Date();
		return site_url + 'index.php/login/captcha/' + d.getTime();
	}
	
	$('img.captcha').attr('src', getCaptchaURL());
	$('#refresh_captcha').click(function() { $('img.captcha').attr('src', getCaptchaURL()); });	
	/*$('form').submit(function() {
		if(!$('#i_user').val() || !$('#i_pass').val()){
			$(".ajax_status").html('<div class="error">Masukkan username dan password.</div>');
			return false;
		}
		$.ajax({
			url: $(this).attr('action'),
			async : false,
			dataType: 'json',
			type : 'POST', 
			data: $(this).serialize(),
			success: function(data){
				//$(".ajax_status").text(data.content).show().fadeOut(5000);
				if(data.type == 'redirect'){window.location.href = data.content;return false;}
				$(".ajax_status").html(data.content);
			}
		});
		
		return false;
	});*/
	$('input[type="reset"]').click(function() {$(".ajax_status").html('');});
});
</script>
<form action="<?=site_url('login/submit')?>" method="POST">
<div>
<div class="form_area">
<div class="form_area_frame">
<!--<div class="ajax_status"><?=validation_errors()?></div>-->
<table width="100%" cellpadding="4" class="form_layout" >
   <tr>
	 
      <td width="196" >Username</td>
        <td width="651"  ><input name="i_user" type="text" id="i_user" size="40" value="<?=$name?>" style="width:95% !important" /></td>
    
   </tr>
   <tr>
      <td>Password</td>
        <td><input name="i_pass" type="password" id="i_pass" size="40" style="width:95% !important"/></td>
 
    </tr>
    <?php /*
    <tr>
      <td></td>
	  <td>
		<img src="#" class="captcha" style="border: 1px solid  #85b1de;" />
	  </td>
    </tr>
    <tr>
      <td><strong>Ketik Ulang</strong></td>
	  <td>
		<div style="margin: 4px 4px 4px 0px;float:left;">
			<input type="text" name="i_captcha" id="i_captcha" size="10" maxlength="10" />
			<span><img src="<?=base_url()?>assets/images/refresh.png" title="Refresh" id="refresh_captcha" style="cursor:pointer;position:relative;top:3px;" /></span>
		</div>
	  </td>
    </tr>
	*/ ?>
	  </table>
      </div>
	 
<div class="command_bar">
    <input type="submit" value="Login" onclick="return cek();" />
	<input type="reset"  value="Reset" />
    
	</div>

  </div>
</form>

