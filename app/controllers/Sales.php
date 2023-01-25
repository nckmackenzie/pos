<?php
class Sales extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['uid'])) {
            redirect('users');
        }else{
            $this->salesModel = $this->model('Sale');
        }
    }
    public function index()
    {
        $products = $this->salesModel->Getproducts();
        $id = $this->salesModel->GetID();
        $customers = $this->salesModel->GetCustomers();
        $data = [
            'products' => $products,
            'customers' => $customers,
            'id' => $id
        ];
        $this->view('sales/index',$data);
    }
    
    public function getdetails()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $_GET = filter_input_array(INPUT_GET,FILTER_SANITIZE_STRING);
            $product = trim($_GET['product']);
            $rate = $this->salesModel->GetProductsDetails($product);
            foreach ($rate as $row) {
                $output['sp'] = $row['SellingPrice'];
                $output['stock'] = $row['stock'];
            }
            echo json_encode($output);
        }else {
            redirect('dashboard');
        }
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'saleid' => trim($_POST['saleid']),
                'sdate' => trim($_POST['sdate']),
                'customer' => trim($_POST['customer']),
                'subtotal' => trim($_POST['subtotal']),
                'discount' => trim($_POST['discount']),
                'total' => trim($_POST['total']),
                'paid' => trim($_POST['paid']),
                'due' => trim($_POST['due']),
                'product' => $_POST['product'],
                'qty' => $_POST['qty'],
                'rate' => $_POST['rate'],
                'value' => $_POST['value']
            ];
            if ($this->salesModel->create($data)) { 
                flash('sale_msg','Sale Added Successfully');
                redirect('sales/sales');
            }
        }else{
            $products = $this->salesModel->Getproducts();
            $id = $this->salesModel->GetID();
            $customers = $this->salesModel->GetCustomers();
            $data = [
                'products' => $products,
                'customers' => $customers,
                'id' => $id
            ];
            $this->view('sales/index',$data);
        }
    }
    public function sales()
    {
        $sales = $this->salesModel->GetSales();
        $data = ['sales' => $sales];
        $this->view('sales/sales',$data);
    }
    public function print($id)
    {
        $companyinfo = $this->salesModel->GetCompanyInfo($id);
        $header = $this->salesModel->SaleHeader($id);
        $customer = $this->salesModel->CustomerInfo($header->CustomerID);
        $details = $this->salesModel->GetSalesDetails($id);
        $data = [
            'companyinfo' => $companyinfo,
            'header' => $header,
            'customerinfo' => $customer,
            'details' => $details
        ];
        // print_r($data);
        $this->view('sales/print',$data);
    }
    public function edit($id)
    {
        $sale = $this->salesModel->GetSale($id);
        $customers = $this->salesModel->GetCustomers();
        $products = $this->salesModel->Getproducts();
        $details = $this->salesModel->GetSaleDetails($id);
        $data = [
            'sale' => $sale,
            'customers' => $customers,
            'products' => $products,
            'details' => $details
        ];
        $this->view('sales/edit',$data);
        // print_r($data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'saleid' => trim($_POST['saleid']),
                'sdate' => trim($_POST['sdate']),
                'customer' => trim($_POST['customer']),
                'subtotal' => trim($_POST['subtotal']),
                'discount' => trim($_POST['discount']),
                'total' => trim($_POST['total']),
                'paid' => trim($_POST['paid']),
                'due' => trim($_POST['due']),
                'product' => $_POST['product'],
                'qty' => $_POST['qty'],
                'rate' => $_POST['rate'],
                'value' => $_POST['value'],
                'id' => trim($_POST['id'])
            ];
            if ($this->salesModel->update($data)) { 
                flash('sale_msg','Sale Updated Successfully');
                redirect('sales/sales');
            }
        }else{
            $products = $this->salesModel->Getproducts();
            $id = $this->salesModel->GetID();
            $customers = $this->salesModel->GetCustomers();
            $data = [
                'products' => $products,
                'customers' => $customers,
                'id' => $id
            ];
            $this->view('sales/index',$data);
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $id = trim($_POST['id']);
            if ($this->salesModel->delete($id)) { 
                flash('sale_msg','Sale Deleted Successfully');
                redirect('sales/sales');
            }
        }else{
            redirect('sales/sales');
        }
    }
}