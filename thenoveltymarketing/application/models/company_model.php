<?php
class Company_model extends CI_Model {

	public function __construct()
	{
		
	}

	public function show_profile()
	{
		$data = '';
		$this->load->view('templates/header', $data);
		$this->load->view('company/profile', $data);
		$this->load->view('templates/footer', $data);
	}
}