<?php
require_once 'db_module.php';

$db = new Database();
$danhmucs = $db->getAllDanhMuc();

// Handle search and filter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_id = isset($_GET['category']) ? intval($_GET['category']) : null;

if (!empty($search) || $category_id) {
    $sanphams = $db->searchSanPham($search, $category_id);
} else {
    $sanphams = $db->getAllSanPham();
}

$selected_category = null;
if ($category_id) {
    foreach ($danhmucs as $dm) {
        if ($dm['id'] == $category_id) {
            $selected_category = $dm;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Hàng Hóa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .content {
            min-height: 100vh;
        }
        .list-group-item.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .search-highlight {
            background-color: yellow;
            font-weight: bold;
        }
        .category-filter:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Menu -->
            <div class="col-md-3 sidebar p-3">
                <h4 class="mb-4">Menu Danh Mục</h4>
                
                <div class="mb-3">
                    <a href="themdm.php" class="btn btn-success w-100 mb-2">Thêm Danh Mục</a>
                    <a href="themsp.php" class="btn btn-primary w-100 mb-3">Thêm Sản Phẩm</a>
                </div>
                
                <h5>Danh Sách Danh Mục:</h5>
                <div class="list-group">
                    <!-- Show All Button -->
                    <a href="index.php" class="list-group-item list-group-item-action <?php echo (!$category_id) ? 'active' : ''; ?>">
                        <strong>📋 Tất cả sản phẩm</strong>
                    </a>
                    
                    <?php if (!empty($danhmucs)): ?>
                        <?php foreach ($danhmucs as $dm): ?>
                            <a href="index.php?category=<?php echo $dm['id']; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" 
                               class="list-group-item list-group-item-action <?php echo ($category_id == $dm['id']) ? 'active' : ''; ?>">
                                <?php echo htmlspecialchars($dm['ten']); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info">Chưa có danh mục nào</div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 content p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">
                        <?php if ($selected_category): ?>
                            Sản phẩm: <?php echo htmlspecialchars($selected_category['ten']); ?>
                        <?php else: ?>
                            Danh Sách Sản Phẩm
                        <?php endif; ?>
                        <?php if ($search): ?>
                            <small class="text-muted">(tìm kiếm: "<?php echo htmlspecialchars($search); ?>")</small>
                        <?php endif; ?>
                    </h2>
                </div>
                
                <!-- Search Bar -->
                <div class="row mb-2">
                    <div class="col-md-10">
                        <form method="GET" class="d-flex">
                            <?php if ($category_id): ?>
                                <input type="hidden" name="category" value="<?php echo $category_id; ?>">
                            <?php endif; ?>
                            <input type="text" name="search" class="form-control me-2" 
                                   placeholder="Tìm kiếm theo tên sản phẩm, mô tả hoặc danh mục..." 
                                   value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-outline-primary w-25">🔍 Tìm kiếm</button>
                            <?php if ($search || $category_id): ?>
                                <a href="index.php" class="btn btn-outline-secondary ms-2 w-25">✖ Xóa bộ lọc</a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="col-md-1 text-end">
                        <span class="badge bg-info fs-6">
                            Tìm thấy: <?php echo count($sanphams); ?> 
                        </span>
                    </div>
                </div>
                
                <?php if (!empty($sanphams)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Mô Tả</th>
                                    <th>Giá</th>
                                    <th>Danh Mục</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sanphams as $sp): ?>
                                    <tr>
                                        <td><?php echo $sp['id']; ?></td>
                                        <td><?php echo htmlspecialchars($sp['ten']); ?></td>
                                        <td><?php echo htmlspecialchars($sp['mota']); ?></td>
                                        <td><?php echo number_format($sp['gia'], 0, ',', '.'); ?> VND</td>
                                        <td><?php echo htmlspecialchars($sp['ten_dm'] ?? 'Không có'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <h5>Chưa có sản phẩm nào trong cơ sở dữ liệu</h5>
                        <p>Hãy <a href="themsp.php">thêm sản phẩm mới</a> để bắt đầu!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-submit search form on Enter key
        document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
        
        // Highlight search terms in results
        function highlightSearchTerm() {
            const searchTerm = '<?php echo addslashes($search); ?>';
            if (searchTerm && searchTerm.length > 0) {
                const tableBody = document.querySelector('tbody');
                if (tableBody) {
                    const regex = new RegExp(`(${searchTerm})`, 'gi');
                    tableBody.innerHTML = tableBody.innerHTML.replace(regex, '<span class="search-highlight">$1</span>');
                }
            }
        }
        
        // Add smooth scrolling and animations
        document.addEventListener('DOMContentLoaded', function() {
            highlightSearchTerm();
            
            // Add hover effects to table rows
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
            
            // Auto-focus search input if no results found
            <?php if (($search || $category_id) && empty($sanphams)): ?>
                document.querySelector('input[name="search"]').focus();
            <?php endif; ?>
        });
        
        // Add category click analytics (optional)
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.addEventListener('click', function() {
                // Could add analytics tracking here
                console.log('Category clicked:', this.textContent.trim());
            });
        });
    </script>
</body>
</html>