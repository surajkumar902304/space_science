<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proj1 extends CI_Controller
{
    public function index()
	{
		$this->load->view('includes/header');
		$this->load->view('proj1');
		$this->load->view('includes/footer');
	}
}

