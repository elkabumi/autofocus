<script type="text/javascript">	
$(function(){

});
function ajaxFileUpload()
	{
	
	
	
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
 
		$.ajaxFileUpload({
				url:'<?=site_url('registration/do_upload')?>',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							reloadImage('#imagex','<?=base_url()?>/tmp/'+data.value);
							$('#photo').val(data.value);
						}
					}
				},
				error: function (data, status, e)
				{
					alert('error ~ '+e);
				}
		}); 
		//alert(1);
		return false;
 
	}
</script>
<form class="subform_area">
<div class="form_area_frame">
<table cellpadding="2" class="form_layout">
	<tr>
  
     <td width="222" req="req" >Nama Foto
     </td>
     <td width="633" >
    <input name="i_photo_name" type="text" id="i_photo_name" value="<?=$photo_name ?>" />
   <input type="hidden" name="i_index" value="<?=$index?>" />
      </td>
    </tr>
	<tr>
     <td width="222" req="req" >Foto Mobil Masuk
     </td>
    <td valign="top">
      <?php
	   if($photo_file == ""){
	   ?><div id="foto_hidden2" style="width:100px; height:70px; border:1px solid #999; text-align:center; padding-top:40px;"><b>FOTO</b></div>
	   <?php
	   }
	   ?>
    <div class="img" >
    <?php if($registration_id == ""){?>
 <img id="imagex" src="<?=base_url().'tmp/'.$photo_file?>"  width="100px"  height:"70px";  alt="" />
 <?php   }else{ ?>
 <img id="imagex" src="<?=base_url().'storage/img_m_in/'.$photo_file?>"  width="100px"  height:"70px";  alt="" />
 <?php } ?>
 <input type="hidden" name="i_photo_file" id="photo" value="<?=$photo_file?>" />

 <div class="desc"></div>
</div>
	  <input id="fileToUpload" type="file" size="10" name="fileToUpload" class="input">
<input type="button" id="buttonUpload" onclick="ajaxFileUpload();return false;" value="Upload" />	<?=$photo_file?></td>
  </tr>

</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan" />
<input type="reset" id="reset"  value="Reset" />
	<input type="button" id="cancel" value="Batal" />
</div>
</form>

