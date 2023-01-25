<?php
class Company {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function create($data)
    {
        $this->db->query('INSERT INTO company (CompanyName,Contact,`Address`,Email) 
                          VALUES (:cname,:contact,:addr,:email)');
        $this->db->bind(':cname',strtolower($data['name']));
        $this->db->bind(':contact',$data['contact']);
        $this->db->bind(':addr',!empty($data['address']) ? strtolower($data['address']) : NULL);
        $this->db->bind(':email',!empty($data['email']) ? $data['email'] : NULL);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function GetCompany($id)
    {
        $this->db->query('SELECT * FROM company WHERE ID=:id');
        $this->db->bind(':id',$_SESSION['cid']);
        return $this->db->single();
    }
    public function update($data)
    {
        $this->db->query('UPDATE company SET CompanyName=:cname,Contact=:contact,`Address`=:addr,Email=:email,PIN=:pin 
                          WHERE (ID=:id)');
        $this->db->bind(':cname',strtolower($data['name']));
        $this->db->bind(':contact',$data['contact']);
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
}