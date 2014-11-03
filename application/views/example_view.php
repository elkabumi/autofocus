<!--<link href="<?php echo base_url()?>css/ajaxfileupload.css" type="text/css" rel="stylesheet">-->
<script type="text/javascript" src="<?php echo base_url()?>js/ajaxfileupload.js"></script>
   <script type="text/javascript">
jQuery(function(){
$('input[name="btn_upload"]').click(function(){
        $("#loading")
        .ajaxStart(function(){
            $(this).show();
        })
        .ajaxComplete(function(){
            $(this).hide();
        });

        $.ajaxFileUpload
        (
            {
                url:'<?=site_url('example/do_upload')?>',
                secureuri:false,
                fileElementId:'fileToUpload',
                dataType: 'json',
                success: function (data, status)
                {
                    if(typeof(data.error) != 'undefined')
                    {
                        if(data.error != '')
                        {
                            $("#info").html(data.error);
                        }else
                        {
                            $("#info").html(data.msg);
							$('input[name="fileToUpload"]').val('');
                        }
                    }
                },
                error: function (data, status, e)
                {
                    $("#info").html(e);
                }
            }
        )       
});
});
</script>
<?php
echo $table;
echo $table2;
?>
<div id="myflex"></div>
<div id="myflex2"></div>
<br />
<form action="" method="post" enctype="multipart/form-data">
        <input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input">
         <input name="btn_upload" type="button" value="Upload" />
          <img id="loading" src="<?php echo base_url()?>assets/images/loading.gif" style="display:none;">
        <div id="info"></div></form>