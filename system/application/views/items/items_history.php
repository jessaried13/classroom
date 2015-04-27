<?php
echo $this->session->flashdata('saved');
?>

<!-- Number of times reserved -->
<!-- Reserved by who and when : Reserved by (name_color red) on (date_color green) -->

<h3>Item Reservation Count : </h3>
<p>Item has been reserved <b style="color: red;"><?php echo $count ?></b> <?php if ($count == 1) { ?>time<?php } else { ?>times<?php } ?>.</p>

<p>&nbsp;</p>

<h3>Item Reservation History : </h3>
<!-- foreach -->
<?php foreach( $items as $item ){ ?>
	<p>Item has been reserved by <b style="color: red;"><?php echo $users[$item->user_id - 1]->displayname ?></b> for date <b style="color: #090;"><?php echo date("F jS, Y", strtotime($item->date)) ?></b> at time 
	<b style="color: #30F;"><?php echo $period[$item->period_id - 1]->time_start ?></b> to <b style="color: #30F;"><?php echo $period[$item->period_id - 1]->time_end ?></b></p></p>
<?php } ?>