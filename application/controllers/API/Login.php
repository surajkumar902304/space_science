<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

// application/controllers/API/My_blog.php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Login extends REST_Controller
{
    private $jwt_key = 'impactmindz@123';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->helper('url_helper');
        $this->load->model('Category_model');
        $this->load->library('upload');
        $this->load->library('form_validation');
    }

    // POST method for Login user
    public function index_post()
    {

        // Read raw input data
        $input = json_decode(file_get_contents('php://input'), true);

        // Set validation rules
        $this->form_validation->set_data($input);
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            // Validation failed
            $this->response([
                'status' => false,
                'message' => validation_errors()
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            // Retrieve email and password from input
            $email = $input['email'];
            $password = $input['password'];

            // Authenticate user
            $user = $this->Auth_model->login_user($email, $password);

            if ($user) {

                $issuedAt = time();
                $expirationTime = $issuedAt + 36000;

                $token_data = [
                    'user_id' => $user->id,

                    'email' => $user->email,

                    'role' => $user->role,
                    'iat' => $issuedAt,
                    'exp' => $expirationTime

                ];

                $token = JWT::encode($token_data, $this->jwt_key, 'HS256');

                $this->response(
                    array(
                        "isSuccess" => true,
                        "message" => "User id  match",
                        "data" => $user,
                        "token" => $token
                    ), REST_Controller::HTTP_OK);



                // Check user role and respond accordingly
                // if ($user->role == 1) {
                //     $this->response([
                //         'status' => true,
                //         'message' => 'User logged in successfully.'
                //     ], REST_Controller::HTTP_OK);
                // } else {
                //     $this->response([
                //         'status' => false,
                //         'message' => 'User logged in successfully. You do not have permission to access Admin page.'
                //     ], REST_Controller::HTTP_FORBIDDEN);
                // }
            } else {
                // Login failed
                $this->response([
                    'status' => false,
                    'message' => 'Invalid email or password'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

}
//login token
//Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMSIsImVtYWlsIjoic3VyYWpzYW5qdTAwMEBnbWFpbC5jb20iLCJ0aW1lIjoxNzIyODM2OTk3LCJyb2xlIjoiMSJ9.2LUEbXOf_wT92jktWBp-UDNHqPmNA-1isOHu9sNP6fI