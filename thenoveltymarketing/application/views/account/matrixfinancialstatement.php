<?php if($this->session->userdata('account_id') == "TNM0015") { ?>

<div class="clearbox"></div>
<div class="autocenter shadowed-box">
	<h1 class="title">MATRIX BOARD FINANCIAL BREAKDOWN</h1>
	<div class='seven_columns'>
	<h3 class="title">MATRIX LEVEL 1</h3>
		<?php 
			echo $this->account_model->get_matrix_list('matrix 1', $this->session->userdata('account_id'));
		?>
	</div>
	<div class='seven_columns'>
	<h3 class="title">MATRIX LEVEL 2</h3>
		<?php 
			echo $this->account_model->get_matrix_list('matrix 2', $this->session->userdata('account_id'));
		?>
	</div>
	<div class='seven_columns'>
	<h3 class="title">MATRIX LEVEL 3</h3>
		<?php 
			echo $this->account_model->get_matrix_list('matrix 3', $this->session->userdata('account_id'));
		?>
	</div>
	<div class='seven_columns'>
	<h3 class="title">MATRIX LEVEL 4</h3>
		<?php 
			echo $this->account_model->get_matrix_list('matrix 4', $this->session->userdata('account_id'));
		?>
	</div>
	<div class='seven_columns'>
	<h3 class="title">MATRIX LEVEL 5</h3>
		<?php 
			echo $this->account_model->get_matrix_list('matrix 5', $this->session->userdata('account_id'));
		?>
	</div>
	<div class='seven_columns'>
	<h3 class="title">MATRIX LEVEL 6</h3>
		<?php 
			echo $this->account_model->get_matrix_list('matrix 6', $this->session->userdata('account_id'));
		?>
	</div>
	<div class='seven_columns'>
	<h3 class="title">MATRIX LEVEL 7</h3>
		<?php 
			echo $this->account_model->get_matrix_list('matrix 7', $this->session->userdata('account_id'));
		?>
	</div>
</div>

<?php } ?>