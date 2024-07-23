<?php
class Blog_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_blogs($id = FALSE) {
        $this->db->order_by('create_act', 'DESC');
        $this->db->where('status', 1); // Ensure the status is active
        
        if ($id === FALSE) {
            $query = $this->db->get('blogs');
            return $query->result_array();
        }
        
        $query = $this->db->get_where('blogs', array('blog_id' => $id));
        
        return $query->row_array();
    }

    

    public function get_blog($blog_id) {
        $this->db->where('blog_id', $blog_id);
        $query = $this->db->get('blogs');
        return $query->row_array();
    }

    public function get_recent_blog($limit = 2) {
        $this->db->order_by('create_act', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('blogs');
        return $query->result_array();
    }
    
    public function create_blog($data) {
        return $this->db->insert('blogs', $data);
    }

    public function update_blog($id, $data) {
        $this->db->where('blog_id', $id);
        return $this->db->update('blogs', $data);
    }

    public function update_blog_status($blog_id, $status) {
        $data = array('status' => $status);
        $this->db->where('blog_id', $blog_id);
        $this->db->update('blogs', $data);
    }
   
    
}
?>
