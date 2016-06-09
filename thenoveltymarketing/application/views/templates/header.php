<html>
<head>
	<title>The Novelty Marketing</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'stylesheets/bootstrap.min.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'stylesheets/styles.css'; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'stylesheets/image-picker.css'; ?>">
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url() . 'js/bootstrap.min.js'; ?>"></script>
	<script src="<?php echo base_url() . 'js/image-picker.min.js' ?>"></script>
	<!-- <link rel="icon" type="image/x-icon" href="<?php echo base_url() . 'stylesheets/images/favicon.gif' ?>" /> -->
</head>
<body>
<header>
	<div id="header">
		<div class="fluid autocenter">
			<h1 class="autocenter" id="site_logo"><a href="<?php echo base_url(); ?>">The Novelty Marketing</a></h1>
			<span id="description"></span>
			<div id="contact_area">
				<span id="header_address"></span>
				<span id="header_mobile"></span>
				<span id="header_mobile"></span>
			</div>
			<div class="clearbox"></div>
		</div>
		<div id="navigation">
			<div class="fluid autocenter">
				<nav>
					<ul>
						<li><a href="<?php echo base_url() . 'account'; ?>">Your Account</a>
							<?php if($this->session->userdata('logged_in')): ?>
							<ul class="sub_menu">
								<li><a href="<?php echo base_url() . 'account/'; ?>">Personal Account</a></li>
								<li><a href="<?php echo base_url() . 'account/signentry'; ?>">Purchase Package</a></li>
								<?php if($this->administrator_model->get_stockist() && false): ?>
									<li><a href="<?php echo base_url() . 'account/repeat-order'; ?>">Purchase Order</a></li>
								<?php endif; ?>
								<li><a href="<?php echo base_url() . 'account/signup'; ?>">Register a Referral</a></li>
								<li><a href="<?php echo base_url() . 'account/matrix'; ?>">Matrix</a></li>
								<li><a href="<?php echo base_url() . 'account/unilevel'; ?>">Unilevel</a></li>
								<li><a href="<?php echo base_url() . 'account/finance'; ?>">Financial Statement</a></li>
								<?php if($this->session->userdata('account_id') == "TNM0015") { ?>
								<li><a href="<?php echo base_url() . 'account/matrixfinance'; ?>">Board Financial Statement</a></li>
								<li><a href="<?php echo base_url() . 'tnmadmin/tickets'; ?>">Create Tickets</a></li>
								<li><a href="<?php echo base_url() . 'tnmadmin/payouts'; ?>">Show Payouts</a></li>
								<?php } ?>
								<li><a href="<?php echo base_url() . 'account/settings'; ?>">Edit Profile</a></li>
								<li><a href="<?php echo base_url() . 'account/logout'; ?>">Log out</a></li>
							</ul>
							<?php else: ?>
							<ul class="sub_menu">
								<li><a href="<?php echo base_url() . 'account/signin'; ?>">Sign In</a></li>
								<li><a href="<?php echo base_url() . 'account/signup'; ?>">Register</a></li>
							</ul>
							<?php endif; ?>
						</li>
					</ul>
				</nav>
			</div>
			<div class="clearbox"></div>
		</div>
	</div>
</header>
<div id="main_content">
	
	<div class="clearbox"></div>
