<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('request_model');
    }

    public function userComment()
    {
        $comment = $this->input->post('comment');
        $transID = $this->input->post('requestID');
        $userID = $this->request_model->get_user_id($this->session->userdata('username'));
        $current_date = date("Y-m-d");

        $newComment = array(
            'tableCommented' => "item request table",
            'comment' => $comment,
            'userID' => $userID,
            'requestID' => $transID,
            'date' => $current_date
        );

        $this->request_model->itemComment($newComment);



        if ($this->session->userdata('department') == "Computer Studies") {
            if ($this->session->userdata('role') == "Faculty") {
                redirect('UserRequest/trackView');
            } elseif ($this->session->userdata('role') == "Dean") {
                redirect('approval/displayRequest');
            }
        } elseif ($this->session->userdata('department') == "Budgeting") {
            redirect('approval/displayRequestBudgeting');
        } elseif ($this->session->userdata('department') == "Purchasing") {
            redirect('approval/displayRequestPurchasing');
        }
    }
}
