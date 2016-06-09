<?php if($this->session->userdata('logged_in') && $this->session->userdata('account_id') == 'TNM0015'): ?>
<?php echo form_open( base_url() . 'tnmadmin/tickets/chocolatemocha'); ?>
<h1 class="title"><?php echo $title; ?></h1>
<div id="registration_wrapper">
	<?php if(isset($form_message)): ?>
	<span class="form_message">
	<?php echo $form_message; ?>
	<br>

	</span>
	<?php endif; ?>
	<div class="form_line_wrapper">
		<div class="two_columns field_wrapper">
			<label for="ticket_count">Ticket Count</label>
			<input type="text" name="ticket_count" id="ticket_count" value="<?php echo set_value('ticket_count'); ?>" maxlength="3" />
			<?php echo form_error('ticket_count','<div class="field_error">','</div>'); ?>
		</div>
		<div class="two_columns field_wrapper">
			<label for="ticket_amount">Ticket Amount</label>
			<input type="text" name="ticket_amount" id="ticket_amount" value="<?php echo set_value('ticket_amount'); ?>" maxlength="5" />
			<?php echo form_error('ticket_amount','<div class="field_error">','</div>'); ?>
		</div>
	</div>
	<div class="form_line_wrapper">
		<input type="submit" name="submit" id="registration_submit_button" value="Create" />
	</div>
	<h2 class="title">Ticket Information</h2>
	<div class="row">
		<div class="col-md-6">
			<?php $total_tickets = 0; foreach ($tickets as $ticket) {
				$total_tickets++;
			} ?>
			<h4>Tickets Available : <?php echo $total_tickets; ?></h4>
		</div>
		<div class="col-md-6">
			<h4>Tickets Used : <?php echo $this->account_model->get_all_entry_count(); ?></h4>
		</div>
	</div>
	<h2 class="title">Active Tickets</h2>
	<?php foreach ($tickets as $ticket) {
		echo '' . $ticket->code . '-' . $ticket->amount . '<br>';
	} ?>
</div>
<div class="clearbox"></div>
<?php echo form_close(); ?>
<?php endif; ?>