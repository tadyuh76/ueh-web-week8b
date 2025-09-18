<?php
require_once 'db_module.php';

$db = new Database();
$danhmucs = $db->getAllDanhMuc();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = trim($_POST['ten']);
    $mota = trim($_POST['mota']);
    $gia = floatval($_POST['gia']);
    $id_dm = intval($_POST['id_dm']);
    
    if (!empty($ten) && $gia > 0 && $id_dm > 0) {
        if ($db->addSanPham($ten, $mota, $gia, $id_dm)) {
            $message = '<div class="alert alert-success">Thêm sản phẩm thành công!</div>';
        } else {
            $message = '<div class="alert alert-danger">Lỗi khi thêm sản phẩm!</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Vui lòng nhập đầy đủ thông tin hợp lệ!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Thêm Sản Phẩm Mới</h3>
                    </div>
                    <div class="card-body">
                        <?php echo $message; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="ten" class="form-label">Tên sản phẩm:</label>
                                <input type="text" class="form-control" id="ten" name="ten" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="mota" class="form-label">Mô tả:</label>
                                <textarea class="form-control" id="mota" name="mota" rows="3"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="gia" class="form-label">Giá (VND):</label>
                                <input type="number" class="form-control" id="gia" name="gia" min="0" step="1000" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="id_dm" class="form-label">Danh mục:</label>
                                <select class="form-select" id="id_dm" name="id_dm" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach ($danhmucs as $dm): ?>
                                        <option value="<?php echo $dm['id']; ?>">
                                            <?php echo htmlspecialchars($dm['ten']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
                                <a href="index.php" class="btn btn-secondary">Quay lại trang chủ</a>
                            </div>
                        </form>
                        
                        <?php if (empty($danhmucs)): ?>
                            <div class="alert alert-warning mt-3">
                                <strong>Chưa có danh mục!</strong> 
                                <a href="themdm.php">Thêm danh mục</a> trước khi thêm sản phẩm.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>