<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('User_model');
    }

    // Display form for user creation
    public function create()
    {
        $profile = $this->User_model->getProfile();
        $data['profilePicture'] = isset($profile->profile_picture) ? $profile->profile_picture : '';
        $data['fileName'] = basename($data['profilePicture']);
        $data['imageId'] = isset($profile->id) ? $profile->id : '';

        $this->load->view('header', $data);
        $this->load->view('form', $data);
        $this->load->view('footer', $data);
    }

    public function getUsers()
    {
        return  $this->User_model->getUsers();
    }

    public function getUserById($id)
    {
        return $this->User_model->getUserById($id);
    }

    // File upload function
    public function uploadUserInfo()
    {
        $this->form_validation->set_rules('firstName', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('userEmail', 'Email', 'trim|required|valid_email');

        $this->form_validation->set_rules('userPhone', 'Mobile', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $errorArr = $this->form_validation->error_array();
            $response = [
                'status' => 500,
                'success' => false,
                'error' => isset($errorArr['userEmail']) ? $errorArr['userEmail'] : (isset($errorArr['firstName']) ? $errorArr['firstName'] : (isset($errorArr['lastName']) ? $errorArr['lastName'] : (isset($errorArr['userPhone']) ? $errorArr['userPhone'] : 'All fields required.')))
            ];
            echo json_encode($response);
        } else {
            $imagePath = '';
            if (!empty($_FILES['profileImage']['name'])) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048;

                // Set a unique file name for the image
                $originalFileName = pathinfo($_FILES['profileImage']['name'], PATHINFO_FILENAME);
                $safeFileName = preg_replace('/\s+/', '-', $originalFileName) . '.' . pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = $safeFileName;

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('profileImage')) {
                    $response = array('success' => false, 'error' => $this->upload->display_errors());
                    echo json_encode($response);
                    return;
                } else {
                    $uploadData = $this->upload->data();
                    $imagePath = $uploadData['file_name'];
                }
            } else {
                $imagePath = $this->input->post('fileNameInput');
            }

            // Validation passed, now insert the data
            $data = [
                'first_name' => $this->input->post('firstName'),
                'last_name' => $this->input->post('lastName'),
                'mobile_number' => $this->input->post('userPhone'),
                'email' => $this->input->post('userEmail'),
                'profile_picture' => !empty($imagePath) ? $imagePath : null,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $id = $this->input->post('userId');
            if ($id) {
                // Update user

                $this->db->where('id', $id);
                $this->db->update('users', $data);
                $response = [
                    'status' => 200,
                    'success' => true,
                    'message' => 'User updated successfully.'
                ];
            } else {

                // Insert new user
                $this->db->insert('users', $data);
                $response = [
                    'status' => 200,
                    'success' => true,
                    'message' => 'User created successfully.'
                ];
            }



            echo json_encode($response);

            // $existingProfile = $this->User_model->getProfile();

            // if ($existingProfile) {
            //     if (file_exists($existingProfile->profile_picture)) {
            //         unlink($existingProfile->profile_picture);
            //     }
            //     $update = $this->User_model->updateProfilePicture($imagePath);
            // } else {
            //     $update = $this->User_model->insertProfilePicture($imagePath);
            // }

            // if ($update) {
            //     $response = array('success' => true, 'imagePath' => base_url($imagePath), 'fileName' => $imagePath);
            // } else {
            //     $response = array('success' => false, 'error' => 'Failed to update profile picture in the database.');
            // }

            //echo json_encode($response);
        }
    }

    // Delete image function
    public function Imagedelete($imageId)
    {
        $imageDetails = $this->User_model->get_image_by_id($imageId);

        if ($imageDetails) {
            $filePath = FCPATH . $imageDetails['path'];

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $this->User_model->delete_image($imageId);

            echo json_encode(['status' => 'success', 'message' => 'Image deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Image not found.']);
        }
    }

    public function deletUser($userId)
    {
        if ($userId) {

            $detaleUser = $this->User_model->delete_user($userId);
            echo json_encode(['status' => 'success', 'message' => 'User deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Please Provide UserId.']);
        }
    }
}
