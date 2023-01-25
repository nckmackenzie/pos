<?php
class Report {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetStockReport($data)
    {
        $this->db->query('CALL spStockReport(:start,:end)');
        $this->db->bind(':start',$data['start']);
        $this->db->bind(':end',$data['end']);
        return $this->db->resultSet();
    }
    public function GetSales($data)
    {
        $this->db->query('SELECT IFNULL(SUM(d.ProfitLoss),0) AS PL
                          FROM   sales_details d inner join sales_header h on d.HeaderID=h.ID
                          WHERE  (h.SaleDate BETWEEN :startd AND :endd)');
        $this->db->bind(':startd',$data['start']);
        $this->db->bind(':endd',$data['end']);
        return $this->db->getValue();
    }
    public function GetServices($data)
    {
        $this->db->query('SELECT IFNULL(SUM(Amount),0) AS PL
                          FROM   services
                          WHERE  (ServiceDate BETWEEN :startd AND :endd)');
        $this->db->bind(':startd',$data['start']);
        $this->db->bind(':endd',$data['end']);
        return $this->db->getValue();
    }
    public function GetExpenses($data)
    {
        $this->db->query('SELECT IFNULL(SUM(Amount),0) AS ExpenseTotal
                          FROM   expenses
                          WHERE  (ExpenseDate BETWEEN :startd AND :endd)');
        $this->db->bind(':startd',$data['start']);
        $this->db->bind(':endd',$data['end']);
        return $this->db->getValue();
    }
    public function GetCustomers()
    {
        $this->db->query('SELECT ID,UCASE(CustomerName) AS CustomerName 
                          FROM   customers
                          WHERE  Active=1 AND Deleted=0 AND CompanyID=:cid');
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function GetStatement($data)
    {
        $this->db->query("SELECT DATE_FORMAT(PaymentDate,'%d/%m/%Y') as PaymentDate,
                                 IF(Debit=0,'',Debit) AS Debit,
                                 IF(Credit=0,'',Credit) AS Credit,
                                 UCASE(Narration) As Narration
                          FROM   payments
                          WHERE  (CustomerID=:cid) AND (PaymentDate BETWEEN :startd AND :endd)
                          ORDER BY PaymentDate");
        $this->db->bind(':cid',$data['customer']);
        $this->db->bind(':startd',$data['start']);
        $this->db->bind(':endd',$data['end']);
        return $this->db->resultSet();
    }
    public function GetTotalDebits($data)
    {
        $this->db->query("SELECT IFNULL(SUM(Debit),0) AS Debit
                          FROM   payments
                          WHERE  (CustomerID=:cid) AND (PaymentDate BETWEEN :startd AND :endd)
                          ORDER BY PaymentDate");
        $this->db->bind(':cid',$data['customer']);
        $this->db->bind(':startd',$data['start']);
        $this->db->bind(':endd',$data['end']);
        return $this->db->getValue();
    }
    public function GetTotalCredits($data)
    {
        $this->db->query("SELECT IFNULL(SUM(Credit),0) AS Credit
                          FROM   payments
                          WHERE  (CustomerID=:cid) AND (PaymentDate BETWEEN :startd AND :endd)
                          ORDER BY PaymentDate");
        $this->db->bind(':cid',$data['customer']);
        $this->db->bind(':startd',$data['start']);
        $this->db->bind(':endd',$data['end']);
        return $this->db->getValue();
    }
}