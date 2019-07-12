<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class PropertyCust extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventory_model');
        $this->load->model('request_model');
        $this->load->helper('date');
    }

    public function index()
    {
        $data['departments'] = $this->inventory_model->display_department();
        $this->load->view('property_cust/inventory_view', $data);
    }


    public function addItem()
    {

        $item = $this->input->post('item');
        $description = $this->input->post('description');
        $unit = $this->input->post('unit');
        $quantity = $this->input->post('quantity');
        $control_no = $this->input->post('control_no');
        $remarks = $this->input->post('remarks');
        $dept = $this->input->post('department');
        $deptArea = $this->input->post('dept_area');

        $item = array(
            'item_name' => $item,
            'item_description' => $description,
            'unit' => $unit,
            'quantity' => $quantity,
            'control_number' => $control_no,
            'remarks' => $remarks,
            'department' => $dept,
            'dept_section' => $deptArea
        );

        $this->inventory_model->insert_item($item);
        $data['items'] = $this->inventory_model->displayItem();
        $data['departments'] = $this->inventory_model->display_department();
        $this->load->view('property_cust/addItem', $data);
    }

    public function incoming_items()
    {
        $data['po'] = $this->request_model->displayPO();
        $data['item'] = $this->inventory_model->display_item_po();
        $this->load->view('property_cust/incoming_items', $data);
    }

    //Populate textboxes id=Address/Contact on dropdown select
    public function areaName()
    {
        $dept = $this->input->post('id', TRUE);
        $data = $this->inventory_model->display_deptArea($dept);
        echo json_encode($data);
    }

    public function inventoryDetails()
    {
        $dept = $this->input->post('id', TRUE);
        $data = $this->inventory_model->inventoryItem($dept);
        echo json_encode($data);
    }


    //item_inventory part
    public function displayInventory()
    {
        $data['departments'] = $this->inventory_model->display_department();
        $data['inventory'] = $this->inventory_model->displayInventory();
        $this->load->view('property_cust/item_inventory', $data);
    }

    public function deptAreaChoice()
    {
        $dept = $this->input->post('id', TRUE);
        $data = $this->inventory_model->selectedArea($dept);
        echo json_encode($data);
    }


    //test
    public function inventory()
    {
        $data['departments'] = $this->inventory_model->display_department();
        $data['inventory'] = $this->inventory_model->displayInventory();
        $this->load->view('property_cust/inventory', $data);
    }

    public function test()
    {
        $dept = $this->input->post('id', TRUE);
        $data = $this->inventory_model->display_deptArea($dept);
        echo json_encode($data);
    }
}
