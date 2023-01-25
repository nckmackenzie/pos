<?php

class Dashboard extends Controller {
    public function __construct()
    {
       if (!isset($_SESSION['uid'])) {
           redirect('users');
       }else{
           $this->dashboardModel = $this->model('Dashboards');
       }
    }

    public function index()
    {
        $header = $this->dashboardModel->index();
        $products = $this->dashboardModel->GetProducts();
        $customers = $this->dashboardModel->Getcustomers();
        $data = [
            'header' => $header,
            'products' => $products,
            'customers' => $customers
        ];
       
       $this->view('dashboard/index',$data);
    }

    public function about()
    {
        $this->view('pages/about');
    }
}