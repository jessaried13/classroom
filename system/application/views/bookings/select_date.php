<form action="<?php echo site_url('bookings/load') ?>" method="POST" name="bookings_book">
<table>
	<tr>
		<td valign="middle"><label for="chosen_date"><strong>Date:</strong></label></td>
		<td valign="middle">
			<input type="text" name="chosen_date" id="chosen_date" size="10" maxlength="10" value="<?php echo date("m/d/Y", $chosen_date) ?>" onchange="this.form.submit()" onblur="this.form.submit()"/>
			
		</td>
		
		<td> &nbsp; <input type="submit" value=" Load " /></td>
	</tr>
</table>
</form>

<br /> 

<?php echo @field($this->validation->chosen_date_error) ?>

<div class="control-group">
	<label class="control-label">Dropdown Filter</label>
	<div class="controls">
		<select class="span3" tabindex="1" id="drop">
				<option value="showAll">Show All</option>
			<?php foreach($types as $type){ ?>
				<option value="<?php echo 'filter-'.$type->type_id ?>"><?php echo $type->name ?></option>
			<?php } ?>
		</select>
	</div>
</div>

<table border="0" cellpadding="4" cellspacing="4" class="bookings" align="center" style="border:1px solid #000;border-width:0px 0px;margin:16px auto;">
<tr class="keyClass">
<td width="20%" align="right" valign="middle"><strong>Legend:</strong></td>
<td class="free" width="20%" align="center">Free booking</td>
<td class="static" width="20%" align="center">Class booking</td>
<td class="staff" width="20%" align="center">Confirmed booking</td>
<td class="reserve" width="20%" align="center">Pending booking</td>
</tr></table>




