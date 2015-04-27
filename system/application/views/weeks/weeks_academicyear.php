<?php
echo $this->session->flashdata('saved');
echo form_open('weeks/saveacademicyear', array('class' => 'cssform', 'id' => 'saveacademicyear') );
?>


<fieldset style="width:50%"><legend accesskey="A" tabindex="1">Academic year</legend>

<p>
  <label for="date_start" class="required">Start date:</label>
  <?php
	$date_start = @field($this->validation->date_start, date("d/m/Y", strtotime($academicyear->date_start)));
	#echo $date_start;
	echo form_input(array(
		'name' => 'date_start',
		'id' => 'date_start',
		'size' => '10',
		'maxlength' => '10',
		'tabindex' => '2',
		'value' => $date_start,
	));
	?>
	<small>Click on the textfield to open up the Start Date calendar</small>
</p>
<?php echo @field($this->validation->date_start_error) ?>


<p>
  <label for="date_end" class="required">End date:</label>
  <?php
	$date_end = @field($this->validation->date_end, date("d/m/Y", strtotime($academicyear->date_end)));
	echo form_input(array(
		'name' => 'date_end',
		'id' => 'date_end',
		'size' => '10',
		'maxlength' => '10',
		'tabindex' => '2',
		'value' => $date_end,
	));
	?>
	<small>Click on the textfield to open up the End Date calendar</small>
</p>
<?php echo @field($this->validation->date_end_error) ?>
</fieldset>

<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Save</button>

<?php
$submit['submit'] = array('Save', '5');
echo form_close();
?>
