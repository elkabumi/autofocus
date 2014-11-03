<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<?php
if(!$is_uploaded)
{
?>
<script type="text/javascript">
var url = '<?=$url?>';
</script>
<body>
<form action="<?=site_url('upload/do_upload')?>" id="submit-form" method="post" enctype="multipart/form-data">
         <input name="i_url" type="hidden" value="<?=$url?>" />
         <input name="upload_type" type="hidden" value="<?=$upload_type?>" />
<input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input">
         <input name="btn_upload" type="submit" value="Upload" />

</form>
<?php
}
else
{
?>
<script type="text/javascript">
function send(){
var id = '<?=$blob_id?>';
if(id=='')return;
//window.opener.tangkap='<?=$url?>';
window.opener.setData('<?=$blob_id?>','<?=$file_name?>');
//opener.document.f1.i_blob.value = '<?=$blob_id?>';
self.close();
//window.close();
}
</script>
<body onload="send();">
<?php
}
?>

</body>
</html>