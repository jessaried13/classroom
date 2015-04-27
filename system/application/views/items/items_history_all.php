<?php
echo $this->session->flashdata('saved');
?>

<!-- foreach -->
<div id="page-wraper">

	<div class="row-fluid">
	
		<div class="span12">
		
			<div class="widget purple">
			
				<div class="widget-title">
					<h4><i class="icon-reorder"></i> Item Reservation History</h4>
				</div>
				
				<div class="widget-body">
				
					<table class="table table-striped sort-table" id="ihistorydt">
					
						<thead>
						
							<tr>
							
								<th>Equipment Name</th>
								<th>Serial Number</th>
								<th>Use Date</th>
								<th>Use Time</th>
								<th>ID Number</th>
								<th>Name</th>
								<th>Notes</th>
							
							</tr>
						
						</thead>
						
						<tbody>
                                                    
                                                    <?php if ($reservations) { ?>
						
                                                        <?php foreach( $reservations as $reservation ){ ?>

                                                                <tr>

                                                                        <td><b style="color: red;"><?php echo $item_group[$reservation->item_id - 1]->name ?> <!--- <?php echo $items[$reservation->item_id - 1]->location ?>!--></b></td>
                                                                        <td><b><?php echo $items[$reservation->item_id - 1]->equipment_id ?></b></td>
                                                                        <td><b style="color: #090;"><?php echo date("F jS, Y", strtotime($reservation->date)) ?></b></td>
                                                                        <td><b style="color: #30F;"><?php echo $period[$reservation->period_id - 1]->time_start ?></b> to <b style="color: #30F;"><?php echo $period[$reservation->period_id - 1]->time_end ?></b></td>
                                                                        <td><b style="color: red;"><?php echo $users[$reservation->user_id - 1]->username ?></b></td>
                                                                        <td><b style="color: red;"><?php echo $users[$reservation->user_id - 1]->lastname ?>, <?php echo $users[$reservation->user_id - 1]->firstname ?></b></td>
                                                                        <td><?php echo $reservation->notes ?></td>

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