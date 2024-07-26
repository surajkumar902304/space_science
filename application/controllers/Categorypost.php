<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categorypost extends CI_Controller
{
	public function __construct() {
        parent::__construct();
        $this->load->model('Blog_model');
    }
    // In your controller
    public function index($cat_id)
    {
        $data['cat_id'] = $cat_id; // Add this line
        $data['cat_name'] = $this->Blog_model->get_category_name($cat_id);
        $data['blogs'] = $this->Blog_model->get_blogs_by_category($cat_id); // Make sure this method returns an array of blogs
        $data['recent_blog'] = $this->Blog_model->get_recent_blog();
        $data['featured_blog'] = $this->Blog_model->get_featured_blog();
        $this->load->view('includes/header');
        $this->load->view('categorypost', $data);
        $this->load->view('includes/footer');
    }
    


	
    
}

?>