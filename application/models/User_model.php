<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', md5($password)); // Assuming passwords are hashed with MD5
        $query = $this->db->get('login');

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
}
