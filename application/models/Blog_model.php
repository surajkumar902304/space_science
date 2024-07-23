<?php
class Blog_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

   
    public function get_blogs($id = FALSE, $status = FALSE)
{
    $this->db->select('blogs.*, category.cat_name');
    $this->db->from('blogs');
    $this->db->join('category', 'category.cat_id = blogs.cat_id');
    $this->db->order_by('create_act', 'DESC');

    // If status is provided, filter by status
    if ($status !== FALSE) {
        $this->db->where('blogs.status', $status);
    }

    // If id is not provided, get all blogs
    if ($id === FALSE) {
        $query = $this->db->get();
        return $query->result_array();
    }

    // If id is provided, get the specific blog
    $this->db->where('blogs.blog_id', $id);
    $query = $this->db->get();
    return $query->row_array();
}

    public function get_blog($blog_id)
    {
        $this->db->where('blog_id', $blog_id);
        $query = $this->db->get('blogs');
        return $query->row_array();
    }

    public function get_recent_blog($limit = 2)
    {
        $this->db->order_by('create_act', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('blogs');
        return $query->result_array();
    }

    public function create_blog($data)
    {
        return $this->db->insert('blogs', $data);
    }

    public function update_blog($id, $data)
    {
        $this->db->where('blog_id', $id);
        return $this->db->update('blogs', $data);
    }


}
?>