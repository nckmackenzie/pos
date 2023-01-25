<?php
class Sale
{
    private $db;
    public function __construct()
    {
        $this->db =  new Database;
    }
    public function GetProducts()
    {
        $this->db->query('SELECT ID,UCASE(ProductName) As ProductName
                          FROM products WHERE (deleted = 0) AND (Active = 1) AND (CompanyID=:id)');
        $this->db->bind(':id',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function GetCustomers()
    {
        $this->db->query('SELECT ID,UCASE(CustomerName) AS CustomerName 
                          FROM customers
                          WHERE (Active=1) AND (Deleted = 0) AND (CompanyID=:cid)');
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function GetProductsByCategory($id)
    {
        $this->db->query('SELECT ID,UCASE(ProductName) As ProductName FROM products WHERE CategoryID=:id');
        $this->db->bind(':id',$id);
        return $this->db->resultSet();
    }
    public function GetProductsDetails($id)
    {
        $this->db->query('SELECT GetCurrentStock(p.ID) As stock,SellingPrice FROM products p WHERE ID=:id');
        $this->db->bind(':id',$id);
        return $this->db->fetch();
    }
    public function GetID()
    {
        $this->db->query('SELECT COUNT(ID) FROM sales_header WHERE CompanyID=:id');
        $this->db->bind(':id',$_SESSION['cid']);
        return $this->db->getValue() + 1;
    }
    public function GetBuyingPrice($id)
    {
        $this->db->query('SELECT BuyingPrice FROM products WHERE ID=:id');
        $this->db->bind(':id',$id);
        return $this->db->getValue();
    }
    public function GetProductName($id) //to be added
    {
        $this->db->query('SELECT ProductName FROM products WHERE ID=:id');
        $this->db->bind(':id',$id);
        return $this->db->getValue();
    }
    public function create($data)
    {
        try {
            $this->db->dbh->beginTransaction();
            $products_arr = array(); //to be added

            //queries
            $this->db->query('INSERT INTO sales_header(SalesID,SaleDate,CustomerID,SubTotal,Discount,TotalAmount,
                                          AmountPaid,CompanyID)
                              VALUES (:saleid,:sdate,:customer,:sub,:disc,:amount,:paid,:cid)');
            $this->db->bind(':saleid',$data['saleid']);
            $this->db->bind(':sdate',$data['sdate']);
            $this->db->bind(':customer',$data['customer']);
            $this->db->bind(':sub',$data['subtotal']);
            $this->db->bind(':disc',!empty($data['discount']) ? $data['discount'] : 0);
            $this->db->bind(':amount',$data['total']);
            $this->db->bind(':paid',!empty($data['paid']) ? $data['paid'] : 0);
            $this->db->bind(':cid',$_SESSION['cid']);
            $this->db->execute();
            $id = $this->db->dbh->lastInsertId();

            
            for ($i=0; $i < count($data['product']); $i++) {
                $sellingprice = $this->GetBuyingPrice($data['product'][$i]);
                $productName = $this->GetProductName($data['product'][$i]); //to be added
                array_push($products_arr,$productName); //to be added

                $this->db->query('INSERT INTO sales_details (HeaderID,ProductID,Qty,BuyingValue,
                                              SellingValue)
                                  VALUES (:hid,:pid,:qty,:bp,:val)');
                $this->db->bind(':hid',$id);
                $this->db->bind(':pid',$data['product'][$i]);
                $this->db->bind(':qty',$data['qty'][$i]);
                $this->db->bind(':bp',$sellingprice * $data['qty'][$i]);
                $this->db->bind(':val',$data['rate'][$i] * $data['qty'][$i]);
                $this->db->execute();

                $this->db->query('INSERT INTO stock_movement (ProductID,TransactionDate,Qty,
                                              SalesId,TransactionType,CompanyID)
                                  VALUES (:pid,:tdate,:qty,:saleid,:ttype,:cid)');
                $this->db->bind(':pid',$data['product'][$i]);
                $this->db->bind(':tdate',$data['sdate']);
                $this->db->bind(':qty',$data['qty'][$i]);
                $this->db->bind(':saleid',$id);
                $this->db->bind(':ttype',2);
                $this->db->bind(':cid',$_SESSION['cid']);
                $this->db->execute();

            }

            $products_separated = implode(",",$products_arr); //add this
            //move this part
            $this->db->query('INSERT INTO payments (PaymentDate,CustomerID,Debit,Narration,
                                          TransactionType,TransactionId,CompanyID)
                              VALUES(:pdate,:customer,:debit,:narr,:ttype,:tid,:cid)');
            $this->db->bind(':pdate',$data['sdate']);
            $this->db->bind(':customer',$data['customer']);
            $this->db->bind(':debit',$data['total']);
            $this->db->bind(':narr',$products_separated); //add this
            $this->db->bind(':ttype',1);
            $this->db->bind(':tid',$id);
            $this->db->bind(':cid',$_SESSION['cid']);
            $this->db->execute();

            if ($data['paid'] > 0) {
                $this->db->query('INSERT INTO payments (PaymentDate,CustomerID,Credit,Narration,
                                          TransactionType,TransactionId,CompanyID)
                                  VALUES(:pdate,:customer,:credit,:narr,:ttype,:tid,:cid)');
                $this->db->bind(':pdate',$data['sdate']);
                $this->db->bind(':customer',$data['customer']);
                $this->db->bind(':credit',$data['paid']);
                $this->db->bind(':narr','Purchases Payment');
                $this->db->bind(':ttype',1);
                $this->db->bind(':tid',$id);
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
    public function GetSales()
    {
        $this->db->query("SELECT h.ID,
                                 SalesID,
                                 DATE_FORMAT(SaleDate, '%d/%m/%Y') As SaleDate,
                                 ucase(c.CustomerName) as CustomerName,
                                 (SELECT IFNULL(SUM(SellingValue),0) FROM sales_details WHERE HeaderID=h.ID) As SaleValue,
                                 h.AmountPaid
                          FROM sales_header h inner join customers c on h.CustomerID=c.ID
                          WHERE h.CompanyID = :cid
                          ORDER BY h.ID DESC");
        $this->db->bind(':cid',$_SESSION['cid']);
        return $this->db->resultSet();
    }
    public function GetCompanyInfo($id)
    {
        $this->db->query('SELECT * FROM company WHERE ID=:id');
        $this->db->bind(':id',$_SESSION['cid']);
        return $this->db->single();
    }
    public function SaleHeader($id)
    {
        $this->db->query("SELECT SalesID,
                                 DATE_FORMAT(SaleDate, '%d/%m/%Y') As SaleDate,
                                 CustomerID,
                                 UCASE(CustomerName) As CustomerName,
                                 SubTotal,
                                 (SubTotal - TotalAmount) As DiscountedAmount,
                                 TotalAmount,
                                 AmountPaid,
                                 Balance
                          FROM   sales_header h inner join customers c on h.CustomerID = c.ID
                          WHERE  (h.ID=:id)");
        $this->db->bind(':id',$id);
        return $this->db->single();
    }
    public function CustomerInfo($id)
    {
        $this->db->query('SELECT * FROM customers WHERE ID=:id');
        $this->db->bind(':id',$id);
        return $this->db->single();
    }
    public function GetSalesDetails($id)
    {
        $this->db->query("SELECT UCASE(ProductName) AS ProductName,
                                 Qty,
                                 FORMAT((SellingValue / Qty),'N') As Rate,
                                 SellingValue
                          FROM   sales_details d inner join products p on d.ProductID=p.ID
                          WHERE  (d.HeaderID=:id)");
        $this->db->bind(':id',$id);
        return $this->db->resultSet();
    }
    public function GetSale($id)
    {
        $this->db->query('SELECT * FROM sales_header WHERE (ID=:id)');
        $this->db->bind(':id',$id);
        return $this->db->single();
    }
    public function GetSaleDetails($id)
    {
        $this->db->query("SELECT ProductID,
                                 Qty,
                                 FORMAT((SellingValue / Qty),'N2') As Rate,
                                 (GetCurrentStock(d.ProductID) + qty) As Stock,
                                 SellingValue
                          FROM sales_details d WHERE (HeaderID=:id)");
        $this->db->bind(':id',$id);
        return $this->db->resultSet();
    }
    public function update($data)
    {
        try {
            $this->db->dbh->beginTransaction();
            //queries
            $this->db->query('UPDATE sales_header SET SaleDate=:sdate,CustomerID=:customer,SubTotal=:sub,Discount=:disc,
                                                      TotalAmount=:amount,AmountPaid=:paid
                              WHERE  (ID=:id)');
            $this->db->bind(':sdate',$data['sdate']);
            $this->db->bind(':customer',$data['customer']);
            $this->db->bind(':sub',$data['subtotal']);
            $this->db->bind(':disc',!empty($data['discount']) ? $data['discount'] : 0);
            $this->db->bind(':amount',$data['total']);
            $this->db->bind(':paid',!empty($data['paid']) ? $data['paid'] : 0);
            $this->db->bind(':id',$data['id']);
            $this->db->execute();
            
            $this->db->query('DELETE FROM sales_details WHERE HeaderID = :id');
            $this->db->bind(':id',$data['id']);
            $this->db->execute();

            $this->db->query('DELETE FROM stock_movement WHERE SalesId = :id');
            $this->db->bind(':id',$data['id']);
            $this->db->execute();

            $this->db->query('DELETE FROM payments WHERE TransactionType = 1 AND TransactionType = :id');
            $this->db->bind(':id',$data['id']);
            $this->db->execute();

            $this->db->query('INSERT INTO payments (PaymentDate,CustomerID,Debit,Narration,
                                          TransactionType,TransactionId,CompanyID)
                              VALUES(:pdate,:customer,:debit,:narr,:ttype,:tid,:cid)');
            $this->db->bind(':pdate',$data['sdate']);
            $this->db->bind(':customer',$data['customer']);
            $this->db->bind(':debit',$data['total']);
            $this->db->bind(':narr','Purchases');
            $this->db->bind(':ttype',1);
            $this->db->bind(':tid',$data['id']);
            $this->db->bind(':cid',$_SESSION['cid']);
            $this->db->execute();

            if ($data['paid'] > 0) {
                $this->db->query('INSERT INTO payments (PaymentDate,CustomerID,Credit,Narration,
                                          TransactionType,TransactionId,CompanyID)
                                  VALUES(:pdate,:customer,:credit,:narr,:ttype,:tid,:cid)');
                $this->db->bind(':pdate',$data['sdate']);
                $this->db->bind(':customer',$data['customer']);
                $this->db->bind(':credit',$data['paid']);
                $this->db->bind(':narr','Purchases Payment');
                $this->db->bind(':ttype',1);
                $this->db->bind(':tid',$data['id']);
                $this->db->bind(':cid',$_SESSION['cid']);
                $this->db->execute();
            }

            for ($i=0; $i < count($data['product']); $i++) {
                $sellingprice = $this->GetBuyingPrice($data['product'][$i]);
                $this->db->query('INSERT INTO sales_details (HeaderID,ProductID,Qty,BuyingValue,
                                              SellingValue)
                                  VALUES (:hid,:pid,:qty,:bp,:val)');
                $this->db->bind(':hid',$data['id']);
                $this->db->bind(':pid',$data['product'][$i]);
                $this->db->bind(':qty',$data['qty'][$i]);
                $this->db->bind(':bp',$sellingprice * $data['qty'][$i]);
                $this->db->bind(':val',$data['rate'][$i] * $data['qty'][$i]);
                $this->db->execute();

                $this->db->query('INSERT INTO stock_movement (ProductID,TransactionDate,Qty,
                                              SalesId,TransactionType,CompanyID)
                                  VALUES (:pid,:tdate,:qty,:saleid,:ttype,:cid)');
                $this->db->bind(':pid',$data['product'][$i]);
                $this->db->bind(':tdate',$data['sdate']);
                $this->db->bind(':qty',$data['qty'][$i]);
                $this->db->bind(':saleid',$data['id']);
                $this->db->bind(':ttype',2);
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
            $this->db->dbh->beginTransaction();
            //queries
            $this->db->query('DELETE FROM sales_details WHERE HeaderID = :id');
            $this->db->bind(':id',$id);
            $this->db->execute();

            $this->db->query('DELETE FROM sales_header WHERE ID = :id');
            $this->db->bind(':id',$id);
            $this->db->execute();
            
            $this->db->query('DELETE FROM stock_movement WHERE SalesId = :id');
            $this->db->bind(':id',$id);
            $this->db->execute();

            $this->db->query('DELETE FROM payments WHERE TransactionType = 1 AND TransactionType = :id');
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