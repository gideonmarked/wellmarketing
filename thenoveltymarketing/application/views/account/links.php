<?php
echo "<b>Hello " . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</b>';
echo '<br>';
echo anchor(base_url() . 'account/signentry', 'Order A Package');
echo '<br>';
echo anchor(base_url() . 'account/signup', 'Register Referral Account');
echo '<br>';
echo anchor(base_url() . 'account/matrix', 'View Matrix Structure');
echo '<br>';
$session_data = $this->session->userdata('logged_in');
$user_id = $session_data['id'];
echo anchor(base_url() . 'account/unilevel' . $user_id, 'View Unilevel Structure');
echo '<br>';
echo anchor(base_url() . 'account/finance', 'View Financial Statement');
echo '<br>';
echo anchor(base_url() . 'account/logout', 'Logout');
echo '<br>';