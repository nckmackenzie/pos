<?php 
class Products extends Controller {
    public function __construct()
    {
        if (!isset($_SESSION['uid'])) {
            redirect('');
        }else{
            $this->productModel = $this->model('Product');
        }
    }
    public function index()
    {
        $products = $this->productModel->GetProducts();
        $data = ['products' => $products];
        $this->view('products/index',$data);
    }
    public function add()
    {
        $categories = $this->productModel->GetCategories();
        $data = [
            'categories' => $categories,
            'name' => '',
            'category' => '',
            'bal' => '',
            'bp' => '',
            'sp' => '',
            'description' => '',
            'name_err' => '',
            'category_err' => '',
            'bal_err' => '',
            'bp_err' => '',
            'sp_err' => '',
        ];
        $this->view('products/add',$data);
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST =filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $categories = $this->productModel->GetCategories();
            $data = [
                'id' => '',
                'categories' => $categories,
                'name' => trim($_POST['name']),
                'category' => trim($_POST['category']),
                'bal' => trim($_POST['bal']),
                'bp' => trim($_POST['bp']),
                'sp' => trim($_POST['sp']),
                'description' => trim($_POST['description']),
                'name_err' => '',
                'category_err' => '',
                'bal_err' => '',
                'bp_err' => '',
                'sp_err' => '',
            ];
            if (empty($data['name'])) {
                $data['name_err'] = 'Enter Product Name';
            }else{
                if (!$this->productModel->CheckExists($data)) {
                    $data['name_err'] = 'Product Already Created';
                }
            }
            if (empty($data['category'])) {
                $data['category_err'] = 'Select Product Category';
            }
            if (empty($data['bal'])) {
                $data['bal_err'] = 'Enter Opening Balance';
            }
            if (empty($data['bp'])) {
                $data['bp_err'] = 'Enter Buying Price';
            }
            if (empty($data['sp'])) {
                $data['sp_err'] = 'Enter Selling Price';
            }
            if (empty($data['name_err']) && empty($data['category_err']) && empty($data['bal_err'])
                && empty($data['bp_err']) && empty($data['sp_err'])) {
                //save
                if ($this->productModel->create($data)) {
                    flash('product_msg','Product Created Successfully!');
                    redirect('products');
                }
            }else{
                $this->view('products/add',$data);
            }
        }else{
            redirect('products');
        }
    }
    public function edit($id)
    {
        $product = $this->productModel->GetProduct($id);
        $categories = $this->productModel->GetCategories();
        $IsInitial = $this->productModel->CheckIsInital($id);
        if ($IsInitial) {
            $openingbal = $this->productModel->GetOpeningBal($id);
        }else {
            $openingbal = '';
        }
        $data = [
            'product' => $product,
            'categories' => $categories,
            'isinitial' => $IsInitial,
            'name' => '',
            'category' => '',
            'bal' => $openingbal,
            'bp' => '',
            'sp' => '',
            'description' => '',
            'name_err' => '',
            'category_err' => '',
            'bal_err' => '',
            'bp_err' => '',
            'sp_err' => '',
        ];
        $this->view('products/edit',$data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST =filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $categories = $this->productModel->GetCategories();
            $data = [
                'id' => trim($_POST['id']),
                'categories' => $categories,
                'name' => trim($_POST['name']),
                'category' => trim($_POST['category']),
                'bal' => trim($_POST['bal']),
                'bp' => trim($_POST['bp']),
                'sp' => trim($_POST['sp']),
                'description' => trim($_POST['description']),
                'name_err' => '',
                'category_err' => '',
                'bal_err' => '',
                'bp_err' => '',
                'sp_err' => '',
            ];
            if (empty($data['name'])) {
                $data['name_err'] = 'Enter Product Name';
            }else{
                if (!$this->productModel->CheckExists($data)) {
                    $data['name_err'] = 'Product Already Created';
                }
            }
            if (empty($data['category'])) {
                $data['category_err'] = 'Select Product Category';
            }
            if (empty($data['bal'])) {
                $data['bal_err'] = 'Enter Opening Balance';
            }
            if (empty($data['bp'])) {
                $data['bp_err'] = 'Enter Buying Price';
            }
            if (empty($data['sp'])) {
                $data['sp_err'] = 'Enter Selling Price';
            }
            if (empty($data['name_err']) && empty($data['category_err']) && empty($data['bal_err'])
                && empty($data['bp_err']) && empty($data['sp_err'])) {
                //save
                if ($this->productModel->update($data)) {
                    flash('product_msg','Product Updated Successfully!');
                    redirect('products');
                }
            }else{
                $this->view('products/add',$data);
            }
        }else{
            redirect('products');
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $id = trim($_POST['id']);
            if (!$this->productModel->CheckIsInital($id)) {
                flash('product_msg','Product Cannot Be Deleted As Its Referenced Elsewhere!',
                      'alert custom-danger alert-dismissible fade show');
                redirect('products');
            }else{
                if ($this->productModel->delete($id)) {
                    flash('product_msg','Product Deleted Successfully!');
                    redirect('products');
                }
            }
        }else{
            redirect('products');
        }
    }
}