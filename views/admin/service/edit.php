<?php
require_once './views/layouts/header.php';
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-3">Chỉnh sửa Dịch vụ</h2>

    <form action="index.php?controller=services&action=update" method="POST">
        <input type="hidden" name="id" value="<?= $service['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Tên dịch vụ</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($service['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Loại dịch vụ</label>
            <select name="type" class="form-select" required>
                <option value="xe" <?= $service['type']=='xe'?'selected':''; ?>>Xe</option>
                <option value="khach_san" <?= $service['type']=='khach_san'?'selected':''; ?>>Khách sạn</option>
                <option value="ve" <?= $service['type']=='ve'?'selected':''; ?>>Vé</option>
                <option value="khac" <?= $service['type']=='khac'?'selected':''; ?>>Khác</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá (VNĐ)</label>
            <input type="number" name="price" class="form-control" value="<?= $service['price']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($service['description']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="index.php?controller=services&action=index" class="btn btn-secondary">Hủy</a>
    </form>
</div>
