<?php
class Account_model extends CI_Model {

	public function __construct()
	{
		
	}

	public function signin()
	{
		$data['title'] = "Login";

		//validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[7]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[7]|max_length[70]');

		//validation message rules
		$this->form_validation->set_message('is_unique', 'The %s is already taken.');

		$this->load->view('templates/header', $data);
		if ($this->form_validation->run() == FALSE):
			$this->load->view('account/login', $data);
		elseif(!$this->account_model->check_credentials($this->input->post('username'),$this->input->post('password'))):
			$data['badmessage'] = 'The username or password is invalid.';
			$this->load->view('account/login', $data);
		else:
			// $this->load->view('account/successlogin', $data);
			redirect('account/','refresh');	
		endif;
		$this->load->view('templates/footer');	
	}

	public function signup()
	{
		$data['title'] = "Member Signup";
		$this ->db->select('id, name, image_name, classification');
		$this ->db->from('packages');
		$query = $this ->db-> get();
		if($query->num_rows() > 0):
			$data['packages'] = $query->result();
		endif;

		//validation rules
		$this->form_validation->set_rules('ticket_code', 'Ticket Number', 'trim|required|alpha_numeric|min_length[7]|max_length[7]|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[7]|max_length[12]|xss_clean|is_unique[account.username]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passwordconfirmation]|min_length[7]|max_length[70]');
		$this->form_validation->set_rules('passwordconfirmation', 'Password Confirmation', 'trim|required|matches[password]|min_length[7]|max_length[70]');
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|min_length[2]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('middlename', 'Middle Name', 'trim|required|min_length[2]|max_length[30]|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[profile.email_address]|max_length[30]');
		$this->form_validation->set_rules('mobilenumber', 'Mobile Number', 'trim|required|numeric|is_unique[profile.mobile_number]');
		$this->form_validation->set_rules('telephonenumber', 'Telephone Number', 'trim|numeric');
		$this->form_validation->set_rules('residentialaddress', 'Residential Address', 'trim|required');
		$this->form_validation->set_rules('shippingaddress', 'Shipping Address', 'trim');
		$this->form_validation->set_rules('package', 'Package', 'required|xss_clean');
		$this->form_validation->set_rules('referrerid', 'Referrer ID', 'trim|required|alpha_numeric|alpha_numeric|xss_clean|is_exists');
		$this->form_validation->set_rules('stockistid', 'Stockist Code', 'trim|required|alpha_numeric|alpha_numeric|xss_clean|is_exists|min_length[5]|max_length[5]|');

		//validation message rules
		$this->form_validation->set_message('is_unique', 'The %s is already taken.');

		$this->load->view('templates/header', $data);
		if ($this->form_validation->run() == FALSE):
			$this->load->view('account/registration', $data);
		elseif(!$this->account_model->check_available_tickets($this->input->post('ticket_code'))):
				$data['badmessage'] = 'The Ticket Number you have used is invalid.';
				$this->load->view('account/registration', $data);
		elseif(!$this->check_valid_ticket($this->input->post('package'),$this->input->post('ticket_code'))):
				$data['badmessage'] = 'The Ticket Number is not valid for this product package.';
				$this->load->view('account/registration', $data);
		elseif(!$this->account_model->check_maximum_placements($this->input->post('referrerid')) && $this->input->post('sub_referrerid') == ''):
			$data['badmessage'] = 'Your Referrer Code that you have used has reached the maximum referrals. Please select a Referrer Spill Over Code instead.';
			$data['spillover'] = true;
			$this->load->view('account/registration', $data);
		elseif(!$this->account_model->check_maximum_placements($this->input->post('sub_referrerid'))):
			$data['badmessage'] = 'Your Referrer Spill Over Code that you have used has reached the maximum referrals. Please select another Referrer Spill Over Code instead.';
			$data['spillover'] = true;
			$this->load->view('account/registration', $data);
		elseif(!$this->account_model->check_valid_data($this->input->post('referrerid'),'entries.entry_id')):
			$data['badmessage'] = 'The Referrer Code you entered is invalid.';
			$this->load->view('account/registration', $data);
		elseif(!$this->account_model->check_valid_data($this->input->post('sub_referrerid'),'entries.entry_id') && $this->input->post('sub_referrerid') != ''  && $this->input->post('referrerid') != ''):
			$data['badmessage'] = 'The Spill Over Referrer Code you entered is invalid.';
			$data['spillover'] = true;
			$this->load->view('account/registration', $data);
		elseif(!$this->account_model->check_valid_placements($this->input->post('referrerid')) && $this->input->post('sub_referrerid') == ""):
			$data['badmessage'] = 'Your Referrer Code that you have used does not exist anymore. Please select another Referrer Spill Over Code instead.';
			$data['spillover'] = true;
			$this->load->view('account/registration', $data);
		elseif(!$this->account_model->check_valid_placements($this->input->post('sub_referrerid'))  && $this->input->post('sub_referrerid') != ''):
			$data['badmessage'] = 'Your Spill Over Referrer Code that you have used does not exist anymore. Please select another Referrer Spill Over Code instead.';
			$data['spillover'] = true;
			$this->load->view('account/registration', $data);
		elseif(!$this->account_model->check_valid_data($this->input->post('stockistid'),'account.stockist_code') && $this->input->post('stockistid') != ''):
			$data['badmessage'] = 'The Stockist Code you entered is invalid.';
			$data['spillover'] = true;
			$this->load->view('account/registration', $data);
		else:
			$member_created = $this->account_model->create_member();
			if($member_created['created']):
				$data['referrer_code'] = $member_created['account_id'];
				$this->load->view('account/success_signup', $data);
			endif;				
		endif;
		$this->load->view('templates/footer');
	}

	public function signentry()
	{
		$data['title'] = "Create Order";
		
		$this ->db->select('id, name, image_name, classification');
		$this ->db->from('packages');
		$query = $this ->db-> get();
		if($query->num_rows() > 0):
			$data['packages'] = $query->result();
		endif;

		//validation rules
		$this->form_validation->set_rules('ticket_code', 'Ticket Number', 'trim|required|alpha_numeric|min_length[7]|max_length[7]|xss_clean');
		$this->form_validation->set_rules('package', 'Package', 'required|xss_clean');
		// $this->form_validation->set_rules('refferrerid', 'Referrer ID Code', 'trim|required|alpha_numeric|alpha_numeric|xss_clean|is_exists|min_length[5]|max_length[5]|');

		//validation message rules
		$this->form_validation->set_message('is_unique', 'The %s is already taken.');
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in')):
			$account_type = $this->account_model->get_account_type( $this->session->userdata('account_id') );

			if ($this->form_validation->run() == FALSE):
				$this->load->view('account/ordercreation', $data);
			elseif(!$this->account_model->check_available_tickets($this->input->post('ticket_code'))):
				$data['badmessage'] = 'The Ticket Number you have used is invalid.';
				$this->load->view('account/ordercreation', $data);
			elseif(!$this->check_valid_ticket($this->input->post('package'),$this->input->post('ticket_code'))):
				$data['badmessage'] = 'The Ticket Number is not valid for this product package.';
				$this->load->view('account/ordercreation', $data);
			elseif(!$this->account_model->check_maximum_placements($this->input->post('referrerid')) && $this->input->post('sub_referrerid') == ''):
				$data['badmessage'] = 'Your Referrer Code that you have used has reached the maximum referrals. Please select a Referrer Spill Over Code instead.';
				$data['spillover'] = true;
				$this->load->view('account/registration', $data);
			elseif(!$this->account_model->check_maximum_placements($this->input->post('sub_referrerid'))):
				$data['badmessage'] = 'Your Referrer Spill Over Code that you have used has reached the maximum referrals. Please select another Referrer Spill Over Code instead.';
				$data['spillover'] = true;
				$this->load->view('account/registration', $data);
			elseif(!$this->account_model->check_valid_placements($this->input->post('referrerid')) && !$data['spillover']):
				$data['badmessage'] = 'Your Referrer Code that you have used does not exist anymore. Please select another Referrer Spill Over Code instead.';
				$this->load->view('account/registration', $data);
			elseif(!$this->account_model->check_valid_placements($this->input->post('sub_referrerid'))):
				$data['badmessage'] = 'Your Spill Over Referrer Code that you have used does not exist anymore. Please select another Referrer Spill Over Code instead.';
				$data['spillover'] = true;
				$this->load->view('account/registration', $data);
			elseif(!$this->account_model->check_valid_data($this->input->post('stockistid'),'account.stockist_code') && $this->input->post('stockistid') != ''):
				$data['badmessage'] = 'The Spill Over Referrer Code you entered is invalid.';
				$data['spillover'] = true;
				$this->load->view('account/ordercreation', $data);
			elseif( ($account_type != 'employ' && $account_type != 'assoc' ) && $this->account_model->get_package_type( $this->input->post('package') ) != 'Entry' ):
				$data['badmessage'] = 'You already have a Regular Account. You can\'t purchase a lower type package.';
				$this->load->view('account/ordercreation', $data);
			else:
				$entry_created = $this->account_model->create_development_entry( $this->session->userdata('account_id'), $this->input->post('package') );
				if($entry_created['created']):
					$data['placement_code'] = $entry_created['entry_id'];
					$this->load->view('account/success_signentry', $data);
				endif;				
			endif;
		endif;
		$this->load->view('templates/footer');
	}

