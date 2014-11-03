<!DOCTYPE html>
<html><head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$title?></title>


   <script type="text/javascript" charset="utf-8"> 
var site_url = '<?=base_url()?>';
var crud_mode = "<?=$access?>";
</script> 
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/superfish.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/superfish-vertical.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/demo_table_jui.css" media="screen">

<?=$css?>
<?=$js?>
<script type="text/javascript" src="<?=base_url()?>assets/js/superfish.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.hoverIntent.minified.js"></script> 

<!--  jquery tmp -->
<script type="text/javascript" src="<?=base_url()?>assets/js/new_js/AdminLTE/app.js"> </script>

<!---->


<link rel="stylesheet" href="<?=base_url()?>assets/css/new_css/bootstrap.min.css" media="screen"/>
<link rel="stylesheet" href="<?=base_url()?>assets/css/new_css/font-awesome.min.css" media="screen"/>
<link rel="stylesheet" href="<?=base_url()?>assets/css/new_css/ionicons.min.css" media="screen"/>
<link rel="stylesheet" href="<?=base_url()?>assets/css/new_css/morris/morris.css" media="screen"/>

<!---chart morris-->
<link rel="stylesheet" href="<?=base_url()?>assets/css/new_css/AdminLTE.css" media="screen"/>


<script type="text/javascript" charset="utf-8"> 

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
		//$('ul.sf-menu').superfish();
		//$('#mainmenu').addClass('sf-vertical');
		//$('ul.sf-menu').superfish();{delay:50, speed: 'fast', animation: {opacity:'show', height:'show'}});
		$('ul.sf-menu').superfish({ dropShadows: false, delay: 100,  animation: {opacity:'show', height:'show'} });
		getCurrentTime();		
	});
</script> 	

</head>
  <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?=base_url()?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                POIN Online<br>
                <div class="little_logo">Purchase Order Inventory Online</div></a>
                
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a class="navbar-btn sidebar-toggle" role="button" data-toggle="offcanvas" href="#">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        
                       
                      
                       
                    </ul>
                </div>
            </nav>
        </header>
     
<!------------------------------------------------------------->

                           <div class="wrapper row-offcanvas row-offcanvas-left"   <?php
                           if(!$logged){
							   
						   ?>
						   
						   style="background-color:#f3f5f9 !important"<?php
                           }
                           ?>>
            <!-- Left side column. contains the logo and sidebar -->
             <?php
                           if($logged){
						   ?>
          
            
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                  
                    <!-- search form -->
                  
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                  
                    <?=$user_info?>
                
                     </li>
                     <?= $side_menu?>
                   
                   </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

			<?php
			}
			?>
            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
              
                <section class="content-header">
                    <h1>
                        <?php
						 $title  = explode("|", $title);
						 echo $title[1];
						 
						 ?>
                        <!--<small> test</small>-->
                    </h1>
                    <ol class="breadcrumb">
                   
                    	
                        <li class="active" style="font-weight:normal !important;"><?=$navigation?></li>
                    
                    </ol>
                </section>
            

                <!-- Main content -->
                <section class="content">
              <?=$content?>
                
                  <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
        
        		
  </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
   <div class="ajaxProgressBox">
<?php /*<img src="<?=base_url()?>images/ajax-loader.gif" style="display: right; vertical-align: middle; " />
*/?>
</div>

   

 <div class='tampung' style='visibelity:hidden'></div>  

    <!-- Page-Level Demo Scripts - Blank - Use for reference -->
			
		
</body>

</html>

