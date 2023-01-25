<?php
class Payments extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['uid']) || $_SESSION['utype'] != 1) {
            redirect('users');
        }else {
            $this->paymentsModel = $this->model('Payment');
        }
    }
    public function index()
    {
        $payments = $this->paymentsModel->GetPayments();
        $data = ['payments' => $payments];
        $this->view('payments/index',$data);
    }
    public function add()
    {
        $customers = $this->paymentsModel->GetCustomers();
        $paymethods = $this->paymentsModel->GetPaymethods();
        $data = [
            'customers' => $customers,
            'paymethods' => $paymethods,
            'customer' => '',
            'date' => '',
            'amount' => '',
            'paymethod' => '',
            'ref' => '',
            'balance' => '',
            'description' => '',
            'customer_err' => '',
            'date_err' => '',
            'amount_err' => '',
            'ref_err' => ''
        ];
        $this->view('payments/add',$data);
        // print_r($data);
    }
    public function getbalance()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $_GET = filter_input_array(INPUT_GET,FILTER_SANITIZE_STRING);
            $customer = trim($_GET['customer']);
            $balance = $this->paymentsModel->GetBalance($customer);
            echo $balance;
        }
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $customers = $this->paymentsModel->GetCustomers();
            $paymethods = $this->paymentsModel->GetPaymethods();
            $data = [
            'customers' => $customers,
            'paymethods' => $paymethods,
            'customer' => !empty($_POST['customer']) ? trim($_POST['customer']) : '',
            'date' => trim($_POST['idate']),
            'amount' => trim($_POST['amount']),
            'paymethod' => trim($_POST['paymethod']),
            'ref' => trim($_POST['reference']),
            'balance' => trim($_POST['balance']),
            'description' => trim($_POST['description']),
            'customer_err' => '',
            'date_err' => '',
            'amount_err' => '',
            'ref_err' => ''
            ];
            //validation
            if (empty($data['customer'])) {
                $data['customer_err'] = 'Select Customer';
            }
            if (empty($data['date'])) {
                $data['date_err'] = 'Select Payment Date';
            }else{
                if ($data['date'] > date('Y-m-d')) {
                    $data['date_err'] = 'Payment Date Cannot Be Later Than Today';
                }
            }
            if (empty($data['amount'])) {
                $data['amount_err'] = 'Enter Amount Being Paid';
            }
            if (empty($data['ref'])) {
                $data['ref_err'] = 'Enter Payment Reference';
            }
            //end of validation

            if (empty($data['customer_err']) && empty($data['date_err']) && empty($data['amount_err']) 
                && empty($data['ref_err'])) {
                
                # save record
                if ($this->paymentsModel->create($data)) {
                    flash('payment_msg','Payment Saved Successfully!');
                    redirect('payments');
                }
            }else{
                $this->view('payments/add',$data);
            }
            
        }else {
            redirect('payments');
        }
    }
    public function edit($id)
    {
        $customers = $this->paymentsModel->GetCustomers();
        $paymethods = $this->paymentsModel->GetPaymethods();
        $payment = $this->paymentsModel->GetPayment($id);
        $data = [
            'customers' => $customers,
            'paymethods' => $paymethods,
            'payment' => $payment,
            'customer' => '',
            'date' => '',
            'amount' => '',
            'paymethod' => '',
            'ref' => '',
            'description' => '',
            'customer_err' => '',
            'date_err' => '',
            'amount_err' => '',
            'ref_err' => ''
        ];
        $this->view('payments/edit',$data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $customers = $this->paymentsModel->GetCustomers();
            $paymethods = $this->paymentsModel->GetPaymethods();
            $data = [
                'customers' => $customers,
                'paymethods' => $paymethods,
                'id' => trim($_POST['id']),
                'customer' => !empty($_POST['customer']) ? trim($_POST['customer']) : '',
                'date' => trim($_POST['idate']),
                'amount' => trim($_POST['amount']),
                'paymethod' => trim($_POST['paymethod']),
                'ref' => trim($_POST['reference']),
                'description' => trim($_POST['description']),
                'customer_err' => '',
                'date_err' => '',
                'amount_err' => '',
                'ref_err' => ''
            ];
            //validation
            if (empty($data['customer'])) {
                $data['customer_err'] = 'Select Customer';
            }
            if (empty($data['date'])) {
                $data['date_err'] = 'Select Payment Date';
            }else{
                if ($data['date'] > date('Y-m-d')) {
                    $data['date_err'] = 'Payment Date Cannot Be Later Than Today';
                }
            }
            if (empty($data['amount'])) {
                $data['amount_err'] = 'Enter Amount Being Paid';
            }
            if (empty($data['ref'])) {
                $data['ref_err'] = 'Enter Payment Reference';
            }
            //end of validation

            if (empty($data['customer_err']) && empty($data['date_err']) && empty($data['amount_err']) 
                && empty($data['ref_err'])) {
                
                # update record
                if ($this->paymentsModel->update($data)) {
                    flash('payment_msg','Payment Updated Successfully!');
                    redirect('payments');
                }
            }else{
                $this->view('payments/edit',$data);
            }
            
        }else {
            redirect('payments');
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $id = trim($_POST['id']);
                # delete record
            if ($this->paymentsModel->delete($id)) {
                flash('payment_msg','Payment Deleted Successfully!');
                redirect('payments');
            }
        }else {
            redirect('payments');
        }
    }
}