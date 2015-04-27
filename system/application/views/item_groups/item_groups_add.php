<?php
if( !isset($item_group_id) ){
	$item_group_id = @field($this->uri->segment(3, NULL), $this->validation->item_group_id, 'X');
}
$errorstr = $this->validation->error_string;

echo form_open_multipart('item_groups/save', array('class' => 'cssform', 'id' => 'item_group_add'), array('item_group_id' => $item_group_id) );
?>


<fieldset><legend accesskey="D" tabindex="1">Equipment Details</legend>
<p>
  <label for="name" class="required">Name</label>
  <?php
	$name = @field($this->validation->name, $item_group->name);
	echo form_input(array(
		'name' => 'name',
		'id' => 'name',
		'size' => '20',
		'maxlength' => '50',
		'tabindex' => '2',
		'value' => $name,
	));
	?>
</p>
<?php echo @field($this->validation->name_error) ?>

<?php if ($item_types != NULL) { ?>

<p>
	<label for="item_type_id">Equipment Type</label>
  <?php
	if($item_types){
  	foreach($item_types as $item_type){
	  	$item_typelist[$item_type->item_type_id] = $item_type->name;		#@field($user->displayname, $user->username);
  	}
  }
	$item_type_id = @field($this->validation->type_id, $user->item_type_id, '0');
	echo form_dropdown('item_type_id', $item_typelist, $item_type_id);
	?>
</p>
<?php echo @field($this->validation->item_type_id_error) ?>

<?php } else {?>

	<div class="alert alert-error">
		<strong>OH NO!</strong> Please add an Equipment Type first.
	</div>

<?php } ?>


<p>
  <label for="description">Description</label>
  <?php
	$description = @field($this->validation->description, $item_group->description);
	echo form_input(array(
		'name' => 'description',
		'id' => 'description',
		'size' => '50',
		'maxlength' => '255',
		'tabindex' => '3',
		'value' => $description,
	));
	?>
</p>
<?php echo @field($this->validation->description_error) ?>


<p>
  <label for="icon">Icon</label>
  <div class="iconbox" style="width:auto;height:180px">
  <?php
	$icon = @field($this->validation->icon, $item_group->icon);
	echo iconbox("icon", "standardicons", $icon, 'tabindex="4"');
	?>
	</div>
<?php echo @field($this->validation->icon_error) ?>
</p>

</fieldset>

<fieldset><legend accesskey="P" tabindex="7">Photograph</legend>
Please use this section to upload an optional photograph of the item to enable easier identification.<br /><br />
The main photo will be resized to 640x480, and small thumbnails will be created.

<p>
  <label>Current photo</label>
  <?php
	if( isset($item->photo) && $item->photo != ''){
		$photo['640'] = 'webroot/images/roomphotos/640/'.$item->photo;
		$photo['160'] = 'webroot/images/roomphotos/160/'.$item->photo;
		if( file_exists($photo['160']) && file_exists($photo['640']) ){
			echo '<a href="'.$photo['640'].'" title="View Photo">';
			echo '<img src="'.$photo['160'].'" width="160" height="120" style="padding:1px;border:1px solid #ccc" alt="View Photo" />';
			echo '</a>';
		} else {
			echo '<em>None on file</em>';
		}
	} else {
		echo '<em>None in database</em>';
	}
	/*$photo_file = 'webroot/images/roomphotos/'.$item_id.'.jpg';
	if( file_exists( $photo_file ) ) {
		#echo '<a href="'.$photo_file.'" title="View Photo"><img src="webroot/images/ui/picture.png" width="16" height="16" alt="View Photo" /></a>';
		echo '<img src="'.$photo_file.'" width="160" height="120" style="padding:1px;border:1px solid #ccc" />';		
	} else {
		echo '<em>None</em>';
	}*/
	?>
</p>

<p>
  <label for="userfile">File upload</label>
  <?php
	#$photo = @field($this->validation->photo, $item->photo);
	echo form_upload(array(
		'name' => 'userfile',
		'id' => 'userfile',
		'size' => '30',
		'maxlength' => '255',
		'value' => '',
	));
	?>
	<p class="hint">Uploading a new photo will <span>overwrite</span> the current one.</p>
</p>
<?php if($this->session->flashdata('image_error') != '' ){ ?>
<p class="hint error"><span><?php echo $this->session->flashdata('image_error') ?></span></p>
<?php } ?>

 
</fieldset>

<div class="submit" style="border-top:0px;">
  <?php echo form_submit(array('value' => 'Save', 'tabindex' => '5')) ?> 
	&nbsp;&nbsp; 
	<?php echo anchor('item_groups', 'Cancel', array('tabindex' => '6')) ?>
</div>
