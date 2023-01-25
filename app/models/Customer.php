<?php
class Customer {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetCustomers()
    {
        $this->db->query('SELECT * FROM customers WHERE (Deleted = 0) AND (CompanyID=:cid)');
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function CheckExists($data)
    {
        $sql = 'SELECT COUNT(ID) FROM customers WHERE CustomerName = ? AND ID <> ? AND Deleted = 0';
        $arr = array();
        array_push($arr,trim(strtolower($data['name'])));
        array_push($arr,trim($data['id']));
        $results = checkExistsMod($this->db->dbh,$sql,$arr);
        if ($results > 0) {
            return false;
        }
        else {
            return true;
        }
    }
    public function create($data)
    {
        try {
            //begin transaction
            $this->db->dbh->beginTransaction();
            //queries
            $this->db->query('INSERT INTO customers (CustomerName,Contact,`Address`,Email,PIN,CompanyID)
                          VALUES (:cname,:cont,:addr,:email,:pin,:cid)');
            $this->db->bind(':cname',strtolower($data['name']));
            $this->db->bind(':cont',$data['contact']);
            $this->db->bind(':addr',!empty($data['address']) ? strtolower($data['address']) : NULL);
            $this->db->bind(':email',!empty($data['email']) ? $data['email'] : NULL);
            $this->db->bind(':pin',!empty($data['pin']) ? $data['pin'] : NULL);
            $this->db->bind(':cid',$_SESSION['cid']);
            $this->db->execute();
            $id = $this->db->dbh->lastInsertId();

            if ($data['openingbal'] > 0) {
                $this->db->query('INSERT INTO payments (PaymentDate,CustomerID,Debit,Narration,TransactionType,
                                              TransactionId,CompanyID)
                                  VALUES (:pdate,:customer,:debit,:narr,:ttype,:tid,:cid)');
                $this->db->bind(':pdate',date('Y-m-d'));
                $this->db->bind(':customer',$id);
                $this->db->bind(':debit',$data['openingbal']);
                $this->db->bind(':narr','Opening Balance');
                $this->db->bind(':ttype',3);
                $this->db->bind(':tid',$id);
                $this->db->bind(':cid',$_SESSION['cid']);
                $this->db->execute();
            }

            if ($this->db->dbh->commit()) {
                return true;
            }else{return false;}

        } catch (\Exception $e) {
            if ($this->db->dbh->inTransaction()) {
                $this->db->dbh->rollBack();
            }
            throw $e;
        }
    }
    public function GetCustomer($id)
    {
        $this->db->query('SELECT * FROM customers WHERE (ID=:id) AND (Deleted = 0)');
        $this->db->bind(':id',$id);
        return $this->db->single();
    }
    public function update($data)
    {
        $this->db->query('UPDATE customers SET CustomerName=:sname,Contact=:cont,`Address`=:addr
                                 ,Email=:email,PIN=:pin,Active=:active
                          WHERE  (ID = :id)');
        $this->db->bind(':sname',strtolower($data['name']));
        $this->db->bind(':cont',$data['contact']);
        $this->db->bind(':addr',!empty($data['address']) ? strtolower($data['address']) : NULL);
        $this->db->bind(':email',!empty($data['email']) ? $data['email'] : NULL);
        $this->db->bind(':pin',!empty($data['pin']) ? $data['pin'] : NULL);
        $this->db->bind(':active',$data['active']);
        $this->db->bind(':id',$data['id']);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function delete($id)
    {
        try {
            //begin transaction
            $this->db->dbh->beginTransaction();
            //queries
            $this->db->query('UPDATE customers SET Deleted = 1 WHERE ID= :id');
            $this->db->bind(':id',$id);
            $this->db->execute();
                     
            $this->db->query('DELETE FROM payments WHERE ID= :id');
            $this->db->bind(':id',$id);
            $this->db->execute();
            
            if ($this->db->dbh->commit()) {
                return true;
            }else{return false;}

        } catch (\Exception $e) {
            if ($this->db->dbh->inTransaction()) {
                $this->db->dbh->rollBack();
            }
            throw $e;
        }
    }
    public function CheckReferenced($id)
    {
        $this->db->query('SELECT COUNT(ID) As dbcount
                          FROM   sales_header 
                          WHERE  (CustomerID = :id)');
        $this->db->bind(':id',$id);
        $count = $this->db->getValue();
        if ((int)$count == 0) {
            return true;
        }else{
            return false;
        }
    }
}