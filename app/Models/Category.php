<?php
namespace App\Models;

use App\Core\Model;

class Category extends Model {
    protected $table = 'tbl_danhmuc';
    
    public function getAllCategories() {
        return $this->findAll('ten');
    }
    
    public function addCategory($name) {
        return $this->create(['ten' => $name]);
    }
    
    public function getCategoryById($id) {
        return $this->findById($id);
    }
    
    public function updateCategory($id, $name) {
        return $this->update($id, ['ten' => $name]);
    }
    
    public function deleteCategory($id) {
        return $this->delete($id);
    }
    
    public function hasProducts($categoryId) {
        $sql = "SELECT COUNT(*) as count FROM tbl_sanpham WHERE id_dm = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['count'] > 0;
    }
}