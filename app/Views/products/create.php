<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Thêm Sản Phẩm Mới</h3>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-<?= $messageType ?>">
                            <?= $message ?>
                        </div>
                    <?php endif; ?>
                    
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
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>">
                                        <?= $this->escape($cat['ten']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image_url" class="form-label">URL Hình ảnh:</label>
                            <input type="url" class="form-control" id="image_url" name="image_url" 
                                   placeholder="https://example.com/image.jpg">
                            <small class="text-muted">Nhập URL hình ảnh sản phẩm (tùy chọn)</small>
                            <div id="image-preview" class="mt-2"></div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
                            <a href="/" class="btn btn-secondary">Quay lại trang chủ</a>
                        </div>
                    </form>
                    
                    <?php if (empty($categories)): ?>
                        <div class="alert alert-warning mt-3">
                            <strong>Chưa có danh mục!</strong> 
                            <a href="/category/create">Thêm danh mục</a> trước khi thêm sản phẩm.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('image_url').addEventListener('input', function(e) {
    const url = e.target.value;
    const preview = document.getElementById('image-preview');
    
    if (url) {
        preview.innerHTML = `
            <img src="${url}" alt="Preview" class="img-thumbnail" 
                 style="max-width: 200px; max-height: 200px;"
                 onerror="this.style.display='none'; document.getElementById('image-error').style.display='block';">
            <div id="image-error" class="text-danger" style="display: none;">
                Không thể tải hình ảnh từ URL này
            </div>
        `;
    } else {
        preview.innerHTML = '';
    }
});
</script>