<script type="text/javascript">	
$(function(){


	createForm({
		id 				: "#id_form_nya", 
		actionTarget	: "user/user_form_action",
		backPage		: "user/",
		nextPage		: "user/"
	});
	
	createLookUp({
		table_id		: "#lookup_table1",
		table_width		: 300,
		listSource 		: "user/group_table_control",
		dataSource		: "user/group_lookup_id",	
		column_id 		: 0,
		component_id	: "#lookup_component1",
		filter_by		: [{id : "p1", label : "Nama"}]
	});
	/*createLookUp({
		table_id		: "#lookup_table2",
		table_width		: 400,
		listSource 		: "user/employee_table_control",
		dataSource		: "user/employee_lookup_id",
		column_id 		: 0,
		component_id	: "#lookup_component2",
		onSelect		: function(id){
				if($('input[name="i_nip"]').val()=='')$('#extid').show();
				else $('#extid').hide();	
		},
		filter_by		: [{id : "p2", label : "Nama"}]
	});
	if($('input[name="i_nip"]').val()=='')$('#extid').show();
	else $('#extid').hide();
	//updateAll(); // tambahkan ini disetiap form
*/	
	createDatePicker();
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
				url:'<?=site_url('user/do_upload')?>',
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

<form class="form_class"  id="id_form_nya">
<div class="form_area">
<div class="form_area_frame">
	<table width="100%" cellpadding="4" class="form_layout">
	<tr>
		<td req="req">User Group</td>
		<td>
			<span class="lookup" id="lookup_component1">
				<input type="hidden" name="i_group" class="com_id" value="<?=$user_group?>" /><input type="text" class="com_input required" size="20"  />
				<input type="hidden" id="row_id" name="row_id" value="<?=$row_id?>" />

				<div class="iconic_base iconic_search com_popup"></div>	
                						</span>		</td>
	</tr>
	<!--<tr>
	  <td req="req">Karyawan</td>
	  <td><span class="lookup" id="lookup_component2">
		<input type="hidden" name="i_karyawan" class="com_id" value="<?//=$employee_id?>" />
           <input id="fixed_state" type="text" name="i_nip" class="com_input required " size="20" <?//=($row_id)?'disabled="disabled"':''?> /><div class="iconic_base iconic_search com_popup"></div>
                     <span class="com_desc"></span>
			
				
			
		</span></td>
    </tr>-->
	<tr id="extid">
	  <td width="196" >User Name</td>
	  <td width="651"><input type="text" value="<?=$user_login?>" name="i_login" />
      <input type="hidden" id="employee_id" name="employee_id" value="<?=$employee_id?>" /></td>
    </tr>
    <tr id="extid">
	  <td width="196" >Name</td>
	  <td width="651"><input type="text" value="<?=$user_name?>" name="i_user_name" /></td>
    </tr>
	<tr>
		<td <? if(empty($row_id)){ echo "req=req"; }; ?>>Password</td>
		<td><input type="password" name="i_sandi1" size="31"  maxlength="31" /></td>
	</tr>
	<tr>
	  <td <? if($row_id == ""){ echo "req=req"; }; ?>>Konfirmasi Password</td>
	  <td><input type="password" name="i_sandi2" size="31"  maxlength="31" value="" /></td>
    </tr>
    <tr id="extid">
	  <td width="196" >Email</td>
	  <td width="651"><input type="text" value="<?=$user_email?>" name="i_user_email" /></td>
    </tr>
    
	 <tr>
     <tr id="extid">
	  <td width="196" >phone</td>
	  <td width="651"><input type="text" value="<?=$user_phone?>" name="i_user_phone" /></td>
    </tr>
	<tr>
     <tr id="extid">
	  <td width="196" >job title</td>
	  <td width="651"><input type="text" value="<?=$job_title?>" name="i_job_title" /></td>
    </tr>
    <tr>
     <tr id="extid">
	  <td width="196" >company</td>
	  <td width="651"><input type="text" value="<?=$company?>" name="i_company" /></td>
    </tr>
        <tr id="extid">
	  <td width="196" > Expired Date</td>
   <td><input type="text" name="i_expired_date" class="date_input" size="15" value="<?=$expired_date?>" /></td>
     
  
  </tr>
    <tr>
    <td valign="top">
      <?php
	   if($row_id == "" || $employee_pic == ""){
	   ?><div id="foto_hidden2" style="width:100px; height:70px; border:1px solid #999; text-align:center; padding-top:40px;"><b>FOTO</b></div>
	   <?php
	   }
	   ?>
    <div class="img" >
 <img id="imagex" src="<?=base_url().'storage/img_employee/'.$employee_pic?>"  width="100px"  height:"70px";  alt="" />
 <input type="hidden" name="i_photo" id="photo" value="<?=$employee_pic?>" />
 <input type="hidden" name="i_oldphoto" value="<?=$employee_pic?>" />
 <div class="desc"></div>
</div>
	  <input id="fileToUpload" type="file" size="10" name="fileToUpload" class="input">
<input type="button" id="buttonUpload" onclick="ajaxFileUpload();return false;" value="Upload" />	</td>
  </tr>

</table>
</div>
<div class="command_bar">
	<input type="button" id="submit" value="Simpan"/>
	<input type="button" id="enable" value="Edit"/>
	<input type="button" id="delete" value="Hapus"/>
	<input type="button" id="cancel" value="Batal" /> 
</div>
</div>
</form>

<div>
	<table id="lookup_table1" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				<th width="10%">ID</th>
				
				<th>Nama</th>
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
	<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
  </div>	
</div>
<!--<div id="">
	<table id="lookup_table2" cellpadding="0" cellspacing="0" border="0" class="display" > 
		<thead>
			<tr>
				
				<th width="5%">ID</th>
				<th width="15%">Nik</th>
				<th width="30%">Nama</th>
                <th width="30%">Keterangan</th>
			</tr> 
		</thead> 
		<tbody> 	
		</tbody>
	</table>
	<div id="panel">
		<input type="button" id="choose" value="Pilih Data"/>
		<input type="button" id="refresh" value="Refresh"/>
		<input type="button" id="cancel" value="Cancel" />
	</div>	
</div>
-->