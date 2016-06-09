<h1 class="title">UNILEVEL BOARD</h1>
<div id="board_wrapper" style="margin: auto;width: 1360px;float: none;">
	<?php echo $unilevel; ?>
</div>
<div class="clearbox"></div>
<?php if($this->session->userdata('privilege') != 'assoc' ): ?>
<h1 class="title">UNILEVEL FINANCIAL BREAKDOWN</h1>
<div id="finance_wrapper">
	<?php 
		echo $finance;
	?>
</div>
<?php endif; ?>
<div class="clearbox"></div>
<?php if($this->session->userdata('privilege') == 'assoc' ): ?>
<h1 class="title">UNILEVEL FINANCIAL BREAKDOWN(AVAILABLE ONLY AT ENTRY LEVEL)</h1>
<div class="clearbox"></div>
<div id="finance_wrapper">
	<?php 
		echo $this->account_model->get_financial_data('unilevel potential', $this->session->userdata('account_id'));
	?>
</div>
<?php endif; ?>