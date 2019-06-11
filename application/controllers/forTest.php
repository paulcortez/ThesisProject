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
         $data['suppliers'] = $this->request_model->displaySupplier();
         $this->load->view('purchase_dept/purchase_order', $data);
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
        //  $supplierID = $this->request_model->get_supplier_id($supplierName);
        //  $supplierName = $this->input->post('supplier');

        $name = $this->input->post('supplier');
        if(isset($_POST['supplier'])){
        $supplierAddress = $this->request_model->get_supplier_address($name);
        echo $supplierAddress;
        
        }
 
    }
}
