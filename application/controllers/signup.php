<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller
{
    public function index()
    {
        $this->load->view('signup');
    }
    
    public function check()
    {           
        sleep(1);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('Username', 'Username', 'required|max_length[40]');
        $this->form_validation->set_rules('Username2', 'Username2', 'required|max_length[40]');
        $this->form_validation->set_rules('Password', 'Password', 'required|max_length[20]');
        $this->form_validation->set_rules('Password2', 'Password2', 'required|max_length[20]');
        
        if ($this->form_validation->run() == FALSE) {
            $message = "<strong>Registration</strong> failed! Incorrect input!";
            $this->json_response(FALSE, $message);
        } else {   
            $username = $this->input->post('Username');
            $password = $this->input->post('Password');
            
            if ($username != $this->input->post('Username2')) {
                $message = "<strong>Username</strong> do not match!";
                $this->json_response(FALSE, $message);
            } elseif ($password != $this->input->post('Password2')) {
                $message = "<strong>Passwords</strong> do not match!";
                $this->json_response(FALSE, $message);
            
            } elseif ($this->user_model->add($username, $password)) {
                $message = "<strong>Registration</strong> successful!";
                $this->json_response(TRUE, $message);
            } else {
                $message = "<strong>Username</strong> already exists!";
                $this->json_response(FALSE, $message);
            }
        }
    }

    private function json_response($successful, $message)
    {
        echo json_encode(array(
            'isSuccessful' => $successful,
            'message' => $message
        )); 
    }
}
/*End of file signup.php*/
