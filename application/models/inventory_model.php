<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model{

    //insert items
    public function insert_item($item){
        $this->db->insert('item_inventory', $item);
        return $this->db->insert_id();
    }

    public function insertIntoInventory($inventory){
        $this->db->insert('inventory', $inventory);
        return $this->db->insert_id();
    }
  
    //get ID
    public function getInventoryID($id){
        $this->db->select('inventory_id')->from('inventory')->where('itemID', $id);
        $query = $this->db->get();
        
         if($query->num_rows() > 0)
         {
            $row = $query->row(0);
            return $row->inventory_id;
         }
    }

    //display item for inventory
    public function displayItem(){
        $this->db->select('item_id, item_name, item_description, unit, quantity, control_number, remarks, department, dept_section');
        $this->db->from('item_inventory');
        $this->db->join('department_section', 'item_inventory.dept_section = department_section.areaID');
        $query = $this->db->get();
        return $query->result();
    }

    /*
    public function inventoryItem($dept){
        $this->db->select('item_id, item_name, item_description, unit, quantity, control_number, remarks, department, areaName');
        $this->db->from('item_inventory');
        $this->db->join('department_section', 'item_inventory.dept_section = department_section.areaID');
        $this->db->where('department', $dept);
        $query = $this->db->get();
        return $query->result();
    }*/

    public function inventoryItem($dept){
        $this->db->select('item_id, item_name, item_description, unit, quantity, control_number, remarks, department, deptName, areaName');
        $this->db->from('item_inventory');
        $this->db->join('department', 'item_inventory.department = department.deptID');
        $this->db->join('department_section', 'item_inventory.dept_section = department_section.areaID');
        $this->db->where('department', $dept);
        $query = $this->db->get();
        return $query->result();
    }

    public function selectedArea($dept){
        $this->db->select('item_id, item_name, item_description, unit, quantity, control_number, remarks, department, deptName, areaName');
        $this->db->from('item_inventory');
        $this->db->join('department', 'item_inventory.department = department.deptID');
        $this->db->join('department_section', 'item_inventory.dept_section = department_section.areaID');
        $this->db->where('dept_section', $dept);
        $query = $this->db->get();
        return $query->result();
    }

    public function displayInventory(){
        $this->db->select('item_id, item_name, item_description, unit, quantity, control_number, remarks, deptName, areaName');
        $this->db->from('item_inventory');
        $this->db->join('department', 'item_inventory.department = department.deptID');
        $this->db->join('department_section', 'item_inventory.dept_section = department_section.areaID');
        $query = $this->db->get();
        return $query->result();
    }

    public function display_department(){
        $this->db->select('deptID, deptName');
        $this->db->from('department'); 
        $query = $this->db->get();
        return $query->result();
    }

    public function getDeptID($name){
        $this->db->select('deptID')->from('department')->where('deptName', $name);
        $query = $this->db->get();
        
         if($query->num_rows() > 0)
         {
            $row = $query->row(0);
            return $row->deptID;
         }
    }

    public function display_deptArea($id){
        $this->db->select('areaID, deptID, areaName');
        $this->db->from('department_section');
        $this->db->where('deptID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    
    public function displayTest($id){
        $this->db->select('areaID, deptID, areaName, item_id, item_name, item_description, unit, quantity, control_number, remarks, department');
        $this->db->from('department_section');
        $this->db->join('item_inventory', 'department_section.deptID = item_inventory.department');
        $this->db->where('deptID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    /*
    public function test($id){
        $this->db->select('areaID, deptID, areaName, item_id, item_name, item_description, unit, quantity, control_number, remarks, deptName, areaName');
        $this->db->from('department_section'); 
        $this->db->join('item_inventory', 'department_section.areaID = item_inventory.dept_section');
        $this->db->where('deptID', $id);
        $query = $this->db->get();
        return $query->result();
    }
    */

//display
    public function display_item_po(){
        $this->db->select('itemID, itemName, itemDescription, unit, quantity, item.PO_number, item.requestID, item_request.requestID, 
                          item_request.userID, users.userID, department, purchase_order.request_id');
        $this->db->from('purchase_order');
        $this->db->join('item', 'item.PO_number = purchase_order.PO_number');
        $this->db->join('item_request', 'item_request.requestID = purchase_order.request_id');
        $this->db->join('users', 'item_request.userID = users.userID');
        $query = $this->db->get();
        return $query->result();
    }
}