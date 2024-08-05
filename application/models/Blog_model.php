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

    public function increment_blog_count($blog_id) {
        $this->db->set('count_blog', 'count_blog + 1', FALSE);
        $this->db->where('blog_id', $blog_id);
        $this->db->update('blogs');
    }

    public function get_blog($blog_id)
    {
        $this->db->where('blog_id', $blog_id);
        $query = $this->db->get('blogs');
        return $query->row_array();
    }

    public function get_blogs_by_admin($admin_id) {
        $this->db->where('created_by', $admin_id);
        $query = $this->db->get('blogs');
        return $query->result(); // Return array of blog records
    }

    public function get_recent_blog($limit = 2)
    {
        $this->db->limit($limit);
        $this->db->where('status', 1);
        $this->db->order_by('create_act', 'DESC');
        $query = $this->db->get('blogs');
        return $query->result_array();
        
    }

    public function create_blog($data)
    {
        $this->db->insert('blogs', $data);
        return $this->db->insert_id();
        
    }

    public function update_blog($id, $data)
    {
        $this->db->where('blog_id', $id);
        return $this->db->update('blogs', $data);
    }

   
    public function update_blog_status($blog_id, $status)
    {
        $data = array('status' => $status);
        $this->db->where('blog_id', $blog_id);
        $this->db->update('blogs', $data);
    }

    public function blog_status($status = FALSE)
    {
        if ($status === FALSE) {
            // If no status is provided, default to status = 1
            $status = 1;
        }

        // Query the blogs table
        $this->db->where('status', $status);
        $query = $this->db->get('blogs');

        // Return the result set
        return $query->result_array();
    }

    public function fetch_blogs(){
        return $this->db->get_where('blogs',array('status'=>1))->result_array();
    }

    // In Blog_model.php
    public function get_blogs_by_category($cat_id) {
        $this->db->where('cat_id', $cat_id);
        $this->db->where('status=1');
        $query = $this->db->get('blogs');
        return $query->result_array(); // Make sure to return an array of blogs
    }

    public function get_category_name($cat_id) {
        $this->db->where('cat_id', $cat_id);
        $query = $this->db->get('category');
        $result = $query->row_array();
        return $result['cat_name'];
    }
    
    public function get_featured_blog($limit = 1) {
        $this->db->order_by('count_blog', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('blogs');
        return $query->row_array();
    }

    public function numRows($table, $conditions = array()) {
        // Check if conditions are provided
        if (!empty($conditions)) {
            // Apply conditions
            $this->db->where($conditions);
        }
    
        // Get count of rows
        $query = $this->db->from($table)->count_all_results();
        
        // Return the count
        return $query;
    }
    

}
?>