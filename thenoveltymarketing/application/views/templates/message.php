<div class="shadowed-box padded-box fluid autocenter">
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
</div>