<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>Test Room Bookings | <?php echo ($title) ?></title>
   <base href="<?php echo $this->config->config['base_url'] ?>" />
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="Index" name="author" />
   <link href="webroot/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="webroot/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="webroot/assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
   <link href="webroot/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="webroot/css/style.css" rel="stylesheet" />
   <link href="webroot/css/style-responsive.css" rel="stylesheet" />
   <link href="webroot/css/style-default.css" rel="stylesheet" id="style_color" />
   <link rel="stylesheet" type="text/css" href="webroot/assets/chosen-bootstrap/chosen/chosen.css">
   
    <!-- data tables!-->
     <link rel="stylesheet" type="text/css" href="webroot/assets/datatables/jquery.dataTables.css">
     <link rel="stylesheet" type="text/css" href="webroot/assets/datatables/dataTables.tableTools.css">
     
    
   
   <link rel="stylesheet" type="text/css" href="webroot/assets/chosen-bootstrap/chosen/chosen.css" />
   
   <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

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
			   <!-- BEGIN RESPONSIVE MENU TOGGLER -->
               <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="arrow"></span>
               </a>
               <!-- END RESPONSIVE MENU TOGGLER -->
			   
			   

               
               <div id="not">
                   <ul class="nav pull-right top-menu" >
                       
                       <!-- BEGIN USER LOGIN DROPDOWN -->
                       <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               <img src="webroot/img/avatar1_small.jpg" alt="">
                               <span class="username"><?php echo (strlen($this->session->userdata('displayname')) > 1) ? $this->session->userdata('displayname') : $this->session->userdata('username'); ?></span>
                               <b class="caret"></b>
                           </a>
						   
                           <ul class="dropdown-menu extended logout">
                               
							    <?php if(!$this->userauth->CheckAuthLevel(GUEST, $this->authlevel)) { ?>
									<!--<li><a href="#"><i class="icon-user"></i> My Profile</a></li> !-->
                               		<li><a href="<?php echo site_url('logout') ?>"><i class="icon-key"></i> Log Out</a></li>
							   	<?php } else { ?>
							   		<li><a href="<?php echo site_url('login') ?>"><i class="icon-key"></i> Log In</a></li>
							   	<?php } ?>
								
                           </ul>
                       </li>
                       <!-- END USER LOGIN DROPDOWN -->
                   </ul>
                   <!-- END TOP NAVIGATION MENU -->
               </div>
               <div id="not" class="nav notify-row">
			   
			   
			   
			   <?php
			   
			   		if($this->userauth->CheckAuthLevel(ADMINISTRATOR)) {
			   
			   			$tasks = $this->userauth->GetTasks();
						
						$reserves = $this->userauth->GetReservations();
						
						$total_tasks = $this->userauth->GetNotificationPing() + $this->userauth->GetNotificationPingReservation()
			   
			   ?>
			   
                   <!-- BEGIN NOTIFICATION -->
                   <ul class="nav pull-right top-menu">
 
					   <!-- BEGIN BOOKINGS -->
					   <li class="dropdown">
						   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
							   <i class="icon-tasks"></i>
							   <?php echo ($total_tasks > 0) ? '<span class="badge badge-important">' .$total_tasks. '</span>' : '' ?>
						   </a>
						   <ul class="dropdown-menu extended tasks-bar">
							   <li>
								   <p>Pending Room Booking Approvals</p>
							   </li>
							   <?php
							   if ($tasks) {
							   		foreach($tasks as $task){
							   
							    ?>
							   <li>
								   <a href="<?php echo site_url("profile/admin_index") ?>">
									   <div class="task-info">
										 <div class="desc">Booking <b style="color: red;">#<?php echo $task->booking_id ?></b> requests approval.</div>
										 <div class="percent"></div>
									   </div>
									   <div class="progress progress-striped active no-margin-bot">
										   <div class="bar" style="width: 100%;"></div>
									   </div>
								   </a>
							   </li>
							   <?php }} else { ?>
							   <li>
								   <a href="<?php echo site_url("profile/admin_index") ?>">
									   <div class="task-info">
										 <div class="desc">No pending booking approvals.</div>
										 <div class="percent"></div>
									   </div>
									   <div class="progress progress-striped progress-info active no-margin-bot">
										   <div class="bar" style="width: 100%;"></div>
									   </div>
								   </a>
							   </li>
							   <?php } ?>
							   
							   <li>
								   <p>Pending Item Reservation Approvals</p>
							   </li>
							   <?php
							   		if ($reserves) {
							   			foreach($reserves as $reserve){
							   
							    ?>
							   <li>
								   <a href="<?php echo site_url("profile/admin_index") ?>">
									   <div class="task-info">
										 <div class="desc">Item Reservation <b style="color: red;">#<?php echo $reserve->reservation_id ?></b> requests approval.</div>
										 <div class="percent"></div>
									   </div>
									   <div class="progress progress-striped progress-success active no-margin-bot">
										   <div class="bar" style="width: 100%;"></div>
									   </div>
								   </a>
							   </li>
							   <?php }} else { ?>
							   
							   		<li>
								   <a href="<?php echo site_url("profile/admin_index") ?>">
									   <div class="task-info">
										 <div class="desc">No pending reservation approvals.</div>
										 <div class="percent"></div>
									   </div>
									   <div class="progress progress-striped progress-warning active no-margin-bot">
										   <div class="bar" style="width: 100%;"></div>
									   </div>
								   </a>
							   </li>
							   
							   <?php }}?>
						   </ul>
					   </li>
					   <!-- END BOOKINGS -->
					   
                   </ul>
               </div>
               <!-- END  NOTIFICATION -->
               
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
                      <span>Room Reservation</span>
                  </a>
              </li>
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('reservations') ?>">
                      <i class="icon-wrench"></i>
                      <span>Equipment Borrowing</span>
                  </a>
              </li>
			  
			  <!-- Start Admin Panels -->
			  
			  <?php if($this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)) : ?>
                          
                    <li class="sub-menu">
                  <a class="" href="<?php echo site_url('profile/admin_index') ?>">
                      <i class="icon-group"></i>
                      <span>Admin Approvals</span>
                  </a>
              </li>      
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('rooms') ?>">
                      <i class="icon-building"></i>
                      <span>Room List</span>
                  </a>
              </li>
			    
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('items') ?>">
                      <i class="icon-shopping-cart"></i>
                      <span>Item List</span>
                  </a>
              </li>
			  
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('users') ?>">
                      <i class="icon-group"></i>
                      <span>Users</span>
                  </a>
              </li>
			  
			  
              
              <li class="sub-menu">
                  <a class="" href="<?php echo site_url('item_groups') ?>">
                      <i class="icon-wrench"></i>
                      <span>Equipments</span>
                  </a>
              </li>
              
              <li class="sub-menu">
                  <a class="" href="<?php echo site_url('item_types') ?>">
                      <i class="icon-wrench"></i>
                      <span>Equipment Types</span>
                  </a>
              </li>
              
               <li class="sub-menu">
                  <a class="" href="<?php echo site_url('types') ?>">
                      <i class="icon-building"></i>
                      <span>Room Types</span>
                  </a>
              </li>
              
               <li class="sub-menu">
                  <a class="" href="<?php echo site_url('holidays') ?>">
                      <i class="icon-calendar-empty"></i>
                      <span>Holidays</span>
                  </a>
              </li>
              
               <li class="sub-menu">
                  <a class="" href="<?php echo site_url('periods') ?>">
                      <i class="icon-time"></i>
                      <span>School Periods</span>
                  </a>
              </li>
              
              <li class="sub-menu">
                  <a class="" href="<?php echo site_url('weeks') ?>">
                      <i class="icon-calendar"></i>
                      <span>Week Cycle</span>
                  </a>
              </li>
              
              <li class="sub-menu">
                  <a class="" href="<?php echo site_url('departments') ?>">
                      <i class="icon-hospital"></i>
                      <span>Departments</span>
                  </a>
              </li>
              
              <li class="sub-menu">
                  <a class="" href="<?php echo site_url('school/details') ?>">
                      <i class="icon-info"></i>
                      <span>School Details</span>
                  </a>
              </li>

			  <?php endif; ?>
			  <!-- End Admin Panels -->
			  
			  <?php if(!$this->userauth->CheckAuthLevel(GUEST, $this->authlevel)) : ?>
			  <li class="sub-menu">
                  <a class="" href="<?php echo site_url('profile') ?>">
                      <i class="icon-question-sign"></i>
                      <span>Booking Status</span>
                  </a>
              </li>
              <?php if(!$this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)) : ?>
			  
              <li class="sub-menu">
                  <a class="" href="<?php echo site_url('profile/notification') ?>">
                      <i class="icon-question-sign"></i>
                      <span>Notifications</span>
                  </a>
              </li>
              
              	  <?php endif; ?>
			  <?php endif; ?>
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

   <!-- BEGIN FOOTER
   <div id="footer">
       Test Footer
   </div>
   END FOOTER -->

   <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="webroot/js/jquery-1.8.3.min.js"></script>
   <script src="webroot/js/jquery.nicescroll.js" type="text/javascript"></script>
   <script type="text/javascript" src="webroot/assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
   <script type="text/javascript" src="webroot/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
   <script src="webroot/assets/bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="webroot/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="webroot/assets/datatables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="webroot/assets/datatables/dataTables.tableTools.js"></script>
   <script type="text/javascript" src="webroot/assets/datatables/dataTables.tableTools.min.js"></script>
   

   <!--common script for all pages-->
   <script src="webroot/js/common-scripts.js"></script>
   
   <script>
  $(function() {
    $( "#chosen_date" ).datepicker();
	$( "#date_start" ).datepicker({dateFormat: "dd/mm/yy"});
	$( "#date_end" ).datepicker({dateFormat: "dd/mm/yy"});
  });
  </script>
  
  <script>
