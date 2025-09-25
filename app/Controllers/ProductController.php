<?php
namespace App\Controllers;

use App\Core\Controller;

class ProductController extends Controller {
    private $productModel;
    private $categoryModel;
    
    public function __construct() {
        parent::__construct();
        $this->productModel = $this->model('Product');
        $this->categoryModel = $this->model('Category');
    }
    
    public function index() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $categoryId = isset($_GET['category']) ? intval($_GET['category']) : null;
        
        $categories = $this->categoryModel->getAllCategories();
        
        if (!empty($search) || $categoryId) {
            $products = $this->productModel->searchProducts($search, $categoryId);
        } else {
            $products = $this->productModel->getAllProducts();
        }
        
        $selectedCategory = null;
        if ($categoryId) {
            foreach ($categories as $cat) {
                if ($cat['id'] == $categoryId) {
                    $selectedCategory = $cat;
                    break;
                }
            }
        }
        
        $this->view->render('products/index', [
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'categoryId' => $categoryId,
            'selectedCategory' => $selectedCategory
        ]);
    }
    
    public function create() {
        $categories = $this->categoryModel->getAllCategories();
        $message = '';
        $messageType = '';
        
        if ($this->isPost()) {
            $name = $this->sanitizeInput($_POST['ten'] ?? '');
            $description = $this->sanitizeInput($_POST['mota'] ?? '');
            $price = floatval($_POST['gia'] ?? 0);
            $categoryId = intval($_POST['id_dm'] ?? 0);
            $imageUrl = $this->sanitizeInput($_POST['image_url'] ?? '');
            
            $errors = $this->validateRequired($_POST, ['ten']);
            
            if (empty($errors) && $price > 0 && $categoryId > 0) {
                if ($this->productModel->addProduct($name, $description, $price, $categoryId, $imageUrl)) {
                    $message = 'Thêm sản phẩm thành công!';
                    $messageType = 'success';
                } else {
                    $message = 'Lỗi khi thêm sản phẩm!';
                    $messageType = 'danger';
                }
            } else {
                $message = 'Vui lòng nhập đầy đủ thông tin hợp lệ!';
                $messageType = 'warning';
            }
        }
        
        $this->view->render('products/create', [
            'categories' => $categories,
            'message' => $message,
            'messageType' => $messageType
        ]);
    }
    
    public function edit($id = null) {
        if (!$id) {
            $this->redirect('/');
        }
        
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            $this->redirect('/');
        }
        
        $categories = $this->categoryModel->getAllCategories();
        $message = '';
        $messageType = '';
        
        if ($this->isPost()) {
            $name = $this->sanitizeInput($_POST['ten'] ?? '');
            $description = $this->sanitizeInput($_POST['mota'] ?? '');
            $price = floatval($_POST['gia'] ?? 0);
            $categoryId = intval($_POST['id_dm'] ?? 0);
            $imageUrl = $this->sanitizeInput($_POST['image_url'] ?? '');
            
            if (!empty($name) && $price > 0 && $categoryId > 0) {
                if ($this->productModel->updateProduct($id, $name, $description, $price, $categoryId, $imageUrl)) {
                    $message = 'Cập nhật sản phẩm thành công!';
                    $messageType = 'success';
                    $product = $this->productModel->getProductById($id);
                } else {
                    $message = 'Lỗi khi cập nhật sản phẩm!';
                    $messageType = 'danger';
                }
            } else {
                $message = 'Vui lòng nhập đầy đủ thông tin hợp lệ!';
                $messageType = 'warning';
            }
        }
        
        $this->view->render('products/edit', [
            'product' => $product,
            'categories' => $categories,
            'message' => $message,
            'messageType' => $messageType
        ]);
    }
    
    public function delete($id = null) {
        if (!$id || !$this->isPost()) {
            $this->redirect('/');
        }
        
        if ($this->productModel->deleteProduct($id)) {
            $_SESSION['message'] = 'Xóa sản phẩm thành công!';
            $_SESSION['messageType'] = 'success';
        } else {
            $_SESSION['message'] = 'Lỗi khi xóa sản phẩm!';
            $_SESSION['messageType'] = 'danger';
        }
        
        $this->redirect('/');
    }
}