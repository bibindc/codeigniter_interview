<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getUsers()
    {
        $this->db->order_by('US_Id', 'asc');
        $this->db->where('US_Type', 2);
        $query = $this->db->get('users');
        return $query->result();
    }
    function getUserData($id)
    {
        $this->db->order_by('US_Id', 'asc');
        $this->db->where('US_ID', $id);
        $query = $this->db->get('users');
        return $query->result();
    }
    public function getCountries()
    {
        $this->db->order_by('country_name', 'asc');
        $query = $this->db->get('countries');
        return $query->result();
    }
    public function getStories($limit,$offset,$sub){
        $this->db->order_by('ST_Id', 'asc');
        $this->db->where('ST_Type', $sub);
        $this->db->limit($limit);
		$this->db->offset($offset);
        $query = $this->db->get('story');
        return $query->result();
    }
    public function getStoriesCount($sub){
        $this->db->where('ST_Type', $sub);
        $query = $this->db->get('story');
        return $query->num_rows();
    }
    public function getStoriesDetails($id){
        $this->db->from('story');        
        $this->db->where('ST_Id', $id);
        $this->db->or_where('ST_StoryId',$id); 
        $query = $this->db->get();
        return $query->result();
    }
    public function insertUser($data)
    {
        return $this->db->insert('users', $data);
    }
    public function updateUser($us_id, $data)
    {
        $this->db->where('US_Id', $us_id);
        return $this->db->update('users', $data);
    }
    public function deleteUser($us_id){
        $this->db->where('US_Id', $us_id);
        return $this->db->delete('users');
    }
    
}