	public function create_member()
	{
		$values = array();
		$values['created'] = false;
		$account_created = $this->account_model->create_account();
		$profile_created = $this->account_model->create_profile( $account_created['account_id'] );
		if( $account_created['created'] && $profile_created['created']):
			$values['created'] = true;
			$this->load->library('email');

			$this->email->from('innovations@thenoveltymarketing.com', 'thenoveltymarketing');
			$this->email->to( $this->input->post('email') ); 

			$this->email->subject('Account created at thenoveltymarketing!');
			$this->email->message('Congratulations! You have successfully created an account at thenoveltymarketing. You need to verify your account before you can use it. Click the following link to verify. http://thenoveltymarketing.com/account/verify/' . $account_created['verification_code']);	

			$this->email->send();

			$entry_created = $this->account_model->create_development_entry( $account_created['account_id'], $this->input->post('package') );
		endif;

		$values['account_id'] = $account_created['account_id'];
		$values['entry_id'] = $entry_created['entry_id'];
		return $values;
	}

	private function create_account()
	{
		$values = array();

		$verification_code  = $this->utility_model->create_random_string( 'alpha_numeric', 30 );
		$account_id = $this->utility_model->create_unique_id( array('firstname'=>$this->input->post('firstname'),'lastname'=>$this->input->post('lastname')),'alpha_numeric_uc', 2, 'account', 'account_id' );

		$values['account'] = array(
			'account_id' => $account_id,
			'username' => $this->input->post('username'),
			'password' => do_hash( $this->input->post('password'),'md5'),
			'referrer_id' => ($this->input->post('sub_referrerid')==''?substr($this->input->post('referrerid'), 0, 7):substr($this->input->post('sub_referrerid'), 0, 7)),
			'direct_referrer_id' => substr($this->input->post('referrerid'), 0, 7),
			'verification_code' => $verification_code
		);

		//query for above values
		$this->db->insert('account', $values['account']);

		$return = array();
		$return['account_id'] = $account_id;
		$return['verification_code'] = $verification_code;
		$return['created'] = true;

		return $return;
	}
	
	private function create_profile( $account_id )
	{
		$values = array();

		$values['profile'] = array(
			'account_id' => $account_id,
			'first_name' => $this->input->post('firstname'),
			'middle_name' => $this->input->post('middlename'),
			'last_name' => $this->input->post('lastname'),
			'email_address' => $this->input->post('email'),
			'residential_address' => $this->input->post('residentialaddress'),
			'shipping_address' => $this->input->post('shippingaddress'),
			'mobile_number' => $this->input->post('mobilenumber'),
			'telephone_number' => $this->input->post('telephonenumber')
		);

		//query for above values
		$this->db->insert('profile', $values['profile']);

		$return = array();
		$return['created'] = true;

		return $return;
	}

	private function create_pending_entry($account_id)
	{
		$values = array();
		$values['pending'] = array(
			'account_id' => $account_id,	
			'placement_id' => $this->input->post('placementid'),
			'package_id' => $this->input->post('package')
		);

		$this->db->insert('pending', $values['pending']);

		$query_string = "SELECT COUNT(id)+1 as entry_num FROM entries WHERE account_id = '$account_id'";
		$query = $this->db->query($query_string);
		$entry_id = $account_id . sprintf('%1$05d',$query->first_row()->entry_num);

		$values['entry_id'] = $entry_id;
		$values['created'] = true;
		return $values;
	}

	public function create_development_entry($account_id, $package)
	{
		$values = NULL;

		$ticket_creation_timestamp = NULL;

		if( $query = $this->check_valid_ticket( $package, $this->input->post('ticket_code') ) ) {
			$result = $query->first_row();
			$ticket_creation_timestamp = $result->creation_timestamp;

			$query_string = "DELETE FROM tickets WHERE code = '" . $this->input->post('ticket_code') . "'";
			$query = $this->db->query($query_string);

			$query_string = "SELECT COUNT(id)+1 as entry_num FROM entries WHERE account_id = '$account_id'";
			$query = $this->db->query($query_string);
			$entry_id = $account_id . sprintf('%1$05d',$query->first_row()->entry_num);

			$query_string = "SELECT leader_id FROM entries WHERE entry_id = '" . $this->input->post('referrerid') . "'";
			$query = $this->db->query($query_string);
			$leader_id = $query->first_row()->leader_id;

			$query_string = "INSERT INTO `entries` (`entry_id`,`account_id`,`leader_id`,`package_id`,`ticket_code`,`placement_id`,`ticket_creation_timestamp`) VALUES (" .
					 "'$entry_id', '$account_id', $leader_id,'" . $this->input->post('package') . "', '" . $this->input->post('ticket_code')  . "','" . ($this->input->post('sub_referrerid') != '' ? $this->input->post('sub_referrerid') : $this->input->post('referrerid')) . "' , '$ticket_creation_timestamp'"  . ")";
			
			$values = array();

			$this->db->query($query_string);
			$values['created'] = true;
			$values['created'] = $this->account_model->create_board_placement($entry_id, ($this->input->post('sub_referrerid') != '' ? $this->input->post('sub_referrerid') : $this->input->post('referrerid')) );

			$query_string = "SELECT classification,amount FROM packages WHERE id = '" . $this->input->post('package') . "'";
			$query = $this->db->query($query_string);
			$classification = $query->first_row()->classification;
			$amount = $query->first_row()->amount;


			$direct_referrer_id = $this->account_model->get_direct_referrer_id($account_id);
			$direct_account_type = $this->account_model->get_account_type( $direct_referrer_id );
			
			// if($values['created'])
			// {
			// 	if ($classification == "Entry") {
			// 		$newAges = [0.20,0.15,0.10,0.08,0.08,0.10,0.10,0.10,0.05,0.04];
			// 		$this->account_model->add_unilevel_income( $account_id, $entry_id, 100, $newAges );
			// 		$fsAges = [2,0.2,0.05,0.05,0.2];
			// 		$this->account_model->add_fast_bonus_income( $account_id, $entry_id, 100, true, $fsAges );
			// 	}

			// 	$this->account_model->add_office_income( $account_id, $entry_id, 'Entry Payment', $amount );
			// 	if($this->input->post("stockistid") != ""):
			// 		$this->account_model->add_stockist_finance($account_id, $entry_id,$this->input->post("stockistid"),600);
					
			// 		$query_stockist = "UPDATE account SET direct_stockist_code = '" . $this->input->post("stockistid") . "' WHERE account_id = '$account_id' AND direct_stockist_code = ''";
			// 		$query_stockist = $this->db->query($query_stockist);
			// 	endif;
			// }
			$this->account_model->add_payment(substr($this->input->post('referrerid'), 0, 7),2200);
			$this->account_model->add_referral_income($account_id,50);
			$values['entry_id'] = $entry_id;
		}
		
		return $values;
	}

