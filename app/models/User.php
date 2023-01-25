<?php
class User {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function GetUsers()
    {
        $this->db->query('SELECT u.ID,
                                 ucase(UserID) As UserID,
                                 ucase(UserName) As UserName,
                                 ucase(UserType) As UserType,
                                 Active
                          FROM   users u inner join usertypes t ON u.UserTypeId = t.ID
                          WHERE  Visible = 1');
        return $this->db->resultSet();
    }
    public function CheckUserExists($data)
    {
        $sql = 'SELECT COUNT(ID) FROM users WHERE UserID = ? AND ID <> ? AND CompanyID = 1';
        $arr = array();
        array_push($arr,trim(strtolower($data['userid'])));
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
        $this->db->query('INSERT INTO users (UserID,UserName,UserPassword,UserTypeId,CompanyID)
                          VALUES(:usid,:uname,:pass,:utype,:cid)');
        $this->db->bind(':usid',strtolower($data['userid']));
        $this->db->bind(':uname',strtolower($data['name']));
        $this->db->bind(':pass',password_hash($data['password'],PASSWORD_DEFAULT));
        $this->db->bind(':utype',$data['type']);
        $this->db->bind(':cid',1);
        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }
    public function GetCompanyCount()
    {
        $this->db->query('SELECT COUNT(ID) FROM company');
        return $this->db->getValue();
    }
    public function GetCompany()
    {
        $this->db->query('SELECT ID,UCASE(CompanyName) AS CompanyName FROM company');
        return $this->db->single();
    }
    public function login($data)
    {
        $this->db->query('SELECT * FROM users WHERE (UserID = :id)');
        $this->db->bind(':id',$data['userid']);
        $row = $this->db->single();
        if (password_verify($data['password'],$row->UserPassword)) {
            return $row;
        }else{
            return false;
        }
    }
    public function PasswordIsCorrect($old)
    {
        $this->db->query('SELECT UserPassword FROM users WHERE ID=:id');
        $this->db->bind(':id',$_SESSION['uid']);
        $hashedPassword = $this->db->getValue();
        if (password_verify($old,$hashedPassword)) {
            return true;
        }else{return false;}
    }
    public function changepassword($data)
    {
        $this->db->query('UPDATE users SET UserPassword=:pass WHERE ID=:id');
        $this->db->bind(':pass',password_hash($data['new'],PASSWORD_DEFAULT));
        $this->db->bind(':id',$_SESSION['uid']);
        if ($this->db->execute()) {
            return true;
        }else{return 'wow';}
    }
}