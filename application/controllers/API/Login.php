<?php
// application/controllers/API/My_blog.php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Login extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->helper('url_helper');
        $this->load->model('Category_model');
        $this->load->library('upload');
    }

    // POST method for Login user
    public function index_post()
{
    // Load the form validation library
    $this->load->library('form_validation');
    
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
            // Login successful
            $session_data = [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'logged_in' => TRUE
            ];
            $this->session->set_userdata($session_data);

            // Check user role and respond accordingly
            if ($user->role == 1) {
                $this->response([
                    'status' => true,
                    'message' => 'User logged in successfully.'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'User logged in successfully. You do not have permission to access Admin page.'
                ], REST_Controller::HTTP_FORBIDDEN);
            }
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