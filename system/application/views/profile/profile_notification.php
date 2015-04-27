<?php
echo $this->session->flashdata('saved');
?>

<div class="row-fluid">
	<div class="span12">
		<!-- BEGIN BASIC PORTLET-->
		<div class="widget green">
			<div class="widget-title">
				<h4><i class="icon-reorder"></i> Room Bookings</h4>
			<span class="tools">
				<a href="javascript:;" class="icon-chevron-down"></a>
				<a href="javascript:;" class="icon-remove"></a>
			</span>
			</div>
			<div class="widget-body">
				<table class="table table-striped table-bordered table-advance table-hover">
					<thead>
					<tr>
						<th>Booking ID</th>
						<th>Room Name</th>
						<th>Room Type</th>
						<th>Date</th>
						<th>Use Time</th>
						<th>Purpose</th>
						<th style="text-align: right;">Status</th>
					</tr>
					</thead>
					<tbody>
					<?php
					
						$i=0;
						
						if( $bookings )
						{
							foreach( $bookings as $booking )
							{ 
							
								if ($users[$booking->user_id - 1]->authlevel != 1) {
					?>
					<tr id="<?php echo $booking->booking_id ?>">
						<td><?php echo $booking->booking_id ?></td>
						<td><?php echo $rooms[$booking->room_id - 1]->name ?></td>
						<td><?php echo $types[$booking->room_id - 1]->name ?></td>
						<td>
						<?php if ($booking->date == NULL) : ?>
							<?php echo 'Admin Booking' ?>
							<?php else : ?>
							<?php echo date("F jS, Y", strtotime($booking->date)) ?>
						<?php endif; ?>
						</td>
						<td><?php echo $periods[$booking->period_id - 1]->time_start ?> - <?php echo $periods[$booking->period_id - 1]->time_end ?></td>
						<td><?php echo $booking->notes ?></td>
						<td style="text-align: right;">
							
							<?php if($booking->status == 1) { ?>
							
								<button class="btn btn-success" disabled="disabled"><i class="icon-ok icon-white"></i> Approved</button>
							
							<?php } else { ?>
							
								<button class="btn btn-danger" disabled="disabled"><i class="icon-remove icon-white"></i> Pending</button>
							
							<?php } ?>
							
						</td>
					</tr>
					<?php 
								} 
							$i++; 
						
							}
					
						} else {
							echo '<td colspan="6" align="center" style="padding:16px 0">No bookings that require approval exists!</td>';
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- END BASIC PORTLET-->
	</div>
</div>
<div class="space20"></div>

<div class="row-fluid">
	<div class="span12">
		<!-- BEGIN BASIC PORTLET-->
		<div class="widget blue">
			<div class="widget-title">
				<h4><i class="icon-reorder"></i> Item Reservations</h4>
			<span class="tools">
				<a href="javascript:;" class="icon-chevron-down"></a>
				<a href="javascript:;" class="icon-remove"></a>
			</span>
			</div>
			<div class="widget-body">
				<table class="table table-striped table-bordered table-advance table-hover">
					<thead>
					<tr>
						<th>Reservation ID</th>
						<th>Item Name</th>
						<th>Serial Number</th>
						<th>Date</th>
						<th>Use Time</th>
						<th>Purpose</th>
						<th style="text-align: right;">Status</th>
					</tr>
					</thead>
					<tbody>
					<?php
					
						$i=0;
						
						if( $reservations )
						{
							foreach( $reservations as $reservation )
							{ 
							
								if ($users[$reservation->user_id - 1]->authlevel != 1) {
					?>
					<tr id="<?php echo $reservation->reservation_id ?>">
						<td><?php echo $reservation->reservation_id ?></td>
						<td><?php echo $items[$reservation->item_id - 1]->name ?></td>
						<td><?php echo $items[$reservation->item_id - 1]->equipment_id ?></td>
						<td>
						<?php if ($reservation->date == NULL) : ?>
							<?php echo 'Admin Booking' ?>
							<?php else : ?>
							<?php echo date("F jS, Y", strtotime($reservation->date)) ?>
						<?php endif; ?>
						</td>
						<td><?php echo $periods[$reservation->period_id - 1]->time_start ?> - <?php echo $periods[$reservation->period_id - 1]->time_end ?></td>
						<td><?php echo $reservation->notes ?></td>
						<td style="text-align: right;">
							
							<?php if($reservation->status == 1) { ?>
							
								<button class="btn btn-success" disabled="disabled"><i class="icon-ok icon-white"></i> Approved</button>
							
							<?php } else { ?>
							
								<button class="btn btn-danger" disabled="disabled"><i class="icon-remove icon-white"></i> Pending</button>
							
							<?php } ?>
							
						</td>
					</tr>
					<?php 
								} 
							$i++; 
						
							}
					
						} else {
							echo '<td colspan="6" align="center" style="padding:16px 0">No bookings that require approval exists!</td>';
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- END BASIC PORTLET-->
	</div>
</div>
<div class="space20"></div>

