<style type="text/css" title="currentStyle"> 
#box_user_info a:link  {
	color: #becfe0 !important;
	text-decoration: none;
}
#box_user_info a:visited  {
	color: #becfe0 !important;
	text-decoration: none;
}
#box_user_info a:hover  {
	color: #becfe0 !important;
	text-decoration: underline;
}
.emp_c
{
color: #becfe0;
font-weight:bold;
}
.border_content
{
}
</style>
<!--<div class="btheader"><img src="<?=base_url()?>images/gear-icon.png" width="12" height="12" align="left" hspace="5"/>Informasi Pengguna</div>

-->

                    <div class="user-panel">
                        <div class="pull-left image" style="margin-right:10px;">
                           <img src="<?=base_url()?>storage/img_employee/<?=$employee_pic?>" class="img-circle" alt="User Image" />
                         </div>
                        <div style="font-size: 12px;
    font-weight: 600;
    line-height: 1; margin-top:5px; text-shadow: 1px 1px 1px rgba(0,0,0,0.2);" >
                            <p>Hello, <?=$employee?></p>

                            <span style="font-size:11px; font-weight:normal; "><a href="<?=base_url()?>login/logout/1" style="color:#A0ACBF; text-shadow: 1px 1px 1px rgba(0,0,0,0.2);"><i class="fa fa-share text-success" style=" color:#A0ACBF"></i> Logout</a></span>
                        </div>
                    </div>
               
<div class="btcontent border_content">
<p>
<table cellpadding="5" cellspacing="0" id="box_user_info">
	<tr>
    <td><img src="<?=base_url()?>assets/images/clock.png" align="left" /></td>
    <td>  <span id="clockTimer" style="color:#A0ACBF !important; text-shadow: 1px 1px 1px rgba(0,0,0,0.2);">1 Mar 2010 &nbsp; 18:23</span> </td>
    </tr>
    <tr>
		<td><img src="<?=base_url()?>assets/images/user_group.png" align="left" /></td><td class="emp_c" title="Grup"><span style="color:#fff; text-shadow: 1px 1px 1px rgba(0,0,0,0.2);"><?= "Login as ".$group_name?></span></td>
	</tr>
</table>

</p>
</div>