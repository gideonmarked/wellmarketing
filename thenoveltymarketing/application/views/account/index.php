<div class="clearbox" style="width: 100%;float: left;">
	<div class="user_table">
		<div class="col">
			<div class="row">
				<div class="title">Name:</div>
				<div class="data"><?php echo $name; ?></div>
			</div>
			<div class="row">
				
			</div>
			<div class="row">
				<div class="title">Your Username:</div>
				<div class="data"><?php echo $username; ?></div>
			</div>
			<div class="row">
				<div class="title">Your Account ID:</div>
				<div class="data"><?php echo $accountid; ?></div>
			</div>
			<div class="row">
				<div class="title">Referrer ID:</div>
				<div class="data"><?php echo $referrerid; ?></div>
			</div>
			<div class="row">
				<div class="title">Direct Referral IDs:</div>
				<div class="data">
					<?php 
					if(isset($directreferralids) && $directreferralids != null):
					foreach ($directreferralids as $direct_referral) {
						echo $direct_referral->account_id . ' : ' .$direct_referral->first_name . ' ' . $direct_referral->last_name . '<br>';
					} 
					endif;
					?>
				</div>
			</div>
		</div>
		<div class="col">
		<?php if($this->session->userdata('account_id') == 'TNM0015'){ ?>
			<div class="row">
				<div class="title" style="color: #0077FF;">Total Company Income:</div>
				<div class="data" style="color: #0077FF;">Php <?php echo number_format( $totalcompanyincome,2,'.',','); ?></div>
			</div>
		<?php } ?>
			<div class="row">
				<div class="title" style="color: #0077FF;">Total Account Income:</div>
				<div class="data" style="color: #0077FF;">Php <?php echo number_format( $totalincome,2,'.',','); ?></div>
			</div>
			<div class="row">
				<div class="title">Available Payout:</div>
				<div class="data">
					Php <?php echo number_format( $withdrawableearnings,2,'.',',') . ' ' 
					. ($withdrawableearnings > 500 ? '<br><a href="' . base_url() . 'account/request-payout/' . $accountid  . '" class="basiclink">Request Payout</a>' : ''); ?>
				</div>
			</div>
			<div class="row">
				<div class="title">Total Payout Withdrawal:</div>
				<div class="data" style="color: rgba(255, 167, 51, 1);">
					Php <?php echo number_format( $withdrawal,2,'.',','); ?>
				</div>
			</div>
		</div>
		<div class="clearbox"></div>
	</div>
</div>