<?php
// application/controllers/API/My_blog.php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class My_blog extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->helper('url_helper');
        $this->load->model('Category_model');
        $this->load->library('upload');
    }

    public function index_get($blog_id = null)
    {
        if ($blog_id) {
            // Fetch a specific blog
            $data['blog'] = $this->Blog_model->get_blog($blog_id);

            if ($data['blog']) {
                // Blog found
                $this->response(
                    array(
                        'status' => true,
                        'data' => $data
                    ),
                    REST_Controller::HTTP_OK
                ); // 200 OK
            } else {
                // Blog ID not found in the database
                $this->response(
                    array(
                        'status' => false,
                        'message' => 'Invalid Blog ID'
                    ),
                    REST_Controller::HTTP_BAD_REQUEST
                ); // 400 Bad Request
                return;
            }
        } else {
            // Fetch all blogs
            $data['blogs'] = $this->Blog_model->get_blogs();

            if ($data['blogs']) {
                // Blogs found
                $this->response(
                    array(
                        'status' => true,
                        'data' => $data
                    ),
                    REST_Controller::HTTP_OK
                ); // 200 OK
            } else {
                // No blogs found
                $this->response(
                    array(
                        'status' => false,
                        'message' => 'No blogs found'
                    ),
                    REST_Controller::HTTP_BAD_REQUEST
                ); // 400 Bad Request
                return;
            }
        }
    }



    public function index_post()
    {
        // Configuration for file upload
        $config['upload_path'] = './assets/uploads/blog_img/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 2048; // Maximum file size in KB (2MB)

        $this->load->library('upload', $config);

        // Check if the upload is successful
        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());


            $this->response(
                array(
                    'status' => false,
                    'message' => 'Failed to upload image',
                    'error' => $error
                ),
                REST_Controller::HTTP_BAD_REQUEST
            ); // 400 Bad Request
            return;

        } else {
            $upload_data = $this->upload->data();
            $image = $upload_data['file_name']; // Get the uploaded file name

            // Prepare data for insertion
            $data = array(
                'title' => $this->post('title'),
                'image' => $image,
                'cat_id' => $this->post('cat_id'),
                'date' => $this->post('date'),
                'long_content' => $this->post('long_content')
            );

            // Insert blog data and get the newly created blog ID
            $blog_id = $this->Blog_model->create_blog($data);

            if ($blog_id) {

                $this->response(
                    array(
                        'status' => true,
                        'message' => 'Blog created successfully',
                        'data' => array('blog_id' => $blog_id)
                    ),
                    REST_Controller::HTTP_CREATED
                ); // 201 Created

            } else {

                $this->response(
                    array(
                        'status' => false,
                        'message' => 'Failed to create blog.'
                    ),
                    REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                ); // 500 Internal Server Error
            }
        }
    }



    public function index_delete()
    {
        // Read raw input data
        $input = json_decode(file_get_contents('php://input'), true);

        // Check if the input data is valid
        if (!isset($input['blog_id']) || !isset($input['status'])) {
            $this->response(['status' => false, 'message' => 'blog_id and status are required'], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        // Retrieve status and blog_id from the input
        $blog_id = $input['blog_id'];
        $status = $input['status'];

        // Validate status
        $status = (int) $status; // Convert status to integer if necessary
        if ($status !== 0 && $status !== 1) {
            $this->response(['status' => false, 'message' => 'Invalid status value'], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        // Update blog status
        $this->Blog_model->update_blog_status($blog_id, $status);

        // Prepare success message based on status
        $message = ($status === 1) ? 'Blog restored successfully' : 'Blog deleted successfully';

        // Send a success response
        $this->response(['status' => true, 'message' => $message], REST_Controller::HTTP_OK);
    }


}
?>