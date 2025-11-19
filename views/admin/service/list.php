<?php
require_once './views/layouts/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Quản lý Dịch vụ</h2>
        <a href="index.php?controller=services&action=create" class="btn btn-primary">
            + Thêm Dịch vụ
        </a>
    </div>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>Tên dịch vụ</th>
                            <th width="12%">Loại</th>
                            <th width="12%">Giá</th>
                            <th width="14%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($services as $service): ?>
                            <tr>
                                <td><?= $service['id']; ?></td>
                                <td><?= htmlspecialchars($service['name']); ?></td>
                                <td>
                                    <span class="badge bg-info text-dark"><?= ucfirst($service['type']); ?></span>
                                </td>
                                <td><?= number_format($service['price']); ?> đ</td>
                                <td>
                                    <a href="index.php?controller=services&action=edit&id=<?= $service['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="index.php?controller=services&action=delete&id=<?= $service['id']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if(empty($services)): ?>
                            <tr>
                                <td colspan="5" class="text-center">Không có dữ liệu</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
