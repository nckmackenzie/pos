<?php
class Product{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetProducts()
    {
        $this->db->query('SELECT p.ID AS ID,
                                 ucase(ProductName) As ProductName,
                                 ucase(CategoryName) As Category,
                                 FORMAT(BuyingPrice,2) AS BuyingPrice,
                                 FORMAT(SellingPrice,2) AS SellingPrice,
                                 GetCurrentStock(p.ID) As CurrentStock,
                                 p.Active
                          FROM   products p inner join categories c on p.CategoryID = c.ID
                          WHERE  (p.deleted = 0) AND (CompanyID = :cid)');
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function CheckExists($data)
    {
        $sql = 'SELECT COUNT(ID) FROM products WHERE ProductName = ? AND ID <> ? AND Deleted = 0';
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
    public function GetCategories()
    {
        $this->db->query('SELECT ID,UCASE(CategoryName) As CategoryName
                          FROM categories WHERE (deleted = 0) AND (Active = 1)');
        return $this->db->resultSet();
    }
    public function create($data)
    {
        try {
            $this->db->dbh->beginTransaction();

            $this->db->query('INSERT INTO products (ProductName,CategoryID,BuyingPrice,SellingPrice,
                                      `Description`,CompanyID)
                              VALUES(:pname,:cat,:bp,:sp,:descr,:cid)');
            $this->db->bind(':pname',strtolower(($data['name'])));
            $this->db->bind(':cat',$data['category']);
            $this->db->bind(':bp',$data['bp']);
            $this->db->bind(':sp',$data['sp']);
            $this->db->bind(':descr',!empty($data['description']) ? $data['description'] : NULL);
            $this->db->bind(':cid',$_SESSION['cid']);
            $this->db->execute();
            $pid = $this->db->dbh->lastInsertId();
            if ((int)$data['bal'] > 0) {
                $this->db->query('INSERT INTO stock_movement (ProductID,TransactionDate,Qty,TransactionType,
                                              InitialCreation,CompanyID)
                                  VALUES (:pid,:tdate,:qty,:ttype,:initial,:cid)');
                $this->db->bind(':pid',$pid);
                $this->db->bind(':tdate',date('Y-m-d'));
                $this->db->bind(':qty',$data['bal']);
                $this->db->bind(':ttype',1);
                $this->db->bind(':initial',1);
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
    public function GetProduct($id)
    {
        $this->db->query('SELECT * FROM products WHERE ID=:id AND Deleted = 0');
        $this->db->bind(':id',$id);
        return $this->db->single();
    }
    public function CheckIsInital($id)
    {
        $this->db->query('SELECT COUNT(ID) As dbcount
                          FROM stock_movement 
                          WHERE (ProductID = :id) AND (InitialCreation = 0)');
        $this->db->bind(':id',$id);
        $count = $this->db->getValue();
        if ((int)$count == 0) {
            return true;
        }else{
            return false;
        }
    }
    public function GetOpeningBal($id)
    {
        $this->db->query('SELECT Qty FROM stock_movement WHERE ProductID = :id AND InitialCreation = 1');
        $this->db->bind(':id',$id);
        return $this->db->getValue();
    }
    public function update($data)
    {
        try {
            $this->db->dbh->beginTransaction();

            $this->db->query('UPDATE products SET ProductName=:pname,CategoryID=:cat,BuyingPrice=:bp,
                                     SellingPrice=:sp,`Description`=:descr
                              WHERE  (ID = :id)');
            $this->db->bind(':pname',strtolower(($data['name'])));
            $this->db->bind(':cat',$data['category']);
            $this->db->bind(':bp',$data['bp']);
            $this->db->bind(':sp',$data['sp']);
            $this->db->bind(':descr',!empty($data['description']) ? $data['description'] : NULL);
            $this->db->bind(':id',$data['id']);
            $this->db->execute();
            
            if ((int)$data['bal'] > 0) {
                $this->db->query('UPDATE stock_movement SET Qty=:qty
                                  WHERE  (ProductID = :pid) AND (InitialCreation = 1)');
                $this->db->bind(':qty',$data['bal']);
                $this->db->bind(':pid',$data['id']);
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
        $this->db->query('UPDATE products SET Deleted = 1 WHERE ID= :id');
        $this->db->bind(':id',$id);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
}