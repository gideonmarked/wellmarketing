<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('company_model');
		$this->load->model('utility_model');
	}

	public function index()
	{
		$data['title'] = 'Desktop';
		if($session_data = $this->session->userdata('logged_in')):
			// $data['message'] = 'Welcome ' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
		else:
			$data['message'] = 'You must be logged in to view this page. You can ' 
								. anchor(base_url() . 'account/signin' , 'Login')
								. ' if you already have an account or '
								. anchor(base_url() . 'account/signup', 'Register')
								. ' for a new account';
		endif;
		$this->load->view('templates/header', $data);
		$this->load->view('company/index', $data);
		$this->load->view('templates/footer');
	}

	public function profile()
	{
		$this->company_model->show_profile();
	}

	public function offices()
	{
		$data = '';
		$this->load->view('templates/header', $data);
		$this->load->view('company/offices', $data);
		$this->load->view('templates/footer', $data);
	}

	public function contactus()
	{
		$data = '';
		$this->load->view('templates/header', $data);
		$this->load->view('company/contactus', $data);
		$this->load->view('templates/footer', $data);
	}

}