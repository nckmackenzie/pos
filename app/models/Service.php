<?php
class Service{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetServices()
    {
        $this->db->query('SELECT s.ID,
                                 UCASE(`Service`) As ServiceType,
                                 ServiceDate,
                                 UCASE(CustomerName) As Customer,
                                 Amount
                          FROM   services s inner join customers c on s.CustomerId=c.ID inner join servicetypes t
                                 on s.ServiceTypeId = t.ID
                          WHERE  (s.CompanyID = :cid)
                          ORDER BY s.ID');
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function GetCustomers()
    {
        $this->db->query('SELECT ID,UCASE(CustomerName) As CustomerName
                          FROM   customers
                          WHERE  (Active=1) AND (Deleted=0) AND (CompanyID=:cid)');
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function GetServiceTypes()
    {
        $this->db->query('SELECT * FROM servicetypes');
        return $this->db->resultSet();
    }
    public function create($data)
    {
        try {
            //start transaction
            $this->db->dbh->beginTransaction();

            //queries
            $this->db->query('INSERT INTO services (ServiceDate,ServiceTypeId,CustomerId,Amount,Narration,CompanyID)
                              VALUES (:sdate,:stype,:customer,:amount,:narr,:cid)');
            $this->db->bind(':sdate',$data['date']);
            $this->db->bind(':stype',$data['service']);
            $this->db->bind(':customer',$data['customer']);
            $this->db->bind(':amount',$data['amount']);
            $this->db->bind(':narr',strtolower($data['narration']));
            $this->db->bind(':cid',$_SESSION['cid']);
            $this->db->execute();
            $tid = $this->db->dbh->lastInsertId();

            $this->db->query('INSERT INTO payments (PaymentDate,CustomerID,Debit,Narration,TransactionType,
                                          TransactionId,CompanyID)
                              VALUES(:pdate,:customer,:debit,:narr,:ttype,:tid,:cid)');
            $this->db->bind(':pdate',$data['date']);
            $this->db->bind(':customer',$data['customer']);
            $this->db->bind(':debit',$data['amount']);
            $this->db->bind(':narr',"Service - " .strtolower($data['narration']));
            $this->db->bind(':ttype',3);
            $this->db->bind(':tid',$tid);
            $this->db->bind(':cid',$_SESSION['cid']);
            $this->db->execute();

            if ($data['paid'] > 0) {
                $this->db->query('INSERT INTO payments (PaymentDate,CustomerID,Credit,Narration,TransactionType,
                                          TransactionId,CompanyID)
                                  VALUES(:pdate,:customer,:credit,:narr,:ttype,:tid,:cid)');
                $this->db->bind(':pdate',$data['date']);
                $this->db->bind(':customer',$data['customer']);
                $this->db->bind(':credit',$data['amount']);
                $this->db->bind(':narr',"Payment " .strtolower($data['narration']));
                $this->db->bind(':ttype',3);
                $this->db->bind(':tid',$tid);
                $this->db->bind(':cid',$_SESSION['cid']);
                $this->db->execute();
            }

            if ($this->db->dbh->commit()) {
                return true;
            }else{
                return false;
            }
            
        } catch (\Exception $e) {
            if ($this->db->dbh->inTransaction()) {
                $this->db->dbh->rollBack();
            }
            throw $e;
        }
    }
    public function GetService($id)
    {
        $this->db->query('SELECT s.ID,
                                 ServiceDate,
                                 ServiceTypeId,
                                 CustomerId,
                                 Amount,
                                 GetAmountPaid_Single(s.ID) As Paid,
                                 Narration,
                                 CompanyID 
                          FROM `services` s
                          WHERE (s.ID=:id)');
        $this->db->bind(':id',trim($id));
        return $this->db->single();
    }
    public function update($data)
    {
        try {
            //start transaction
            $this->db->dbh->beginTransaction();

            //queries
            $this->db->query('UPDATE services SET ServiceDate=:sdate,ServiceTypeId=:stype,CustomerId=:customer,Amount=:amount,
                                                  Narration=:narr
                              WHERE  (ID=:id)');
            $this->db->bind(':sdate',$data['date']);
            $this->db->bind(':stype',$data['service']);
            $this->db->bind(':customer',$data['customer']);
            $this->db->bind(':amount',$data['amount']);
            $this->db->bind(':narr',strtolower($data['narration']));
            $this->db->bind(':id',$data['id']);
            $this->db->execute();
            
            $this->db->query('DELETE FROM payments WHERE (TransactionType = 3) AND (TransactionId = :id)');
            $this->db->bind(':id',$data['id']);
            $this->db->execute();

            $this->db->query('INSERT INTO payments (PaymentDate,CustomerID,Debit,Narration,TransactionType,
                                          TransactionId,CompanyID)
                              VALUES(:pdate,:customer,:debit,:narr,:ttype,:tid,:cid)');
            $this->db->bind(':pdate',$data['date']);
            $this->db->bind(':customer',$data['customer']);
            $this->db->bind(':debit',$data['amount']);
            $this->db->bind(':narr',"Service - " .strtolower($data['narration']));
            $this->db->bind(':ttype',3);
            $this->db->bind(':tid',$data['id']);
            $this->db->bind(':cid',$_SESSION['cid']);
            $this->db->execute();

            if ($data['paid'] > 0) {
                $this->db->query('INSERT INTO payments (PaymentDate,CustomerID,Credit,Narration,TransactionType,
                                          TransactionId,CompanyID)
                                  VALUES(:pdate,:customer,:credit,:narr,:ttype,:tid,:cid)');
                $this->db->bind(':pdate',$data['date']);
                $this->db->bind(':customer',$data['customer']);
                $this->db->bind(':credit',$data['amount']);
                $this->db->bind(':narr',"Payment " .strtolower($data['narration']));
                $this->db->bind(':ttype',3);
                $this->db->bind(':tid',$data['id']);
                $this->db->bind(':cid',$_SESSION['cid']);
                $this->db->execute();
            }

            if ($this->db->dbh->commit()) {
                return true;
            }else{
                return false;
            }
            
        } catch (\Exception $e) {
            if ($this->db->dbh->inTransaction()) {
                $this->db->dbh->rollBack();
            }
            throw $e;
        }
    }
    public function delete($id)
    {
        try {
            //start transaction
            $this->db->dbh->beginTransaction();

            //queries
            $this->db->query('DELETE FROM services
                              WHERE  (ID=:id)');
            $this->db->bind(':id',$id);
            $this->db->execute();
            
            $this->db->query('DELETE FROM payments WHERE (TransactionType = 3) AND (TransactionId = :id)');
            $this->db->bind(':id',$id);
            $this->db->execute();

            if ($this->db->dbh->commit()) {
                return true;
            }else{
                return false;
            }
            
        } catch (\Exception $e) {
            if ($this->db->dbh->inTransaction()) {
                $this->db->dbh->rollBack();
            }
            throw $e;
        }
    }
}