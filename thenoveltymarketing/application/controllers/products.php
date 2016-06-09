<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('administrator_model');
		$this->load->model('utility_model');
	}

	public function index()
	{
		$data['title'] = 'Products';
		$this->load->view('templates/header', $data);
		$this->load->view('products/links', $data);
		$this->load->view('products/index', $data);
		$this->load->view('templates/footer');
	}

	public function item($page="index")
	{
		$data['title'] = 'Products';
		$this->load->view('templates/header', $data);
		$this->load->view('products/links', $data);
		if( !file_exists(APPPATH.'/views/products/'.$page.'.php') ):
		else:
			$this->load->view('products/' . $page, $data);
		endif;
		$this->load->view('templates/footer');
	}


}