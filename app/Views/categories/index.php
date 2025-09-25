<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Quản Lý Danh Mục</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="/category/create" class="btn btn-primary">Thêm Danh Mục Mới</a>
                        <a href="/" class="btn btn-secondary">Quay lại trang chủ</a>
                    </div>
                    
                    <?php if (!empty($categories)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên Danh Mục</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $cat): ?>
                                        <tr>
                                            <td><?= $cat['id'] ?></td>
                                            <td><?= $this->escape($cat['ten']) ?></td>
                                            <td>
                                                <a href="/category/edit/<?= $cat['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                                <form method="POST" action="/category/delete/<?= $cat['id'] ?>" style="display: inline-block;" 
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
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
                            Chưa có danh mục nào. <a href="/category/create">Thêm danh mục mới</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>