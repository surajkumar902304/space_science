<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct() {
        parent::__construct();
        if($this->session->userdata('role')=='2' || empty($this->session->userdata('user_id'))) {
			redirect('admin/auth/login');
		}
		
    }

    public function index()
    {
		
            $this->load->view('admin/includes/header');
            $this->load->view('admin/index');
            $this->load->view('admin/includes/footer');
       
    }
}
?>
