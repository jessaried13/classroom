<?php echo $this->session->flashdata('saved') ?>
<?php
$icondata[0] = array('items/add', 'Add Equipment Item', 'add.gif' );
$icondata[1] = array('items/itemhistory', 'View All Reservation History', 'school_manage_weeks_academicyear.gif');
$icondata[2] = array('items/currentreservations', 'Equipment Reservation Today', 'school_manage_search.gif');
$this->load->view('partials/iconbar', $icondata);
$jscript = '';
?>
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="table table-striped table-bordered sort-table" id="jsst-items">
	<col /><col /><col /><col />
	<thead>
	<tr class="heading">
		<td class="h" title="Blank"></td>
		<td class="h" title="Name">Name</td>
		<td class="h" title="Equipment ID">Equipment ID</td>
		<td class="h" title="Serial Number">Serial Number</td>
		<td class="h" title="Notes">Notes</td>
		<!--<td class="h" title="Photo">Photo</td>!-->
		<td class="n" title="X"></td>
	</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	if( $items ){
	foreach( $items as $item ){ ?>
	<tr class="tr<?php echo ($i & 1) ?>">
		<td><i class="icon-play"></i></td>
		<td><?php echo $item->item_group_name ?> - <?php echo $item->location ?></td> <!-- change this -->
		<td><?php echo $item->equipment_id ?></td>
		<td><?php echo $item->serial ?></td>
		<td><?php echo $item->notes ?></td>
		<!--<td width="60" align="center"><?php
		$photo_file = 'webroot/images/roomphotos/'.$item->item_id.'.jpg';
		/*if( file_exists( $photo_file ) ) {
			echo '<a href="'.$photo_file.'" title="View Photo"><img src="webroot/images/ui/picture.png" width="16" height="16" alt="View Photo" /></a>';
		} else {
			echo '&nbsp;';
		}*/
		
		if( $item->photo != '' ){
			$photo = 'webroot/images/roomphotos/640/'.$item->photo;
			$photo_sm = 'webroot/images/roomphotos/160/'.$item->photo;
			$jscript .= "messages[{$item->item_id}] = new Array('$photo_sm','{$item->name}');\n";
			if( file_exists($photo) ){
				echo '<a href="'.$photo.'" title="View Photo" onmouseover="doTooltip(event,'.$item->item_id.')" onmouseout="hideTip()"><img src="webroot/images/ui/picture.gif" width="16" height="16" alt="View Photo" /></a>'."\n";
			}
		}
		?>
		</td> !-->
		<td width="45" class="n"><?php
			$actions['edit'] = 'items/edit/'.$item->item_id;
			$actions['delete'] = 'items/delete/'.$item->item_id;
			$this->load->view('partials/editdelete', $actions);
			?>
		</td>
	</tr>
	<?php $i++; }
	} else {
		echo '<td colspan="6" align="center" style="padding:16px 0">No items exist!</td>';
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
$jsst['id'] = 'jsst-items';
$jsst['cols'] = array("Icon", "Name", "Equipment ID", "Serial Number", "Notes", "Photo", "None");
$this->load->view('partials/js-sorttable', $jsst);
?>
