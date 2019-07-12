<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class PurchasingDept extends CI_Controller
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
        $data['item'] = $this->request_model->display_item_po();
        $data['suppliers'] = $this->request_model->display_supplier();
        $this->load->view('purchase_dept/createPurchaseOrder', $data);
    }

    public function id()
    {
        $idNumber = rand(10, 100);
        $this->session->set_userdata('po_number', $idNumber);
        return $idNumber;
    }

    public function print()
    {
        $transID = $this->input->post('reqID');
        $poNumber = $this->input->post('poNumber');
        $data['supplier'] = $this->request_model->displaySupplier($poNumber);
        $data['po_details'] = $this->request_model->displayPurchaseOrder($poNumber);
        $data['item'] = $this->request_model->displayRequest($transID);
        $this->load->view('purchase_dept/print', $data);
    }

    public function processPO()
    {
        $transID = $this->input->post('reqID');
        $data['id'] = $this->id();
        $data['requestID'] = $this->request_model->get_request_id($transID);
        $data['item'] = $this->request_model->displayRequest($transID);
        $data['suppliers'] = $this->request_model->display_supplier();
        $this->load->view('purchase_dept/processingPO', $data);
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
            'supplier_id' => $supplier,
            'request_id' => $requestID,
            'order_date' => $orderDate,
            'credit_terms' => $creditTerms
        );

        $this->request_model->purchaseOrder($purchaseOrder);
    }

    public function generatePo(){
        
        $poNumber = $this->input->post('po_number');
        $supplier = $this->request_model->get_supplier_id($this->input->post('supplier'));
        $creditTerms = $this->input->post('credit');
        $orderDate = $this->input->post('date');


        $purchaseOrder = array(
            'PO_number' => $poNumber,
            'supplier_id' => $supplier,
            'order_date' => $orderDate,
            'credit_terms' => $creditTerms
        );

        $add = $this->request_model->purchaseOrder($purchaseOrder);
        $this->session->set_userdata('po_number', $add);

        $data['poNumber'] = $this->request_model->get_po_number($poNumber);
        $data['supplier'] = $this->request_model->displaySupplier($poNumber);
        $data['po_details'] = $this->request_model->displayPurchaseOrder($poNumber);
        $this->load->view('purchase_dept/addItem', $data);
        //redirect('purchasingDept/viewGeneratedPo');
    }

    public function viewGeneratedPo(){ 
        $poNumber = $this->input->post('poNumber');
        $data['poNumber'] = $poNumber;//$this->request_model->get_po_number($this->session->userdata('po_number'));
        $this->load->view('purchase_dept/addItem', $data);
    }

    public function add_item()
    { 
            $item = $this->input->post('item');
            $description = $this->input->post('description');
            $unit = $this->input->post('unit');
            $quantity = $this->input->post('quantity');
            $po_number = $this->input->post('po_num');

            $item = array(
                'itemName' => $item,
                'itemDescription' => $description,
                'unit' => $unit,
                'quantity' => $quantity,
                'PO_Number' => $po_number
            );
             $this->request_model->insert_item($item);
            $transID = $this->input->post('reqID');
            $poNumber = $this->input->post('poNumber');
            $data['supplier'] = $this->request_model->displaySupplier($poNumber);
            $data['po_details'] = $this->request_model->displayPurchaseOrder($poNumber);
            $data['items'] = $this->request_model->displayRequest($transID);
            
            $this->load->view('purchase_dept/addItem', $data);
        
    }

    public function editPurchaseOrder()
    {
        $transID = $this->input->post('reqID');
        $poNumber = $this->input->post('poNumber');
        $data['po_supplier'] = $this->request_model->display_supplier();
        $data['supplier'] = $this->request_model->displaySupplier($poNumber);
        $data['po_details'] = $this->request_model->displayPurchaseOrder($poNumber);
        $data['item'] = $this->request_model->displayRequest($transID);
        $this->load->view('purchase_dept/editPurchaseOrder', $data);
    }

    public function updatePurchaseOrder()
    {
        $poNumber = $this->input->post('po_number');
        $supplier = $this->request_model->get_supplier_id($this->input->post('supplier'));
        $creditTerms = $this->input->post('credit');
        $orderDate = $this->input->post('date');
        $requestID = $this->input->post('reqID');

        $purchaseOrder = array(
            'supplier_id' => $supplier,
            'request_id' => $requestID,
            'order_date' => $orderDate,
            'credit_terms' => $creditTerms
        );

        $this->request_model->update_po($poNumber, $purchaseOrder);
        redirect('PurchasingDept/view_po');
    }

    public function view_po()
    {
        $data['po'] = $this->request_model->displayPO();
        $this->load->view('purchase_dept/po_list', $data);
    }

    public function purchaseOrder()
    {
        $transID = $this->input->post('reqID');
        $poNumber = $this->input->post('poNumber');
        $data['supplier'] = $this->request_model->displaySupplier($poNumber);
        $data['po_details'] = $this->request_model->displayPurchaseOrder($poNumber);
        $data['items'] = $this->request_model->displayRequest($transID);
        $this->load->view('purchase_dept/purchaseOrder', $data);
    }



    //Populate textboxes id=Address/Contact on dropdown select
    public function show_address()
    {
        $name = $this->input->post('supplier');
        if (isset($_POST['supplier'])) {
            $supplierAddress = $this->request_model->get_supplier_address($name);
            echo $supplierAddress;
        }
    }

    public function show_contact()
    {
        $name = $this->input->post('supplier');
        if (isset($_POST['supplier'])) {
            $supplierContanct = $this->request_model->get_supplier_contact($name);
            echo $supplierContanct;
        }
    }
}
