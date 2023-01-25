<?php
class Expense {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetExpenses()
    {
        $this->db->query("SELECT  ID,
                                  DATE_FORMAT(ExpenseDate,'%d/%m/%Y') AS ExpenseDate,
                                  `Description`, 
                                  Amount
                          FROM expenses WHERE CompanyID=:cid");
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function create($data)
    {
        $this->db->query('INSERT INTO expenses (ExpenseDate,`Description`,Amount,CompanyID)
                          VALUES (:edate,:descr,:amount,:cid)');
        $this->db->bind(':edate',$data['date']);
        $this->db->bind(':descr',strtolower($data['desc']));
        $this->db->bind(':amount',$data['amount']);
        $this->db->bind(':cid',$_SESSION['cid']);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function GetExpense($id)
    {
        $this->db->query('SELECT * FROM expenses WHERE ID=:id');
        $this->db->bind(':id',$id);
        return $this->db->single();
    }
    public function update($data)
    {
        $this->db->query('UPDATE expenses SET ExpenseDate=:edate,`Description`=:descr,Amount=:amount
                          WHERE (ID=:id)');
        $this->db->bind(':edate',$data['date']);
        $this->db->bind(':descr',strtolower($data['desc']));
        $this->db->bind(':amount',$data['amount']);
        $this->db->bind(':id',$data['id']);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function delete($id)
    {
        $this->db->query('DELETE FROM expenses 
                          WHERE (ID=:id)');
        $this->db->bind(':id',$id);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
}