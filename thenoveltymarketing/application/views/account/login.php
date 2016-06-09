<div id="login_wrapper" class="fluid autocenter shadowed-box">
	<?php echo form_open( base_url() . 'account/signin/'); ?>
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
	<div class="form_line_wrapper">
		<div class="middle_fields field_wrapper">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" maxlength="12" />
			<?php echo form_error('username','<div class="field_error">','</div>'); ?>
		</div>
	</div>
	<div class="form_line_wrapper">
		<div class="middle_fields field_wrapper">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" maxlength="70" />
			<?php echo form_error('password','<div class="field_error">','</div>'); ?>
		</div>
	</div>
	<div class="form_line_wrapper">
		<input type="submit" name="submit" id="registration_submit_button" value="Sign In" />
	</div>
	<?php echo form_close(); ?>
	<div class="clearbox"></div>
</div>