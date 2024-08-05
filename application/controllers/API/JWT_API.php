<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class JWT_API extends REST_Controller
{
    private $jwt_key = 'impactmindz@123'; // Your JWT secret key

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('Blog_model');
        $this->load->helper('url_helper');
        $this->load->model('Category_model');
        $this->load->library('upload');
    }

    public function index_get($blog_id = null)
    {
        $headers = $this->input->get_request_header('Authorization');

        if ($headers) {
            $token = str_replace('Bearer ', '', $headers);

            try {
                // Decode the token
                $decoded = JWT::decode($token, new Key($this->jwt_key, 'HS256'));
                $admin_id = $decoded->user_id; // Get the admin ID from the token

                if ($blog_id) {
                    // Fetch a single blog created by the current admin
                    $data = $this->Blog_model->get_blog_by_admin($blog_id, $admin_id);

                    if ($data) {
                        $this->response([
                            'status' => true,
                            'data' => $data
                        ], REST_Controller::HTTP_OK); // 200 OK
                    } else {
                        $this->response([
                            'status' => false,
                            'message' => 'Blog not found or unauthorized access'
                        ], REST_Controller::HTTP_NOT_FOUND); // 404 Not Found
                    }
                } else {
                    // Fetch all blogs created by the current admin
                    $data = $this->Blog_model->get_blogs_by_admin($admin_id);

                    if ($data) {
                        $this->response([
                            'status' => true,
                            'data' => $data
                        ], REST_Controller::HTTP_OK); // 200 OK
                    } else {
                        $this->response([
                            'status' => false,
                            'message' => 'No blogs found'
                        ], REST_Controller::HTTP_NOT_FOUND); // 404 Not Found
                    }
                }

            } catch (\Firebase\JWT\ExpiredException $e) {
                // Token has expired
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



    public function index_post()
    {
        $headers = $this->input->get_request_header('Authorization');

        if ($headers) {
            $token = str_replace('Bearer ', '', $headers);

            try {
                // Decode the token
                $decoded = JWT::decode($token, new Key($this->jwt_key, 'HS256'));
                $admin_id = $decoded->user_id;


                // Configuration for file upload
                $config['upload_path'] = FCPATH . 'assets/uploads/blog_img/'; // Use absolute path
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = '2048'; // Max file size in KB

                $this->upload->initialize($config);

                // Check if the upload is successful
                if (!$this->upload->do_upload('image')) {
                    $error = $this->upload->display_errors();

                    $this->response([
                        'status' => false,
                        'message' => 'Failed to upload image',
                        'error' => $error
                    ], REST_Controller::HTTP_BAD_REQUEST); // 400 Bad Request
                    return;
                }

                $upload_data = $this->upload->data();
                $image = $upload_data['file_name']; // Get the uploaded file name

                // Prepare data for insertion
                $data = [
                    'title' => $this->post('title'),
                    'image' => $image,
                    'cat_id' => $this->post('cat_id'),
                    'date' => $this->post('date'),
                    'long_content' => $this->post('long_content'),
                    'created_by' => $admin_id // Store the admin ID who created the blog
                ];

                // Insert blog data and get the newly created blog ID
                $blog_id = $this->Blog_model->create_blog($data);

                if ($blog_id) {
                    $this->response([
                        'status' => true,
                        'message' => 'Blog created successfully',
                        'data' => ['blog_id' => $blog_id]
                    ], REST_Controller::HTTP_CREATED); // 201 Created
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'Failed to create blog.'
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




    public function index_delete()
    {
        $headers = $this->input->get_request_header('Authorization');
        if ($headers) {
            $token = str_replace('Bearer ', '', $headers);

            try {
                $decoded = JWT::decode($token, new Key($this->jwt_key, 'HS256'));
                $admin_id = $decoded->user_id;

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

                // Fetch blog details to check the creator
                $blog = $this->Blog_model->get_blog($blog_id);
                if (!$blog) {
                    $this->response(['status' => false, 'message' => 'Blog not found'], REST_Controller::HTTP_NOT_FOUND);
                    return;
                }

                // Check if the current admin is the creator of the blog
                if ($blog['created_by'] != $admin_id) {
                    $this->response(['status' => false, 'message' => 'Unauthorized access'], REST_Controller::HTTP_FORBIDDEN);
                    return;
                }

                // Update blog status
                $this->Blog_model->update_blog_status($blog_id, $status);

                // Prepare success message based on status
                $message = ($status === 1) ? 'Blog restored successfully' : 'Blog deleted successfully';

                // Send a success response
                $this->response(['status' => true, 'message' => $message], REST_Controller::HTTP_OK);
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
?>