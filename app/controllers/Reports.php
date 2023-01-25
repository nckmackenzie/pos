<?php
class Reports extends Controller 
{
    public function __construct()
    {
        if (!isset($_SESSION['uid'])) {
            redirect('users');
        }else {
            $this->reportModel = $this->model('Report');
        }
    }
    public function index()
    {
        $data = [];
        $this->view('reports/index',$data);
    }
    public function stock()
    {
        $data = [];
        $this->view('reports/stock',$data);
    }
    public function stockreport()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $_GET = filter_input_array(INPUT_GET,FILTER_SANITIZE_STRING);
            $data = [
                'start' => trim($_GET['start']),
                'end' => trim($_GET['end'])
            ];
            $products = $this->reportModel->GetStockReport($data);
            $output = '';
            $output .= '
                <table class="table table-bordered table-sm" id="table">
                    <thead class="bg-lightblue"
                        <tr>
                            <th>Product Name</th>
                            <th width="20%">Opening Balance</th>
                            <th width="10%">Receipts</th>
                            <th width="10%">Sales</th>
                            <th width="20%">Balance</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($products as $product ) {
                        $output .= '
                            <tr>
                                <td>'.$product->ProductName.'</td>
                                <td>'.$product->OpeningBal.'</td>
                                <td>'.$product->Receipts.'</td>
                                <td>'.$product->Sales.'</td>
                                <td>'.$product->CurrentBalance.'</td>
                            </tr>
                        ';
                    }
            $output .='
                    </tbody>
                </table>';
            echo $output;
        }
    }
    public function incomestatement()
    {
        $data = [];
        $this->view('reports/incomestatement',$data);
    }
    public function incomestatementrpt()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $_GET = filter_input_array(INPUT_GET,FILTER_SANITIZE_STRING);
            $data = [
                'start' => trim($_GET['start']),
                'end' => trim($_GET['end'])
            ];
            $sales = $this->reportModel->GetSales($data);
            $services = $this->reportModel->GetServices($data);
            $expenses = $this->reportModel->GetExpenses($data);
            $profitLoss = ($sales + $services) - $expenses;
            $output = '';
            $output .= '
                    <table class="table table-bordered table-sm" id="table">
                        <thead class="bg-lightblue"
                            <tr>
                                <th colspan="2">Income Statement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-olive">
                                <td colspan="2">Income</td>
                            </tr>
                            <tr>
                                <td style="padding-left: 30px;">Sales</td>
                                <td>'.number_format($sales,2).'</td>
                            </tr>
                            <tr>
                                <td style="padding-left: 30px;">Services</td>
                                <td>'.number_format($services,2).'</td>
                            </tr>
                            <tr style="background-color: #abebbc;">
                                <td style="font-weight: 700;">Total Income</td>
                                <td style="font-weight: 700;">'.number_format(($sales + $services),2).'</td>
                            </tr>
                            <tr style="background-color: #e85858; color: #fff;">
                                <td colspan="2">Expenses</td>
                            </tr>
                            <tr>
                                <td style="padding-left: 30px;">Expenses</td>
                                <td>'.number_format($expenses,2).'</td>
                            </tr>
                            <tr style="background-color: #f59595;">
                                <td style="font-weight: 700;">Total Expense</td>
                                <td style="font-weight: 700;">'.number_format($expenses,2).'</td>
                            </tr>
                            <tr style="background-color: #39cccc;">
                                <td style="font-weight: 700;">NET EARNINGS</td>
                                <td style="font-weight: 700;">'.number_format($profitLoss,2).'</td>
                            </tr>
                        </tbody>
                    </table>';
                echo $output;
        }else{
            redirect('users');
        }
    }
    public function statement()
    {
        $customers = $this->reportModel->GetCustomers();
        $data = ['customers'=>$customers];
        $this->view('reports/statement',$data);
    }
    public function statementrpt()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $_GET = filter_input_array(INPUT_GET,FILTER_SANITIZE_STRING);
            $data = [
                'customer' => trim($_GET['customer']),
                'start' => trim($_GET['start']),
                'end' => trim($_GET['end'])
            ];
            $payments = $this->reportModel->GetStatement($data);
            $debits = $this->reportModel->GetTotalDebits($data); //added
            $credits = $this->reportModel->GetTotalCredits($data); //added
            $balance = floatval($debits) - floatval($credits);
            $output = '';
            $output .= '
                    <table class="table table-bordered table-sm" id="table">
                        <thead class="bg-lightblue"
                            <tr>
                                <th>Transaction Date</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Narration</th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach ($payments as $payment) {
                                $output .= '
                                <tr>
                                    <td>'.$payment->PaymentDate.'</td>
                                    <td>'.number_format(floatval($payment->Debit),2).'</td>
                                    <td>'.number_format(floatval($payment->Credit),2).'</td>
                                    <td>'.$payment->Narration.'</td>
                                </tr>';
                            }
                        $output .='    
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="text-align:right">Total:</th>
                                <th id="debittotal"></th>
                                <th id="credittotal"></th>
                                <th>Balance: '.number_format(floatval($balance)).'</th> 
                            </tr>
                        </tfoot>
                    </table>';
                echo $output;
        }else{
            redirect('users');
        }
    }
}