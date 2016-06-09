<?php
class Administrator_model extends CI_Model {

	public function __construct()
	{
		
	}

	public function check_authentication()
	{
		
	}

	public function show_pending_entries()
	{
		$data['pending_entries'] = $this->administrator_model->get_pending_entries();
		$data['title'] = "Pending Entries";
		$this->load->view('templates/header', $data);
		$this->load->view('tnmadmin/pending', $data);
		$this->load->view('templates/footer', $data);
	}

	public function get_pending_entries()
	{
		$query = $this->db->get_where('pending', array('status' => 'pending'));
		return $query->result();
	}

	public function get_tickets()
	{
		$this->load->model('utility_model');

		$data['title'] = "Create Tickets";

		//validation rules
		$this->form_validation->set_rules('ticket_count', 'Ticket Count', 'trim|required|numeric|min_length[1]|max_length[3]|xss_clean');
		$this->form_validation->set_rules('ticket_amount', 'Ticket Amount', 'trim|required|numeric|min_length[2]|max_length[5]|xss_clean');

		if ($this->form_validation->run() == FALSE):

		else:
			$tickets = array();
			for ($i=0; $i < $this->input->post('ticket_count'); $i++) {
				$code = 'YL' . $this->utility_model->create_unique_random_string('alpha_numeric_uc',5,'tickets','code');
				$tickets[] = $code;
				$data = array(
				   'code' => $code,
				   'amount' => $this->input->post('ticket_amount')
				);

				$this->db->insert('tickets', $data); 
			}
			$data['form_message'] = 'Tickets successfully created.';
				
		endif;
		$query = $this->db->query('SELECT code,amount FROM tickets');
		$results = $query->result();

		$data['tickets'] = $results;
		$this->load->view('tnmadmin/tickets', $data);
	}

	public function get_ticket_owners()
	{
		$this->load->model('utility_model');
		$this->load->model('account_model');

		$query = $this->db->query('SELECT account_id,username FROM account');
		$results = $query->result();

		$data['content'] = '<div class="content">';



		if($query->num_rows() > 0)
		{
			foreach ($results as $key => $line) {
				$data['content'] .= '<div class="panel panel-default pull-left" style="width: 50%;">';
				$data['content'] .= '<div class="panel-heading">' . $line->username . '</div>';
				$query2 = $this->db->query('SELECT ticket_code FROM entries WHERE account_id LIKE "%' .$line->account_id. '%"');
				$results2 = $query2->result();
				$data['content'] .= '<div class="panel-body">';
				foreach ($results2 as $key => $line2) {
					$data['content'] .= $line2->ticket_code . '<br />';
				}
				$data['content'] .= '</div>';
				$data['content'] .= '</div>';

			}
		}

		$data['content'] .= '</div>';

		$this->load->view('tnmadmin/ticketowners', $data);
	}

	public function get_repeat_order()
	{
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
				// $this->load->view('tnmadmin/repeat_order', $data);
				$this->output->set_header('refresh:3;url=' . current_url());
			endif;
		endif;
		if(!isset($data['goodmessage'])):
		$this->load->view('tnmadmin/repeat_order', $data);
		endif;
	}

	public function get_members($needle)
	{
		$this->db->select('*');
		$this->db->like('profile.first_name',$needle);
		$this->db->or_like('profile.last_name',$needle);
		$this->db->from('account');
		$this->db->join('profile','account.account_id = profile.account_id');
		$query = $this->db->get();
		$data['members'] = $query->result();
		$this->load->view('tnmadmin/members', $data);
	}

	public function approve_entry($id)
	{
		$values = array( 'status' => 'approved');

		$this->db->where('id', $id);
		$this->db->update('pending', $values);
		
		$this->load->model('account_model');
		if($this->account_model->check_maximum_placements($id)):
			$this->account_model->create_development_entry($id);
		else:
			echo 'The entry has reached the maximum placements available.';
			//should send email to entry owner and the entry placer
		endif;
	}

