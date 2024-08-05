<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// application/controllers/API/My_blog.php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Update_blog extends REST_Controller
{
    private $jwt_key = 'impactmindz@123';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->helper('url_helper');
        $this->load->model('Category_model');
        $this->load->library('upload');
    }

    // POST method for updating blog
    public function index_post()
{
    $headers = $this->input->get_request_header('Authorization');
    
    if ($headers) {
        $token = str_replace('Bearer ', '', $headers);

        try {
            // Decode the token
            $decoded = JWT::decode($token, new Key($this->jwt_key, 'HS256'));
            $admin_id = $decoded->user_id;

            $id = $this->post('blog_id'); // Retrieve the blog ID
            if (!$id) {
                $this->response([
                    'status' => false,
                    'message' => 'Blog ID is required'
                ], REST_Controller::HTTP_BAD_REQUEST); // 400 Bad Request
                return;
            }

            // Configuration for file upload
            $config['upload_path'] = './assets/uploads/blog_img/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $this->upload->initialize($config);

            // Fetch the current blog details to get the existing image
            $blog = $this->Blog_model->get_blog($id);
            if (!$blog) {
                $this->response([
                    'status' => false,
                    'message' => 'Blog not found'
                ], REST_Controller::HTTP_NOT_FOUND); // 404 Not Found
                return;
            }

            $old_image = $blog ['image']; // Assuming $blog is an object
            if ($blog ['created_by'] != $admin_id) {
                $this->response([
                    'status' => false,
                    'message' => 'Unauthorized access'
                ], REST_Controller::HTTP_FORBIDDEN); // 403 Forbidden
                return;
            }

            if ($_FILES['image']['name']) { // Check if a new image is uploaded
                if (!$this->upload->do_upload('image')) {
                    $error = $this->upload->display_errors();
                    $this->response([
                        'status' => false,
                        'message' => 'Failed to upload image',
                        'error' => $error
                    ], REST_Controller::HTTP_BAD_REQUEST); // 400 Bad Request
                    return;
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
                'title' => $this->post('title'),
                'cat_id' => $this->post('cat_id'),
                'date' => $this->post('date'),
                'long_content' => $this->post('long_content')
            );

            // Debugging: Print data to be updated
            log_message('debug', 'Update Data: ' . print_r($data, true));

            // Update the blog entry
            $update = $this->Blog_model->update_blog($id, $data);

            if ($update) {
                $this->response([
                    'status' => true,
                    'message' => 'Blog updated successfully',
                    'data' => $data
                ], REST_Controller::HTTP_OK); // 200 OK
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Failed to update blog'
                ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
            }

        } catch (\Firebase\JWT\ExpiredException $e) {
            $this->response([
                'status' => false,
                'message' => 'Token has expired.'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
        } catch (Exception $e) {
            $this->response([
                'status' => false,
                'message' => 'Unauthorized access or token invalid.'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

    } else {
        $this->response([
            'status' => false,
            'message' => 'Unauthorized access. Token missing.'
        ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
    }
}

}