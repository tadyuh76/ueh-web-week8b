<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 sidebar p-3">
            <h4 class="mb-4">Menu Danh Mục</h4>
            
            <div class="mb-3">
                <a href="/category/create" class="btn btn-success w-100 mb-2">Thêm Danh Mục</a>
                <a href="/product/create" class="btn btn-primary w-100 mb-3">Thêm Sản Phẩm</a>
            </div>
            
            <h5>Danh Sách Danh Mục:</h5>
            <div class="list-group">
                <a href="/" class="list-group-item list-group-item-action <?= (!$categoryId) ? 'active' : '' ?>">
                    <strong>📋 Tất cả sản phẩm</strong>
                </a>
                
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <a href="/?category=<?= $cat['id'] ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                           class="list-group-item list-group-item-action <?= ($categoryId == $cat['id']) ? 'active' : '' ?>">
                            <?= $this->escape($cat['ten']) ?>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info">Chưa có danh mục nào</div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-9 content p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <?php if ($selectedCategory): ?>
                        Sản phẩm: <?= $this->escape($selectedCategory['ten']) ?>
                    <?php else: ?>
                        Danh Sách Sản Phẩm
                    <?php endif; ?>
                    <?php if ($search): ?>
                        <small class="text-muted">(tìm kiếm: "<?= $this->escape($search) ?>")</small>
                    <?php endif; ?>
                </h2>
            </div>
            
            <div class="row mb-2">
                <div class="col-md-10">
                    <form method="GET" class="d-flex">
                        <?php if ($categoryId): ?>
                            <input type="hidden" name="category" value="<?= $categoryId ?>">
                        <?php endif; ?>
                        <input type="text" name="search" class="form-control me-2" 
                               placeholder="Tìm kiếm theo tên sản phẩm, mô tả hoặc danh mục..." 
                               value="<?= $this->escape($search) ?>">
                        <button type="submit" class="btn btn-outline-primary w-25">🔍 Tìm kiếm</button>
                        <?php if ($search || $categoryId): ?>
                            <a href="/" class="btn btn-outline-secondary ms-2 w-25">✖ Xóa bộ lọc</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="col-md-1 text-end">
                    <span class="badge bg-info fs-6">
                        Tìm thấy: <?= count($products) ?> 
                    </span>
                </div>
            </div>
            
            <?php if (!empty($products)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Hình Ảnh</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Mô Tả</th>
                                <th>Giá</th>
                                <th>Danh Mục</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= $product['id'] ?></td>
                                    <td>
                                        <?php if (!empty($product['image_url'])): ?>
                                            <img src="<?= $this->escape($product['image_url']) ?>" 
                                                 alt="<?= $this->escape($product['ten']) ?>"
                                                 class="img-thumbnail"
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light border rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 80px; height: 80px;">
                                                <span class="text-muted">No image</span>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $this->escape($product['ten']) ?></td>
                                    <td><?= $this->escape($product['mota']) ?></td>
                                    <td><?= number_format($product['gia'], 0, ',', '.') ?> VND</td>
                                    <td><?= $this->escape($product['ten_dm'] ?? 'Không có') ?></td>
                                    <td>
                                        <a href="/product/edit/<?= $product['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                        <form method="POST" action="/product/delete/<?= $product['id'] ?>" style="display: inline-block;" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <h5>Chưa có sản phẩm nào trong cơ sở dữ liệu</h5>
                    <p>Hãy <a href="/product/create">thêm sản phẩm mới</a> để bắt đầu!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>