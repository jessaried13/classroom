<?php
echo $this->session->flashdata('saved');
?>

<div class="row-fluid">
	<div class="span12">
		<!-- BEGIN BASIC PORTLET-->
		<div class="widget orange">
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
						<th>Reserved By</th>
						<th>Date</th>
						<th>Notes</th>
						<th>Action</th>
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
						<td><?php echo $reservation->reservation_id ?></a></td>
						
						<td><?php echo $users[$reservation->user_id - 1]->displayname ?></td>
						<td>
						<?php if ($reservation->date == NULL) : ?>
							<?php echo 'Admin Reservation' ?>
							<?php else : ?>
							<?php echo $reservation->date ?>
						<?php endif; ?>
						</td>
						<td><?php echo $reservation->notes ?></td>
						<td>
							
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
