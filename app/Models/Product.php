<?php
namespace App\Models;

use App\Core\Model;

class Product extends Model {
    protected $table = 'tbl_sanpham';
    
    public function getAllProducts() {
        $sql = "SELECT sp.*, dm.ten as ten_dm 
                FROM tbl_sanpham sp 
                LEFT JOIN tbl_danhmuc dm ON sp.id_dm = dm.id 
                ORDER BY sp.ten";
        
        return $this->query($sql);
    }
    
    public function getProductById($id) {
        $sql = "SELECT sp.*, dm.ten as ten_dm 
                FROM tbl_sanpham sp 
                LEFT JOIN tbl_danhmuc dm ON sp.id_dm = dm.id 
                WHERE sp.id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result ? $result->fetch_assoc() : null;
    }
    
    public function addProduct($name, $description, $price, $categoryId, $imageUrl = null) {
        return $this->create([
            'ten' => $name,
            'mota' => $description,
            'gia' => $price,
            'id_dm' => $categoryId,
            'image_url' => $imageUrl
        ]);
    }
    
    public function updateProduct($id, $name, $description, $price, $categoryId, $imageUrl = null) {
        return $this->update($id, [
            'ten' => $name,
            'mota' => $description,
            'gia' => $price,
            'id_dm' => $categoryId,
            'image_url' => $imageUrl
        ]);
    }
    
    public function deleteProduct($id) {
        return $this->delete($id);
    }
    
    public function searchProducts($search = '', $categoryId = null) {
        $sql = "SELECT sp.*, dm.ten as ten_dm 
                FROM tbl_sanpham sp 
                LEFT JOIN tbl_danhmuc dm ON sp.id_dm = dm.id 
                WHERE 1=1";
        
        $params = [];
        $types = "";
        
        if (!empty($search)) {
            $sql .= " AND (sp.ten LIKE ? OR dm.ten LIKE ? OR sp.mota LIKE ?)";
            $searchTerm = "%" . $search . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= "sss";
        }
        
        if ($categoryId !== null && $categoryId > 0) {
            $sql .= " AND sp.id_dm = ?";
            $params[] = $categoryId;
            $types .= "i";
        }
        
        $sql .= " ORDER BY sp.ten";
        
        if (empty($params)) {
            return $this->getAllProducts();
        }
        
        return $this->query($sql, $params, $types);
    }
    
    public function getProductsByCategory($categoryId) {
        $sql = "SELECT sp.*, dm.ten as ten_dm 
                FROM tbl_sanpham sp 
                LEFT JOIN tbl_danhmuc dm ON sp.id_dm = dm.id 
                WHERE sp.id_dm = ? 
                ORDER BY sp.ten";
        
        return $this->query($sql, [$categoryId], "i");
    }
}