	public function void_entry($id)
	{
		$values = array( 'status' => 'void');
		$this->db->where('id', $id);
		$this->db->update('pending', $values); 
	}

	public function find_all_leaders()
	{
		$timestamp = NULL;
		$query = $this->db->query("SELECT MAX(creation_timestamp) as max_creation_timestamp FROM logs WHERE type = 'leadership bonus'");
		if( $query->num_rows() > 0 ):
			$result = $query->first_row();
			$creation_timestamp = $result->max_creation_timestamp;
			$creation_timestamp = strtotime( $creation_timestamp );
			$current_timestamp = time();
			if( ( $current_timestamp - $creation_timestamp ) >= (3600 * 24 * 7) ):
				$this->db->select("account_id");
				$query2 = $this->db->get("account");
				if( $query2->num_rows() > 0 ):
					$result2 = $query2->result();
					foreach ($result2 as $line) {
						$this->administrator_model->find_referrals_for_leadership_bonus( $line->account_id, $result->max_creation_timestamp );
					}
				endif;
				$values = array(
					'type' => 'leadership bonus'
				);
				$this->db->insert('logs', $values);
			endif;
		else:
			$this->db->select("account_id");
			$query = $this->db->get("account");
			if( $query->num_rows() > 0 ):
				$result = $query->result();
				foreach ($result as $line) {
					$this->administrator_model->find_referrals_for_leadership_bonus( $line->account_id );
				}
			endif;
			$values = array(
				'type' => 'leadership bonus'
			);
			$this->db->insert('logs', $values);
		endif;
	}

	private function find_referrals_for_leadership_bonus( $account_id, $timestamp = NULL )
	{
		$this->db->select("account_id");
		$this->db->where("direct_referrer_id",$account_id);
		$query = $this->db->get("account");
		if( $query->num_rows() > 0 ):
			$result = $query->result();
			foreach ($result as $line) {
				$this->administrator_model->add_leadership_bonus( $line->account_id, $account_id, $timestamp );
			}
		endif;
	}

	public function show_payout_requests()
	{
		$query_string = "SELECT * FROM payouts WHERE status = 'pending' ORDER BY creation_timestamp ASC";
		$query = $this->db->query( $query_string );
		if ( $query->num_rows() > 0 ) {
			$data['result_payouts'] = $query->result();
		}

		$this->load->model('account_model');
		$data['result_remaining'] = $this->account_model->get_accounts('account_id');

		$this->load->view('tnmadmin/payouts', $data);
	}

	public function news()
	{
		$this->form_validation->set_rules('title', 'Title', 'required');
		if ($this->form_validation->run() == FALSE):
			$this->load->view('tnmadmin/news');
		else:
			if($this->administrator_model->create_news()):
				$data['goodmessage'] = "Settings Updated!";
			else:
				$data['badmessage'] = "Something went wrong! Please check the fields.";
			endif;
			$this->load->view('tnmadmin/news', $data);
		endif;
	}

	private function create_news()
	{
		
		$query_string = "INSERT INTO news (title,image,content,location) VALUES ('" . $this->input->post("title") . "','" . $this->input->post("image") . "','" . $this->input->post("content") . "','" . $this->input->post("location") . "')";
		$this->db->query( $query_string );
		return true;
	}

	public function set_purchased_order($product_id, $purchase_type, $accountid)
	{
		$this->load->model('account_model');

		$query_string = "DELETE FROM tickets WHERE code = '" . $this->input->post('ticket_code') . "'";
		$query = $this->db->query($query_string);

		$query = $this->db->query(
			"SELECT * FROM products INNER JOIN prices ON products.id = prices.link_id INNER JOIN points ON points.link_id = products.id WHERE (prices.type = 'RO' or prices.type = 'B1T1') AND products.id = $product_id AND prices.type = '$purchase_type'"
			);
		$newAges = [0.20,0.15,0.10,0.08,0.08,0.10,0.10,0.10,0.05,0.04];
		$this->account_model->add_unilevel_income( $accountid, '', $query->first_row()->value, $newAges, true );
		$stockist_code = $this->administrator_model->get_stockist();
		if($stockist_code):
			$this->administrator_model->add_stockist_income( $accountid, $stockist_code, $query->first_row()->stockist_amount );
			$this->account_model->add_stockist_finance($account_id, $entry_id,$this->input->post("stockistid"),$query->first_row()->stockist_amount,false);
		endif;
	}

