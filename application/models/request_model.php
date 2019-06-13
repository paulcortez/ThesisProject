<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request_model extends CI_Model{

    //---------------------------------user----------------------------------//
    //get user id
    public function get_user_id($username){
        $this->db->select('userID')->from('users')->where('username', $username);
        $query = $this->db->get();
        
         if($query->num_rows() > 0)
         {
            $row = $query->row(0);
            return $row->userID;
         }
    }

    //-----------------------------item processing-----------------------------//
    //get item id
    public function get_item_id(){
        $this->db->select('itemID')->from('item')->where('itemID', );
        $query = $this->db->get();
        
         if($query->num_rows() == 1)
         {
            $row = $query->row(0);
            return $row->itemID;
         }
    }

    //get last id of item transaction
    public function get_request_id($id){
        $this->db->select('requestID')->from('item_request')->where('requestID', $id);
        $query = $this->db->get();

        if($query->num_rows() == 1 ){
            $row = $query->row(0);

            return $row->requestID;
        }
    }

    //supplier  
    public function get_supplier_id($name){
        $this->db->select('supplierID')->from('supplier')->where('supplierName', $name);
        $query = $this->db->get();

        if($query->num_rows() == 1 ){
            $row = $query->row(0);

            return $row->supplierID;
        }
    }

    public function get_supplier_address($name){
        $this->db->select('supplierAddress')->from('supplier')->where('supplierName', $name);
        $query = $this->db->get();

        if($query->num_rows() == 1 ){
            $row = $query->row(0);

            return $row->supplierAddress;
        }
    }

    public function get_supplier_contact($name){
        $this->db->select('phone_no')->from('supplier')->where('supplierName', $name);
        $query = $this->db->get();

        if($query->num_rows() == 1 ){
            $row = $query->row(0);

            return $row->phone_no;
        }
    }

    //-------------------Purchase Order----------------------------// 
    
    public function purchaseOrder($purchaseOrder){
        $this->db->insert('purchase_order', $purchaseOrder);
    }


    //====================Request manipulation============================//
    public function addRequest($request){
        $this->db->insert('item_request', $request);
        return $this->db->insert_id();
    }

    //insert items
    public function insert_item($item){
        $this->db->insert('item', $item);
        return $this->db->insert_id();
    }

    public function update_item($itemID, $itemDetails){
        $this->db->where('itemID', $itemID);
        $this->db->update('item', $itemDetails);
        return $this->db->affected_rows(); 
    }

    public function delete_item($itemID){
        $this->db->where('itemID', $itemID);
        $this->db->delete('item');
        return $this->db->affected_rows(); 
    }

    //after submitting
    public function update_request($requestID, $requestData){
        $this->db->where('requestID', $requestID);
        $this->db->update('item_request', $requestData);
        return $this->db->affected_rows();
    }

    public function delete_request($requestID){
        $this->db->where('requestID', $requestID);
        $this->db->delete('item_request');
        return $this->db->affected_rows();
    }


    //------------------------------Comment-------------------------------------//
    public function itemComment($comment){
        $this->db->insert('comment', $comment);
        return $this->db->insert_id();
    }

   

    //------------------------------displaying-----------------------------------//
    //displaying records
        public function display_item(){
        $this->db->select('itemID, itemName, itemDescription, unit, quantity, item.requestID');
        $this->db->from('item_request');
        $this->db->join('item', 'item.requestID = item_request.requestID');
        $query = $this->db->get();
        return $query->result();
    }

    //display request
    public function display_request($userID){
        $this->db->select('item_request.requestID, username, date_requested, status, approved_by, date_approved, users.userID');
        $this->db->from('item_request');
        $this->db->where('users.userID', $userID);
        $this->db->join('users', 'users.userID = item_request.userID');
        $query = $this->db->get();
        return $query->result();
    }

    //display during user adding items
    public function displayOpenRequest($userID){
        $this->db->select('item_request.requestID, status, date_requested, users.userID');
        $this->db->from('item_request');
        $this->db->where('status', "Pending Submission");
        $this->db->where('item_request.userID', $userID);
        $this->db->join('users', 'users.userID = item_request.userID');
        $query = $this->db->get();
        return $query->result();
    }

    public function displayUnitHead(){
        $this->db->select('item_request.requestID, username, date_requested, status');
        $this->db->from('item_request');
        $this->db->where('status', 'Waiting Dean');
        $this->db->join('users', 'users.userID = item_request.userID');
        $query = $this->db->get();
        return $query->result();
    }

    public function displayBudgeting(){
        $this->db->select('item_request.requestID, username, date_requested, department, status');
        $this->db->from('item_request');
        $this->db->where('status', 'Waiting Budgeting');
        $this->db->join('users', 'users.userID = item_request.userID');
        $query = $this->db->get();
        return $query->result();
    }

    public function displayPurchasing(){
        $this->db->select('item_request.requestID, username, date_requested, department, status');
        $this->db->from('item_request');
        $this->db->where('status', 'Submitted PD');
        $this->db->join('users', 'users.userID = item_request.userID');
        $query = $this->db->get();
        return $query->result();
    }

    public function displayUserRequest(){
        $this->db->select('item_request.requestID, username, date_requested, status');
        $this->db->from('item_request');
        $this->db->where('status', 'Waiting Dean');
        $this->db->join('users', 'users.userID = item_request.userID');
        $query = $this->db->get();
        return $query->result();
    }

    public function declinedRequest($userID){
        $this->db->select('item_request.requestID, username, date_requested, status, approved_by, date_approved, users.userID');
        $this->db->from('item_request');
        $this->db->where('users.userID', $userID);
        $this->db->where('status', 'Declined');
        $this->db->join('users', 'users.userID = item_request.userID');
        $query = $this->db->get();
        return $query->result();
    }

    public function displayComment(){
        $this->db->select('comment, username, requestID, date');
        $this->db->from('comment');
        $this->db->join('users', 'users.userID = comment.userID');
        $query = $this->db->get();
        return $query->result();
    }

    //For Printing
    public function displayRequest($requestID){
        $this->db->select('itemID, itemName, itemDescription, unit, quantity, item.requestID');
        $this->db->from('item');
        $this->db->where('item.requestID' , $requestID);
        $query = $this->db->get();
        return $query->result();
    }

    public function displaySupplier( ){
        $this->db->select('supplierID, supplierName, supplierAddress, phone_no');
        $this->db->from('supplier'); 
        $query = $this->db->get();
        return $query->result();
    }

}