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
        
        $this->load->view('admin/includes/header');
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
            redirect('admin/blogs');
        }
    }


    public function edit($id)
    {
        $data['categories'] = $this->Category_model->get_categories();
        $data['blog'] = $this->Blog_model->get_blogs($id);

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('long_content', 'Content', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/includes/header');
            $this->load->view('admin/blogs/edit', $data);
        } else {
            $image = $data['blog']['image']; // Default to existing image

            // Check if a new file is uploaded
            $config['upload_path'] = './assets/uploads/blog_img/';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                // Delete the old image if a new one is uploaded
                $old_image_path = './assets/uploads/blog_img/' . $data['blog']['image'];
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
                $uploadData = $this->upload->data();
                $image = $uploadData['file_name'];
            } else {
                $error = array('error' => $this->upload->display_errors());
            }

            $data = array(
                'image' => $image,
                'title' => $this->input->post('title'),
                'cat_id' => $this->input->post('cat_name'),
                'date' => $this->input->post('date'),
                'long_content' => $this->input->post('long_content')
            );

            $this->Blog_model->update_blog($id, $data);
            redirect('admin/blogs');
        }
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