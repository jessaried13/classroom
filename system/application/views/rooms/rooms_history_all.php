<?php
echo $this->session->flashdata('saved');
?>

<!-- foreach -->
<div id="page-wraper">

	<div class="row-fluid">
	
		<div class="span12">
		
			<div class="widget purple">
			
				<div class="widget-title">
					<h4><i class="icon-reorder"></i> Room Booking History</h4>
				</div>
				
				<div class="widget-body">
				
					<table class="table table-striped sort-table" id="historydt">
					
						<thead>
						
							<tr>
							
								<th>Room Name</th>
								<th>Room Type</th>
								<th>Use Date</th>
								<th>Use Time</th>
								<th>ID Number</th>
								<th>Name</th>
								<th>Notes</th>
							
							</tr>
						
						</thead>
						
						<tbody>
						
						<?php if ($bookings) { ?>
						
							<?php foreach( $bookings as $booking ){ ?>
							
								<tr>
								
									<td><b style="color: red;"><?php echo $rooms[$booking->room_id - 1]->name ?></b></td>
									<td><b><?php echo $types[$booking->room_id - 1]->name ?></b></td>
									<td><b style="color: #090;"><?php echo date("F jS, Y", strtotime($booking->date)) ?></b></td>
									<td><b style="color: #30F;"><?php echo $period[$booking->period_id - 1]->time_start ?></b> to <b style="color: #30F;"><?php echo $period[$booking->period_id - 1]->time_end ?></b></td>
									<td><b style="color: red;"><?php echo $users[$booking->user_id - 1]->username ?></b></td>
									<td><b style="color: red;"><?php echo $users[$booking->user_id - 1]->lastname ?>, <?php echo $users[$booking->user_id - 1]->firstname ?> </b></td>
									<td><?php echo $booking->notes ?></td>
								
								</tr>
							
							<?php } ?>
						
						<?php } ?>

						</tbody>
					
					</table>
				
				</div>
			
			</div>
		
		</div>
	
	</div>

</div>