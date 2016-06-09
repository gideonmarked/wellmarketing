<div class="clearbox"></div>
<?php echo form_open( base_url() . 'account/signentry/'); ?>
<div id="registration_wrapper" class="fluid autocenter shadowed-box">
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
		<div class="two_columns field_wrapper">
			<label for="ticket_code">Ticket Number</label>
			<input type="text" name="ticket_code" id="ticket_code" value="<?php echo set_value('ticket_code'); ?>" maxlength="7" />
			<?php echo form_error('ticket_code','<div class="field_error">','</div>'); ?>
		</div>
		<div class="two_columns field_wrapper">
			<label for="referrerid">Referrer Code</label>
			<input type="text" name="referrerid" id="referrerid" value="<?php echo set_value('referrerid'); ?>" maxlength="50" />
			<?php echo form_error('referrerid','<div class="field_error">','</div>'); ?>
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
			<?php 
			$account_type = $this->account_model->get_account_type( $this->session->userdata('account_id') );
			if( $account_type == 'assoc' || $account_type == 'employ' ): ?>
			<optgroup label="YES Packages">
				<?php foreach($packages as $package) {
					if($package->classification == "YES"): ?>
					<option data-img-src="<?php echo base_url() . 'uploads/yl_logo_70.png'; ?>" value="<?php echo $package->id; ?>"><?php echo $package->name; ?></option>
				<?php endif; }?>
			</optgroup>
		<?php endif; ?>
		</select>
		<?php echo form_error('package','<div class="field_error">','</div>'); ?>
	</div>
	<?php endif; ?>
	<div class="form_line_wrapper">
		<input type="submit" name="submit" id="registration_submit_button" value="Place Order" />
	</div>
	<div class="clearbox"></div>
</div>
<?php echo form_close(); ?>