<?php
echo $this->session->flashdata('saved');
?>

<h3>Room Booking Count : </h3>
<p>Room has been booked <b style="color: red;"><?php echo $count ?></b> <?php if ($count == 1) { ?>time<?php } else { ?>times<?php } ?>.</p>

<p>&nbsp;</p>

<h3>Room Booking History : </h3>
<!-- foreach -->
<?php foreach( $rooms as $room ){ ?>
	<p>Room has been booked by <b style="color: red;"><?php echo $users[$room->user_id - 1]->displayname ?></b> for date <b style="color: #090;"><?php echo date("F jS, Y", strtotime($room->date)) ?></b> at time 
	<b style="color: #30F;"><?php echo $period[$room->period_id - 1]->time_start ?></b> to <b style="color: #30F;"><?php echo $period[$room->period_id - 1]->time_end ?></b></p>
<?php } ?>