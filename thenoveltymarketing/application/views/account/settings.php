<?php echo form_open( base_url() . 'account/settings/'); ?>
<div id="settings_wrapper" class="shadowed-box fluid autocenter">
	<h1 class="title"><?php echo $title; ?></h1>
	<?php 
		if (isset($goodmessage)) {
			?>
			<div class="good-message">
				<?php echo $goodmessage; ?>
			</div>
			<?php
		}
		if (isset($badmessage)) {
			?>
			<div class="bad-message">
				<?php echo $badmessage; ?>
			</div>
			<?php
		}
	?>
	<div class="padded-box">
		<h2 class="title">Account Information</h2>
		<div class="form_line_wrapper">
			<div class="three_columns field_wrapper">
				<label for="username">Username</label>
				<input type="text" name="username" id="username" value="<?php echo (set_value('username') != '' ? set_value('username') : $account_data->username ); ?>" maxlength="12" disabled />
				<?php echo form_error('username','<div class="field_error">','</div>'); ?>
			</div>
			<div class="three_columns field_wrapper">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" maxlength="70" />
				<?php echo form_error('password','<div class="field_error">','</div>'); ?>
			</div>
			<div class="three_columns field_wrapper">
				<label>Password Confirmation</label>
				<input type="password" name="passwordconfirmation" id="passwordconfirmation" value="<?php echo set_value('passwordconfirmation'); ?>" maxlength="70" />
				<?php echo form_error('passwordconfirmation','<div class="field_error">','</div>'); ?>
			</div>
		</div>
		<div class="clearbox"></div>
	</div>
	<div class="padded-box">
		<h2 class="title">Personal Information</h2>
		<div class="form_line_wrapper">
			<div class="three_columns field_wrapper">
				<label for="firstname">First Name</label>
				<input type="text" name="firstname" id="firstname" value="<?php echo (set_value('firstname') != '' ? set_value('firstname') : $profile_data->first_name ); ?>" maxlength="50" disabled />
				<?php echo form_error('firstname','<div class="field_error">','</div>'); ?>
			</div>
			<div class="three_columns field_wrapper">
				<label for="middlename">Middle Name</label>
				<input type="text" name="middlename" id="middlename" value="<?php echo (set_value('middlename') != '' ? set_value('middlename') : $profile_data->middle_name ); ?>" maxlength="30" disabled />
				<?php echo form_error('middlename','<div class="field_error">','</div>'); ?>
			</div>
			<div class="three_columns field_wrapper">
				<label for="lastname">Last Name</label>
				<input type="text" name="lastname" id="lastname" value="<?php echo (set_value('lastname') != '' ? set_value('lastname') : $profile_data->last_name ); ?>" maxlength="30" disabled />
				<?php echo form_error('lastname','<div class="field_error">','</div>'); ?>
			</div>
		</div>
		<div class="form_line_wrapper">
			<div class="three_columns field_wrapper">
				<label for="email">Email Address</label>
				<input type="text" name="email" id="email" value="<?php echo (set_value('email') != '' ? set_value('email') : $profile_data->email_address ); ?>" maxlength="70" />
				<?php echo form_error('email','<div class="field_error">','</div>'); ?>
			</div>
			<div class="three_columns field_wrapper">
				<label for="mobilenumber">Mobile Number (ex: 09171231234)</label>
				<input type="text" name="mobilenumber" id="mobilenumber" value="<?php echo (set_value('mobilenumber') != '' ? set_value('mobilenumber') : $profile_data->mobile_number ); ?>" maxlength="11" />
				<?php echo form_error('mobilenumber','<div class="field_error">','</div>'); ?>
			</div>
			<div class="three_columns field_wrapper">
				<label for="telephonenumber">Telephone Number</label>
				<input type="text" name="telephonenumber" id="telephonenumber" value="<?php echo (set_value('telephonenumber') != '' ? set_value('telephonenumber') : $profile_data->telephone_number ); ?>" maxlength="11" disabled />
				<?php echo form_error('telephonenumber','<div class="field_error">','</div>'); ?>
			</div>
		</div>
		<div class="form_line_wrapper">
			<div class="two_columns field_wrapper">
				<label for="residentialaddress">Residential Address</label>
				<input type="text" name="residentialaddress" id="residentialaddress" value="<?php echo (set_value('residentialaddress') != '' ? set_value('residentialaddress') : $profile_data->residential_address ); ?>" maxlength="200" disabled />
				<?php echo form_error('residentialaddress','<div class="field_error">','</div>'); ?>
			</div>
			<div class="two_columns field_wrapper">
				<label for="shippingaddress">Shipping Address</label>
				<input type="text" name="shippingaddress" id="shippingaddress" value="<?php echo (set_value('shippingaddress') != '' ? set_value('shippingaddress') : $profile_data->shipping_address ); ?>" maxlength="200" disabled />
				<?php echo form_error('shippingaddress','<div class="field_error">','</div>'); ?>
			</div>
		</div>
	</div>
	<div class="form_line_wrapper">
		<input type="submit" name="submit" id="registration_submit_button" value="Update Details" />
	</div>
	<div class="clearbox"></div>
</div>
<?php echo form_close(); ?>