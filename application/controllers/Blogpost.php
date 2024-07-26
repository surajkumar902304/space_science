<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blogpost extends CI_Controller
{
	public function __construct() {
        parent::__construct();
        $this->load->model('Blog_model');
    }
    public function index()
    {
		
        // Fetch blog data from model
        $data['blogs'] = $this->Blog_model->blog_status(1);
        $data['featured_blog'] = $this->Blog_model->get_featured_blog();
        $data['recent_blog'] = $this->Blog_model->get_recent_blog();
        // Load the view and pass the blogs data
        $this->load->view('includes/header');
        $this->load->view('blogpost', $data);
        $this->load->view('includes/footer');
    }
	
    public function view($blog_id)
    {
        $data['blog'] = $this->Blog_model->get_blog($blog_id);  
        $data['recent_blog'] = $this->Blog_model->get_recent_blog();
		$this->load->view('includes/header');
		$this->load->view('singlepost', $data);
		$this->load->view('includes/footer');
    }
    // public function recent_blogs() {
    //     $limit = 2;  // You can adjust the limit as needed
    //     $data['recent_blogs'] = $this->Blog_model->get_recent_blog($limit);
    //     $this->load->view('recent_blogs_view', $data);  // Load the view and pass the data
    // }
}

?>