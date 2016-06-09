<div class="shadowed-box padded-box fluid autocenter">
<?php if($this->session->userdata('logged_in')): ?>
<?php echo form_open( base_url() . 'account/repeat-order/'); ?>
<h1 class="title"><?php echo $title; ?></h1>
<div id="registration_wrapper">
	<?php if(isset($form_message)): ?>
	<span class="form_message">
	<?php echo $form_message; ?>
	<br>

	</span>
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
		<div class="two_columns field_wrapper">
			<label for="purchase_type">Purchase Type</label>
			<input type="radio" name="purchase_type" value="RO" checked /> Repeat Order
			<input type="radio" name="purchase_type" value="B1T1" /> Buy 1 Take 1
			<?php echo form_error('purchase_type','<div class="field_error">','</div>'); ?>
		</div>
		<div class="two_columns field_wrapper">
			<label for="ticket_count">Ticket Count</label>
			<select name="product" id="product">
				<?php foreach($products as $product) { ?>
					<option value="<?php echo $product->id; ?>"><?php echo $product->name; ?></option>
				<?php }?>
			</select>
			<?php echo form_error('ticket_count','<div class="field_error">','</div>'); ?>
		</div>
	</div>
	<div class="form_line_wrapper">
		<div class="two_columns field_wrapper">
			<label for="ticket_code">Ticket Number</label>
			<input type="text" name="ticket_code" id="ticket_code" value="<?php echo set_value('ticket_code'); ?>" maxlength="7" />
			<?php echo form_error('ticket_code','<div class="field_error">','</div>'); ?>
		</div>
		<div class="two_columns field_wrapper" >
			<label for="accountid">Account ID</label>
			<input type="text" name="accountid" id="accountid" value="<?php echo set_value('accountid'); ?>" maxlength="50" />
			<?php echo form_error('accountid','<div class="field_error">','</div>'); ?>
		</div>
	</div>
	<div class="form_line_wrapper">
		<input type="submit" name="submit" id="registration_submit_button" value="Submit Order" />
	</div>
</div>
<div class="clearbox"></div>
<?php echo form_close(); ?>
<?php endif; ?>
</div>