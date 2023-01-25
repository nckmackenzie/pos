<?php
class Suppliers extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['uid'])) {
            redirect('');
        }else{
            $this->supplierModel = $this->model('Supplier');
        }
    }
    public function index()
    {
        $suppliers = $this->supplierModel->GetSuppliers();
        $data = ['suppliers' => $suppliers];
        $this->view('suppliers/index',$data);
    }
    public function add()
    {
        $data = [
            'name' => '',
            'contact' => '',
            'email' => '',
            'address' => '',
            'pin' => '',
            'name_err' => '',
            'contact_err' => '',
        ];
        $this->view('suppliers/add',$data);
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
                'name_err' => '',
                'contact_err' => '',
                'id' => ''
            ];
            if (empty($data['name'])) {
                $data['name_err'] = 'Enter Supplier Name';
            }else{
                if (!$this->supplierModel->CheckExists($data)) {
                    $data['name_err'] = 'Supplier Exists';
                }
            }
            if (empty($data['contact'])) {
                $data['contact_err'] = 'Enter Supplier Contact';
            }
            if (empty($data['name_err']) && empty($data['contact_err'])) {
                if ($this->supplierModel->create($data)) {
                    flash('supplier_msg','Supplier Added Successfully');
                    redirect('suppliers');
                }
            }else{
                $this->view('suppliers/add',$data);
            }
        }else {
            redirect('suppliers');
        }
    }
    public function edit($id)
    {
        $supplier = $this->supplierModel->GetSupplier($id);
        $data = [
            'supplier' => $supplier,
            'name' => '',
            'contact' => '',
            'email' => '',
            'address' => '',
            'pin' => '',
            'name_err' => '',
            'contact_err' => '',
        ];
        $this->view('suppliers/edit',$data);
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
                'name_err' => '',
                'contact_err' => '',
                'id' => trim($_POST['id'])
            ];
            if (empty($data['name'])) {
                $data['name_err'] = 'Enter Supplier Name';
            }else{
                if (!$this->supplierModel->CheckExists($data)) {
                    $data['name_err'] = 'Supplier Exists';
                }
            }
            if (empty($data['contact'])) {
                $data['contact_err'] = 'Enter Supplier Contact';
            }
            if (empty($data['name_err']) && empty($data['contact_err'])) {
                if ($this->supplierModel->update($data)) {
                    flash('supplier_msg','Supplier Updated Successfully');
                    redirect('suppliers');
                }
            }else{
                $this->view('suppliers/edit',$data);
            }
        }else {
            redirect('suppliers');
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $id = trim($_POST['id']);
            if (!$this->supplierModel->CheckReferenced($id)) {
                flash('supplier_msg','supplier Cannot Be Deleted As Its Referenced Elsewhere!',
                      'alert custom-danger alert-dismissible fade show');
                redirect('suppliers');
            }else{
                if ($this->supplierModel->delete($id)) {
                    flash('supplier_msg','Supplier Deleted Successfully!');
                    redirect('suppliers');
                }
            }
        }else{
            redirect('suppliers');
        }
    }
}