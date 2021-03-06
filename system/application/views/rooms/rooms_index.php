<?php echo $this->session->flashdata('saved') ?>
<?php
$icondata[0] = array('rooms/add', 'Add Room', 'add.gif' );
$icondata[1] = array('rooms/roomhistory', 'View All Reservation History', 'school_manage_weeks_academicyear.gif');
$this->load->view('partials/iconbar', $icondata);
$jscript = '';
?>
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="table table-bordered table-striped sort-table" id="jsst-rooms">
	<col /><col /><col /><col />
	<thead>
	<tr class="heading">
		<td class="h" title="I"></td>
		<td class="h" title="Name">Name</td>
		<td class="h" title="Type">Room Type</td>
		<td class="h" title="Location">Location</td>
		<td class="h" title="Notes">Notes</td>
		<td class="h" title="Photo">Photo</td>
		<td class="n" title="X"></td>
	</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	if( $rooms ){
	foreach( $rooms as $room ){ ?>
	<tr class="tr<?php echo ($i & 1) ?>">
		<td><i class="icon-play"></i></td>
		<td><?php echo $room->name ?></td>
		<td><?php echo $type[$room->type_id - 1]->name ?></td>
		<td><?php echo $room->location ?></td>
		<td><?php echo $room->notes ?></td>
		<td width="60" align="center"><?php
		$photo_file = 'webroot/images/roomphotos/'.$room->room_id.'.jpg';
		/*if( file_exists( $photo_file ) ) {
			echo '<a href="'.$photo_file.'" title="View Photo"><img src="webroot/images/ui/picture.png" width="16" height="16" alt="View Photo" /></a>';
		} else {
			echo '&nbsp;';
		}*/
		
		if( $room->photo != '' ){
			$photo = 'webroot/images/roomphotos/640/'.$room->photo;
			$photo_sm = 'webroot/images/roomphotos/160/'.$room->photo;
			$jscript .= "messages[{$room->room_id}] = new Array('$photo_sm','{$room->name}');\n";
			if( file_exists($photo) ){
				echo '<a href="'.$photo.'" title="View Photo" onmouseover="doTooltip(event,'.$room->room_id.')" onmouseout="hideTip()"><img src="webroot/images/ui/picture.gif" width="16" height="16" alt="View Photo" /></a>'."\n";
			}
		}
		?>
		</td>
		<td width="45" class="n"><?php
			$actions['edit'] = 'rooms/edit/'.$room->room_id;
			$actions['delete'] = 'rooms/delete/'.$room->room_id;
			$this->load->view('partials/editdelete', $actions);
			?>
		</td>
	</tr>
	<?php $i++; }
	} else {
		echo '<td colspan="6" align="center" style="padding:16px 0">No rooms exist!</td>';
	}
	?>
	</tbody>
</table>
<script type="text/javascript">
<?php echo $jscript ?>
</script>
<?php $this->load->view( 'partials/iconbar', $icondata ); ?>
<?php
$jsst['name'] = 'st1';
$jsst['id'] = 'jsst-rooms';
$jsst['cols'] = array("Icon", "Name", "Location", "Notes", "Photo", "None");
$this->load->view('partials/js-sorttable', $jsst);
?>
