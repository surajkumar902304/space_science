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

    public function register()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload registration form with errors
            $this->load->view('admin/register');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role' => 2 // Default role, e.g., 2 for regular user
            ];

            $insert_id = $this->Auth_model->register_user($data);

            if ($insert_id) {
                // Registration successful
                $this->session->set_flashdata('success', 'Registration successful. You can now log in.');
                redirect('admin/auth/login');
            } else {
                // Registration failed
                $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                $this->load->view('admin/register');
            }
        }
    }

    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            // Redirect if user is already logged in
            redirect('admin/blogs');
        } else {
            $this->load->view('admin/login');
        }
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload login form with errors
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
                    redirect('admin/blogs');
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


    public function logout()
    {
        // Unset session data
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('logged_in');

        // Set a flash message
        $this->session->set_flashdata('success', 'You have been logged out successfully.');

        // Redirect to login page
        redirect('admin/auth/login');
    }
    
}

?>
