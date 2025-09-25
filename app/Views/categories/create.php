<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Thêm Danh Mục Mới</h3>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-<?= $messageType ?>">
                            <?= $message ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="ten" class="form-label">Tên danh mục:</label>
                            <input type="text" class="form-control" id="ten" name="ten" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Thêm Danh Mục</button>
                            <a href="/" class="btn btn-secondary">Quay lại trang chủ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>