	public function add_stockist_finance($account_id,$entry_id,$stockist_id,$amount,$maintain=true)
	{
		if(substr($stockist_id, 3,2) == "00" || substr($stockist_id, 3,2) == "77" )
		{
			if($maintain)
				$this->account_model->add_stockist_income( $account_id, $entry_id, $stockist_id, 45  );
			else
				$this->account_model->add_stockist_income( $account_id, $entry_id, $stockist_id, $amount * 0.075  );
		}
		else
		{
			if($maintain){
				$this->account_model->add_stockist_income( $account_id, $entry_id, $stockist_id, 20  );
				$this->account_model->add_stockist_income( $account_id, $entry_id, substr($stockist_id,0,3) . "00", 25 );
			} else {
				$this->account_model->add_stockist_income( $account_id, $entry_id, $stockist_id, $amount * 0.04  );
				$this->account_model->add_stockist_income( $account_id, $entry_id, substr($stockist_id,0,3) . "00", $amount * 0.035 );
			}
		}
	}

	public function create_entry( $id )
	{
		$values = array();

		$query = $this->db->get_where('pending',array('id'=>$id));
		$result = $query->result();
		if($query->num_rows() == 1): $result = $result[0]; else: echo 'Error:A001';endif;

		$entry_id = $this->utility_model->create_unique_random_string('alpha_numeric',17,'entries','entry_id');

		$query_string = "INSERT INTO `entries` (`entry_number`,`entry_id`,`account_id`,`placement_id`,`package_id`) " .
				 "SELECT COUNT(id), '$entry_id', '$result->account_id', '$result->placement_id', '$result->package_id' ".
				 "FROM `entries` WHERE account_id = '$result->account_id'";
		
		$this->db->query($query_string);

		return $this->account_model->create_board_placement($entry_id);
	}

	public function create_board_placement($entry_id,$referrer_id)
	{
		$board_id = $this->account_model->get_placement_board_id( $entry_id );
		$position = $this->account_model->get_placement_board_count( $board_id );
		$query_string = "INSERT INTO matrix_placements (`board_id`,`entry_id`,`position`) VALUES ('$board_id','$entry_id','$position')";
		$this->db->query($query_string);

		return $this->account_model->update_qualifying_count($this->db->insert_id(),$entry_id);
	}

	public function create_upgraded_board_placement($entry_id,$level)
	{
		$board_id = $this->account_model->get_upgraded_placement_board_id( $entry_id, $level );
		$position = $this->account_model->get_placement_board_count( $board_id );
		$query_string = "INSERT INTO matrix_placements (`board_id`,`entry_id`,`position`) VALUES ('$board_id','$entry_id','$position')";
		$this->db->query($query_string);

		return $this->account_model->update_qualifying_count($this->db->insert_id(),$entry_id);
	}

	public function create_new_upgraded_board_placement($entry_id,$level,$leader_id)
	{
		$query_string = "INSERT INTO matrix_boards (`level`,`leader_id`) VALUES ($level+1,$leader_id)";
		$query = $this->db->query($query_string);

		$board_id = $this->db->insert_id();
		$query_string = "INSERT INTO matrix_placements (`board_id`,`entry_id`,`position`) VALUES ('$board_id','$entry_id',0)";
		$this->db->query($query_string);
	}

	private function create_board_graduation($board_id)
	{
		$boards = array();
		$newboards = array();
		$query = $this->db->query("SELECT entry_id, qualify_count FROM matrix_placements WHERE board_id = '$board_id' ORDER BY position ASC");
		$graduate_id = $query->first_row()->entry_id;
		$result = $query->result();

		foreach ($result as $key => $value) {
			$boards[] = $value;
		}

		$newboards['left'] = [$boards[1],$boards[3],$boards[4]];
		$newboards['right'] = [$boards[2],$boards[5],$boards[6]];

		/*
		for ($i=0; $i < 3; $i++) {
			for($ii=1;$ii<7;$ii++) {
				$line = $result[$ii];
				if($line->qualify_count== (2-$i)):
					$boards[]= array('entry_id'=>$line->entry_id,'qualify_count'=>$line->qualify_count);
				endif;
				// echo $ii;
			}
		}

		$gap = 2;
		$max = 1;
		$sel = 0;
		$newboards['left'] = array();
		while ($sel < 6):
			for ($ii=0; $ii < $max; $ii++) {
				$newboards['left'][] = $boards[$sel + $ii];
			}
			$sel += $gap;
			$gap *= 2;
			$max *= 2;
		endwhile;

		$gap = 2;
		$max = 1;
		$sel = 1;
		$newboards['right'] = array();

		while ($sel < 6):
			for ($ii=0; $ii < $max; $ii++) {
				$newboards['right'][] = $boards[$sel + $ii];
			}
			$sel += $gap + $max;
			$gap *= 2;
			$max *= 2;
		endwhile;*/

		$query = $this->db->query("SELECT level,leader_id FROM entries WHERE entry_id = '$graduate_id'");
		$level = $query->first_row()->level;
		$leader_id = $query->first_row()->leader_id;


		$query = $this->db->query("SELECT qualify_count FROM matrix_placements WHERE entry_id = '$graduate_id'");
		$qualify_count = $query->first_row()->qualify_count;

		$this->db->query("INSERT INTO matrix_boards (level,leader_id) VALUES ($level,$leader_id)");
		$new_board_id = $this->db->insert_id();
		foreach ($newboards['left'] as $key => $values) {
			$this->db->query("INSERT INTO matrix_placements (`entry_id`,`qualify_count`,`position`,`board_id`) VALUES ('".$values->entry_id."','".$values->qualify_count."',$key,'$new_board_id')");
		}

		// $new_board_id = $this->utility_model->create_unique_random_string('alpha_numeric',7,'boards','board_id');
		$this->db->query("INSERT INTO matrix_boards  (level,leader_id) VALUES ($level,$leader_id)");
		$new_board_id = $this->db->insert_id();
		foreach ($newboards['right'] as $key => $values) {
			$this->db->query("INSERT INTO matrix_placements (`entry_id`,`qualify_count`,`position`,`board_id`) VALUES ('".$values->entry_id."','".$values->qualify_count."',$key,'$new_board_id')");
		}

		
		$this->db->query("UPDATE matrix_boards SET status = 0 WHERE id = '$board_id'");
		$this->account_model->add_graduation_income( $graduate_id, $level );
		if( $qualify_count == 2 && $level < 10) {
			$this->db->query("UPDATE entries SET level = $level+1 WHERE entry_id = '$graduate_id'");
			$query = $this->db->query("SELECT level FROM matrix_boards WHERE level = $level+1");
			if($query->num_rows > 0) {
				$this->account_model->create_upgraded_board_placement($graduate_id,$level+1);
			} else {
				$this->account_model->create_new_upgraded_board_placement($graduate_id,$level,$leader_id);
			}
		}
		elseif( $level == 10 )
		{

		}
		else
		{
			$this->db->query("UPDATE entries SET graduation_status = 1 WHERE entry_id = '$graduate_id'");
		}
	}


	private function update_qualifying_count($id,$entry_id)
	{
		$query_string = "UPDATE matrix_placements SET qualify_count = " . 
						"(SELECT COUNT(*) as qualify_count FROM entries WHERE placement_id = " .
						"(SELECT placement_id FROM entries WHERE entry_id = '$entry_id'))" . 
						"WHERE entry_id = (SELECT placement_id FROM entries WHERE entry_id = '$entry_id')";
				
		$this->db->query($query_string);
		return $this->account_model->check_board_graduation($id);
	}

	public function check_direct_referrals_count($account_id, $passing_count, $direct = false)
	{
		if($direct):
			$query_string = "SELECT COUNT(direct_referrer_id) as referral_count, direct_referrer_id FROM account WHERE direct_referrer_id = '$account_id'";
		else:
			$query_string = "SELECT COUNT(direct_referrer_id) as referral_count, direct_referrer_id FROM account WHERE direct_referrer_id = (SELECT direct_referrer_id FROM account WHERE account_id = '$account_id')";
		endif;
		$query = $this->db->query( $query_string );
		if( $query->num_rows() > 0 ):
			if( $query->first_row()->referral_count >= $passing_count ):
				return true;
			else:
				return false;
			endif;
		endif;
	}