	public function approve_payout_request($account_id)
	{
		$query_string = "SELECT amount FROM payouts WHERE creation_timestamp = (SELECT MAX(creation_timestamp) FROM payouts WHERE account_id = '$account_id')";
		$query = $this->db->query($query_string );
		if ($query->num_rows() > 0) {
			$amount = $query->first_row()->amount;
			$withdrawable_earnings = $this->account_model->get_withdrawable_earnings( $account_id );
			if( $withdrawable_earnings >= $amount )
			{
				$query_string_2 = "INSERT INTO finance (payee_id,payer_id,amount,type,description) VALUES ('$account_id','YOVELIF',$amount,'LOSS','payout')";
				$query_2 = $this->db->query($query_string_2);
			}
			else
			{
				echo 'Not enough funds!';
			}
		}
	}

	private function add_leadership_bonus( $account_id, $referrer_id, $timestamp = NULL )
	{
		$q = '';
		if( $timestamp == NULL ):
			$q = "SELECT SUM(amount) as sum_amount FROM finance WHERE payee_id = '$account_id' AND description = 'unilevel'";
		else:
			$q = "SELECT SUM(amount) as sum_amount FROM finance WHERE payee_id = '$account_id' AND description = 'unilevel' AND creation_timestamp >= '$timestamp'";
		endif;
		
		$query = $this->db->query( $q );
		if( $query->num_rows() > 0 ):
			$leadership_amount = $query->first_row()->sum_amount * 0.10;
			$values = array(
				'type' => 'profit',
				'description' => 'leadership bonus',
				'amount' => $leadership_amount,
				'payer_id' => $account_id,
				'payee_id' => $referrer_id,
				);
			$this->db->insert('finance', $values);
		endif;
	}

	public function get_stockist()
	{
		$query = $this->db->query("SELECT stockist_code FROM account WHERE stockist_code != '' AND account_id = '" . $this->session->userdata('account_id') . "'");
		if($query->num_rows() > 0):
			return $query->first_row()->stockist_code;
		else:
			return false;
		endif;
	}

	public function show_finance()
	{
		$query_string = "SELECT DATE_FORMAT(creation_timestamp,'%M %e %y  %l:%i:%S %p') as transaction_date,type,description,amount,payee_entry_id,payer_entry_id,payer_id,payee_id FROM finance WHERE payee_id = 'YOBELIF' AND type = 'profit'";
		$query = $this->db->query($query_string);
		$table = "";
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
		}
		else
		{
			$table = "<div class='financial_table'><span>No data found.</span></div>";
		}
		$data['finance'] = $table;
		$this->load->view('yladmin/finance', $data);
	}

	public function check_valid_data($field, $tablefield)
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

	private function add_stockist_income( $account_id, $stockist_code, $amount )
	{
		$query_string  = "INSERT INTO finance (payee_id,type, description, amount,payer_id) " .
						 "SELECT account_id, 'profit', 'stockist', $amount, '$account_id' " .
						 "FROM account where stockist_code = '" . $stockist_code . "'";
						 

		$query = $this->db->query($query_string);
	}

	public function check_valid_ticket($product_id, $purchase_type, $ticketcode)
	{
		$query_string = "SELECT prices.amount FROM products INNER JOIN prices ON products.id = prices.link_id WHERE type = '$purchase_type' AND products.id = $product_id";
		$query = $this->db->query( $query_string );
		$result = $query->first_row();
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
}