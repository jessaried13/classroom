<?php echo $this->session->flashdata('saved') ?>
<?php
$icondata[0] = array('types/add', 'Add Type', 'add.gif' );
$this->load->view('partials/iconbar', $icondata);
?>
<table width="100%" cellpadding="2" cellspacing="2" border="0" class=" table table-bordered table-striped sort-table" id="jsst-types">
	<col /><col /><col /><col />
	<thead>
	<tr class="heading">
		<td class="h" title="I">Icon</td>
		<td class="h" title="Name">Type</td>
		<td class="h" title="Description">Description</td>
		<td class="n" title="X">&nbsp;</td>
	</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	if($types){
	foreach( $types as $type ){
	?>
	<tr class="tr<?php echo ($i & 1) ?>">
		<?php
		if( isset($type->icon) && $type->icon != '' && ! empty($type->icon)){
			list(,,,$img_wh) = @getimagesize('webroot/images/standardicons/'.$type->icon);
			$img_file = 'webroot/images/standardicons/'.$type->icon;
		} else {
			$img_wh = 'width="16" height="16"';
			$img_file = 'webroot/images/blank.gif';
		}
		?>
		<td width="50" align="center"><img src="<?php echo $img_file ?>" <?php echo $img_wh; ?>  alt=" " /></td>
		<td><?php echo $type->name ?></td>
		<td><?php echo $type->description ?></td>
		<td width="45" class="n"><?php
			$actions['edit'] = 'types/edit/'.$type->type_id;
			$actions['delete'] = 'types/delete/'.$type->type_id;
			$this->load->view('partials/editdelete', $actions);
			?>
		</td>
	</tr>
	<?php $i++; }
	} else {
		echo '<td colspan="4" align="center" style="padding:16px 0">No types exist!</td>';
	}
	?>
	</tbody>
</table>

<?php echo $pagelinks ?>

<?php $this->load->view('partials/iconbar', $icondata) ?>
<?php
$jsst['name'] = 'st1';
$jsst['id'] = 'jsst-types';
$jsst['cols'] = array("Icon", "Type", "Description", "None");
$this->load->view('partials/js-sorttable', $jsst);
?>
