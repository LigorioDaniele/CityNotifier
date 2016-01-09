<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function index()
    {
        if (!$this->is_logged_in()) {
            $this->load->view('login');
        } else {
            redirect('site');
        }
    }
    
    public function check()
    {           
        $this->load->library('form_validation');
        $this->form_validation->set_rules('Username', 'Username', 'required|max_length[40]');
        $this->form_validation->set_rules('Password', 'Password', 'required|max_length[20]');
       
        if ($this->form_validation->run() == FALSE) {
            redirect('login/error');
        } else {
            $is_user = $this->user_model->is($this->input->post('Username'), $this->input->post('Password'));
            
            if ($is_user) {
                $username = $this->input->post('Username');
                $idUtente = $this->user_model->get_id($username);
                
                $data = array(
                    'Username' => $username,
                    'Id' => $idUtente,
                    'is_logged_in' => TRUE,
                    'is_admin' => FALSE
                );
                $this->session->set_userdata($data);

                redirect('site');
            } else {
                redirect('login/error');
            }
        }
    }
    
    public function error()
    {
        $this->load->view('login', array('error' => TRUE));
    }
    
    public function logout()
    {
        if (!$this->is_logged_in()) {
            redirect('login');
        } else {
            $this->session->set_userdata(array('is_logged_in' => FALSE));
            $this->session->sess_destroy();
            $this->load->view('login');
        }
    }
    
    private function is_logged_in()
    {
        return $this->session->userdata('is_logged_in');
    }
}
/*End of file login.php*/
