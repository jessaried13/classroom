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
						<th>Booked By</th>
                                                <th>User Type </th>
						<th>Date</th>
						<th>Use Time</th>
						<th>Notes</th>
						<th style="text-align: right;">Action</th>
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
                                                <td><?php echo $users[$booking->user_id - 1]->lastname ?>, <?php echo $users[$booking->user_id - 1]->firstname ?> </td>
						<td><?php if($users[$booking->user_id - 1]->authlevel == 2) echo "Student"; else echo "Teacher"; ?>
                                             <!--<td><?php echo $users[$booking->user_id - 1]->displayname ?></td>!-->
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
							
							<a onclick="if(!confirm('Are you sure you want to accept this booking?')){return false;}" href="<?php echo site_url('bookings/accept/'.$booking->booking_id); ?>"><button onclick="" class="btn btn-success"><i class="icon-ok"></i> Approve</button></a>
							<a onclick="if(!confirm('Are you sure you want to reject this booking?')){return false;}" href="<?php echo site_url('bookings/reject/'.$booking->booking_id); ?>"><button class="btn btn-danger"><i class="icon-remove "></i> Reject</button></a>
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
						<th>Reserved By</th>
                                                <th>User Type </th>
						<th>Date</th>
						<th>Use Time</th>
						<th>Notes</th>
						<th style="text-align: right;">Action</th>
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
						<td><?php echo $item_groups[$reservation->item_id - 1]->name ?> - <?php echo $item_groups[$reservation->item_id - 1]->name ?><?php echo $items[$reservation->item_id - 1]->location ?></td>
						<td><?php echo $items[$reservation->item_id - 1]->equipment_id ?></td>
                                                <td><?php echo $users[$booking->user_id - 1]->lastname ?>, <?php echo $users[$booking->user_id - 1]->firstname ?> </td>
						<td><?php if($users[$booking->user_id - 1]->authlevel == 2) echo "Student"; else echo "Teacher"; ?>
                                                <!--<td><?php echo $users[$reservation->user_id - 1]->displayname ?></td>!-->
						<td>
						<?php if ($reservation->date == NULL) : ?>
							<?php echo 'Admin Reservation' ?>
							<?php else : ?>
							<?php echo date("F jS, Y", strtotime($reservation->date)) ?>
						<?php endif; ?>
						</td>
						<td><?php echo $periods[$reservation->period_id - 1]->time_start ?> - <?php echo $periods[$reservation->period_id - 1]->time_end ?></td>
						<td><?php echo $reservation->notes ?></td>
						<td style="text-align: right;">
							
							<a onclick="if(!confirm('Are you sure you want to accept this reservation?')){return false;}" href="<?php echo site_url('reservations/accept/'.$reservation->reservation_id); ?>"><button onclick="" class="btn btn-success"><i class="icon-ok"></i> Approve</button></a>
							<a onclick="if(!confirm('Are you sure you want to reject this reservation?')){return false;}" href="<?php echo site_url('reservations/reject/'.$reservation->reservation_id); ?>"><button class="btn btn-danger"><i class="icon-remove "></i> Reject</button></a>
						</td>
					</tr>
					<?php 
								} 
							$i++; 
						
							}
					
						} else {
							echo '<td colspan="6" align="center" style="padding:16px 0">No reservations that require approval exists!</td>';
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

