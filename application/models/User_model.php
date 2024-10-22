<?php
class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getProfile()
    {
        $query = $this->db->get('users');
        return $query->row();
    }

    public function insert_user($data)
    {
        return $this->db->insert('users', $data);
    }

    public function getUsers() {
        $query = $this->db->get('users');
        $result = $query->result();
        echo json_encode($result);
    }
    
    public function getUserById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        $result = $query->row();
        echo json_encode($result);
    }

    // Insert new profile picture
    public function insertProfilePicture($imagePath)
    {
        $data = array(
            'profile_picture' => $imagePath,
        );
        return $this->db->insert('users', $data);
    }

    // Update existing profile picture
    public function updateProfilePicture($imagePath)
    {
        $data = array(
            'profile_picture' => $imagePath,
        );

        return $this->db->update('users', $data);
    }
    

    // from this when i update profile image so uploads folder image also updated 
    // but i dont want to update uploads folder image please correct this 

    public function get_image_by_id($imageId)
    {
        $this->db->select('profile_picture AS path');
        $this->db->from('users');
        $this->db->where('id', $imageId);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return null;
    }

    // Delete Image
    public function delete_image($id)
    {
        // return $this->db->delete('users', ['id' => $id]);
        return $this->db->update('users', ['profile_picture' => null], ['id' => $id]);
    }
    public function delete_user($id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }
}
