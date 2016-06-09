<?php $alt = true; ?>
<div></div>
<div class="default-content shadowed-box autocenter fluid">
	<?php foreach ($members as $member) { ?>
		<div class="form-row <?php echo ($alt?'alt':''); ?>">
		<span class="form-col" style="width: 400px;"><?php echo $member->first_name . ' ' . $member->last_name; ?></span>
		<span class="form-col"><?php echo $member->username; ?></span>
		<span class="form-col"><?php echo $member->account_id; ?></span>
		<div class="clearbox"></div>
		</div>
		<?php $alt = !$alt; ?>
	<?php } ?>
</div>