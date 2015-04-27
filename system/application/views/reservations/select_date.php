<form action="<?php echo site_url('reservations/load/'.$ninja_id) ?>" method="POST" name="reservations_book">
<table>
	<tr>
		<td valign="middle"><label for="chosen_date"><strong>Date:</strong></label></td>
		<td valign="middle">
			<input type="text" name="chosen_date" id="chosen_date" size="10" maxlength="10" value="<?php echo date("m/d/Y", $chosen_date) ?>" onchange="this.form.submit()" onblur="this.form.submit()" class="m-ctrl-medium"/>
		</td>
		
		<td> &nbsp; <input type="submit" value=" Load " /></td>
	</tr>
</table>
</form>

<br /> 

<?php echo @field($this->validation->chosen_date_error) ?>

<table border="0" cellpadding="4" cellspacing="4" class="reservations" align="center" style="border:1px solid #000;border-width:0px 0px;margin:16px auto;">
<tr>
<td width="20%" align="right" valign="middle"><strong>Legend:</strong></td>
<td class="free" width="20%" align="center">Free reservation</td>
<td class="static" width="20%" align="center">Class reservation</td>
<td class="staff" width="20%" align="center">Confirmed reservation</td>
<td class="reserve" width="20%" align="center">Pending reservation</td>
</tr></table>
