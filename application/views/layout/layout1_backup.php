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


<!---->


<link rel="stylesheet" href="<?=base_url()?>assets/css/new_css/bootstrap.min.css" media="screen"/>
<link rel="stylesheet" href="<?=base_url()?>assets/css/new_css/font-awesome.min.css" media="screen"/>
<link rel="stylesheet" href="<?=base_url()?>assets/css/new_css/AdminLTE.css" media="screen"/>
<script type="text/javascript" charset="utf-8"> 

      
	$(function() {
		//$('ul.sf-menu').superfish();
		//$('#mainmenu').addClass('sf-vertical');
		//$('ul.sf-menu').superfish();{delay:50, speed: 'fast', animation: {opacity:'show', height:'show'}});
		$('ul.sf-menu').superfish({ dropShadows: false, delay: 1000,  animation: {opacity:'show', height:'show'} });
					
	});
</script> 	

</head>
  <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.html" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Wimbi Komunika</a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        
                       
                      
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                           <?php
                           if($logged){
						   ?> <a href="login/logout/1" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-share"></i>
                                <span>Logout </span>
                            </a>
                            <?php
						   }
							?>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-dark">
                                    <img src="assets/css/img/avatar3.png" class="img-circle" alt="User Image" />
                                    <p>
                                        Admin - Web Developer
                                    </p>
                                </li>
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                    <?=$logged?'<a href="'.site_url('login/logout').'" class="btn btn-default btn-flat">Logout</a> &nbsp;&nbsp;':''?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
     
<!------------------------------------------------------------->

                         <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                     <?php
                           if($logged){
						   ?>
                    <div class="user-panel">
                        <div class="pull-left image">
                            <!--<img src="assets/css/img/avatar3.png" class="img-circle" alt="User Image" />-->
                        </div>
                        <div class="pull-left info">
                            <p>Hello, Admin</p>

                            <a href="login/logout/1"><i class="fa fa-share text-success"></i> Logout</a>
                        </div>
                    </div>
                    <?php
						   }
					?>
                    <!-- search form -->
                  
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    
                     <ul class="sidebar-menu">
                     <?= $side_menu?>
                     
                    
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

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

