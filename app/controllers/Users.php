<?php
class Users extends Controller {
    public function __construct()
    {
        $this->userModel =  $this->model('User');
    }
    public function index()
    {
        $companycount = $this->userModel->GetCompanyCount();
        if ($companycount == 1) {
            $companies = $this->userModel->GetCompany();
        }
        $data = [
            'userid' => '',
            'password' => '',
            'userid_err' => '',
            'password_err' => '',
            'count' => $companycount,
            'companies' => $companies
        ];
        $this->view('users/index',$data);
    }
    public function all()
    {
        if (!isset($_SESSION['uid'])) {
            redirect('');
        }else{
            $users = $this->userModel->GetUsers();
            $data = ['users' => $users];
            $this->view('users/all',$data);
        }
    }
    public function add()
    {
        $data = [
            'id' => '',
            'userid' => '',
            'name' => '',
            'password' => '',
            'type' => 2,
            'userid_err' => '',
            'name_err' => '',
            'password_err' => '',
        ];
        $this->view('users/add',$data);
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'id' => '',
                'userid' => trim($_POST['userid']),
                'name' => trim($_POST['name']),
                'password' => trim($_POST['password']),
                'type' => trim($_POST['type']),
                'userid_err' => '',
                'name_err' => '',
                'password_err' => '',
            ];
            if (empty($data['userid'])) {
                $data['userid_err'] = 'Enter User ID';
            }else{
                if (!$this->userModel->CheckUserExists($data)) {
                    $data['userid_err'] = 'User ID Exists';
                }
            }
            if (empty($data['name'])) {
                $data['name_err'] = 'Enter User Name';
            }
            if (empty($data['password'])) {
                $data['password_err'] = 'Enter User Password';
            }
            if (empty($data['userid_err']) && empty($data['name_err']) && empty($data['password_err'])) {
                if ($this->userModel->create($data)) {
                    flash('user_msg','User Created Successfully!');
                    redirect('users/all');
                }
            }else{
                $this->view('users/add',$data);
            }
        }else{
            redirect('');
        }
    }
    public function signin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $companycount = $this->userModel->GetCompanyCount();
            if ($companycount == 1) {
                $companies = $this->userModel->GetCompany();
            }
            $data = [
                'id' => '',
                'userid' => trim($_POST['userid']),
                'password' => trim($_POST['password']),
                'company' => trim($_POST['company']),
                'count' => $companycount,
                'companies' => $companies,
                'userid_err' => '',
                'password_err' => '',
            ];
            if (empty($data['userid'])) {
                $data['userid_err'] = 'Enter User ID';
            }
            else {
                if ($this->userModel->CheckUserExists($data)) {
                   $data['userid_err'] = 'User ID Not Found';
                }
            }
            if (empty($data['password'])) {
                $data['password_err'] = 'Enter Your Password';
            }
            if (empty($data['userid_err']) && empty($data['password_err'])) {
                $loggeduser = $this->userModel->login($data);
                if ($loggeduser) {
                    //create session
                    $this->CreateUserSession($loggeduser);
                }else{
                    $data['password_err'] = 'Invalid Password';
                    $this->view('users/index',$data);
                }
            }else{
                $this->view('users/index',$data);
            }
        }else{
            $companycount = $this->userModel->GetCompanyCount();
            if ($companycount == 1) {
                $companies = $this->userModel->GetCompany();
            }
            $data = [
                'userid' => '',
                'password' => '',
                'userid_err' => '',
                'password_err' => '',
                'count' => $companycount,
                'companies' => $companies
            ];
            $this->view('users/index',$data);
        }
    }
    public function CreateUserSession($user)
    {
        $_SESSION['uid'] = $user->ID;
        $_SESSION['cid'] = $user->CompanyID;
        $_SESSION['usid'] = $user->UserID;
        $_SESSION['uname'] = $user->UserName;
        $_SESSION['utype'] = $user->UserTypeId;
        redirect('dashboard');
    }
    public function logout()
    {
        unset($_SESSION['uid']);
        unset($_SESSION['uname']);
        unset($_SESSION['cid']);
        unset($_SESSION['usid']);
        unset($_SESSION['utype']);
        session_destroy();
        redirect('users');
    }
    public function changepassword()
    {
        $data = [
            'old' => '',
            'new' => '',
            'confirm' => '',
            'old_err' => '',
            'new_err' => '',
            'confirm_err' => ''
        ];
        $this->view('users/changepassword',$data);
    }
    public function password()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST =filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'old' => trim($_POST['old']),
                'new' => trim($_POST['new']),
                'confirm' => trim($_POST['confirm']),
                'old_err' => '',
                'new_err' => '',
                'confirm_err' => ''
            ];
            //validate
            if (empty($data['old'])) {
                $data['old_err'] = 'Enter Old Password';
            }else{
                if (!$this->userModel->PasswordIsCorrect($data['old'])) {
                    $data['old_err'] = 'Old Password Is Incorrect';
                }
            }
            if (empty($data['new'])) {
                $data['new_err'] = 'Enter New Password';
            }
            if (empty($data['confirm'])) {
                $data['confirm_err'] = 'Confirm Password';
            }
            if (!empty($data['new']) && !empty($data['confirm'])) {
                if ($data['new'] != $data['confirm']) {
                    $data['confirm_err'] ='Passwords Don\'t Match';
                    $data['new_err'] ='Passwords Don\'t Match';
                }
            }
            //end of validation
            if (empty($data['old_err']) && empty($data['new_err']) && empty($data['confirm_err'])) {
                //change password
                if ($this->userModel->changepassword($data)) {
                    redirect('dashboard');
                }
            }else{
                $this->view('users/changepassword',$data);
            }
        }else{
            $data = [
                'old' => '',
                'new' => '',
                'confirm' => '',
                'old_err' => '',
                'new_err' => '',
                'confirm_err' => ''
            ];
            $this->view('users/changepassword',$data);
        }
    }
}