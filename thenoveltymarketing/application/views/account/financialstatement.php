<?php
	$stockist_data = $this->account_model->get_financial_data('stockist', $this->session->userdata('account_id'), 'profit');
	if($stockist_data != "<div class='financial_table'><span>No data found.</span></div>"):
?>


<div class="clearbox"></div>
<div id="finance_table" class="fluid autocenter shadowed-box">
	<h1 class="title">STOCKIST INCOME BREAKDOWN</h1>
	<?php 
		echo $stockist_data;
	?>
</div>
<?php endif; ?>



<div class="clearbox"></div>
<div id="finance_table" class="fluid autocenter shadowed-box">
	<h1 class="title">CLAIMED PAYOUTS</h1>
	<?php 
		echo $this->account_model->get_financial_data('payout spending', $this->session->userdata('account_id'));
	?>
</div>

<div class="clearbox"></div>
<div id="finance_table" class="fluid autocenter shadowed-box">
	<h1 class="title">MATRIX FINANCIAL BREAKDOWN</h1>
	<?php 
		echo $this->account_model->get_financial_data('matrix', $this->session->userdata('account_id'));
	?>
</div>



<div class="clearbox"></div>
<div id="finance_table" class="fluid autocenter shadowed-box">
	<h1 class="title">UNILEVEL FINANCIAL BREAKDOWN</h1>
	<?php 
		echo $this->account_model->get_financial_data('unilevel', $this->session->userdata('account_id'));
	?>
</div>

<div class="clearbox"></div>
<div id="finance_table" class="fluid autocenter shadowed-box">
	<h1 class="title">DIRECT REFERRAL FINANCIAL BREAKDOWN</h1>
	<?php 
		echo $this->account_model->get_financial_data('referral', $this->session->userdata('account_id'));
	?>
</div>