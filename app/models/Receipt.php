<?php
class Receipt{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetReceipts()
    {
        $this->db->query("SELECT  DISTINCT h.ID,
                                  h.Reference,
                                  DATE_FORMAT(h.ReceiptDate,'%d/%m/%Y') As ReceiptDate,
                                  ucase(s.SupplierName) As Supplier,
                                  (SELECT IFNULL(SUM(`Value`),0) As totalValue 
                                   FROM receipts_details 
                                   WHERE ReceiptID=h.ID) As rvalue
                          FROM    receipts_header h inner join receipts_details d on h.ID=d.ReceiptID
                                  inner join suppliers s on h.SupplierID=s.ID
                          WHERE   (h.CompanyID = :cid)
                          ORDER BY h.ID DESC");
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function GetCategories()
    {
        $this->db->query('SELECT ID,UCASE(CategoryName) As CategoryName 
                          FROM   categories
                          WHERE  Active = 1 AND Deleted = 0');
        return $this->db->resultSet();
    }
    public function GetSuppliers()
    {
        $this->db->query('SELECT ID,UCASE(SupplierName) As SupplierName 
                          FROM   suppliers
                          WHERE  Active = 1 AND Deleted = 0');
        return $this->db->resultSet();
    }
    public function GetProductsByCategory($id)
    {
        $this->db->query('SELECT ID,UCASE(ProductName) As ProductName FROM products WHERE CategoryID=:id');
        $this->db->bind(':id',$id);
        return $this->db->resultSet();
    }
    public function GetProductsRate($id)
    {
        $this->db->query('SELECT BuyingPrice FROM products WHERE ID=:id');
        $this->db->bind(':id',$id);
        return $this->db->getValue();
    }
    public function GetReference()
    {
        $this->db->query('SELECT COUNT(ID) AS dbcount
                          FROM   receipts_header
                          WHERE  (CompanyID = :cid)');
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->getValue() + 1;
    }
    public function create($data)
    {
        try {
            $this->db->dbh->beginTransaction();
            //queries
            $this->db->query('INSERT INTO receipts_header (ReceiptDate,SupplierID,Reference,CompanyID)
                              VALUES (:rdate,:supp,:ref,:cid)');
            $this->db->bind(':rdate',$data['date']);
            $this->db->bind(':supp',$data['supplier']);
            $this->db->bind(':ref',$data['ref']);
            $this->db->bind(':cid',$_SESSION['cid']);
            $this->db->execute();
            $id = $this->db->dbh->lastInsertId();

            for ($i=0; $i < count($data['product']); $i++) { 
                $this->db->query('INSERT INTO receipts_details (ReceiptID,CategoryID,ProductID,Qty,Rate,
                                              `Value`)
                                  VALUES (:rid,:cid,:pid,:qty,:rate,:val)');
                $this->db->bind(':rid',$id);
                $this->db->bind(':cid',$data['category'][$i]);
                $this->db->bind(':pid',$data['product'][$i]);
                $this->db->bind(':qty',$data['qty'][$i]);
                $this->db->bind(':rate',$data['rate'][$i]);
                $this->db->bind(':val',$data['rate'][$i] * $data['qty'][$i]);
                $this->db->execute();

                $this->db->query('INSERT INTO stock_movement (ProductID,TransactionDate,Qty,Received,
                                              SupplierID,Reference,TransactionType,CompanyID)
                                  VALUES (:pid,:tdate,:qty,:rec,:supp,:ref,:ttype,:cid)');
                $this->db->bind(':pid',$data['product'][$i]);
                $this->db->bind(':tdate',$data['date']);
                $this->db->bind(':qty',$data['qty'][$i]);
                $this->db->bind(':rec',1);
                $this->db->bind(':supp',$data['supplier']);
                $this->db->bind(':ref',$data['ref']);
                $this->db->bind(':ttype',1);
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
    public function GetReceiptsHeader($id)
    {
        $this->db->query('SELECT * FROM receipts_header WHERE ID = :id');
        $this->db->bind(':id',$id);
        return $this->db->single();
    }
}