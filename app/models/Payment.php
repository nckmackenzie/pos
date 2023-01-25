<?php
class Payment {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetPayments()
    {
        $this->db->query("SELECT p.ID,
                                 DATE_FORMAT(PaymentDate,'%d/%m/%Y') AS PaymentDate,
                                 ucase(c.CustomerName) As CustomerName,
                                 Credit As Amount,
                                 PaymentReference
                          FROM   payments p inner join customers c on p.CustomerID=c.ID
                          WHERE  (p.CompanyID=:cid) AND (TransactionType = 2);
                          ORDER BY p.ID");
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function GetCustomers()
    {
        $this->db->query('SELECT ID,UCASE(CustomerName) As CustomerName
                          FROM   customers
                          WHERE  Active=1 AND Deleted=0 AND CompanyID=:cid');
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function GetPaymethods()
    {
        $this->db->query('SELECT ID,UCASE(PaymentMethod) As PaymentMethod
                          FROM   paymethods');
        return $this->db->resultSet();
    }
    public function GetBalance($id)
    {
        $this->db->query('SELECT GetCustomerBalance(:id) As Balance');
        $this->db->bind(':id',$id);
        return $this->db->getValue();
    }
    public function create($data)
    {
        $this->db->query('INSERT INTO payments (PaymentDate,CustomerID,Credit,Narration,PaymentId,
                                      PaymentReference,TransactionType,CompanyID)
                          VALUES(:pdate,:customer,:credit,:narr,:pid,:ref,:ttype,:cid)');
        $this->db->bind(':pdate',$data['date']);
        $this->db->bind(':customer',$data['customer']);
        $this->db->bind(':credit',$data['amount']);
        $this->db->bind(':narr',!empty($data['description']) ? strtolower($data['description']) : NUll);
        $this->db->bind(':pid',$data['paymethod']);
        $this->db->bind(':ref',strtolower($data['ref']));
        $this->db->bind(':ttype',2);
        $this->db->bind(':cid',$_SESSION['cid']);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function GetPayment($id)
    {
        $this->db->query('SELECT * FROM payments WHERE (ID=:id)');
        $this->db->bind(':id',$id);
        return $this->db->single();
    }
    public function update($data)
    {
        $this->db->query('UPDATE payments SET PaymentDate=:pdate,CustomerID=:customer,Credit=:credit,
                                              Narration=:narr,PaymentId=:pid,PaymentReference=:ref
                          WHERE (ID = :id)');
        $this->db->bind(':pdate',$data['date']);
        $this->db->bind(':customer',$data['customer']);
        $this->db->bind(':credit',$data['amount']);
        $this->db->bind(':narr',!empty($data['description']) ? strtolower($data['description']) : NUll);
        $this->db->bind(':pid',$data['paymethod']);
        $this->db->bind(':ref',strtolower($data['ref']));
        $this->db->bind(':id',$data['id']);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function delete($id)
    {
        $this->db->query('DELETE FROM payments WHERE ID=:id');
        $this->db->bind(':id',$id);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
}