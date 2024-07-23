<?php

/**
 * Register Model
 */
class Register_model extends CI_Model
{
    // Method to insert a new user record
    public function register_user($data)
    {
        // You can add additional logic here to handle data processing, 
        // such as password hashing
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $result = $this->db->insert('users', $data);
        return $result;
    }

    // Method to check if the email already exists
    public function email_exists($email)
    {
        $query = $this->db->get_where('users', ['email' => $email]);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
