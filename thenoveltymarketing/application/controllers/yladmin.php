<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class YLadmin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('administrator_model');
		$this->load->model('account_model');
		$this->load->model('utility_model');
		$this->load->library('javascript');
		$this->load->library('javascript/jquery');
	}

	public function index()
	{
		echo '<span>ahoy</span>';
		$this->jquery->_fadeOut('span',2);
	}

	public function pending_entries()
	{
		$this->administrator_model->show_pending_entries();
	}

	public function approve_entry($id)
	{
		$this->administrator_model->approve_entry($id);
	}

	public function tickets()
	{
		$data['title'] = 'Show Tickets';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in') && $this->session->userdata('username') == 'yladmin'):
			$this->administrator_model->get_tickets();
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer', $data);
	}

	public function repeat_order()
	{
		$data['title'] = 'Purchase Order';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in') && $this->session->userdata('username') == 'yladmin'):
			$this->administrator_model->get_repeat_order();
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer', $data);
	}

	public function payouts()
	{
		$data['title'] = 'Show Payouts';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in') && $this->session->userdata('username') == 'yladmin'):
			$this->administrator_model->show_payout_requests();
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer', $data);
	}

	public function news()
	{
		$data['title'] = 'Create News';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in') && $this->session->userdata('username') == 'yladmin'):
			$this->administrator_model->news();
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer', $data);
	}

	public function approve_payout($account_id)
	{
		$data['title'] = 'Approve Requests';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in') && $this->session->userdata('username') == 'yladmin'):
			$this->administrator_model->approve_payout_request($account_id);
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer', $data);
	}

	public function leadership_bonus()
	{
		// $this->administrator_model->find_all_leaders();
		print_r('error');
	}

	public function finance()
	{
		$data['title'] = 'Financial Breakdown';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in') && $this->session->userdata('username') == 'yladmin'):
			$this->administrator_model->show_finance();
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer', $data);
	}

	public function members($needle='')
	{
		$data['title'] = 'Members Master List';
		$this->load->view('templates/header', $data);
		if($this->session->userdata('logged_in') && $this->session->userdata('username') == 'yladmin'):
			$this->administrator_model->get_members($needle);
		else:
			$data['badmessage'] = 'You must be logged in to view this page.';
			$this->load->view('account/login', $data);
		endif;
		$this->load->view('templates/footer', $data);
	}

	public function test()
	{
		$this->load->view('yladmin/test');
	}
}