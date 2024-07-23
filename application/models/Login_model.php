<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login_model extends CI_Model
{
    public function login_user($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('password', md5($password)); // Assuming passwords are stored as md5 hashes
        $query = $this->db->get('users'); // Assuming the table name is 'users'

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }
}
?>
