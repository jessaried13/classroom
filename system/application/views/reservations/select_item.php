<?php
$itemlist = array();
$itemphoto = array();
foreach($items as $item){
	$itemlist[$item->item_id] = $item->name;
	if($item->photo != NULL){
		$itemphoto[$item->item_id] = TRUE;
	} else {
		#$itemphoto[$item->item_id] = FALSE;
	}
}
?>
<form action="<?php echo site_url('reservations/load') ?>" method="POST">
<?php echo form_hidden('chosen_date', $chosen_date) ?>
<table>
	<tr>
		<td valign="middle">
			<label for="item_id">
				<?php
				$url = site_url('items/info/'.$this->school_id.'/'.$item_id);
				if(isset($itemphoto[$item_id])){
					$width = 760;
				} else {
					$width = 400;
				}
				?>
				<strong>
					<a onclick="window.open('<?php echo $url ?>','','width=<?php echo $width ?>,height=360,scrollbars');return false;" href="<?php echo $url ?>" title="View Item Information">Item</a>:
				</strong>
			</label>
		</td>
		<td valign="middle">
			<?php
			echo form_dropdown(
				'item_id',
				$itemlist,
				$item_id,
				'onchange="this.form.submit()" onmouseup="this.form.submit"'
			);
		?>
		</td>
		<td> &nbsp; <input type="submit" value=" Load " /></td>
	</tr>
</table>
</form>

<br />
