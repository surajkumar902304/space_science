<?php

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Register_model');
        $this->load->model('Login_model');
    }

    public function register()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Load the registration form view
            $this->load->view('register_form');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
            ];

            $result = $this->Register_model->register_user($data);

            if ($result) {
                // Registration successful
                $this->session->set_flashdata('success', 'Registration successful');
                redirect('user/login');
            } else {
                // Registration failed
                $this->session->set_flashdata('error', 'Registration failed');
                $this->load->view('register_form');
            }
        }
    }
    public function login()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Load the login form view
            $this->load->view('login_form');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->Login->login_user($email, $password);

            if ($user) {
                // Login successful, set session data
                $session_data = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($session_data);
                redirect('http://localhost/suraj-CI/');
            } else {
                // Login failed
                $this->session->set_flashdata('error', 'Invalid email or password');
                $this->load->view('login_form');
            }       
        }
    }

    public function dashboard()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('user/login');
        }

        $this->load->view('dashboard');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('user/login');
    }
}
