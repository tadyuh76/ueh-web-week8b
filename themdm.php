<?php
require_once 'db_module.php';

$db = new Database();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = trim($_POST['ten']);
    
    if (!empty($ten)) {
        if ($db->addDanhMuc($ten)) {
            $message = '<div class="alert alert-success">Thêm danh mục thành công!</div>';
        } else {
            $message = '<div class="alert alert-danger">Lỗi khi thêm danh mục!</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Vui lòng nhập tên danh mục!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Danh Mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Thêm Danh Mục Mới</h3>
                    </div>
                    <div class="card-body">
                        <?php echo $message; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="ten" class="form-label">Tên danh mục:</label>
                                <input type="text" class="form-control" id="ten" name="ten" required>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Thêm Danh Mục</button>
                                <a href="index.php" class="btn btn-secondary">Quay lại trang chủ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>