<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model'); // Load the Auth_model
        $this->load->library('session'); // Load session library
        $this->load->library('form_validation'); // Load form validation library
    }

   

    public function login()
    {
      if ($this->session->userdata('logged_in')) {
        // Redirect if user is already logged in
        redirect('admin/dashboard');
    } else {
        $this->load->view('admin/includes/header');
        $this->load->view('admin/login');
        $this->load->view('admin/includes/footer');
    }
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload login form with errors
            $this->load->view('admin/includes/header');
            $this->load->view('admin/login');
            $this->load->view('admin/includes/footer');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->Auth_model->login_user($email, $password);

            if ($user) {
                // Login successful, set session data
                $session_data = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($session_data);

                // Check user role and redirect accordingly
                if ($user->role == 1) {
                    redirect('admin/dashboard');
                } else {
                  // Non-admin role, deny access
                  $this->session->set_flashdata('error', 'You do not have permission to access this page.');
                  redirect('home');
                }
            } else {
                // Login failed
                $this->session->set_flashdata('error', 'Invalid email or password');
                redirect('admin/auth/login');
            }
        }
    }

    
}

?>