	private function check_credentials( $username, $password )
	{
		$query_string = "SELECT account.account_id,account.username, account.password,account.privilege,profile.first_name,profile.last_name FROM account INNER JOIN profile ON account.account_id = profile.account_id WHERE username = '$username' AND password='" . md5($password) . "'";
		$query = $this->db->query( $query_string );
		if($query->num_rows() > 0):
			$userdata = array(
                   'account_id'  => $query->first_row()->account_id,
                   'username'  => $query->first_row()->username,
                   'logged_in' => TRUE,
                   'first_name' => $query->first_row()->first_name,
                   'last_name' => $query->first_row()->last_name,
                   'privilege' => $query->first_row()->privilege
               );
			$this->session->set_userdata($userdata);
			return true;
		else:
			return false;
		endif;
	}

	private function check_credit($account_id)
	{
		$credit_balance = $this->account_model->get_total_credit($account_id) - $this->account_model->get_credit_payment($account_id);
		if($credit_balance <= 0) {
			$this->account_model->set_upgrade_privilege( $account_id, 'bronze' );
		}
	}


	private function check_board_graduation( $id )
	{
		$query_string = "SELECT COUNT(*) as max_placements,board_id FROM matrix_placements WHERE board_id = (SELECT board_id FROM matrix_placements WHERE id = $id)";
		$query = $this->db->query($query_string);
		if( $query->first_row()->max_placements == 7 ):
			$this->account_model->create_board_graduation( $query->first_row()->board_id );
		endif;
		return true;
	}

	private function check_maximum_referral($referrer_id)
	{
		$value = true;
		$query_referrals = $this->db->get_where(
									'account',
									array(
										'referrer_id' => $referrer_id
									)
								);

		$query_referrer = $this->db->get_where(
									'account',
									array(
										'account_id' => $referrer_id
									)
								);
		$result = $query_referrer->result();
		if( $query_referrer->num_rows() > 0 ):
			$result = $result[0];

			if( $query_referrals->num_rows() < $result->max_referrals):
				$value = true;
			else:
				$value = false;
			endif;
		endif;

		return $value;
	}

	public function check_maximum_placements($placement_id)
	{
		$value = true;
		$query = $this->db->query("SELECT COUNT(id) as max_placements FROM entries WHERE `placement_id` = '$placement_id'");
		if($query->num_rows() > 0 ):
			if( $query->first_row()->max_placements >= 2)://max placements (2)
				$value = false;
			endif;
		endif;
		return $value;
	}

	public function check_valid_placements($placement_id)
	{
		$value = false;
		$query = $this->db->query("SELECT * FROM entries WHERE `entry_id` = '$placement_id' AND level = 1");
		if($query->num_rows() > 0 ):
			$value = true;
		endif;
		return $value;
	}

	private function check_valid_data($field, $tablefield)
	{
		$tablefield = explode('.', $tablefield);
		$query_string = "SELECT " . $tablefield[1] . " FROM " . $tablefield[0] . " WHERE " . $tablefield[1] . " = '" . $field . "'";
		$query = $this->db->query( $query_string );
		if($query->num_rows>0): 
			return true; 
		else: 
			return false; 
		endif;
	}

	private function check_valid_ticket($package, $ticketcode)
	{

		$query_string = "SELECT classification,amount FROM packages WHERE id = '$package'";
		$query = $this->db->query( $query_string );
		$result = $query->first_row();
		$classification = $result->classification;
		$amount = $result->amount;

		$query_string = "SELECT * FROM tickets WHERE code = '$ticketcode' AND amount = $amount";
		$query = $this->db->query($query_string);
		$ticket_creation_timestamp = NULL;
		if($query->num_rows > 0): 
			return $query; 
		else: 
			return false; 
		endif;
	}

	private function check_available_tickets( $ticket_code )
	{
		$query_string = "SELECT code FROM tickets WHERE code = '$ticket_code'";
		$query = $this->db->query($query_string);
		if( $query->num_rows == 0 ):
			return false;
		else:
			return true;
		endif;
		return true;
	}

	private function check_privilege( $account_id, $parent = false )
	{

		$query_string = "SELECT privilege FROM account WHERE account_id = '$account_id'";

		
		$query = $this->db->query($query_string);
		if($parent):
			if ( ($query->num_rows() > 0) && (($query->first_row()->privilege == 'gold') ||  ($query->first_row()->privilege == 'silver') ||  ($query->first_row()->privilege == 'bronze'))) {
				return false;
			}
			else {
				return true;
			}
		else:
			if ( ($query->num_rows() > 0) &&  ($query->first_row()->privilege == 'gold') ) {
				return false;
			}
			else {
				return true;
			}
		endif;
	}

	public function get_entry_count( $account_id, $type )
	{
		$query_string_count = "SELECT COUNT(entries.id) as entry_count FROM entries INNER JOIN packages ON entries.package_id = packages.id WHERE entries.account_id = '$account_id' AND packages.classification = '$type'";
		$query_count = $this->db->query($query_string_count);
		$result_count = $query_count->first_row();
		$entry_count = $result_count->entry_count;
		return $entry_count;
	}

	public function get_all_entry_count( )
	{
		$query_string_count = "SELECT COUNT(entries.id) as entry_count FROM entries";
		$query_count = $this->db->query($query_string_count);
		$result_count = $query_count->first_row();
		$entry_count = $result_count->entry_count;
		return $entry_count;
	}

	public function get_repeat_order()
	{
		$this->load->model('administrator_model');
		if($this->administrator_model->get_stockist()):
			$this->form_validation->set_rules('ticket_code', 'Ticket Number', 'trim|required|alpha_numeric|min_length[7]|max_length[7]|xss_clean');
			$this->form_validation->set_rules('accountid', 'Account ID', 'trim|required|alpha_numeric|alpha_numeric|xss_clean|is_exists');
			$query = $this->db->get('products');
			$data["products"] = $query->result();
			if ($this->form_validation->run()):
				if(!$this->administrator_model->check_valid_data($this->input->post('accountid'),'account.account_id')):
					$data['badmessage'] = 'The Account ID you entered is invalid.';
				elseif(!$this->administrator_model->check_valid_ticket($this->input->post('product'),$this->input->post('purchase_type'),$this->input->post('ticket_code'))):
					$data['badmessage'] = 'The Ticket Code you entered is invalid.';
				else:
					$this->administrator_model->set_purchased_order($this->input->post('product'),$this->input->post('purchase_type'),$this->input->post('accountid'));
					$data['goodmessage'] = 'Purchase successful.';
					$this->load->view('templates/message', $data);
					$this->output->set_header('refresh:3;url=' . current_url());
				endif;
			endif;
			if(!isset($data['goodmessage'])):
				$this->load->view('account/repeat_order', $data);
			endif;
		endif;
	}


	private function get_placement_board_id( $entry_id )
	{
		$query_string = "SELECT DISTINCT(matrix_boards.id) as board_id  FROM matrix_boards INNER JOIN matrix_placements ON matrix_placements.board_id = matrix_boards.id WHERE matrix_placements.entry_id = (SELECT placement_id FROM entries WHERE entry_id='$entry_id') AND matrix_boards.status = 1";
		$query = $this->db->query( $query_string );

		return $query->first_row()->board_id;
	}

	private function get_upgraded_placement_board_id( $entry_id, $level )
	{
		$query_string = "SELECT matrix_placements.board_id FROM matrix_placements INNER JOIN entries ON entries.entry_id = matrix_placements.entry_id INNER JOIN matrix_boards ON matrix_boards.id = matrix_placements.board_id WHERE matrix_boards.level = 2 AND matrix_boards.status = 1 AND matrix_placements.entry_id = (SELECT placement_id FROM entries WHERE entry_id = '$entry_id')";
		$query = $this->db->query( $query_string );

		if( $query->num_rows == 0 )
		{
			$query_string = "SELECT id FROM matrix_boards WHERE level = $level ORDER BY creation_timestamp ASC";
			$query = $this->db->query( $query_string );

			return $query->first_row()->id;
		}
		else
		{
			return $query->first_row()->board_id;
		}
		
	}

