<?php
echo $this->session->flashdata('saved');
?>

<!-- foreach -->
<div id="page-wraper">

	<div class="row-fluid">
	
		<div class="span12">
		
			<div class="widget purple">
			
				<div class="widget-title">
					<h4><i class="icon-reorder"></i> Today's Item Reservations</h4>
				</div>
				
				<div class="widget-body">
				
					<table class="table">
					
						<thead>
						
							<tr>
							
								<th>Borrower</th>
								<th>Equipment Name</th>
								<th>Serial Number</th>
								<th></th>
							
							</tr>
						
						</thead>
						
						<tbody>
						
						<?php if ($reservations) { ?>
						
						<?php foreach( $reservations as $reservation ){ ?>
						
							<?php if (date("F jS, Y", strtotime($reservation->date)) == date('F jS, Y')) {?>
							
								<tr>
									
									<td><b style="color: red;"><?php echo $users[$reservation->user_id - 1]->displayname ?> <br /> <?php echo $users[$reservation->user_id - 1]->username ?></b></td>
									<td><b style="color: red;"><?php echo $item_group[$items[$reservation->item_id - 1]->item_group_id - 1]->name ?></b></td>
									<td><b><?php echo $items[$reservation->item_id - 1]->equipment_id ?></b></td>									
									<td><a onclick="if(!confirm('Are you sure you want to confirm this reservation?')){return false;}" href="<?php echo site_url('items/status/'.$reservation->reservation_id); ?>"><button onclick="" class="btn btn-success"><i class="icon-ok"></i> Returned</button></a></td>
								
								</tr>
							
							<?php } ?>
						
							
						
						<?php } ?>
						
						<?php } ?>
						
						</tbody>
					
					</table>
				
				</div>
			
			</div>
		
		</div>
	
	</div>

</div>