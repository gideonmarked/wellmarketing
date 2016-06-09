<div class="clearbox"></div>
<?php echo form_open( base_url() . 'account/signup/'); ?>
<div id="registration_wrapper" class="shadowed-box">
	<h1 class="title">Member Signup</h1>
	<?php if(isset($global_error)): ?>
	<span class="global_error"> <?php echo  $global_error; ?></span>
	<?php endif; ?>
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
	<div class="form_line_wrapper">
		<div class="four_columns field_wrapper">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" maxlength="12" />
			<?php echo form_error('username','<div class="field_error">','</div>'); ?>
		</div>
		<div class="four_columns field_wrapper">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" maxlength="70" />
			<?php echo form_error('password','<div class="field_error">','</div>'); ?>
		</div>
		<div class="four_columns field_wrapper">
			<label>Password Confirmation</label>
			<input type="password" name="passwordconfirmation" id="passwordconfirmation" value="<?php echo set_value('passwordconfirmation'); ?>" maxlength="70" />
			<?php echo form_error('passwordconfirmation','<div class="field_error">','</div>'); ?>
		</div>
		<div class="four_columns field_wrapper">
			<label for="ticket_code">Ticket Number</label>
			<input type="text" name="ticket_code" id="ticket_code" value="<?php echo set_value('ticket_code'); ?>" maxlength="7" />
			<?php echo form_error('ticket_code','<div class="field_error">','</div>'); ?>
		</div>
	</div>
	<h2>Personal Information</h2>
	<div class="form_line_wrapper">
		<div class="three_columns field_wrapper">
			<label for="firstname">First Name</label>
			<input type="text" name="firstname" id="firstname" value="<?php echo set_value('firstname'); ?>" maxlength="50" />
			<?php echo form_error('firstname','<div class="field_error">','</div>'); ?>
		</div>
		<div class="three_columns field_wrapper">
			<label for="middlename">Middle Name</label>
			<input type="text" name="middlename" id="middlename" value="<?php echo set_value('middlename'); ?>" maxlength="30" />
			<?php echo form_error('middlename','<div class="field_error">','</div>'); ?>
		</div>
		<div class="three_columns field_wrapper">
			<label for="lastname">Last Name</label>
			<input type="text" name="lastname" id="lastname" value="<?php echo set_value('lastname'); ?>" maxlength="30" />
			<?php echo form_error('lastname','<div class="field_error">','</div>'); ?>
		</div>
	</div>
	<div class="form_line_wrapper">
		<div class="three_columns field_wrapper">
			<label for="email">Email Address</label>
			<input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>" maxlength="70" />
			<?php echo form_error('email','<div class="field_error">','</div>'); ?>
		</div>
		<div class="three_columns field_wrapper">
			<label for="mobilenumber">Mobile Number (ex: 09171231234)</label>
			<input type="text" name="mobilenumber" id="mobilenumber" value="<?php echo set_value('mobilenumber'); ?>" maxlength="11" />
			<?php echo form_error('mobilenumber','<div class="field_error">','</div>'); ?>
		</div>
		<div class="three_columns field_wrapper">
			<label for="telephonenumber">Telephone Number</label>
			<input type="text" name="telephonenumber" id="telephonenumber" value="<?php echo set_value('telephonenumber'); ?>" maxlength="11" />
			<?php echo form_error('telephonenumber','<div class="field_error">','</div>'); ?>
		</div>
	</div>
	<div class="form_line_wrapper">
		<div class="two_columns field_wrapper">
			<label for="residentialaddress">Residential Address</label>
			<input type="text" name="residentialaddress" id="residentialaddress" value="<?php echo set_value('residentialaddress'); ?>" maxlength="200" />
			<?php echo form_error('residentialaddress','<div class="field_error">','</div>'); ?>
		</div>
		<div class="two_columns field_wrapper">
			<label for="shippingaddress">Shipping Address</label>
			<input type="text" name="shippingaddress" id="shippingaddress" value="<?php echo set_value('shippingaddress'); ?>" maxlength="200" />
			<?php echo form_error('shippingaddress','<div class="field_error">','</div>'); ?>
		</div>
	</div>
	<?php if($packages != null): ?>
	<h2>Package Selection</h2>
	<div class="form_line_wrapper">
		<select class="image-picker show-html" name="package">
			<optgroup label="Entry Packages">
				<?php foreach($packages as $package) {
					if($package->classification == "Entry"): ?>
					<option data-img-src="<?php echo base_url() . 'uploads/yl_logo_70.png'; ?>" value="<?php echo $package->id; ?>"><?php echo $package->name; ?></option>
				<?php endif; }?>
			</optgroup>
			<!-- <optgroup label="YES Packages">
				<?php foreach($packages as $package) {
					if($package->classification == "YES"): ?>
					<option data-img-src="<?php echo base_url() . 'uploads/yl_logo_70.png'; ?>" value="<?php echo $package->id; ?>"><?php echo $package->name; ?></option>
				<?php endif; }?>
			</optgroup> -->
		</select>
		<?php echo form_error('package','<div class="field_error">','</div>'); ?>
	</div>
	<?php endif; ?>
	<h2>References</h2>
	<div class="form_line_wrapper">
		<div id="referrer" class="two_columns field_wrapper" >
			<label for="referrerid">Referrer Code</label>
			<?php
				$referrer_code = ( $this->session->userdata('logged_in') ? $this->session->userdata('account_id') : set_value('referrerid') );
			?>
			<input type="text" name="referrerid" id="referrerid" value="<?php echo ($referrer_code != NULL ? $referrer_code : set_value('referrerid')); ?>" maxlength="50" />
			<?php echo form_error('referrerid','<div class="field_error">','</div>'); ?>
		</div>
		<div id="sub_referrer" class="two_columns field_wrapper <?php echo (isset($spillover) ? 'must_field' : ''); ?>">
			<label for="sub_referrerid">Spill Over Referrer Code</label>
			<input type="text" name="sub_referrerid" id="sub_referrerid" value="" maxlength="50" />
			<?php echo form_error('sub_referrerid','<div class="field_error">','</div>'); ?>
		</div>
		<input type="hidden" id="spillover" value="<?php echo $spillover; ?>">
		<div class="two_columns field_wrapper" style="display:none;">
			<label for="placementid">Stockist Code</label>
			<input type="text" name="stockistid" id="stockistid" value="TNM77" maxlength="30" />
			<?php echo form_error('stockistid','<div class="field_error">','</div>'); ?>
		</div>
	</div>
	<div class="form_line_wrapper">
		<input type="submit" name="submit" id="registration_submit_button" value="Member Signup" />
	</div>
	<div class="clearbox"></div>
</div>
<?php echo form_close(); ?>