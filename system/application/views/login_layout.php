<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="utf-8" />
		<title>Test Room Bookings | <?php echo strtolower($title) ?></title>
		<base href="<?php echo $this->config->config['base_url'] ?>" />
		<meta content="width=device-width, initial-scale=1.0" name="viewport" />
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>webroot/login/style.css" />
		<script src="<?php echo base_url() ?>webroot/js/modernizr.custom.63321.js"></script>

		<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
		
		<style>
		
		button.close {
  padding: 0;
  cursor: pointer;
  background: transparent;
  border: 0;
  -webkit-appearance: none;
		}
		
		.close {
  float: right;
  font-size: 20px;
  font-weight: bold;
  line-height: 20px;
  color: #000;
  text-shadow: 0 1px 0 #fff;
  opacity: .2;
  filter: alpha(opacity=20);
}
			
			.alert {
  padding: 8px 35px 8px 14px;
  margin-bottom: 20px;
  text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
  background-color: #fcf8e3;
  border: 1px solid #fbeed5;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}

.alert,
.alert h4 {
  color: #c09853;
}

.alert h4 {
  margin: 0;
}

.alert .close {
  position: relative;
  top: -2px;
  right: -21px;
  line-height: 20px;
}

.alert-success {
  color: #468847;
  background-color: #dff0d8;
  border-color: #d6e9c6;
}

.alert-success h4 {
  color: #468847;
}

.alert-danger,
.alert-error {
  color: #b94a48;
  background-color: #f2dede;
  border-color: #eed3d7;
}

.alert-danger h4,
.alert-error h4 {
  color: #b94a48;
}

.alert-info {
  color: #3a87ad;
  background-color: #d9edf7;
  border-color: #bce8f1;
}

.alert-info h4 {
  color: #3a87ad;
}

.alert-block {
  padding-top: 14px;
  padding-bottom: 14px;
}

.alert-block > p,
.alert-block > ul {
  margin-bottom: 0;
}

.alert-block p + p {
  margin-top: 5px;
}

		
		</style>
    </head>
    <body>
        <div class="container">
			
			<?php echo $this->session->flashdata('auth') ?>
			
			<?php

	 			$attributes = array('class' => 'form-1');

			?>
						
			<section class="main">
					<?php
						$t = 1;
						echo form_open('login/submit', $attributes);
					?>
					
					<p>
					
						<h3 style="color: red;">SYSTEM LOGIN</h3>
					
					</p>
					
					<p style="font-size: 13px; margin: 20px 0 20px 0;">
					
						To log-in to the system, request for an account registration from the <span style="color: red;">System Administrator</span>.
					
					</p>
										
					<p class="field">
                     <?php
						$username = @field($this->validation->username);
						echo form_input(array(
							'name' => 'username',
							'id' => 'username',
							'size' => '20',
							'maxlength' => '20',
							'tabindex' => $t,
							'value' => $username,
							'placeholder' => 'Student Number',
						));
						$t++;
						?>
					<?php echo @field($this->validation->username_error); ?>
						<i class="icon-user icon-large"></i>
					</p>
						<p class="field">
							<?php
								$password = @field($this->validation->password);
								echo form_password(array(
									'name' => 'password',
									'id' => 'password',
									'size' => '20',
									'tabindex' => $t,
									'maxlength' => '20',
									'placeholder' => 'Password',
								));
								$t++;
							?>
							<i class="icon-lock icon-large"></i>
					</p>
					<p>
						<button type="submit" name="submit">login</button>
					</p>
				<?php
					echo form_close();
				?>
				
				<?php
					$t = 1;
					echo form_open('login/submit');
				?>
				
				<?php
					echo form_input(array(
						'name' => 'username',
						'id' => 'username',
						'size' => '20',
						'maxlength' => '20',
						'tabindex' => $t,
						'style' => 'display: none;',
						'value' => 'guest',
					));
					$t++;
				?>
				
				<?php
					echo form_password(array(
						'name' => 'password',
						'id' => 'password',
						'size' => '20',
						'tabindex' => $t,
						'maxlength' => '20',
						'style' => 'display: none;',
						'value' => 'password',
					));
					$t++;
				?>
				
				<style>
				
					.guestButton { background: transparent;
	border-top: 0;
	border-right: 0;
	border-bottom: 1px solid #00F;
	border-left: 0;
	color: #00F;
	display: inline;
	margin-left: 45%;
	cursor: pointer;
	}
				
				</style>
				
				<p>
					<button type="submit" class="guestButton" name="submit">View Bookings/Reservations Schedules</button>
				</p>
				
				<?php
					echo form_close();
				?>
				
			</section>
			
        </div>
		
    </body>
</html>