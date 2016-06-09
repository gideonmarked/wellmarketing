<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('account_model');
		$this->load->model('utility_model');
		$this->load->model('administrator_model');
	}

	public function index()
	{
		$data['title'] = 'Log In';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in')):
			$data['name'] = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
			$data['accounttype'] = $this->account_model->get_account_type( $this->session->userdata('account_id') );
			$data['username'] = $this->session->userdata('username');
			$data['accountid'] = $this->session->userdata('account_id');
			$data['referrerid'] = $this->account_model->get_referrer_id( $this->session->userdata('account_id') );
			$data['directreferralids'] = $this->account_model->get_direct_referral_ids( $this->session->userdata('account_id') );
			$data['totalearnings'] = $this->account_model->get_total_earnings( $this->session->userdata('account_id') );
			$data['totalincome'] = $this->account_model->get_total_income( $this->session->userdata('account_id'), "AND description !='payment'" );
			$data['totalcompanyincome'] = $this->account_model->get_total_income( $this->session->userdata('account_id'), "AND description ='payment'" );
			$data['totalcredit'] = $this->account_model->get_total_credit( $this->session->userdata('account_id') );
			$data['creditpayment'] = $this->account_model->get_credit_payment( $this->session->userdata('account_id') );
			$data['creditbalance'] = $data['totalcredit'] - $data['creditpayment'];
			// $data['withdrawableearnings'] = $this->account_model->get_withdrawable_earnings( $this->session->userdata('account_id') );
			$data['withdrawableearnings'] = $this->account_model->get_total_earnings( $this->session->userdata('account_id') );
			$data['withdrawal'] = $this->account_model->get_total_payout( $this->session->userdata('account_id') );
			$this->load->view('account/index', $data);
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer');
	}

	public function signup()
	{
		$this->account_model->signup();
	}

	public function signin()
	{
		$this->account_model->signin();
	}

	public function signentry()
	{
		$this->account_model->signentry();
	}

	public function settings()
	{
		$data['title'] = 'Settings';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in')):
			$this->account_model->show_settings();
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer', $data);
	}

	public function verify()
	{
		$data['title'] = 'Login';
		if($this->input->post('submit') === FALSE):
			redirect(base_url() . 'account/login', 'refresh');
		else: //the form is submitted
			if( $result = $this->account_model->bypass( $this->input->post('accounts') )): //check if user exists
				$sess_array = array(
					'id' => $result[0]->id,
					'firstname' => $result[0]->firstname,
					'lastname' => $result[0]->lastname
					);
				$this->session->set_userdata('logged_in', $sess_array);
				redirect(base_url() . 'account', 'refresh');
			endif;
		endif;
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url() . 'account', 'refresh');
	}

	public function create()
	{
		$this->account_model->create();
	}

	public function fix()
	{
		$this->account_model->fix();
	}

	public function matrix( $page = 0 )
	{
		$this->account_model->get_boards( $page );
	}

	public function finance()
	{
		$data['title'] = 'Financial Statement';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in')):
			$this->account_model->show_finance();
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer', $data);
	}

	public function matrixfinance()
	{
		$data['title'] = 'Matrix Financial Statement';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in')):
			$this->account_model->show_matrix_finance();
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer', $data);
	}

	public function unilevel($id=null)
	{
		$data['title'] = 'Unilevel Details';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in')):
			$this->account_model->get_unilevel($id);
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer', $data);
	}

	public function fixreferrals()
	{
		$this->account_model->fixreferral();
	}

	public function request_payout( $account_id )
	{
		if(isset($account_id)):
			$this->account_model->request_payout( $account_id );
		endif;
	}

	public function repeat_order()
	{
		$data['title'] = 'Purchase Order';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in')):
			$this->account_model->get_repeat_order();
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);

		endif;
		$this->load->view('templates/footer', $data);
	}

	public function test($id='')
	{
		$this->account_model->add_fast_bonus_income( 'FF15JA3', "", 100,false );
	}

	
}