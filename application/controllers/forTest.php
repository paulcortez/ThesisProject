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

    public function printPO()
    {
        $transID = $this->input->post('reqID');
        $data['item'] = $this->request_model->displayRequest($transID);
        $this->load->view('purchase_dept/invoice-print', $data);
    }

    public function createPO(){
        $transID = $this->input->post('reqID');
        $data['item'] = $this->request_model->displayRequest($transID);
        $this->load->view('purchase_dept/invoice-print', $data);
    }

    public function createPurchaseOrder()
    {
         $poNumber = $this->input->post('po_number');
         $supplier = $this->request_model->get_supplier_id($this->input->post('supplier')); 
         $creditTerms = $this->input->post('credit');
         $orderDate = $this->input->post('date');
         $requestID = $this->input->post('reqID');

         $purchaseOrder = array(
            'PO_number' => $poNumber,
            'supplier_id' =>$supplier,
            'request_id' => $requestID,
            'order_date' => $orderDate,
            'credit_terms' => $creditTerms
         );

         $this->request_model->purchaseOrder($purchaseOrder); 
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
}
