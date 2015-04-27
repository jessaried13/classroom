<?php
echo $this->session->flashdata('saved');

?>

<!-- BEGIN NOTIFICATION PORTLET-->
<div class="widget red">
	<div class="widget-title">
	   <h4><i class="icon-bar-chart"></i> Booking Status and Inquiry Actions</h4>
	</div>
  <div class="widget-body">
	<div class="row-fluid">
		<!--BEGIN BUTTON STATES-->
		<div class="metro-nav metro-fix-view">
			
			<div class="metro-nav-block nav-block-red double">
				<a href="<?php echo site_url('bookings') ?>" data-original-title="">
					<i class="icon-plus-sign"></i>
					<div class="info">Room Reservation</div>
					<div class="status">Book a classroom</div>
				</a>
			</div>
			
			<div class="metro-nav-block nav-deep-terques double">
				<a href="<?php echo site_url('reservations') ?>" data-original-title="">
					<i class="icon-plus-sign"></i>
					<div class="info">Equipment Borrowing</div>
					<div class="status">Borrow equipments</div>
				</a>
			</div>
			
			
			<?php if(!$this->userauth->CheckAuthLevel(GUEST, $this->authlevel)) : ?>
			<div class="metro-nav-block nav-light-green double">
				<a href="<?php echo site_url('profile') ?>" data-original-title="">
					<i class="icon-question-sign"></i>
					<div class="info">Booking Status</div>
					<div class="status">Check booking status</div>
				</a>
			</div>
			
				<?php if(!$this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)) : ?>
			
					<div class="metro-nav-block nav-deep-red double">
						<a href="<?php echo site_url('profile/notification') ?>" data-original-title="">
							<i class="icon-question-sign"></i>
							<div class="info">Notifications</div>
							<div class="status">Check notifications</div>
						</a>
					</div>
			
				<?php endif; ?>
			
			<?php endif; ?>
			
			<!-- ADMIN ONLY -->
			
			<?php if($this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)) : ?>
			
			<?php
			
				$total_tasks = $this->userauth->GetNotificationPingReservation() + $this->userauth->GetNotificationPing();
			
			?>
		
			<div class="metro-nav-block nav-deep-red double">
				<a href="<?php echo site_url('profile/admin_index') ?>" data-original-title="">
					<i class="icon-building"></i>
					<div class="info"><?php echo ($total_tasks > 0) ? $total_tasks.' New Task' : 'No Notifications'; ?></div>
					<div class="status">View Admin Approval Notifications</div>
				</a>
			</div>
			
			<?php endif; ?>
			
			<!-- ADMIN ONLY -->
			
		</div>
		
		
		
		<!-- END BUTTON STATES -->
		</div>
  </div>
</div>
<!-- END NOTIFICATION PORTLET-->

<div class="space10"></div>

<?php if($this->userauth->CheckAuthLevel(ADMINISTRATOR, $this->authlevel)) : ?>

<!-- BEGIN NOTIFICATION PORTLET-->
<div class="widget blue">
	<div class="widget-title">
	   <h4><i class="icon-dashboard"></i> Administrator Actions</h4>
	</div>
  <div class="widget-body">
	<div class="row-fluid">
		<!--BEGIN BUTTON STATES-->
		<div class="metro-nav metro-fix-view">

			<div class="metro-nav-block nav-block-red double">
				<a href="<?php echo site_url('school/details') ?>" data-original-title="">
					<i class="icon-info"></i>
					<div class="info">School Details</div>
					<div class="status">Modify school details</div>
				</a>
			</div>
			
			<div class="metro-nav-block nav-deep-terques double">
				<a href="<?php echo site_url('periods') ?>" data-original-title="">
					<i class="icon-time"></i>
					<div class="info">School Period</div>
					<div class="status">Add/Modify room reservation period</div>
				</a>
			</div>
			
			<div class="metro-nav-block nav-light-green double">
				<a href="<?php echo site_url('weeks') ?>" data-original-title="">
					<i class="icon-calendar"></i>
					<div class="info">Week Cycle</div>
					<div class="status">Add/Modify week periods</div>
				</a>
			</div>
			
			<div class="metro-nav-block nav-block-purple double">
				<a href="<?php echo site_url('holidays') ?>" data-original-title="">
					<i class="icon-calendar-empty"></i>
					<div class="info">Holidays</div>
					<div class="status">Add/Modify holidays</div>
				</a>
			</div>
			
			<div class="metro-nav-block nav-deep-red double">
				<a href="<?php echo site_url('rooms') ?>" data-original-title="">
					<i class="icon-building"></i>
					<div class="info">Room List</div>
					<div class="status">Add/Modify rooms</div>
				</a>
			</div>
			
			<div class="metro-nav-block nav-light-blue double">
				<a href="<?php echo site_url('departments') ?>" data-original-title="">
					<i class="icon-hospital"></i>
					<div class="info">Departments</div>
					<div class="status">Add/Modify Departments</div>
				</a>
			</div>
			
			<div class="metro-nav-block nav-block-blue double">
				<a href="<?php echo site_url('types') ?>" data-original-title="">
					<i class="icon-hospital"></i>
					<div class="info">Room Types</div>
					<div class="status">Add/Modify Room Types</div>
				</a>
			</div>
			
			<div class="metro-nav-block nav-light-purple double">
				<a href="<?php echo site_url('item_types') ?>" data-original-title="">
					<i class="icon-hospital"></i>
					<div class="info">Equipment Types</div>
					<div class="status">Add/Modify Equipment Types</div>
				</a>
			</div>
			
			<div class="metro-nav-block nav-light-green double">
				<a href="<?php echo site_url('items') ?>" data-original-title="">
					<i class="icon-shopping-cart"></i>
					<div class="info">Item List</div>
					<div class="status">Add/Modify Items</div>
				</a>
			</div>
			
		</div>
		<!-- END BUTTON STATES -->
		</div>
  </div>
</div>
<!-- END NOTIFICATION PORTLET-->

<!-- BEGIN NOTIFICATION PORTLET-->
<div class="widget purple">
	<div class="widget-title">
	   <h4><i class="icon-group"></i> Administrator to User Actions</h4>
	</div>
  <div class="widget-body">
	<div class="row-fluid">
		<!--BEGIN BUTTON STATES-->
		<div class="metro-nav metro-fix-view">
			
			<div class="metro-nav-block nav-block-red double">
				<a href="<?php echo site_url('users') ?>" data-original-title="">
					<i class="icon-group"></i>
					<div class="info">Users</div>
					<div class="status">Add/Modify Users</div>
				</a>
			</div>

		</div>
		<!-- END BUTTON STATES -->
		</div>
  </div>
</div>
<!-- END NOTIFICATION PORTLET-->

<div class="space10"></div>

<?php endif; ?>