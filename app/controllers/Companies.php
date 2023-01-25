<?php
class Companies extends Controller {
    public function __construct()
    {
        $this->companyModel = $this->model('Company');
    }
    public function index()
    {
        $data = [];
        $this->view('companies/index',$data);
    }
    public function add()
    {
        $data = [
            'name' => '',
            'contact' => '',
            'address' => '',
            'email' => '',
            'name_err' => '',
            'contact_err' => ''
        ];
        $this->view('companies/add',$data);
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'contact' => trim($_POST['contact']),
                'address' => trim($_POST['address']),
                'email' => trim($_POST['email']),
                'name_err' => '',
                'contact_err' => ''
            ];
            if (empty($data['name'])) {
                $data['name_err'] = 'Enter Company Name';
            }
            if (empty($data['contact'])) {
                $data['contact_err'] = 'Enter Contact';
            }
            if (empty($data['name_err']) && empty($data['contact_err'])) {
                if ($this->companyModel->create($data)) {
                    redirect('dashboard');
                }
            }else{
                $this->view('companies/add',$data);
            }
        }else{
            redirect('');
        }
    }
    public function edit($id)
    {
        $company = $this->companyModel->GetCompany($id);
        $data = [
            'company' => $company,
            'name' => '',
            'contact' => '',
            'address' => '',
            'pin' => '',
            'email' => '',
            'name_err' => '',
            'contact_err' => ''
        ];
        $this->view('companies/edit',$data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'id' => trim($_POST['id']),
                'name' => trim($_POST['name']),
                'contact' => trim($_POST['contact']),
                'address' => trim($_POST['address']),
                'email' => trim($_POST['email']),
                'pin' => trim($_POST['pin']),
                'name_err' => '',
                'contact_err' => ''
            ];
            if (empty($data['name'])) {
                $data['name_err'] = 'Enter Company Name';
            }
            if (empty($data['contact'])) {
                $data['contact_err'] = 'Enter Contact';
            }
            if (empty($data['name_err']) && empty($data['contact_err'])) {
                // print_r($data);
                if ($this->companyModel->update($data)) {
                    redirect('dashboard');
                }
            }else{
                $this->view('companies/edit',$data);
            }
        }else{
            redirect('users');
        }
    }
}