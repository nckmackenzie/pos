<?php
class Customers extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['uid']) || $_SESSION['utype'] != 1) {
            redirect('users/login');
        }else{
            $this->customerModel = $this->model('Customer');
        }
    }
    public function index()
    {
        $customers = $this->customerModel->GetCustomers();
        $data = ['customers'=> $customers];
        $this->view('customers/index',$data);
    }
    public function add()
    {
        $data = [
            'name' => '',
            'contact' => '',
            'email' => '',
            'address' => '',
            'pin' => '',
            'openingbal' => '',
            'name_err' => '',
            'contact_err' => '',
        ];
        $this->view('customers/add',$data);
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'contact' =>  trim($_POST['contact']),
                'email' =>  trim($_POST['email']),
                'address' =>  trim($_POST['address']),
                'pin' =>  trim($_POST['pin']),
                'openingbal' => trim($_POST['openingbal']),
                'name_err' => '',
                'contact_err' => '',
                'id' => ''
            ];
            if (empty($data['name'])) {
                $data['name_err'] = 'Enter Customer Name';
            }else{
                if (!$this->customerModel->CheckExists($data)) {
                    $data['name_err'] = 'customer Exists';
                }
            }
            if (empty($data['contact'])) {
                $data['contact_err'] = 'Enter customer Contact';
            }
            if (empty($data['name_err']) && empty($data['contact_err'])) {
                if ($this->customerModel->create($data)) {
                    flash('customer_msg','Customer Added Successfully');
                    redirect('customers');
                }
            }else{
                $this->view('customers/add',$data);
            }
        }else {
            redirect('customers');
        }
    }
    public function edit($id)
    {
        $customer = $this->customerModel->GetCustomer($id);
        $data = [
            'customer' => $customer,
            'name' => '',
            'contact' => '',
            'email' => '',
            'address' => '',
            'pin' => '',
            'name_err' => '',
            'contact_err' => '',
        ];
        $this->view('customers/edit',$data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'contact' =>  trim($_POST['contact']),
                'email' =>  trim($_POST['email']),
                'address' =>  trim($_POST['address']),
                'pin' =>  trim($_POST['pin']),
                'active' => isset($_POST['active']) ? 1 : 0,
                'name_err' => '',
                'contact_err' => '',
                'id' => trim($_POST['id'])
            ];
            if (empty($data['name'])) {
                $data['name_err'] = 'Enter Customer Name';
            }else{
                if (!$this->customerModel->CheckExists($data)) {
                    $data['name_err'] = 'Customer Exists';
                }
            }
            if (empty($data['contact'])) {
                $data['contact_err'] = 'Enter Customer Contact';
            }
            if (empty($data['name_err']) && empty($data['contact_err'])) {
                if ($this->customerModel->update($data)) {
                    flash('customer_msg','Customer Updated Successfully');
                    redirect('customers');
                }
            }else{
                $this->view('customers/edit',$data);
            }
        }else {
            redirect('customers');
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $id = trim($_POST['id']);
            if (!$this->customerModel->CheckReferenced($id)) {
                flash('customer_msg','Customer Cannot Be Deleted As Its Referenced Elsewhere!',
                      'alert custom-danger alert-dismissible fade show');
                redirect('customers');
            }else{
                if ($this->customerModel->delete($id)) {
                    flash('customer_msg','Customer Deleted Successfully!');
                    redirect('customers');
                }
            }
        }else{
            redirect('customers');
        }
    }
}