	private function get_placement_board_count( $board_id )
	{
		$query_string = "SELECT COUNT(id) as position FROM matrix_placements WHERE board_id = '$board_id'";
		$query = $this->db->query( $query_string );

		return $query->first_row()->position;
	}

	public function get_boards( $page = 0 )
	{
			$data['title'] = "View Boards";
			$data['finance'] = $this->account_model->get_financial_data('matrix', $this->session->userdata('account_id'));
			//getting user entries
			$query_string = "";
			
			switch ($this->session->userdata('account_id')) {
				case 'TNM0015':
					$query_string = "SELECT DISTINCT(matrix_boards.id) FROM entries " . 
							"INNER JOIN matrix_placements ON entries.entry_id = matrix_placements.entry_id " . 
							"INNER JOIN matrix_boards ON matrix_placements.board_id = matrix_boards.id WHERE entries.account_id = '" . $this->session->userdata('account_id') . "'";
					break;
				
				default:
					$query_string = "SELECT DISTINCT(matrix_boards.id) FROM entries " . 
							"INNER JOIN matrix_placements ON entries.entry_id = matrix_placements.entry_id " . 
							"INNER JOIN matrix_boards ON matrix_placements.board_id = matrix_boards.id WHERE entries.account_id = '" . $this->session->userdata('account_id') . "' AND matrix_boards.status = 1";
					break;
			}

			$query = $this->db->query($query_string);


			$boards = $query->result();

			if($query->num_rows()> 0):
				if($page >= count($boards)): $page = count($boards) - 1; endif;
				if($page < 0): $page = 0; endif;
				$board =  $boards[$page];
				$data['prev'] = $page - 1;
				$data['next'] = $page + 1;
				$data['page'] = $page;
				$data['max_page'] = count($boards);
				$data['matrix'] = $this->account_model->get_matrix( $board->id );
			else:
				$data['prev'] = 0;
				$data['next'] = 0;
				$data['page'] = 0;
				$data['max_page'] = 1;
				$data['matrix'] = '<span class="notify">Your current board is empty.</span>';
			endif;
			$this->load->view('templates/header', $data);
			$this->load->view('account/matrix', $data);
			$this->load->view('templates/footer');
	}

	public function get_matrix($board_id)
	{
		$query_string = "SELECT DISTINCT(level) FROM matrix_boards WHERE id = $board_id";
		$query = $this->db->query($query_string);
		$level = $query->first_row()->level;

		$placements = $this->account_model->get_placements( $board_id );
		if(count($placements) != 7):
			$rem = 7 - count($placements);
			for ($i=0; $i < $rem; $i++) { 
				$placements[] = 'EMPTY';	
			}
		endif;
		$value = '<div class="level">LEVEL ' . $level . '</div>';
		$counter = 0;
		$max = 1;
		for ($i=0; $i < 3; $i++) { 
			$value .= '<div class="board_line">';
			for ($ii=0; $ii < $max; $ii++) {
				$value .= '<div style="width:' . (100/$max) . '%;float:left;">';
				if($i > 0):
					$value .= '<div class="vertical_line"></div>';
				endif;
				$value .= '<a class="entry_box ' . ($placements[$counter] == 'EMPTY' ? 'empty' : $this->account_model->get_placement_status($placements[$counter]) )  . '">' . ($placements[$counter] == 'EMPTY' ? 'EMPTY' : $this->account_model->get_placement_display($placements[$counter]) ) . '</a>';
				if($i != 2):
					$value .= '<div class="vertical_line"></div>';
					$value .= '<div class="horizontal_line"></div>';
				endif;
				$value .= '</div>';
				$counter++;
			}
			$value .= "</div>";
			$max *= 2;
		}
		return $value;
	}

	private function get_placements($board_id)
	{
		$query_string = "SELECT account.username as username, entries.entry_id as placement_code  FROM matrix_placements INNER JOIN entries ON matrix_placements.entry_id = entries.entry_id INNER JOIN account ON entries.account_id = account.account_id WHERE matrix_placements.board_id = $board_id ORDER BY matrix_placements.position ASC";
		$query = $this->db->query($query_string);
		
		return $query->result();
	}

	private function get_placement_display( $placement )
	{
		$query_string = 'SELECT account.username as username FROM entries INNER JOIN account ON entries.account_id = account.account_id WHERE entries.placement_id = "' . $placement->placement_code . '"';
		$query = $this->db->query( $query_string );
		$result = $query->result_array();
		return '<b>' . $placement->username . "[" . ltrim(substr($placement->placement_code,-5),'0') . "]" . '</b> <span style="font-size: 11px">' .  ($query->num_rows > 0 ?  $result[0]['username'] : '' ) . ' <br>' .  ($query->num_rows > 1 ? $result[1]['username'] : '</span>' ) ;
	}


	private function get_placement_status( $placement )
	{
		$query_string = 'SELECT account.username as username FROM entries INNER JOIN account ON entries.account_id = account.account_id WHERE entries.placement_id = "' . $placement->placement_code . '"';
		$query = $this->db->query( $query_string );
		$result = $query->result_array();
		$class = 'initial';
		if( $query->num_rows > 0 && $query->num_rows < 2 ){
			$class = 'active';
		}

		if( $query->num_rows > 1 ){
			$class = 'qualified';
		}

		return $class;
	}

	public function get_unilevel($id=null)
	{
		$id = ($id == null ? $this->session->userdata('account_id') : $id);

		$query = $this->db->query("SELECT account.referrer_id, profile.first_name, profile.last_name FROM account INNER JOIN profile ON account.account_id = profile.account_id WHERE account.account_id = '$id'");
		$unilevel_string = '';
		if($query->num_rows > 0):
			$unilevel_string .= ( $id == $this->session->userdata('account_id') ? '' : '<a href="' . base_url() . 'account/unilevel/' . $query->first_row()->referrer_id . '">-Referrer: ' . $query->first_row()->first_name . ' ' . $query->first_row()->last_name . '</a>' );
		endif;
		//getting referral data
		$unilevel_string .= $this->account_model->get_referral_data( $id );
		//$data['referrals'] = $referrals;

		$data['unilevel'] = $unilevel_string;
		$data['finance'] = $this->account_model->get_financial_data('unilevel', $this->session->userdata('account_id'));
		$this->load->view('account/unilevel', $data);
	}

	public function get_referral_data($id, $divide = 1, $currentlevel = 0, $maxlevel = 2)
	{
		//select data of current id
		$query = $this->db->query("SELECT * FROM account INNER JOIN profile ON account.account_id = profile.account_id WHERE account.account_id = '$id'");
		if($id != 'EMPTY'):
			$unilevel_string = '<div style="width:' . (1360/$divide) . 'px;float:left;">';
			if($currentlevel > 0):
				$unilevel_string .= '<div style="width: 1px;height:20px;border-right:1px solid #000;margin:auto;"></div>';
			endif;
			$unilevel_string .= '<a class="entry_box" href="' . base_url() . 'account/unilevel/' . $query->first_row()->account_id . '">';
			$unilevel_string .= $query->first_row()->first_name . ' ' . $query->first_row()->last_name;
			$unilevel_string .= '</a>';
			if($currentlevel != $maxlevel):
				$unilevel_string .= '<div style="width: 1px;height:20px;border-right:1px solid #000;margin:auto;"></div>';
				$unilevel_string .= '<div style="width: 75.1%;border-bottom: 1px solid #000;margin-left: 12.5%;"></div>';
			endif;
		else:
			$unilevel_string = '<div style="width:' . (1360/$divide) . 'px;float:left;">';
			if($currentlevel > 0):
				$unilevel_string .= '<div style="width: 1px;height:20px;border-right:1px solid #000;margin:auto;"></div>';
			endif;
			$unilevel_string .= '<a class="entry_box" href="' . base_url() . 'account/signup">';
			$unilevel_string .= 'EMPTY';
			$unilevel_string .= '</a>';
			if($currentlevel != $maxlevel):
				$unilevel_string .= '<div style="width: 1px;height:20px;border-right:1px solid #000;margin:auto;"></div>';
				$unilevel_string .= '<div style="width: 75.1%;border-bottom: 1px solid #000;margin-left: 12.5%;"></div>';
			endif;
		endif;

		//select children of parent id
		$this->db->select('*');
		$this->db->from('account');
		$this->db->where('referrer_id', $id);
		$query = $this->db->get();
		$result = $query->result();
		if($currentlevel < $maxlevel):
			foreach ($result as $key => $value) {
				$unilevel_string .= $this->account_model->get_referral_data( $value->account_id, $divide * 4 , $currentlevel + 1 );
			}
			for ($i=$query->num_rows(); $i < 4; $i++) { 
			 	$unilevel_string .= $this->account_model->get_referral_data( 'EMPTY', $divide * 4 , $currentlevel + 1 );
			}
		endif;
		$unilevel_string .= '</div>'; 
		return $unilevel_string;
	}

