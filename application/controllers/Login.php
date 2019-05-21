<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('login_model');
    }

    public function index(){
        $this->load->view('login');
    }

    public function validate(){
        $username = $this->input->post('username',TRUE);
        $password = MD5($this->input->post('password',TRUE));
        $validate = $this->login_model->validate($username,$password);
        if($validate->num_rows() > 0){
            $this->session->set_userdata(array(
                'username'   => $this->input->post('username'),
                'role'       => $this->login_model->user_role($username),
                'department' => $this->login_model->department($username),
                'logged_in' => TRUE));
            redirect('login/load_page');
        }
        
        else{
            echo $this->session->set_flashdata('msg','Username or Password is Wrong');
            redirect('login');
        }
    }

    public function load_page(){
        if($this->session->userdata('logged_in')){
            $dept = $this->session->userdata('department');

            if($dept == "Computer Studies"){
                redirect('page/ccs');
            }
            
            elseif($dept == "Budgeting"){
                redirect('page/budgeting');
            }
            elseif($dept == "Purchasing"){
                redirect('page/purchasing');
            }
            
        }
    }

    public function logout(){
        $this->session->unset_userdata();
        $this->session->sess_destroy();

        redirect('login');
    }
}