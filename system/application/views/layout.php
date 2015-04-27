<?php
echo $this->session->flashdata('saved');

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>Test Room Bookings | <?php echo strtolower($title) ?></title>
   <base href="<?php echo $this->config->config['base_url'] ?>" />
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="Mosaddek" name="author" />
   <link href="webroot/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="webroot/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="webroot/assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
   <link href="webroot/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="webroot/css/style.css" rel="stylesheet" />
   <link href="webroot/css/style-responsive.css" rel="stylesheet" />
   <link href="webroot/css/style-default.css" rel="stylesheet" id="style_color" />

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
   <!-- BEGIN HEADER -->
   <div id="header" class="navbar navbar-inverse navbar-fixed-top">
       <!-- BEGIN TOP NAVIGATION BAR -->
       <div class="navbar-inner">
           <div class="container-fluid">
               <!--BEGIN SIDEBAR TOGGLE-->
               <div class="sidebar-toggle-box hidden-phone">
                   <div class="icon-reorder tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
               </div>
               <!--END SIDEBAR TOGGLE-->
               <!-- BEGIN LOGO -->
               <a class="brand" href="index.html">
                   <!-- Insert Logo Here -->
               </a>
               <!-- END LOGO -->

               <div id="top_menu" class="nav notify-row">
                   <!-- BEGIN NOTIFICATION -->
                   <ul class="nav top-menu">
                      
                       
                       <!-- Notifications, if applicable -->

                   </ul>
               </div>
               <!-- END  NOTIFICATION -->
               <div class="top-nav ">
                   <ul class="nav pull-right top-menu" >
                       
                       <!-- BEGIN USER LOGIN DROPDOWN -->
                       <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               <img src="img/avatar1_small.jpg" alt="">
                               <span class="username"><?php echo (strlen($this->session->userdata('displayname')) > 1) ? $this->session->userdata('displayname') : $this->session->userdata('username'); ?></span>
                               <b class="caret"></b>
                           </a>
                           <ul class="dropdown-menu extended logout">
                               <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
                               <li><a href="<?php echo site_url('logout') ?>"><i class="icon-key"></i> Log Out</a></li>
                           </ul>
                       </li>
                       <!-- END USER LOGIN DROPDOWN -->
                   </ul>
                   <!-- END TOP NAVIGATION MENU -->
               </div>
           </div>
       </div>
       <!-- END TOP NAVIGATION BAR -->
   </div>
   <!-- END HEADER -->
   <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->
      <div class="sidebar-scroll">
        <div id="sidebar" class="nav-collapse collapse">

         <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
         <div class="navbar-inverse">
            <form class="navbar-search visible-phone">
               <input type="text" class="search-query" placeholder="Search" />
            </form>
         </div>
         <!-- END RESPONSIVE QUICK SEARCH FORM -->
         <!-- BEGIN SIDEBAR MENU -->

          <ul class="sidebar-menu">
              <li class="sub-menu active">
                  <a class="" href="<?php echo site_url('controlpanel') ?>">
                      <i class="icon-dashboard"></i>
                      <span>Dashboard</span>
                  </a>
              </li>
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('bookings') ?>">
                      <i class="icon-home"></i>
                      <span>Room Bookings</span>
                  </a>
              </li>
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('bookings') ?>">
                      <i class="icon-wrench"></i>
                      <span>Item Reservations</span>
                  </a>
              </li>
			  
			  <!-- Start Admin Panels -->
			  
			  <?php if($this->userauth->CheckAuthLevel(ADMINISTRATOR, $authlevel)) : ?>
		  
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('school/details') ?>">
                      <i class="icon-info"></i>
                      <span>School Details</span>
                  </a>
              </li>
			  
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('periods') ?>">
                      <i class="icon-time"></i>
                      <span>School Days</span>
                  </a>
              </li>
			  
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('weeks') ?>">
                      <i class="icon-calendar"></i>
                      <span>Week Cycle</span>
                  </a>
              </li>
			  
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('holidays') ?>">
                      <i class="icon-calendar-empty"></i>
                      <span>Holidays</span>
                  </a>
              </li>
			  
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('rooms') ?>">
                      <i class="icon-building"></i>
                      <span>Rooms</span>
                  </a>
              </li>
			  
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('departments') ?>">
                      <i class="icon-hospital"></i>
                      <span>Departments</span>
                  </a>
              </li>
			  
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('types') ?>">
                      <i class="icon-warning-sign"></i>
                      <span>Room Type</span>
                  </a>
              </li>
			  
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('users') ?>">
                      <i class="icon-group"></i>
                      <span>Users</span>
                  </a>
              </li>
			  
			  <?php endif; ?>
			  <!-- End Admin Panels -->
			  
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('profile') ?>">
                      <i class="icon-question-sign"></i>
                      <span>Booking Status</span>
                  </a>
              </li>
			  
          </ul>
         <!-- END SIDEBAR MENU -->
      </div>
      </div>
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->  
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">

                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                   <h3 class="page-title">
                     Dashboard
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li class="active">
                           <?php if(isset($showtitle)){ echo $showtitle; } ?>
                       </li>
                       <li class="pull-right search-wrap">
                           <form action="search_result.html" class="hidden-phone">
                               <div class="input-append search-input-area">
                                   <input class="" id="appendedInputButton" type="text">
                                   <button class="btn" type="button"><i class="icon-search"></i> </button>
                               </div>
                           </form>
                       </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
				<?php echo $body ?>
            </div>

            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->

   <!-- BEGIN FOOTER -->
   <div id="footer">
       Test Footer
   </div>
   <!-- END FOOTER -->

   <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="webroot/js/jquery-1.8.3.min.js"></script>
   <script src="webroot/js/jquery.nicescroll.js" type="text/javascript"></script>
   <script type="text/javascript" src="webroot/assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
   <script type="text/javascript" src="webroot/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
   <script src="webroot/assets/bootstrap/js/bootstrap.min.js"></script>

   <!--common script for all pages-->
   <script src="webroot/js/common-scripts.js"></script>
   
   <script>
  $(function() {
    $( "#chosen_date" ).datepicker();
	$( "#date_start" ).datepicker();
	$( "#date_end" ).datepicker();
  });
  </script>

   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>

