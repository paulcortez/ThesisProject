<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class forTest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('request_model');
        $this->load->helper('date');
    }

    public function index()
    {
        $transID = $this->input->post('reqID');
        $data['id'] = $this->id();
        $data['requestID'] = $this->request_model->get_request_id($transID);
        $data['item'] = $this->request_model->displayRequest($transID);
        $data['suppliers'] = $this->request_model->displaySupplier();
        $this->load->view('purchase_dept/purchase_order', $data);
    }

    public function id(){
        $idNumber = rand(10,100);
        return $idNumber;
    }

    public function printPurchaseOrder()
    {
        $transID = $this->input->post('reqID');
        $data['item'] = $this->request_model->displayRequest($transID);
        $this->load->view('invoice-print', $data);
    }

    public function createPO()
    {
        $transID = $this->input->post('reqID');
        $data['requestID'] = $this->request_model->get_request_id($transID);
        $data['item'] = $this->request_model->displayRequest($transID);
        $this->load->view('po', $data);
    }


    public function createPurchaseOrder()
    {
         $supplier = $this->input->post('supplier');
         $address = $this->input->post('address');
         $contact = $this->input->post('contact');
         $creditTerms = $this->input->post('credit');
         $orderDate = $this->input->post('date');

         $purchaseOrder = array(
             
         );
    }

    public function test_one()
    {
        //  $supplierID = $this->request_model->get_supplier_id($supplierName);
        //  $supplierName = $this->input->post('supplier');

        $name = $this->input->post('supplier');
        if (isset($_POST['supplier'])) {
            $supplierAddress = $this->request_model->get_supplier_address($name);
            echo $supplierAddress;
        }
    }

    public function test_two()
    {
        //  $supplierID = $this->request_model->get_supplier_id($supplierName);
        //  $supplierName = $this->input->post('supplier');

        $name = $this->input->post('supplier');
        if (isset($_POST['supplier'])) {
            $supplierContanct = $this->request_model->get_supplier_contact($name);
            echo $supplierContanct;
        }
    }

    public function test()
    {
        $this->load->view('dept_views/purchase_dept');
    }
}
