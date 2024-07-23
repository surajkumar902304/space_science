<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Singlepost extends CI_Controller
{
	public function __construct() {
        parent::__construct();
        $this->load->model('Blog_model');
    }
    public function index()
	{
		// $data['recent_blog'] = $this->Blog_model->get_recent_blog();
		$this->load->view('includes/header');
		$this->load->view('singlepost');
		$this->load->view('includes/footer');
	}
	public function view($blog_id) {
        $data['blog'] = $this->Blog_model->get_blog($blog_id);
		$data['recent_blog'] = $this->Blog_model->get_recent_blog();
		$this->load->view('includes/header');
		$this->load->view('singlepost', $data);
		$this->load->view('includes/footer');
    }

	
}
?>