	public function get_financial_data( $type, $account_id, $option = '' )
	{
		$query_string = "SELECT DATE_FORMAT(creation_timestamp,'%M %e %y  %l:%i:%S %p') as transaction_date,type,description,amount,payee_entry_id,payer_entry_id,payer_id,payee_id FROM finance WHERE payee_id = '$account_id' AND " . ($type == 'matrix' ? "description LIKE '%matrix%'" : "description = '$type'") . " /*AND creation_timestamp BETWEEN SUBDATE(CURDATE(),INTERVAL 1 MONTH)*/ AND NOW() AND TYPE LIKE '%" . $option . "%'";
		//var_dump($query_string);
		$query = $this->db->query($query_string);
		if ($query->num_rows() > 0) {
			// $table = "<div class='financial_table'>";
			$table = "<div class='fin_row'>" . "<div class='fin_title'>Date</div>" . "<div class='fin_title'>Type</div>" . "<div class='fin_title'>Amount</div>" . "<div class='fin_title'>From</div>" . "<div class='fin_title'>To</div>" . "</div>";
			$total = 0;
			foreach ($query->result() as $key => $line) {
				$table .= "<div class='fin_row'>";
				$table .= "<div class='fin_date fin_data'>" . $line->transaction_date . "</div>";
				$table .= "<div class='fin_type fin_data'>" . $line->description . "</div>";
				$table .= "<div class='fin_amount fin_data'>" . ($line->type=='profit'?'+':'-') . $line->amount . "</div>";
				$table .= "<div class='fin_from fin_data'>" . $line->payer_id . "</div>";
				$table .= "<div class='fin_to fin_data'>" . $line->payee_id . "</div>";
				$table .= "</div>";
				$total += ($line->type=='profit'?+($line->amount):-($line->amount));
			}
			$table .= "<div class='fin_row'>";
			$table .= "<div class='fin_end'> </div>"."<div class='fin_end'>Total</div>". "<div class='fin_end'>" . $total . "</div>"."<div class='fin_end'></div>"."<div class='fin_end'></div>";
			$table .= "</div>";
			$table .= "<div class='clearbox'></div>";
			// $table .= "</div>";
			return $table;
		}
		else
		{
			return "<div class='financial_table'><span>No data found.</span></div>";
		}
	}

	public function get_matrix_list( $type, $account_id, $option = '' )
	{
		$query_string = "SELECT profile.first_name, profile.last_name FROM finance INNER JOIN profile ON finance.payee_id = profile.account_id WHERE finance.description = '$type'";
		$query = $this->db->query($query_string);
		if ($query->num_rows() > 0) {
			$table = "";
			$ctr = 1;
			foreach ($query->result() as $line) {
				$table .= "<div class='matrix_fin_row'>" . $ctr . ".) " . $line->first_name . " " . $line->last_name . "</div>";
				$ctr++;
			}
			
			return $table;
		}
		else
		{
			return "<div class='financial_table'><span>No data found.</span></div>";
		}
	}

	private function get_current_board($parentid,$select,$max=31)
	{
		$query_string = "SELECT " . $select . " FROM board WHERE (";
		for ($i=1; $i <= $max; $i++) { 
			$query_string .= "e" . ($i) . " = '$parentid'";
			if($i < $max): $query_string .= " OR "; endif;
		}
		$query_string .= ") AND currententry < 31";
		$query = $this->db->query($query_string);
		return $query->result_array();
	}

	private function get_column_name($result,$parentid)
	{
		$column_count = 0;
		foreach ($result as $key => $value) {
			$column_count++;
			if($value == $parentid):
				break;
			endif;
		}
		return $column_count-2;
	}

	public function get_entries( $account_id, $option = '' )
	{
		$option = ($option != '' ? ' AND graduation_status = ' . $option : '');
		$query_string = "SELECT entry_id  FROM entries WHERE account_id = '" . $account_id . "'" . $option . "";
		$query = $this->db->query( $query_string );
		$result = $query->result();
		if($query->num_rows() > 0):
			$entries = '';
			foreach ($result as $line) {
				$entries .= '' . $line->entry_id . '<br>';
			}
			return $entries;
		else:
			return '';
		endif;
	} 

	public function get_entries_count( $account_id, $option = '' )
	{
		$option = ($option != '' ? ' AND graduation_status = ' . $option : '');
		$query_string = "SELECT COUNT(*) as num_entries  FROM entries WHERE account_id = '" . $account_id . "'" . $option . "";
		$query = $this->db->query( $query_string );
		$result = $query->first_row();
		if($query->num_rows() > 0):
			return $result->num_entries;
		else:
			return 0;
		endif;
	}

	public function get_earnings( $account_id, $option = '' )
	{
		$option = ($option != '' ? '' . $option : '');
		$query_string = "SELECT SUM(amount) as earnings FROM finance WHERE payee_id = '" . $account_id . "' AND type = 'PROFIT' " . $option . "";
		$query = $this->db->query( $query_string );
		$result = $query->first_row();
		if($query->num_rows() > 0):
			return $result->earnings;
		else:
			return 0;
		endif;
	}

	public function get_spendings( $account_id, $option = '' )
	{
		$option = ($option != '' ? '' . $option : '');
		$query_string = "SELECT SUM(amount) as spendings FROM finance WHERE payee_id = '" . $account_id . "' AND type = 'loss' " . $option . "";
		$query = $this->db->query( $query_string );
		$result = $query->first_row();
		if($query->num_rows() > 0):
			return $result->spendings;
		else:
			return 0;
		endif;
	}

	public function get_total_earnings( $account_id, $option = '' )
	{
		$total_earnings = $this->account_model->get_earnings( $account_id );
		$total_spendings = $this->account_model->get_spendings( $account_id );
		return ($total_earnings - $total_spendings);
	}

	public function get_total_income( $account_id, $option = '' )
	{
		$total_earnings = $this->account_model->get_earnings( $account_id, $option );

		return $total_earnings;
	}

	public function get_total_credit( $account_id, $option = '' )
	{
		$option = ($option != '' ? '' . $option : '');
		$query_string = "SELECT SUM(amount) as creditbalance FROM finance WHERE payee_id = '" . $account_id . "' AND type = 'credit' " . $option . " AND description = 'employ balance'";
		$query = $this->db->query( $query_string );
		$result = $query->first_row();
		if($query->num_rows() > 0):
			return $result->creditbalance;
		else:
			return 0;
		endif;
	}

	public function get_credit_payment( $account_id, $option = '' )
	{
		$option = ($option != '' ? '' . $option : '');
		$query_string = "SELECT SUM(amount) as creditpayment FROM finance WHERE payee_id = '" . $account_id . "' AND type = 'credit' " . $option . " AND description  = 'employ payment'";
		$query = $this->db->query( $query_string );
		$result = $query->first_row();
		if($query->num_rows() > 0):
			return $result->creditpayment;
		else:
			return 0;
		endif;
	}

	public function get_withdrawable_earnings( $account_id )
	{
		$last_monday = date('Y-m-d H:i:s' ,strtotime('last monday', strtotime('tomorrow'))+15*3600);
		$total_earnings = $this->account_model->get_earnings( $account_id, " AND creation_timestamp < '$last_monday'" );
		$total_spendings = $this->account_model->get_spendings( $account_id, " AND creation_timestamp < NOW()" );
		return ($total_earnings - $total_spendings);
	}

