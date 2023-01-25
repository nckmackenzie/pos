<?php
class Services extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['uid'])) {
            redirect('users');
        }else{
            $this->servicesModel = $this->model('Service');
        }
    }
    public function index()
    {
        $services = $this->servicesModel->GetServices();
        $data = ['services' => $services];
        $this->view('services/index',$data);
    }
    public function add()
    {
        $customers = $this->servicesModel->GetCustomers();
        $services = $this->servicesModel->GetServiceTypes();
        $data = [
            'customers' => $customers,
            'services' => $services,
            'date' => '',
            'service' => '',
            'amount' => '',
            'paid' => '',
            'balance' => '',
            'narration' => '',
            'date_err' => '',
            'service_err' => '',
            'amount_err' => '',
            'narration_err' => '',
        ];
        $this->view('services/add',$data);
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $customers = $this->servicesModel->GetCustomers();
            $services = $this->servicesModel->GetServiceTypes();
            $data = [
                'customers' => $customers,
                'services' => $services,
                'date' => trim($_POST['date']),
                'service' => trim($_POST['service']),
                'customer' => trim($_POST['customer']),
                'amount' => trim($_POST['amount']),
                'paid' => trim($_POST['paid']),
                'balance' => trim($_POST['balance']),
                'narration' => trim($_POST['narration']),
                'date_err' => '',
                'service_err' => '',
                'customer_err' => '',
                'amount_err' => '',
                'narration_err' => ''
            ];
            //validation
            if (empty($data['date'])) {
                $data['date_err'] = 'Enter Date';
            }
            if (empty($data['service'])) {
                $data['service_err'] = 'Select Service';
            }
            if (empty($data['customer'])) {
                $data['customer_err'] = 'Select Customer';
            }
            if (empty($data['amount'])) {
                $data['amount_err'] = 'Enter Amount';
            }
            if (empty($data['narration'])) {
                $data['narration_err'] = 'Enter Service Description';
            }
            if ($data['balance'] < 0 ) {
                $data['amount_err'] = 'Service Charges Less Than Amount Paid';
            }

            if (empty($data['date_err']) && empty($data['service_err']) && empty($data['customer_err']) && 
                empty($data['amount_err']) && empty($data['narration_err'])) {
                if ($this->servicesModel->create($data)) {
                    flash('service_msg','Service Saved Successfully!');
                    redirect('services');
                }
            }else{
                $this->view('services/add',$data);
            }
        }else{
            redirect('services');
        }
    }
    public function edit($id)
    {
        $service = $this->servicesModel->GetService($id);
        $customers = $this->servicesModel->GetCustomers();
        $services = $this->servicesModel->GetServiceTypes();
        $data = [
            'customers' => $customers,
            'services' => $services,
            'service' => $service,
            'date' => '',
            'sservice' => '',
            'customer' => '',
            'amount' => '',
            'paid' => '',
            'balance' => ($service->Amount) - ($service->Paid),
            'narration' => '',
            'date_err' => '',
            'service_err' => '',
            'amount_err' => '',
            'narration_err' => '',
        ];
        $this->view('services/edit',$data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $customers = $this->servicesModel->GetCustomers();
            $services = $this->servicesModel->GetServiceTypes();
            $data = [
                'customers' => $customers,
                'services' => $services,
                'date' => trim($_POST['date']),
                'service' => trim($_POST['service']),
                'customer' => trim($_POST['customer']),
                'amount' => trim($_POST['amount']),
                'paid' => trim($_POST['paid']),
                'balance' => trim($_POST['balance']),
                'narration' => trim($_POST['narration']),
                'id' => trim($_POST['id']),
                'date_err' => '',
                'service_err' => '',
                'customer_err' => '',
                'amount_err' => '',
                'narration_err' => ''
            ];
            //validation
            if (empty($data['date'])) {
                $data['date_err'] = 'Enter Date';
            }
            if (empty($data['service'])) {
                $data['service_err'] = 'Select Service';
            }
            if (empty($data['customer'])) {
                $data['customer_err'] = 'Select Customer';
            }
            if (empty($data['amount'])) {
                $data['amount_err'] = 'Enter Amount';
            }
            if (empty($data['narration'])) {
                $data['narration_err'] = 'Enter Service Description';
            }
            if ($data['balance'] < 0 ) {
                $data['amount_err'] = 'Service Charges Less Than Amount Paid';
            }

            if (empty($data['date_err']) && empty($data['service_err']) && empty($data['customer_err']) && 
                empty($data['amount_err']) && empty($data['narration_err'])) {
                if ($this->servicesModel->update($data)) {
                    flash('service_msg','Service Updated Successfully!');
                    redirect('services');
                }
            }else{
                $this->view('services/add',$data);
            }
        }else{
            redirect('services');
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $id = trim($_POST['id']);
            if ($this->servicesModel->delete($id)) {
                flash('service_msg','Service Deleted Successfully!');
                redirect('services');
            }

        }else{
            redirect('services');
        }
    }
}