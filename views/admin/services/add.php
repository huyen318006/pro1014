<?php
require_once './views/layouts/header.php';
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-3">Thêm Dịch vụ Mới</h2>

    <form action="index.php?act=servicesStore" method="POST">
        <div class="mb-3">
            <label class="form-label">Tên dịch vụ</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Loại dịch vụ</label>
            <select name="type" class="form-select" required>
                <option value="xe">Xe</option>
                <option value="khach_san">Khách sạn</option>
                <option value="ve">Vé</option>
                <option value="khac">Khác</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá (VNĐ)</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="index.php?act=services" class="btn btn-secondary">Hủy</a>
    </form>
</div>