	public function get_total_payout( $account_id, $option = '' )
	{
		$total_earnings = $this->account_model->get_spendings( $account_id, "AND description = 'payout spending'" );
		return $total_earnings;
	}

	public function get_u_from_a($account_id)
	{
		$query_string = "SELECT username FROM account WHERE account_id = '" . $account_id . "'";
		$query = $this->db->query( $query_string );
		$result = $query->first_row();
		if($query->num_rows() > 0):
			return $result->username;
		else:
			return false;
		endif;
	}

	public function get_a_from_e($factor,$field)
	{
		$query_string = "SELECT " . $field . " FROM entries WHERE entry_id = '" . $factor . "'";
		$query = $this->db->query( $query_string );
		$result = $query->result_array();
		if($query->num_rows() > 0):

			return $result[0][$field];
		else:
			return false;
		endif;
	}

	public function get_referrer_id($account_id)
	{
		$query_string = "SELECT referrer_id FROM account WHERE account_id = '" . $account_id . "'";
		$query = $this->db->query( $query_string );
		$result = $query->first_row();
		if($query->num_rows() > 0):
			return $result->referrer_id;
		else:
			return '';
		endif;
	}

	public function get_direct_referrer_id($account_id)
	{
		$query_string = "SELECT direct_referrer_id FROM account WHERE account_id = '" . $account_id . "'";
		$query = $this->db->query( $query_string );
		$result = $query->first_row();
		if($query->num_rows() > 0):
			return $result->direct_referrer_id;
		else:
			return 'ERROR_ID';
		endif;
	}

	public function get_direct_referral_ids($account_id)
	{
		$query_string = "SELECT * FROM account INNER JOIN profile ON account.account_id = profile.account_id WHERE account.direct_referrer_id = '" . $account_id . "'";
		$query = $this->db->query( $query_string );
		$result = $query->result();
		if($query->num_rows() > 0):
			return $result;
		else:
			return '';
		endif;
	}

	public function get_package_type($id)
	{
		$query_string = "SELECT classification FROM packages WHERE id = '" . $id . "'";
		$query = $this->db->query($query_string);
		return $query->first_row()->classification;
	}

	public function get_account_type($account_id)
	{
		$query_string = "SELECT privilege FROM account WHERE account_id = '" . $account_id . "'";
		$query = $this->db->query( $query_string );
		$result = $query->first_row();
		if($query->num_rows() > 0):
			return $result->privilege;
		else:
			return '';
		endif;
	}

	public function get_accounts($select)
	{
		$query_string = "SELECT " . $select . " FROM account WHERE account_id != 'TNM0015'";
		$query = $this->db->query( $query_string );
		$result = $query->result();
		if($query->num_rows() > 0):
			return $result;
		else:
			return false;
		endif;
	}

	private function add_office_income( $account_id, $entry_id, $description, $amount )
	{
		$values = array(
						'type' => 'profit',
						'description' => $description,
						'amount' => $amount,
						'payer_id' => $account_id,
						'payee_id' => 'thenoveltymarketing',
						'payer_entry_id' => $entry_id
						);
		$this->db->insert('finance', $values);
	}

	private function add_account_income( $account_id, $description, $amount )
	{
		$values = array(
						'type' => 'profit',
						'description' => $description,
						'amount' => $amount,
						'payer_id' => $account_id,
						'payee_id' => $account_id
						);
		$this->db->insert('finance', $values);
	}

	private function add_graduation_income( $graduated_id, $level )
	{
		$account_id = $this->account_model->get_a_from_e($graduated_id,'account_id');
		$values = array(
						'type' => 'profit',
						'description' => 'matrix ' . $level,
						'amount' => ($level>1?2000:4000),
						'payer_id' => 'TNM',
						'payee_id' => $account_id,
						'payee_entry_id' => $graduated_id 	
						);
		$this->db->insert('finance', $values);
	}

	public function add_unilevel_income($id, $entry_id = '', $pv = 100, $ages, $direct = false)
	{
		if($direct)
			$ancestors = $this->account_model->get_direct_ancestors($id,10);
		else
			$ancestors = $this->account_model->get_spilled_ancestors($id,10);

		foreach ($ancestors as $key => $ancestor) {
			$values = array(
							'type' => 'profit',
							'description' => 'unilevel' . ($ancestor->privilege == 'assoc' ? ' potential' : ''),
							'amount' => $ages[$key] * $pv,
							'payer_id' => $id,
							'payee_id' => $ancestor->account_id,
							'payer_entry_id' => $entry_id
							);
			$this->add_leadership_bonus($ancestor->account_id,$ages[$key] * $pv);
			$this->db->insert('finance', $values);
		}
	}

	private function get_direct_ancestors($id,$max)
	{
		$not_ancestor = true;
		$counter = 0;
		$ancestors = array();
		$m_id = $id;
		while($counter<$max && $not_ancestor) {
			$this->db->select('referrer_id,direct_referrer_id,privilege');
			$this->db->from('account');
			$this->db->where('account_id',$m_id);
			$query = $this->db->get();
			if( $query->num_rows > 0 ):
				$result = $query->first_row();

				$this->db->select('privilege,account_id');
				$this->db->from('account');
				$this->db->where('account_id',$result->referrer_id);
				$query2 = $this->db->get();
				if( $query2->num_rows() > 0 ):
					$m_id = $result->referrer_id;
					$ancestors[] = $query2->first_row();
				endif;
			else:
				$not_ancestor = false;
			endif;
			$counter++;
		}

		return $ancestors;
	}

	private function get_spilled_ancestors($id,$max)
	{
		$not_ancestor = true;
		$counter = 0;
		
		$ancestors = array();
		$m_id = $id;

		while($counter<$max && $not_ancestor) {
			$this->db->select('referrer_id,direct_referrer_id,privilege');
			$this->db->from('account');
			$this->db->where('account_id',$m_id);
			$query = $this->db->get();
			if( $query->num_rows > 0 ):
				$result = $query->result();
				$result = $result[0];

				$this->db->select('privilege,account_id,direct_stockist_code');
				$this->db->from('account');
				$this->db->where('account_id',$result->direct_referrer_id);
				$query2 = $this->db->get();
				if( $query2->num_rows() > 0 ):
					$m_id = $result->direct_referrer_id;
					$ancestors[] = $query2->first_row();
				endif;
			else:
				$not_ancestor = false;
			endif;
			$counter++;
		}

		return $ancestors;
	}

	public function add_fast_bonus_income($id, $entry_id, $pv = 100, $regular = true, $ages)
	{
		$ancestors = $this->account_model->get_direct_ancestors($id,5);

		$query_privilege = "SELECT * FROM privileges";
		$query_privilege = $this->db->query( $query_privilege );
		$result_privilege = $query_privilege->result();

		foreach ($ancestors as $key => $ancestor) {
			$p_value = 0;
			$min_value = 99;
			foreach ($result_privilege as $line) {
				if( $ancestor->privilege == $line->type )
				{
					$p_value = $line->value;
				}
				if ($min_value > $line->value) {
					$min_value = $line->value;
				}
			}

			if( $p_value > $min_value )
			{
				$values = array(
							'type' => 'profit',
							'description' => 'fast bonus',
							'amount' => $ages[$key] * $pv,
							'payer_id' => $id,
							'payee_id' => $ancestor->account_id,
							'payer_entry_id' => $entry_id
							);
				$this->db->insert('finance', $values);
			}
			else {
				$amount = ($ages[$key] * $pv);
				$credit_balance = $this->account_model->get_total_credit($id) - $this->account_model->get_credit_payment($id);
				$company_profit = ( $credit_balance >= ($amount * 0.5) ? ($amount * 0.5) : $credit_balance);
				$amount = $amount - $company_profit;

				//add profit to employ/assoc member (remaining from credit payment)
				$values = array(
							'type' => 'profit',
							'description' => 'fast bonus',
							'amount' => $amount,
							'payer_id' => $id,
							'payee_id' => $ancestor->account_id
							);
				$this->db->insert('finance', $values);

				//add payment to employ credit balance
				$this->account_model->add_credit_payment( $ancestor->account_id, $id, $company_profit );

				//add payment to stockist from company
				$query_stockist = "SELECT account_id FROM account WHERE stockist_code = '" . ($ancestor->direct_stockist_code == ''? 'YLA77': $ancestor->direct_stockist_code) . "'";
				$query_stockist = $this->db->query( $query_stockist );
				if ($query_stockist->num_rows() > 0) {
					$values = array(
								'type' => 'credit',
								'description' => 'stockist',
								'amount' => $company_profit * 0.05,
								'payer_id' => 'thenoveltymarketing',
								'payee_id' => $query_stockist->first_row()->account_id
								);
					$this->db->insert('finance', $values);
				}
			}
		}
	}

