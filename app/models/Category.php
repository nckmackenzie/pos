<?php
class Category{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetCategories()
    {
        $this->db->query('SELECT * FROM categories WHERE Deleted = 0');
        return $this->db->resultSet();
    }
    public function CheckExists($data)
    {
        $sql = 'SELECT COUNT(ID) FROM categories WHERE CategoryName = ? AND ID <> ? AND Deleted = 0';
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
        $this->db->query('INSERT INTO categories (CategoryName) VALUES(:cname)');
        $this->db->bind(':cname',strtolower($data['name']));
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function GetCategory($id)
    {
        $this->db->query('SELECT * FROM categories WHERE (ID=:id)');
        $this->db->bind(':id',$id);
        return $this->db->single();
    }
    public function update($data)
    {
        $this->db->query('UPDATE categories SET CategoryName=:cname WHERE (ID=:id)');
        $this->db->bind(':cname',strtolower($data['name']));
        $this->db->bind(':id',$data['id']);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function deactivate($id)
    {
        $this->db->query('UPDATE categories SET Active=0 WHERE (ID=:id)');
        $this->db->bind(':id',$id);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function activate($id)
    {
        $this->db->query('UPDATE categories SET Active=1 WHERE (ID=:id)');
        $this->db->bind(':id',$id);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function delete($id)
    {
        $this->db->query('UPDATE categories SET Deleted=1 WHERE (ID=:id)');
        $this->db->bind(':id',$id);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
}