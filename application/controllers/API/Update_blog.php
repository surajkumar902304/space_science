<?php
// application/controllers/API/My_blog.php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Update_blog extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->helper('url_helper');
        $this->load->model('Category_model');
        $this->load->library('upload');
    }

    // POST method for updating blog
    public function index_post() {
        // Debugging: Print POST data
        
    
        $id = $this->input->post('blog_id'); // Retrieve the blog ID
        $config['upload_path'] = './assets/uploads/blog_img/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $this->upload->initialize($config);

        // Fetch the current blog details to get the existing image
        $current_blog = $this->Blog_model->get_blog($id);
        $old_image = $current_blog['image'];
    
        if ($_FILES['image']['name']) { // Check if a new image is uploaded
            // Perform the image upload
            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('message', 'Failed to upload image');
                redirect('admin/blogs/edit/' . $id);
            } else {
                // Get the new image data
                $upload_data = $this->upload->data();
                $image = $upload_data['file_name'];

                // Delete the old image if it exists
                if ($old_image && file_exists($config['upload_path'] . $old_image)) {
                    unlink($config['upload_path'] . $old_image);
                }
            }
        } else {
            // Use the existing image if no new image is uploaded
            $image = $old_image;
        }
    
        // Prepare the data to update
        $data = array(
            'image' => $image,
            'title' => $this->input->post('title'),
            'cat_id' => $this->input->post('cat_id'),
            'date' => $this->input->post('date'),
            'long_content' => $this->input->post('long_content')
        );
    
        // Debugging: Print data to be updated
        log_message('debug', 'Update Data: ' . print_r($data, true));
    
        // Update the blog entry
        $update = $this->Blog_model->update_blog($id, $data);
    
        if ($update) {
            $this->response(['status' => true, 'message' => 'Blog updated successfully', 'data' => $data], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Failed to update blog'], REST_Controller::HTTP_INTERNAL_ERROR);
        }
    }
    

}