	private function add_payment($account_id, $amount)
	{
		$query_string  = "INSERT INTO finance (payee_id,type, description, amount,payer_id) " .
						 "VALUES('TNM0015', 'profit', 'payment', $amount, '$account_id' )";
						 
		$query = $this->db->query($query_string);
	}

	private function add_credit_balance($account_id, $amount)
	{
		$query_string  = "INSERT INTO finance (payee_id,type, description, amount,payer_id) " .
						 "VALUES('$account_id', 'credit', 'employ balance', $amount, 'thenoveltymarketing' )";
						 
		$query = $this->db->query($query_string);
	}

	private function add_credit_payment($account_id, $payer_id,$amount)
	{
		$query_string  = "INSERT INTO finance (payee_id,type, description, amount,payer_id) " .
						 "VALUES ('$account_id', 'credit', 'employ payment', $amount, '$payer_id') ";
						 
		$query = $this->db->query($query_string);

		$this->account_model->check_credit($account_id);
	}

	private function add_referral_income($account_id, $amount)
	{
		$query_string  = "INSERT INTO finance (payee_id,type, description, amount,payer_id) " .
						 "SELECT direct_referrer_id, 'profit', 'referral', $amount, '$account_id' " .
						 "FROM account where account_id = '$account_id'";
						 
		$query = $this->db->query($query_string);
	}

	public function add_stockist_income( $account_id, $entry_id = '', $stockist_id, $amount )
	{
		$query_string  = "INSERT INTO finance (payee_id,type, description, amount,payer_id) " .
						 "SELECT account_id, 'profit', 'stockist', $amount, '$account_id' " .
						 "FROM account where stockist_code = '$stockist_id'";
						 

		$query = $this->db->query($query_string);
	}

	public function show_finance()
	{
		$user_id = $this->session->userdata('account_id');
		$query_string = "SELECT type, description, amount, CONVERT_TZ(`creation_timestamp`,'+00:00','+08:00') as transaction_date, payee_id,payer_id,payee_entry_id,payer_entry_id" .
						" FROM finance WHERE payee_id = '$user_id' AND type='profit'";
		$query = $this->db->query($query_string);
		$data['title'] = 'Financial Statement';
		$data['finance'] = $query->result();

		$this->load->view('account/financialstatement', $data);
	}

	public function show_matrix_finance()
	{
		$user_id = $this->session->userdata('account_id');
		$query_string = "SELECT type, description, amount, CONVERT_TZ(`creation_timestamp`,'+00:00','+08:00') as transaction_date, payee_id,payer_id,payee_entry_id,payer_entry_id" .
						" FROM finance WHERE payee_id = '$user_id' AND type='profit'";
		$query = $this->db->query($query_string);
		$data['title'] = 'Financial Statement';
		$data['finance'] = $query->result();

		$this->load->view('account/matrixfinancialstatement', $data);
	}

	public function show_settings()
	{
		$query_string = "SELECT username FROM account WHERE account_id = '" . $this->session->userdata('account_id') . "'";
		$query = $this->db->query( $query_string );
		$data["account_data"] = $query->first_row();

		$query_string = "SELECT first_name,middle_name,last_name, email_address, shipping_address,residential_address,mobile_number,telephone_number FROM profile WHERE account_id = '" . $this->session->userdata('account_id') . "'";
		$query = $this->db->query( $query_string );
		$data["profile_data"] = $query->first_row();

		//validation rules
		if($this->input->post("password") != ""):
		$this->form_validation->set_rules('password', 'Password', 'trim|matches[passwordconfirmation]|min_length[7]|max_length[70]');
		$this->form_validation->set_rules('passwordconfirmation', 'Password Confirmation', 'trim|matches[password]|min_length[7]|max_length[70]');
		endif;
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|max_length[30]');
		$this->form_validation->set_rules('mobilenumber', 'Mobile Number', 'trim|required|numeric');
		$this->form_validation->set_rules('telephonenumber', 'Telephone Number', 'trim|numeric');

		if ($this->form_validation->run() == FALSE):
			$this->load->view('account/settings', $data);
		else:
			if($this->account_model->update_settings($data["profile_data"])):
				$data['goodmessage'] = "Settings Updated!";
			else:
				$data['badmessage'] = "Something went wrong! Please check the fields.";
			endif;
			$this->load->view('account/settings', $data);
		endif;
	}

	private function update_settings($profile_data)
	{
		if($this->input->post("password") != ""):
			$query_string = "UPDATE account SET password = '" . do_hash($this->input->post("password"),"md5") . "' WHERE account_id='" . $this->session->userdata('account_id') . "'";
			$this->db->query( $query_string );
		endif;

		$query_string = "UPDATE profile SET";
		$query_string .= ($this->input->post("email") != $profile_data->email_address ? " email_address = '" . $this->input->post("email") . "'," : "");
		$query_string .= ($this->input->post("mobilenumber") != $profile_data->mobile_number ? " mobile_number = '" . $this->input->post("mobilenumber") . "'," : "");
		$query_string .= ($this->input->post("telephonenumber") != $profile_data->telephone_number ? " telephone_number = '" . $this->input->post("telephonenumber") . "'," : "");
		$query_string .= " account_id = account_id";
		$query_string .= " WHERE account_id = '" . $this->session->userdata('account_id') . "'";
		$this->db->query( $query_string );

		return true;
	}

	private function add_leadership_bonus($account_id, $amount)
	{
		$query_string = "SELECT direct_referrer_id FROM account WHERE account_id = '$account_id'";
		$query = $this->db->query( $query_string );

		if ($query->num_rows > 0) {
			$direct_referrer_id = $query->first_row()->direct_referrer_id;
			$query_string = "INSERT INTO finance ( payee_id, payer_id, amount, description, type ) VALUES ( '$direct_referrer_id', '$account_id', " . ($amount*0.1) . ", 'leadership bonus', 'profit' )";
			$this->db->query( $query_string );
		}
	}

	public function request_payout($account_id)
	{
		$withdrawable_earnings = $this->account_model->get_total_earnings( $this->session->userdata('account_id') );
		if($withdrawable_earnings >= 500) {
			$query_string = "INSERT INTO payouts (`amount`,`account_id`) VALUES ($withdrawable_earnings,'$account_id')";
			$query = $this->db->query($query_string);
			if( $this->session->userdata('account_id') != 'TNM0015' ) {
				$query_string = "INSERT INTO finance (`type`,`description`,`amount`,`payee_id`,`payer_id`) VALUES ('loss','payout claim',$withdrawable_earnings,'TNM0015','TNM0015')";
				$query = $this->db->query($query_string);
			}
			$query_string = "INSERT INTO finance (`type`,`description`,`amount`,`payee_id`,`payer_id`) VALUES ('loss','payout spending',$withdrawable_earnings,'$account_id','TNM0015')";
			$query = $this->db->query($query_string);
			$data['title'] = 'Request Successful';
			$data['goodmessage'] = 'You have successfully requested your payout. Proceed to the office for payout claims.';
		} else {
			$data['title'] = 'Request Failed';
			$data['goodmessage'] = 'You can only request for amounts with a minimum of 500.';
		}
		$this->load->view('templates/header', $data);
		$this->load->view('templates/message', $data);
		$this->load->view('templates/footer');
	}
}