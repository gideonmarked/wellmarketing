<?php echo form_open( base_url() . 'yladmin/news/'); ?>
<div id="news_wrapper" class="shadowed-box fluid autocenter">
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
		<h2 class="title">Create News</h2>
		<div class="form_line_wrapper">
			<div class="one_column field_wrapper">
				<label for="title">Title</label>
				<input type="text" name="title" id="title" value="<?php echo set_value('title'); ?>" maxlength="100" />
				<?php echo form_error('title','<div class="field_error">','</div>'); ?>
			</div>
			<div class="one_column field_wrapper">
				<label for="content">Content</label>
				<input type="text" name="content" id="content" value="<?php echo set_value('content'); ?>" maxlength="2000" />
				<?php echo form_error('content','<div class="field_error">','</div>'); ?>
			</div>
			<div class="one_column field_wrapper">
				<label for="location">Location</label>
				<input type="text" name="location" id="location" value="<?php echo set_value('location'); ?>" maxlength="100" />
				<?php echo form_error('location','<div class="field_error">','</div>'); ?>
			</div>
			<div class="one_column field_wrapper">
				<label for="image">Image Name</label>
				<input type="text" name="image" id="image" value="<?php echo set_value('image'); ?>" maxlength="100" />
				<?php echo form_error('image','<div class="field_error">','</div>'); ?>
			</div>
		</div>
		<div class="clearbox"></div>
	</div>
	
	<div class="form_line_wrapper">
		<input type="submit" name="submit" id="registration_submit_button" value="Add News" />
	</div>
	<div class="clearbox"></div>
</div>
<?php echo form_close(); ?>