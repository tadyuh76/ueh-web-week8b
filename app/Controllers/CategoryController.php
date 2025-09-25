<?php
namespace App\Controllers;

use App\Core\Controller;

class CategoryController extends Controller {
    private $categoryModel;
    
    public function __construct() {
        parent::__construct();
        $this->categoryModel = $this->model('Category');
    }
    
    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        
        $this->view->render('categories/index', [
            'categories' => $categories
        ]);
    }
    
    public function create() {
        $message = '';
        $messageType = '';
        
        if ($this->isPost()) {
            $name = $this->sanitizeInput($_POST['ten'] ?? '');
            
            if (!empty($name)) {
                if ($this->categoryModel->addCategory($name)) {
                    $message = 'Thêm danh mục thành công!';
                    $messageType = 'success';
                } else {
                    $message = 'Lỗi khi thêm danh mục!';
                    $messageType = 'danger';
                }
            } else {
                $message = 'Vui lòng nhập tên danh mục!';
                $messageType = 'warning';
            }
        }
        
        $this->view->render('categories/create', [
            'message' => $message,
            'messageType' => $messageType
        ]);
    }
    
    public function edit($id = null) {
        if (!$id) {
            $this->redirect('/category');
        }
        
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            $this->redirect('/category');
        }
        
        $message = '';
        $messageType = '';
        
        if ($this->isPost()) {
            $name = $this->sanitizeInput($_POST['ten'] ?? '');
            
            if (!empty($name)) {
                if ($this->categoryModel->updateCategory($id, $name)) {
                    $message = 'Cập nhật danh mục thành công!';
                    $messageType = 'success';
                    $category['ten'] = $name;
                } else {
                    $message = 'Lỗi khi cập nhật danh mục!';
                    $messageType = 'danger';
                }
            } else {
                $message = 'Vui lòng nhập tên danh mục!';
                $messageType = 'warning';
            }
        }
        
        $this->view->render('categories/edit', [
            'category' => $category,
            'message' => $message,
            'messageType' => $messageType
        ]);
    }
    
    public function delete($id = null) {
        if (!$id || !$this->isPost()) {
            $this->redirect('/category');
        }
        
        if ($this->categoryModel->hasProducts($id)) {
            $_SESSION['message'] = 'Không thể xóa danh mục đã có sản phẩm!';
            $_SESSION['messageType'] = 'warning';
        } elseif ($this->categoryModel->deleteCategory($id)) {
            $_SESSION['message'] = 'Xóa danh mục thành công!';
            $_SESSION['messageType'] = 'success';
        } else {
            $_SESSION['message'] = 'Lỗi khi xóa danh mục!';
            $_SESSION['messageType'] = 'danger';
        }
        
        $this->redirect('/category');
    }
}