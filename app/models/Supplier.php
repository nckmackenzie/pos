<?php
class Supplier {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetSuppliers()
    {
        $this->db->query('SELECT * FROM suppliers WHERE (Deleted = 0)');
        return $this->db->resultSet();
    }
    public function CheckExists($data)
    {
        $sql = 'SELECT COUNT(ID) FROM suppliers WHERE SupplierName = ? AND ID <> ? AND Deleted = 0';
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
        $this->db->query('INSERT INTO suppliers (SupplierName,Contact,`Address`,Email,PIN)
                          VALUES (:sname,:cont,:addr,:email,:pin)');
        $this->db->bind(':sname',strtolower($data['name']));
        $this->db->bind(':cont',$data['contact']);
        $this->db->bind(':addr',!empty($data['address']) ? strtolower($data['address']) : NULL);
        $this->db->bind(':email',!empty($data['email']) ? $data['email'] : NULL);
        $this->db->bind(':pin',!empty($data['pin']) ? $data['pin'] : NULL);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function GetSupplier($id)
    {
        $this->db->query('SELECT * FROM suppliers WHERE (ID=:id) AND (Deleted = 0)');
        $this->db->bind(':id',$id);
        return $this->db->single();
    }
    public function update($data)
    {
        $this->db->query('UPDATE suppliers SET SupplierName=:sname,Contact=:cont,`Address`=:addr
                                 ,Email=:email,PIN=:pin
                          WHERE  (ID = :id)');
        $this->db->bind(':sname',strtolower($data['name']));
        $this->db->bind(':cont',$data['contact']);
        $this->db->bind(':addr',!empty($data['address']) ? strtolower($data['address']) : NULL);
        $this->db->bind(':email',!empty($data['email']) ? $data['email'] : NULL);
        $this->db->bind(':pin',!empty($data['pin']) ? $data['pin'] : NULL);
        $this->db->bind(':id',$data['id']);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function delete($id)
    {
        $this->db->query('UPDATE suppliers SET Deleted = 1 WHERE ID= :id');
        $this->db->bind(':id',$id);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function CheckReferenced($id)
    {
        $this->db->query('SELECT COUNT(ID) As dbcount
                          FROM   stock_movement 
                          WHERE  (SupplierID = :id)');
        $this->db->bind(':id',$id);
        $count = $this->db->getValue();
        if ((int)$count == 0) {
            return true;
        }else{
            return false;
        }
    }
}