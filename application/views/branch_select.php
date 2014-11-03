<?php
}
else if($user_id &&!$branch_id)
{
?>
<script type="text/javascript">
    $(function(){
	$('#btn_continue').click(function() {	
	    if($('#branch').val()=='00'){
		$('.ajax_status').html('Pilih cabang terlebih dahulu!');
		return;
	    }
	    $.ajax({
		type: 'POST',
		url: '<?= site_url('login/submit_continue') ?>',
		data: $('#id_form_nya').serialize(),
		dataType: 'json',
		success: showResponse
	    })
	    return false;
	});
	$('input[name="btn_reset"]').click(function(){
	    $('.ajax_status').html('');
	    resetForm('id_form_nya');	
	});
	$("#company").change(function() {
	    var company_id = this.value;
	    var data = 'company_id='+company_id;
	    $.ajax({
		type: 'POST',
		url: '<?= site_url('login/get_groupregion') ?>',
		data: data,
		dataType: 'json',
		success: appendToCombo
	    });
			
	});
	$("#regional_group").change(function() {
	    var rg_id = this.value;
	    var data = 'region_group='+rg_id;
	    $.ajax({
		type: 'POST',
		url: '<?= site_url('login/get_region') ?>',
		data: data,
		dataType: 'json',
		success: appendToCombo
	    });
			
	});
	$("#region").change(function() {
	    var region_id = this.value;
	    var data = 'region_id='+region_id;
	    $.ajax({
		type: 'POST',
		url: '<?= site_url('login/get_branch') ?>',
		data: data,
		dataType: 'json',
		success: appendToCombo
	    });
	});
	$('#company')[0].selectedIndex = 1;
	$('#company').change();
    });
    function showResponse(data){
	if(data.type == "redirect"){
	    window.location=data.content;
	    return;
	}
	if(data.type=="content"){
	    $('.ajax_status').html('');
	    return;
	}
	$('.ajax_status').html(data.content);
    }
    function appendToCombo(data){
	var i, id, optHtml='';
	id=data.type;
	if(data.type=="regional_group"){
	    optHtml='<option value="00" selected>Pilih Regional...</option>';
	    $('#region').html('<option value="00" selected>Pilih Wilayah...</option>');
	    $('#branch').html('<option value="00" selected>Pilih Cabang...</option>');
	}
	if(data.type=="region"){
	    id="region";
	    optHtml='<option value="00" selected>Pilih Wilayah...</option>';
	    $('#branch').html('<option value="00" selected>Pilih Cabang...</option>');
	}
	if(data.type=="branch"){
	    optHtml='<option value="00" selected>Pilih Cabang...</option>';
	}
	for(i=0;i<data.content.length;i++)optHtml+='<option value="'+data.content[i][0]+'">'+data.content[i][1]+'</option>';
	$('#'+id).html(optHtml);
    }
</script>
<form class="form_class" id="id_form_nya">
    <div class="ajax_status"></div>
    <table class="form_layout">    
	<tr>
	    <td width="150">Perusahaan</td>
	    <td>
		<select name="company" id="company">
		    <option value="00" selected>Pilih Perusahaan ...</option>
		    <option value="1">Kopindosat</option>
                </select>
	    </td>
	</tr>
	<tr>
	    <td>Regional</td>
	    <td>
		<select name="regional_group" id="regional_group" width="100">
		    <option value="00" selected>Pilih Regional ...</option>
		</select>
	    </td>
	</tr>
	<tr>
	    <td>Wilayah</td>
	    <td><select name="region" id="region" width="100">
		    <option value="00" selected>Pilih Wilayah...</option>
		</select></td>
	</tr>
	<tr>
	    <td>Cabang</td>
	    <td>
		<select name="branch" id="branch" width="100">
		    <option value="00" selected>Pilih Cabang...</option>
		</select>
	    </td>
	</tr>
	<tr>
	    <td colspan="2" align="center">
		<input name="btn_continue" type="button" id="btn_continue" value="Lanjutkan" />
	    </td>
	</tr>
    </table>
</form>
<?php
}
else header("location: ".site_url('trial/warehouse'));
?>
