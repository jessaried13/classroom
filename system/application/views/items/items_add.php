<?php
if( !isset($item_id) ){
	$item_id = @field($this->uri->segment(3, NULL), $this->validation->item_id, 'X');
}
$errorstr = $this->validation->error_string;

#echo $item_id;

echo form_open('items/save', array('class' => 'cssform', 'id' => 'items_add'), array('item_id' => $item_id) );

$t = 1;
?>

<p>

</p>

<fieldset><legend accesskey="R" tabindex="<?php echo $t; $t++; ?>">Item details</legend>

<!-- -->

<?php if ($item_groups != NULL) { ?>

<p>
	<label for="item_group_id">Item Name</label>
  <?php
	if($item_groups){
  	foreach($item_groups as $item_group){
	  	$item_grouplist[$item_group->item_group_id] = $item_group->name;		#@field($user->displayname, $user->username);
  	}
  }
	$item_group_id = @field($this->validation->group_id, $user->item_group_id, '0');
	echo form_dropdown('item_group_id', $item_grouplist, $item_group_id, 'tabindex="'.$t.'"');
	$t++;
	?>
</p>
<?php echo @field($this->validation->item_group_id_error) ?>

<?php } else {?>

	<div class="alert alert-error">
		<strong>OH NO!</strong> Please add an Equipment first.
	</div>

<?php } ?>	

<p>
  <label for="equipment" class="required">Equipment ID</label>
  <?php
	$equipment_id = @field($this->validation->equipment_id, $item->equipment_id);
	echo form_input(array(
		'name' => 'equipment_id',
		'id' => 'equipment_id',
		'size' => '30',
		'maxlength' => '40',
		'tabindex' => $t,
		'value' => $equipment_id,
	));
	$t++;
	?>
</p>
<?php echo @field($this->validation->equipment_error) ?>

<p>
  <label for="serial" class="required">Serial Number</label>
  <?php
	$serial = @field($this->validation->serial, $item->serial);
	echo form_input(array(
		'name' => 'serial',
		'id' => 'serial',
		'size' => '30',
		'maxlength' => '40',
		'tabindex' => $t,
		'value' => $serial,
	));
	$t++;
	?>
</p>
<?php echo @field($this->validation->serial) ?>


<p>
  <label for="location">Item Code</label>
  <?php
	$location = @field($this->validation->location, $item->location);
	echo form_input(array(
		'name' => 'location',
		'id' => 'location',
		'size' => '30',
		'maxlength' => '40',
		'tabindex' => $t,
		'value' => $location,
	));
	$t++;
	?>
</p>
<?php echo @field($this->validation->location_error) ?>

<p>
  <label for="notes">Notes</label>
  <?php
	$notes = @field($this->validation->notes, $item->notes);
	echo form_textarea(array(
		'name' => 'notes',
		'id' => 'notes',
		'rows' => '5',
		'cols' => '30',
		'tabindex' => $t,
		'value' => $notes,
	));
	$t++;
	?>
</p>
<?php echo @field($this->validation->user_id_error) ?>


<p>
  <label for="bookable">Can be reserved</label>
  <?php
	#$photo = @field($this->validation->name, $item->name);
	$bookable = @field($this->validation->bookable, $item->bookable);
	echo form_checkbox( array( 
		'name' => 'bookable',
		'id' => 'bookable',
		'value' => '1',
		'tabindex' => $t,
		'checked' => $bookable,
	));
	$t++;
	?>
</p>

<p>&nbsp;</p>
<p>&nbsp;</p>

<p>
  <label for="status">Item Status</label>
  <?php
	#$photo = @field($this->validation->name, $item->name);
	$status = @field($this->validation->status, $item->status);
	echo form_checkbox( array( 
		'name' => 'status',
		'id' => 'status',
		'value' => '1',
		'tabindex' => $t,
		'checked' => $status,
	));
	$t++;
	?>
</p>
<p>Tick this checkbox if item is currently on-hand. Otherwise, remove tick.</p>
</fieldset>

<?php if ($fields): ?>

<fieldset>
	
	<legend accesskey="F" tabindex="<?php echo $t; $t++; ?>">Fields</legend>

	<?php
	$tabindex = 12;
	
	foreach($fields as $field){

	echo '<p>';
	echo '<label>'.$field->name.'</label>';

		switch($field->type){
		
			case 'TEXT':
			
				$value = @field($fieldvalues[$field->field_id], NULL);
				echo form_input(array(
					'name' => 'f'.$field->field_id,
					'id' => 'f'.$field->field_id,
					'size' => '30',
					'maxlength' => '255',
					'tabindex' => $t,
					'value' => $value,	#$location,
				));
				break;
			
			
			case 'SELECT':
			
				$value = @field($fieldvalues[$field->field_id], NULL);
				$options = $field->options;
				foreach($options as $option){
					$opts[$option->option_id] = $option->value; 
				}
				echo form_dropdown('f'.$field->field_id, $opts, $value, 'tabindex="'.$t.'"');
				unset($opts);
				break;
				
				
			case 'CHECKBOX':

				$value = ( @field($fieldvalues[$field->field_id], NULL) == '1') ? true : false;
				echo form_checkbox( array( 
					'name' => 'f'.$field->field_id,
					'id' => 'f'.$field->field_id,
					'value' => '1',
					'tabindex' => $t,
					'checked' => $value,
				));
				break;

				
			}
		echo '</p>';
		
		$t++;
				
	}  // endforeach
	?>
	
</fieldset>

<?php endif; ?>




<?php
$submit['submit'] = array('Save', $t);
$submit['cancel'] = array('Cancel', $t+1, 'items');
$this->load->view('partials/submit', $submit);
echo form_close();
?>
