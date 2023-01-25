<?php
class Dashboards {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function index()
    {
        $this->db->query('SELECT GetProductCount() as ProductCount,
                                 GetSalesValue() as SalesValue,
                                 TotalExpenses() as TotalExpenses,
                                 GetAmountOwed() as Balances;');
        return $this->db->single();
    }
    public function GetProducts()
    {
        $this->db->query('SELECT  ucase(p.ProductName) as ProductName,
                                  s.Qty,
                                  s.SellingValue
                          FROM    sales_details s inner join products p on s.ProductID=p.ID 
                          ORDER BY p.ID DESC LIMIT 10');
        return $this->db->resultSet();
    }
    public function GetCustomers()
    {
        $this->db->query('SELECT DISTINCT h.CustomerID,UCASE(c.CustomerName) AS CustomerName,TotalAmount
                          FROM sales_header h inner join customers c on h.CustomerID=c.ID
                          ORDER BY TotalAmount LIMIT 10;');
        return $this->db->resultSet();
    }
}