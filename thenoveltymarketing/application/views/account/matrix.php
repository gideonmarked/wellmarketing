<h1 class="title">MATRIX BOARD</h1>

<div id="board_wrapper">
	<div id="matrix_num_buttons">
		<?php
			for ($i=0; $i < $max_page; $i++) { 
			 	if( $i != $page ):
			 		echo "<a href='" . base_url() . 'account/matrix/' . $i . "'>" . ($i+1) . "</a>";
			 	else:
			 		echo "<span>" . ($i+1) . "</span>";
			 	endif;
			 	/*if( $i != ($max_page - 1) ):
			 		echo ' | ';
			 	endif;*/
			} 
		?>
	</div>
	<div id="matrix_nav_buttons"><?php echo ($prev < 0 ? "" : "<a href='" . base_url() . 'account/matrix/' .  $prev . "'>< Previous</a>" ); ?><?php echo ($next >= $max_page ? "" : "<a href='" . base_url() . 'account/matrix/' .  $next . "'>Next ></a>" ); ?></div>
	<?php echo $matrix; ?>
</div>

<h1 class="title">MATRIX FINANCIAL BREAKDOWN</h1>
<div class="clearbox"></div>
<div id="finance_wrapper">
	<?php 
		echo $finance;
	?>
</div>