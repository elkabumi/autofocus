<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="SIKATT - Licensed to KOPINDOSAT" />
<meta name="keywords" content="finance keuangan erp ap ar cm kopindosat teramedia tmm" />
<meta name="author" content="Teramedia, Terafulk Holding" />
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<meta name="access" content="<?=$access?>" />
<link rel="shortcut icon" href="<?=base_url()?>images/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dsg/main/common.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dsg/main/app.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/south-street/jquery-ui-1.8rc3.custom.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dsg/menu/superfish.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dsg/menu/superfish-vertical.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dsg/datatables/demo_table_jui.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dsg/modal/jqModal.css" media="screen">

<?=$css?>
<style type="text/css">
	.focus { background-color: #F00; }
</style>

<script type="text/javascript"> var site_url = "<?=base_url()?>"; </script>
<script type="text/javascript"> var base_url = "<?=base_url()?>"; </script>
<script type="text/javascript"> var crud_mode = "<?=$access?>"; </script>

<script type="text/javascript" src="<?=base_url()?>js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery-ui-1.8rc3.custom.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>js/jquery.accordion.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.json.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/KeyTable.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/form.js"></script>

<script type="text/javascript" src="<?=base_url()?>js/jqModal.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.hoverIntent.minified.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/superfish.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.dataTables.plugin.js"></script>
<script type="text/javascript">
	var milisecond = 1000*'<?=$server_time?>';
	
    function getCurrentTime()
    {
        var currTime = new Date(milisecond);
		var timeStr = '<b>'+getDayName(currTime.getDay())+'</b>, '+currTime.getDate()+' '+ getMonthName(currTime.getMonth())+' '+currTime.getFullYear();
		milisecond+=1000;
        var hrs = currTime.getHours();
        var mnts = currTime.getMinutes();
        var secs = currTime.getSeconds();
        mnts = setTwoDigits(mnts);
        secs = setTwoDigits(secs);
        document.getElementById('clockTimer').innerHTML = timeStr+' &nbsp;'+hrs + ":" + mnts + ":" + secs;
        var timeOut = setTimeout("getCurrentTime()",1000);
    }
      
	$(function() {
	
		$('ul.sf-menu').superfish({delay:50, speed: 'fast', animation: {opacity:'show', height:'show'}});
		getCurrentTime();
		
		var menu_is_hidden = <?=$menu_is_hidden?>;
		
		if (menu_is_hidden == 0) $('#sidepanel').hide();
		
		$('#menuhide').click(function() {
			
			if (menu_is_hidden == 1) {
				simplePost('<?=site_url('home/setmenu/0')?>', null, function() {
					$('#sidepanel').hide(500, function() { menu_is_hidden = 0; });
				});
			} else {
				simplePost('<?=site_url('home/setmenu/1')?>', null, function() {
					$('#sidepanel').show(500, function() { menu_is_hidden = 1;	}); 
				});
			}
		}); 
		
	});
	
	
</script>
<?=$js?>

<title><?=$title?></title>
</head>

<body>
<div id="tracebox" style="background: #FFF; "></div>
<table style="position: absolute;"><tr><td class="centerblock">
<div class="sideshadow" ><div>
<table>
<tr><td>
	<table width="100%">
		<tr class="titlebar">
			<td width="121"><a href="<?=base_url()?>"><img src="<?=base_url()?>dsg/main/images/logo_app.png"  /></a></td>
			<td width="1"><img src="<?=base_url()?>dsg/main/images/titlebar_split.png" /></td>
			<td class="maintitle"><?=$title?></td>
			<td width="220" align="right" id="clockTimer" nowrap="nowrap">1 Mar 2010 &nbsp; 18:23</td>
			<td width="80" nowrap="nowrap">
				<a href="#" id="menuhide"><img src="<?=base_url()?>dsg/main/images/menuhide.png" title="Sembunyikan/Munculkan Menu" /></a>&nbsp;
				<a href="<?=site_url('help')?>"><img src="<?=base_url()?>dsg/main/images/helpguide.png" title="Panduan Penggunaan" /></a>&nbsp;
				<a href="<?=site_url('login/logout')?>"><img src="<?=base_url()?>dsg/main/images/btn_logout.png"  title="Keluar dari Aplikasi" /></a>
			</td>
		</tr>
	</table>
</td></tr>
<tr><td>
	<table>
		<tr>
			<td width="180" bgcolor="#7E7E7E" class="rightborder" id="sidepanel" valign="top">
				<div class="sideinfo">
					<div id="origin"><?=$branch_name?></div>
					<div id="person"><?=$user_name?></div>
					<div id="group"><?=$group_name?></div>
				</div>
				<?=$menu?>
			</td>
			<td class="desktop" height="800" valign="top">
				<?=$content?>
			</td>
		</tr>
	</table>
</td></tr>
<tr><td>
	<table width="100%" class="copyright"><tr>
		<td width="41"><img src="<?=base_url()?>dsg/main/images/logo_client.png" /></td>
		<td width="300"><h1><b>KIS - Kopindosat Information Systems</b></h1><h1>Licensed to Koperasi Pegawai Indosat</h1></td>
		<td>&nbsp;</td>
		<td width="300"><h2>Developed by <b>TERAMEDIA</b> - PT. Terafulk Multimedia</h2><h2>a Terafulk Multimedia & Software Division</h2></td>
		<td width="30"><img src="<?=base_url()?>dsg/main/images/logo_tmm.png" /></td>
	</tr></table>
</td></tr>
</table>
</div></div>
</td></tr></table>
<div class="ajaxProgressBox">Tunggu sebentar <img src="<?=base_url()?>dsg/main/images/ajax-loader.gif" style="display: right; vertical-align: middle; " /></div>
</body>
</html>
