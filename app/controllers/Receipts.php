<?php
class Receipts extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['uid'])) {
            redirect('');
        }else{
            $this->receiptsModel = $this->model('Receipt');
        }
    }
    public function index()
    {
        $receipts = $this->receiptsModel->GetReceipts();
        $data = ['receipts' => $receipts];
        $this->view('receipts/index',$data);
    }
    public function add()
    {
        $categories = $this->receiptsModel->GetCategories();
        $suppliers = $this->receiptsModel->GetSuppliers();
        $reference = $this->receiptsModel->GetReference();
        $data = [
            'categories' => $categories,
            'suppliers' => $suppliers,
            'reference' => $reference
        ];
        $this->view('receipts/add',$data);
    }
    public function getproducts()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $category = trim($_POST['category']);
            $products = $this->receiptsModel->GetProductsByCategory($category);
            $output = '';
            $output .='<option value="0" disabled selected>Select Product</option>';
            foreach ($products as $product ) {
                $output .= '<option value="'.$product->ID.'">'.$product->ProductName.'</option>';
            }
            echo $output;
        }else {
            redirect('receipts');
        }
    }
    public function getprice()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $product = trim($_POST['product']);
            $rate = $this->receiptsModel->GetProductsRate($product);
            echo $rate;
        }else {
            redirect('receipts');
        }
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'ref' => trim($_POST['ref']),
                'date' => trim($_POST['date']),
                'supplier' => trim($_POST['supplier']),
                'category' => $_POST['category'],
                'product' => $_POST['product'],
                'qty' => $_POST['qty'],
                'rate' => $_POST['rate'],
                'value' => $_POST['value'],
            ];
            if ($this->receiptsModel->create($data)) {
                flash('receipt_msg','Receipt Saved Successfully!');
                redirect('receipts');
            }
        }else {
            redirect('receipts');
        }
    }
    public function edit($id)
    {
        $header = $this->receiptsModel->GetReceiptsHeader($id);
        $data = [
            'header' => $header
        ];
        $this->view('receipts/edit',$data);
    }
}