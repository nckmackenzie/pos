<?php
class Categories extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['uid'])) {
            redirect('');
        }else{
            $this->categoryModel = $this->model('Category');
        }
    }
    public function index()
    {
        $categories = $this->categoryModel->GetCategories();
        $data = ['categories' => $categories];
        $this->view('categories/index',$data);
    }
    public function add()
    {
        $data = [
            'name' => '',
            'name_err' => ''
        ];
        $this->view('categories/add',$data);
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'id' => '',
                'name' => trim($_POST['name']),
                'name_err' => ''
            ];
            if (empty($data['name'])) {
                $data['name_err'] = 'Enter Category Name';
            }else{
                if (!$this->categoryModel->CheckExists($data)) {
                    $data['name_err'] = 'Category Already Created';
                }
            }
            if (empty($data['name_err'])) {
                if ($this->categoryModel->create($data)) {
                    flash('category_msg','Category Created Successfully!');
                    redirect('categories');
                }
            }else{
                $this->view('categories/add',$data);
            }
        }else{
            redirect('');
        }
    }
    public function edit($id)
    {
        $category = $this->categoryModel->GetCategory($id);
        $data = [
            'category' => $category,
            'name' => '',
            'name_err' => ''
        ];
        $this->view('categories/edit',$data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'id' => trim($_POST['id']),
                'name' => trim($_POST['name']),
                'name_err' => ''
            ];
            if (empty($data['name'])) {
                $data['name_err'] = 'Enter Category Name';
            }else{
                if (!$this->categoryModel->CheckExists($data)) {
                    $data['name_err'] = 'Category Already Created';
                }
            }
            if (empty($data['name_err'])) {
                if ($this->categoryModel->update($data)) {
                    flash('category_msg','Category Updated Successfully!');
                    redirect('categories');
                }
            }else{
                $this->view('categories/edit',$data);
            }
        }else{
            redirect('');
        }
    }
    public function deactivate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $id = trim($_POST['id']);
            if ($this->categoryModel->deactivate($id)) {
                flash('category_msg','Category Deactivated Successfully!');
                redirect('categories');
            }
        }else{
            redirect('');
        }
    }
    public function activate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $id = trim($_POST['id']);
            if ($this->categoryModel->activate($id)) {
                flash('category_msg','Category Activated Successfully!');
                redirect('categories');
            }
        }else{
            redirect('');
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $id = trim($_POST['id']);
            if ($this->categoryModel->delete($id)) {
                flash('category_msg','Category Deleted Successfully!');
                redirect('categories');
            }
        }else{
            redirect('');
        }
    }
}