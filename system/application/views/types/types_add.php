<?php
if( !isset($type_id) ){
	$type_id = @field($this->uri->segment(3, NULL), $this->validation->type_id, 'X');
}
$errorstr = $this->validation->error_string;

echo form_open('types/save', array('class' => 'cssform', 'id' => 'type_add'), array('type_id' => $type_id) );
?>


<fieldset><legend accesskey="D" tabindex="1">Type Information</legend>
<p>
  <label for="name" class="required">Name</label>
  <?php
	$name = @field($this->validation->name, $type->name);
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


<p>
  <label for="description">Description</label>
  <?php
	$description = @field($this->validation->description, $type->description);
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
	$icon = @field($this->validation->icon, $type->icon);
	echo iconbox("icon", "standardicons", $icon, 'tabindex="4"');
	?>
	</div>
<?php echo @field($this->validation->icon_error) ?>
</p>

</fieldset>



<div class="submit" style="border-top:0px;">
  <?php echo form_submit(array('value' => 'Save', 'tabindex' => '5')) ?> 
	&nbsp;&nbsp; 
	<?php echo anchor('types', 'Cancel', array('tabindex' => '6')) ?>
</div>
