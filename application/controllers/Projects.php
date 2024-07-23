<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Projects extends CI_Controller
{
    public function index()
	{
		$this->load->view('includes/header');
		$this->load->view('projects');
		$this->load->view('includes/footer');
	}
}

?>