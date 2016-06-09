<div class="request_message">
	<?php 
		if (isset($message) && $message != '') {
			echo $message;
		}
		else
		{
			echo 'You have successfully sent your request.';
		}
	 ?>
</div>