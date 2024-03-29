<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserRequest extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('request_model');
        $this->load->helper('date');
    }

    public function index()
    {
        $this->load->view('user/requestView');
    }

    //---------------------------------Item 
    public function new_request()
    {
        $newRequest = array(
            $user = $this->request_model->get_user_id($this->session->userdata('username'))
        );
        $date = date("Y-m-d");
        $newRequest = array(
            'userID' => $user,
            'date_requested' => $date,
            'status' => 'Pending Submission'
        );

        $add = $this->request_model->addRequest($newRequest);
        $this->session->set_userdata('requestID', $add);
        $data['requestID'] = $this->request_model->get_request_id($add);

        $this->load->view('user/AddItemView', $data);
    }

    public function add_item()
    { 
        $id = $this->request_model->get_user_id($this->session->userdata('username'));
        $department = $this->request_model->get_user_department($id);
        
        if($department == 'Purchasing')
        {
            $item = $this->input->post('item');
            $description = $this->input->post('description');
            $unit = $this->input->post('unit');
            $quantity = $this->input->post('quantity');
            $po_number = $this->session->userdata('po_number');

            $item = array(
                'itemName' => $item,
                'itemDescription' => $description,
                'unit' => $unit,
                'quantity' => $quantity,
                'PO_Number' => $po_number
            );

            $this->request_model->insert_item($item); 
            $data['item'] = $this->request_model->display_item($po_number);
            redirect('PurchasingDept');
        }

        else{
            $item = $this->input->post('item');
            $description = $this->input->post('description');
            $unit = $this->input->post('unit');
            $quantity = $this->input->post('quantity');
            $reqID = $this->session->userdata('requestID');
    
            
           
    
            $item = array(
                'itemName' => $item,
                'itemDescription' => $description,
                'unit' => $unit,
                'quantity' => $quantity,
                'requestID' => $reqID
            );
    
            
            $this->request_model->insert_item($item);
            $data['requestID'] = $this->request_model->get_request_id($reqID);
            $data['item'] = $this->request_model->display_item();
            $this->load->view('user/RequisitionForm', $data);
        }
    }

    public function edit_item()
    {
        $item = $this->input->post('item');
        $description = $this->input->post('description');
        $unit = $this->input->post('unit');
        $quantity = $this->input->post('quantity');
        $itemID = $this->input->post('itemID');
        $reqID = $this->session->userdata('requestID');

        $itemDetails = array(
            'itemName' => $item,
            'itemDescription' => $description,
            'unit' => $unit,
            'quantity' => $quantity
        );

        $this->request_model->update_item($itemID, $itemDetails);
        $data['requestID'] = $this->request_model->get_request_id($reqID);
        $data['item'] = $this->request_model->display_item();
        $this->load->view('user/RequisitionForm', $data);
    }

    public function delete_item()
    {
        $itemID = $this->input->post('itemID');
        $reqID = $this->session->userdata('requestID');

        $this->request_model->delete_item($itemID);
        $data['requestID'] = $this->request_model->get_request_id($reqID);
        $data['item'] = $this->request_model->display_item();
        $this->load->view('user/RequisitionForm', $data);
    }


    //-------------------------------Request

    public function edit_request()
    {
        $reqID = $this->input->post('requestID');
        $this->session->set_userdata('requestID', $reqID);
        $data['requestID'] = $reqID;
        $data['item'] = $this->request_model->display_item();
        $this->load->view('user/pendingItems', $data);
    }

    public function delete_request()
    {
        $reqID = $this->input->post('requestID');
        $this->request_model->delete_request($reqID);
        redirect('UserRequest/trackView');
    }

    public function submit_request()
    {
        $id = $this->request_model->get_user_id($this->session->userdata('username'));
        $transID = $this->session->userdata('requestID');
        $current_date = date("Y-m-d");
        $department = $this->request_model->get_user_department($id);

        if ($department !== 'Purchasing') {
            $request = array(
                'userID' => $id,
                'date_requested' => $current_date,
                'status' => 'Waiting Dean'
            );
            $this->request_model->update_request($transID, $request);
            redirect('page/ccs');
        } else {
            $request = array(
                'userID' => $id,
                'date_requested' => $current_date,
                'status' => 'Processing'
            );
            $this->request_model->update_request($transID, $request);
            redirect('approval/displayRequestPurchasing');
        }
    }


    //--------------------Comment----------------------//

    public function userComment()
    {
        $comment = $this->input->post('comment');
        $userID = $this->request_model->get_user_id($this->session->userdata('username'));
        $requestID = $this->input->post('reqID');

        $newComment = array(
            'comment' => $comment,
            'userID' => $userID,
            'requestID' => $requestID
        );

        $this->request_model->itemComment($newComment);
        redirect('UserRequest/trackView');
    }

    //-----------------------------End of Request Operations----------------------------------------


    //Display
    public function display_request()
    {
        $data['pendingRequest'] = $this->request_model->displayOpenRequest($this->request_model->get_user_id($this->session->userdata('username')));
        $this->load->view('user/pending_req_view', $data);
    }


    public function trackView()
    {
        $data['pendingItems'] = $this->request_model->display_request($this->request_model->get_user_id($this->session->userdata('username')));
        $data['item'] = $this->request_model->display_item();
        $data['comment'] = $this->request_model->displayComment();
        $this->load->view('user/trackingViewUser', $data);
    }

    public function declinedRequest()
    {
        $data['declinedRequest'] = $this->request_model->declinedRequest($this->request_model->get_user_id($this->session->userdata('username')));
        $data['item'] = $this->request_model->display_item();
        $data['comment'] = $this->request_model->displayComment();
        $this->load->view('user/declinedRequest', $data);
    }
}
