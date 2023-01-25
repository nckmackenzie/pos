<?php
class Expenses extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['uid']) || $_SESSION['utype'] != 1) {
            redirect('users');
        }else{
            $this->expenseModel = $this->model('Expense');
        }
    }
    public function index()
    {
        $expenses = $this->expenseModel->GetExpenses();
        $data = ['expenses' => $expenses];
        $this->view('expenses/index',$data);
    }
    public function add()
    {
        $data = [
            'date' => '',
            'amount' => '',
            'desc' => '',
            'date_err' => '',
            'amount_err' => '',
            'desc_err' => ''
        ];
        $this->view('expenses/add',$data);
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'date' => trim($_POST['date']),
                'amount' => trim($_POST['amount']),
                'desc' => trim($_POST['desc']),
                'date_err' => '',
                'amount_err' => '',
                'desc_err' => ''
            ];
            //validation
            if (empty($data['date'])) {
                $data['date_err'] = 'Select Date';
            }else{
                if ($data['date'] > date('Y-m-d')) {
                    $data['date_err'] = 'Payment Date Cannot Be Later Than Today';
                }
            }
            if (empty($data['amount'])) {
                $data['amount_err'] = 'Enter Expense Amount';
            }
            if (empty($data['desc'])) {
                $data['desc_err'] = 'Enter Expense Description';
            }
            //end of validation
            if (empty($data['date_err']) && empty($data['amount_err']) && empty($data['desc_err'])) {
                //save
                if ($this->expenseModel->create($data)) {
                    flash('expense_msg','Expense Added Successfully');
                    redirect('expenses');
                }
            }else{
                $this->view('expenses/add',$data);
            }
        }
    }
    public function edit($id)
    {
        $expense = $this->expenseModel->GetExpense($id);
        $data = ['expense' => $expense];
        $this->view('expenses/edit',$data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'date' => trim($_POST['date']),
                'amount' => trim($_POST['amount']),
                'desc' => trim($_POST['desc']),
                'id' => trim($_POST['id']),
                'date_err' => '',
                'amount_err' => '',
                'desc_err' => ''
            ];
            //validation
            if (empty($data['date'])) {
                $data['date_err'] = 'Select Date';
            }else{
                if ($data['date'] > date('Y-m-d')) {
                    $data['date_err'] = 'Payment Date Cannot Be Later Than Today';
                }
            }
            if (empty($data['amount'])) {
                $data['amount_err'] = 'Enter Expense Amount';
            }
            if (empty($data['desc'])) {
                $data['desc_err'] = 'Enter Expense Description';
            }
            //end of validation
            if (empty($data['date_err']) && empty($data['amount_err']) && empty($data['desc_err'])) {
                //save
                if ($this->expenseModel->update($data)) {
                    flash('expense_msg','Expense Updated Successfully');
                    redirect('expenses');
                }
            }else{
                $this->view('expenses/edit',$data);
            }
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $id = trim($_POST['id']);
            if ($this->expenseModel->delete($id)) {
                    flash('expense_msg','Expense Deleted Successfully');
                    redirect('expenses');
            }
        }
    }
}