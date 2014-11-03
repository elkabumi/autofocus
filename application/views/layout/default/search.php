<script language="javascript">
$(function() {
	$('#formsearch').submit(function() {
		if(!$('#search').val()){
			$("#search").focus();
			return false;
		}
		$.ajax({
			url: $(this).attr('action'),
			async : false,
			dataType: 'json',
			type : 'GET', 
			data: $(this).serialize(),
			success: function(data){
				//$(".ajax_status").text(data.content).show().fadeOut(5000);
				if(data.type == 'redirect'){window.location.href = data.content;return false;}
				$(".ajax_status").html(data.content);
			}
		});
		
		return false;
	});
});
</script>
<div class="block_content">
<div class="search_form">
<form id="formsearch" action="<?=site_url($action_url)?>">
<input type="text" size="20" name="q" id="search" class="search_txt" />
<span><input title="Search" alt="Search" src="<?=base_url()?>assets/css/images/searchglass.png" class="image" type="image" /></span>
</form>
</div>
</div><br />
