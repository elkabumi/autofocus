<script type="text/javascript">
	var is_hit = 0;
	$(function(){			
		
		$("#company").change(function() {
			var company_id = this.value;
			var data = 'company_id='+company_id;
			$.ajax({
				type: 'POST',
				url: '<?=site_url('common/get_groupregion')?>',
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
				url: '<?=site_url('common/get_region')?>',
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
				url: '<?=site_url('common/get_branch')?>',
				data: data,
				dataType: 'json',
				success: appendToCombo
			});
		});
		$('#company')[0].selectedIndex = 0;
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
		var i, id,selectedValue, optHtml='',isSelected='';
		id=data.type;
		if(data.type=="regional_group"){
			optHtml='<option value="00" selected>Pilih Regional...</option>';
			$('#region').html('<option value="00" selected>Pilih Wilayah...</option>');
			$('#branch').html('<option value="00" selected>Pilih Cabang...</option>');
			selectedValue = parseInt('<?=$region_group_id?>');
			//$('#regional_group').change();
		}
		if(data.type=="region"){
			id="region";
			optHtml='<option value="00" selected>Pilih Wilayah...</option>';
			$('#branch').html('<option value="00" selected>Pilih Cabang...</option>');
			selectedValue = parseInt('<?=$region_id?>');
			//$('#regional')[0].selectedIndex = '<?=$region_id?>';
			//$('#regional').change();
		}
		if(data.type=="branch"){
			optHtml='<option value="00" selected>Pilih Cabang...</option>';
			selectedValue = parseInt('<?=$branch_id?>');
			//$('#branch')[0].selectedIndex = '<?=$region_id?>';
		}
		for(i=0;i<data.content.length;i++)
		{
			isSelected=(data.content[i][0]==selectedValue) ? 'selected="selected"':'';
			optHtml+='<option value="'+data.content[i][0]+'" '+isSelected+'>'+data.content[i][1]+'</option>';
		}
		$('#'+id).html(optHtml);
		if(is_hit)return;
		if(data.type=="regional_group"){
			$('#regional_group').change();
		}
		else if(data.type=="region"){
			$('#region').change();
		}
		else if(data.type=="branch"){
			is_hit = 1;
			if(selectedValue!=1){
				$('#company').attr('disabled','disabled');
				$('#regional_group').attr('disabled','disabled');
				$('#region').attr('disabled','disabled');
				$('#branch').attr('disabled','disabled');
			}
			//$('#branch')[0].selectedIndex = '<?=$branch_id?>';
		}
	}
</script>
<div class="form_category">Cabang</div>
 <? $is_enabled = ($branch_id==1)?'':'disabled="disabled"'; ?>
<table class="form_layout">    
    <tr>
      <td width="150">Perusahaan</td>
      <td>
        <select name="i_company" id="company" >
        <option value="1" selected>Kopindosat</option>
                </select>
      </td>
    </tr>
    <tr>
      <td>Regional</td>
      <td>
        <select name="i_regional_group" id="regional_group" width="100" init="<?=$region_group_id?>">
        <option value="00" selected>Pilih Regional ...</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Wilayah</td>
      <td><select name="i_region" id="region" width="100" init="<?=$region_id?>" >
         <option value="00" selected>Pilih Wilayah...</option>
                  </select></td>
    </tr>
    <tr>
      <td>Cabang</td>
      <td>
        <select name="i_branch" id="branch" width="100" init="<?=$branch_id?>">
           <option value="00" selected>Pilih Cabang...</option>
        </select>
        <?
        if($is_enabled)
        {
        ?>
        <input type="hidden" name="i_branch" value="<?=$branch_id?>">
        <input type="hidden" name="i_company" value="1">
      	<?
      	}
      	?>
      </td>
    </tr>
  </table>