$(document).ready(function(){
   // $('#jsst-users').dataTable();
   /* $('#jsst-items').dataTable();
    $('#historydt').dataTable();
    $('#ihistorydt').dataTable();
    $('#jsst-types').dataTable();*/
 
});



$(document).ready(function() {
    $('#jsst-items').DataTable( {
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "<?php echo base_url(); ?>webroot/assets/js/swf/copy_csv_xls_pdf.swf"
        }
    } );
} );

$(document).ready(function() {
    $('#historydt').DataTable( {
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "<?php echo base_url(); ?>webroot/assets/js/swf/copy_csv_xls_pdf.swf"
        }
    } );
} );

$(document).ready(function() {
    $('#ihistorydt').DataTable( {
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "<?php echo base_url(); ?>webroot/assets/js/swf/copy_csv_xls_pdf.swf"
        }
    } );
} );





</script>
  
  
<script>

jQuery("#drop").change(function () {
	var end = this.value;
	
	if (end == "showAll") {
		
		jQuery(".bookings tr").not("showAll").css("display", "");
		
	} else {
		
		jQuery(".bookings tr").filter("." + end).css("display", "");
		jQuery(".bookings tr").not("." + end).not(".noClass").not(".keyClass").css("display", "none");

	}
});

jQuery("#item_drop").change(function () {
	var end = this.value;
	
	if (end == "showAll") {
		
		jQuery(".span3").not("showAll").css("display", "");
		
	} else {
		
		jQuery(".span3").filter("." + end).css("display", "");
		jQuery(".span3").not("." + end).not(".noClass").not(".keyClass").css("display", "none");

	}
});

</script>

   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>

