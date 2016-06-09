<?php if($this->session->userdata('logged_in') && $this->session->userdata('account_id') == 'YL014JC'): ?>
<h1>Pending Entries</h1>
<?php if($pending_entries!=null): ?>
	<table border="1">
		<th>Account ID</th><th>Creation Time</th><th>Placement ID</th><th>Package ID</th><th>Action</th>
	<?php foreach ($pending_entries as $pending_entry) { ?>
		<tr>
			<td><?php echo $pending_entry->account_id; ?></td>
			<td><?php echo $pending_entry->creation_timestamp; ?></td>
			<td><?php echo $pending_entry->placement_id; ?></td>
			<td><?php echo $pending_entry->package_id; ?></td>
			<td><a href="<?php echo base_url() . 'yladmin/approve/' . $pending_entry->id; ?>">APPROVE</a></td>
		</tr>
	<?php } ?>
	</table>
<?php endif; ?>
<?php endif; ?>