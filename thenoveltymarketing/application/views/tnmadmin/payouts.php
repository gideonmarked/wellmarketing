<div class="default-content shadowed-box autocenter fluid row">
<div class="col-md-6">
	<?php 
	$total = 0;
	if(isset($result_payouts)) {
		foreach ($result_payouts as $value) {
			$total += $value->amount;
		}
	} ?>
	<h3>Claimed - Php <?php echo number_format( $total, 2, '.',',' ); ?></h3>
	<?php
	$alt = true;
	if(isset($result_payouts)) {
		foreach ($result_payouts as $value) {
			echo '<div class="form-row '  . ($alt?'alt':'') . '">';
			echo '<span class="form-col">' . $value->account_id . ' - ' . $this->account_model->get_u_from_a($value->account_id) . '</span>';
			echo '<span class="form-col">' . $this->utility_model->get_name($value->account_id)  . '</span>';
			echo '<span class="form-col">' . $value->creation_timestamp . '</span>';
			echo '<span class="form-col">' . 'Php ' .number_format( $value->amount,2,'.',',') . '</span>';
			//echo '<span class="form-col"><a href="approve-payout/' . $value->account_id . '" class="simplelink">Approve Payout</a></span>';
			echo '<div class="clearbox"></div>';
			echo '</div>';
			$alt = !$alt;
		}
	}
  	?>
</div>
<div class="col-md-6">
	<?php 
	$total = 0;
	if($result_remaining) {
		foreach ($result_remaining as $value) {
			$remaining_payout = $this->account_model->get_total_earnings($value->account_id);
			if($remaining_payout > 1) {
				$total += $remaining_payout;
			}
		}
	} ?>
	<h3>Remaining - Php <?php echo number_format( $total, 2, '.',',' ); ?></h3>
	<?php
	$alt = true;

	if($result_remaining) {
		foreach ($result_remaining as $value) {
			$remaining_payout = $this->account_model->get_total_earnings($value->account_id);
			if($remaining_payout > 1) {
				echo '<div class="form-row '  . ($alt?'alt':'') . '">';
				echo '<span class="form-col">' . $value->account_id . ' - ' . $this->account_model->get_u_from_a($value->account_id) . '</span>';
				echo '<span class="form-col">' . $this->utility_model->get_name($value->account_id) . '</span>';
				echo '<span class="form-col"></span>';
				echo '<span class="form-col">' . 'Php ' .number_format( $remaining_payout,2,'.',',') . '</span>';
				//echo '<span class="form-col"><a href="approve-payout/' . $value->account_id . '" class="simplelink">Approve Payout</a></span>';
				echo '<div class="clearbox"></div>';
				echo '</div>';
				$alt = !$alt;
			}
		}
	}
  	?>
</div>
</div>