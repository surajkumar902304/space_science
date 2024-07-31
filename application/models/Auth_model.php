<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function register_user($data)
    {
        return $this->db->insert('users', $data);
    }

    public function login_user($username, $password)
    {
        $this->db->where('email', $username);
        $this->db->where('password', md5($password)); // Assuming passwords are hashed with MD5
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }
}
