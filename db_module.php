<?php
require_once 'config.php';

class Database {
    private $connection;
    
    public function __construct() {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
            
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            }
            
            $this->connection->set_charset("utf8");
        } catch (Exception $e) {
            die("<div class='alert alert-danger'>
                <h4>Database Connection Error</h4>
                <p><strong>Error:</strong> " . $e->getMessage() . "</p>
                <p><strong>Please check:</strong></p>
                <ul>
                    <li>XAMPP is running (Apache + MySQL)</li>
                    <li>MySQL service is started in XAMPP Control Panel</li>
                    <li>Database 'db_hanghoa' exists (import database.sql first)</li>
                </ul>
                <p><strong>Setup Steps:</strong></p>
                <ol>
                    <li>Start XAMPP Control Panel</li>
                    <li>Click 'Start' for Apache and MySQL</li>
                    <li>Click 'Admin' for MySQL (opens phpMyAdmin)</li>
                    <li>Import the database.sql file</li>
                    <li>Refresh this page</li>
                </ol>
            </div>");
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function close() {
        $this->connection->close();
    }
    
    // Get all categories
    public function getAllDanhMuc() {
        $sql = "SELECT * FROM tbl_danhmuc ORDER BY ten";
        $result = $this->connection->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    // Add new category
    public function addDanhMuc($ten) {
        $stmt = $this->connection->prepare("INSERT INTO tbl_danhmuc (ten) VALUES (?)");
        $stmt->bind_param("s", $ten);
        return $stmt->execute();
    }
    
    // Get all products
    public function getAllSanPham() {
        $sql = "SELECT sp.*, dm.ten as ten_dm FROM tbl_sanpham sp 
                LEFT JOIN tbl_danhmuc dm ON sp.id_dm = dm.id 
                ORDER BY sp.ten";
        $result = $this->connection->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    // Add new product
    public function addSanPham($ten, $mota, $gia, $id_dm) {
        $stmt = $this->connection->prepare("INSERT INTO tbl_sanpham (ten, mota, gia, id_dm) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $ten, $mota, $gia, $id_dm);
        return $stmt->execute();
    }
    
    // Search products by name or category
    public function searchSanPham($search = '', $category_id = null) {
        $sql = "SELECT sp.*, dm.ten as ten_dm FROM tbl_sanpham sp 
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
        
        if ($category_id !== null && $category_id > 0) {
            $sql .= " AND sp.id_dm = ?";
            $params[] = $category_id;
            $types .= "i";
        }
        
        $sql .= " ORDER BY sp.ten";
        
        if (empty($params)) {
            return $this->getAllSanPham();
        }
        
        $stmt = $this->connection->prepare($sql);
        if (!empty($types)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    // Get products by category
    public function getSanPhamByCategory($category_id) {
        $stmt = $this->connection->prepare("SELECT sp.*, dm.ten as ten_dm FROM tbl_sanpham sp 
                                           LEFT JOIN tbl_danhmuc dm ON sp.id_dm = dm.id 
                                           WHERE sp.id_dm = ? 
                                           ORDER BY sp.ten");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
?>