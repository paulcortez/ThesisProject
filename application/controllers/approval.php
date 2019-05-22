<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approval extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('request_model');
    }

   public function approveRequest(){
        $transID = $this->input->post('reqID');
        $current_date = date("Y-m-d");

        $request = array(
            'status' => 'Waiting Budgeting',
            'date_approved' => $current_date,
            'approved_by' => $this->session->userdata('username')
        );
        
        $this->request_model->update_request($transID, $request);
        redirect('approval/displayRequest');
    }

    public function budgetingApproveRequest(){
        $transID = $this->input->post('reqID');
        $current_date = date("Y-m-d");

        $request = array(
            'status' => 'Submitted PD',
            'date_approved' => $current_date,
            'approved_by' => $this->session->userdata('username')
        );
        
        $this->request_model->update_request($transID, $request);
        redirect('approval/DisplayRequestBudgeting');
    }

    public function purchasingApproveRequest(){
        $transID = $this->input->post('reqID');
        $current_date = date("Y-m-d");

        $request = array(
            'status' => 'Processing',
            'date_approved' => $current_date,
            'approved_by' => $this->request_model->get_user_id($this->session->userdata('username'))
        );
        
        $this->request_model->update_request($transID, $request);
        redirect('approval/DisplayRequestPurchasing');
    }

    public function declineRequest(){
        $transID = $this->input->post('reqID');
        $current_date = date("Y-m-d");

        $request = array(
            'status' => 'Processing',
            'date_approved' => $current_date
        );
    }

    //Displaying Request 
    public function displayRequest(){
        $data['query'] = $this->request_model->displayUnitHead();
        $data['item'] = $this->request_model->display_item(); 
        $data['comment'] = $this->request_model->displayComment();
        $this->load->view('dean_view', $data);
    }

    public function displayRequestBudgeting(){
        $data['requests'] = $this->request_model->displayBudgeting();
        $data['requestItems'] = $this->request_model->display_item(); 
        $data['comment'] = $this->request_model->displayComment();
        $this->load->view('budgeting_view', $data);
    }

    public function displayRequestPurchasing(){
        $data['requests'] = $this->request_model->displayPurchasing();
        $data['requestItems'] = $this->request_model->display_item(); 
        $data['comment'] = $this->request_model->displayComment();
        $this->load->view('purchasing_view', $data);
    }

}