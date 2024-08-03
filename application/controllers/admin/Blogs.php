<?php
class Blogs extends CI_Controller
{

    public function __construct()
    {


        parent::__construct();
        $this->load->model('Blog_model');
        if ($this->session->userdata('role') == '2' || empty($this->session->userdata('user_id'))) {
            redirect('admin/auth/login');
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('Blog_model');
        $this->load->helper('url_helper');
        $this->load->model('Category_model');

    }

    public function index()
    {

        $data['blogs'] = $this->Blog_model->get_blogs();
        $data['categories'] = $this->Category_model->get_categories();
        $this->load->view('admin/includes/header', $data);
        $this->load->view('admin/blogs/index', $data);
        $this->load->view('admin/includes/footer');

    }

    public function View_blogs()
    {
        $data['blogs'] = $this->Blog_model->get_blogs();

        $this->load->view('admin/blogs/index', $data);
        $this->load->view('admin/includes/footer');
    }

    public function create_form()
    {

        $data['categories'] = $this->Category_model->get_categories();
        $this->load->view('admin/includes/header');
        $this->load->view('admin/blogs/create', $data);
    }



    public function create()
    {

        $config['upload_path'] = './assets/uploads/blog_img/';
        $config['allowed_types'] = 'jpg|png|jpeg';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());

            // echo '<pre>';
            // print_r($error);

            $this->session->set_flashdata('message', 'fail to upload');
            redirect('admin/blogs/create');
        } else {
            $data = array('upload_data' => $this->upload->data());

            $image = $data['upload_data']['file_name'];

            $data = array(
                'image' => $image,
                'title' => $this->input->post('title'),
                'cat_id' => $this->input->post('category'),
                'date' => $this->input->post('date'),
                'long_content' => $this->input->post('long_content')
            );

            $this->Blog_model->create_blog($data);
            redirect('admin/blogs/create_form');
        }
    }


    public function update($id)
    {
        // Load necessary models and libraries
        $this->load->library('upload');

        // Fetch existing blog data
        $data['blog'] = $this->Blog_model->get_blogs($id);
        $data['categories'] = $this->Category_model->get_categories();

        // Load views
        $this->load->view('admin/includes/header');
        $this->load->view('admin/blogs/edit', $data);
    }


    public function update_blog()
    {
        $id = $this->input->post('id'); // Retrieve the blog ID

        // Load the upload library and configure it
        $config['upload_path'] = './assets/uploads/blog_img/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $this->load->library('upload', $config);

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
            'cat_id' => $this->input->post('category'),
            'date' => $this->input->post('date'),
            'long_content' => $this->input->post('long_content')
        );

        // Update the blog entry
        $this->Blog_model->update_blog($id, $data);
        $this->session->set_flashdata('message', 'Blog updated successfully');
        redirect('admin/blogs');
    }

    public function delete($blog_id)
    {
        $this->Blog_model->update_blog_status($blog_id, 0);
        redirect('admin/blogs'); // redirect back to the blogs list
    }

    public function restore($blog_id)
    {
        $this->Blog_model->update_blog_status($blog_id, 1);
        redirect('admin/blogs'); // redirect back to the blogs list
    }




    public function blogs_with_category()
    {
        $this->load->model('Blog_model');
        $data['blogs'] = $this->Blog_model->update_blog_status();

        // Debugging
        if (empty($data['blogs'])) {
            log_message('error', 'No blogs retrieved in the index method.');
        }

        $this->load->view('admin/blogs/index', $data);
    }


}
?>