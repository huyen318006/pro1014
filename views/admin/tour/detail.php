<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-user-shield"></i>
        </div>
        <h4>ADMIN</h4>
        <a href="index.php?act=home"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a href="<?= BASE_URL . '?act=account' ?>"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
        <a href="index.php?act=listTours" class="active"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
        <a href="index.php?act=listItinerary"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Lịch Trình</span></a>
        <a href="?act=listAssignments"><i class="fas fa-map-marked-alt"></i> <span>Phân công HDV</span></a>
        <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
        <a href="#"><i class="fas fa-shopping-cart"></i> <span>Quản lý đơn đặt</span></a>
        <a href="#"><i class="fas fa-comments"></i> <span>Quản lý bình luận</span></a>
        <a href="<?= BASE_URL . '?act=DepartureAdmin'  ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
        <a href="index.php?act=logout"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- Header -->
    <div class="header">
        <h5><i class="fas fa-cogs"></i> Bảng điều khiển tour</h5>
        <div class="user- info">
            <i class="fas fa-user-circle"></i>
            <span>Admin Chủ</span>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container-fluid">

            <!-- Tour Title -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="mb-3">
                                <i class="fas fa-map-marked-alt text-primary"></i>
                                <?= $tour['name'] ?>
                            </h2>
                            <div class="mb-2">
                                <span class="badge bg-secondary fs-6 me-2">
                                    <i class="fas fa-barcode"></i> Mã: <?= $tour['code'] ?>
                                </span>
                                <?php
                                $statusLabels = [
                                    'published' => '<span class="badge bg-success fs-6"><i class="fas fa-check-circle"></i> Đang hoạt động</span>',
                                    'draft' => '<span class="badge bg-warning text-dark fs-6"><i class="fas fa-edit"></i> Bản nháp</span>',
                                    'archived' => '<span class="badge bg-secondary fs-6"><i class="fas fa-archive"></i> Ngừng kinh doanh</span>'
                                ];
                                echo $statusLabels[$tour['status']] ?? $tour['status'];
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Cột trái - Hình ảnh -->
                <div class="col-lg-5">
                    <!-- Hình ảnh Tour -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-image text-primary"></i> Hình ảnh Tour</h5>
                        </div>
                        <div class="card-body text-center">
                            <?php if (!empty($tour['image'])): ?>
                                <img src="<?= BASE_URL . 'uploads/' . basename($tour['image']) ?>" 
                                     class="img-fluid rounded shadow-sm" 
                                     alt="<?= $tour['name'] ?>"
                                     style="max-height: 400px; width: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light p-5 rounded">
                                    <i class="fas fa-image fa-5x text-muted"></i>
                                    <p class="mt-3 text-muted">Chưa có hình ảnh</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Cột phải - Thông tin chi tiết -->
                <div class="col-lg-7">
                    <!-- Thông tin cơ bản -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle text-primary"></i> Thông tin chi tiết</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="bg-light" style="width: 35%;">
                                                <strong><i class="fas fa-key text-secondary"></i> ID Tour</strong>
                                            </td>
                                            <td>
                                                <code class="bg-light p-2 rounded">#<?= $tour['id'] ?></code>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">
                                                <strong><i class="fas fa-barcode text-info"></i> Mã Tour</strong>
                                            </td>
                                            <td><?= $tour['code'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">
                                                <strong><i class="fas fa-heading text-primary"></i> Tên Tour</strong>
                                            </td>
                                            <td class="fw-bold"><?= $tour['name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">
                                                <strong><i class="fas fa-map-marker-alt text-danger"></i> Điểm đến</strong>
                                            </td>
                                            <td class="fw-bold text-danger"><?= $tour['destination'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">
                                                <strong><i class="fas fa-list-alt text-info"></i> Loại Tour</strong>
                                            </td>
                                            <td>
                                                <?= $tour['category_name'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">
                                                <strong><i class="fas fa-toggle-on text-success"></i> Trạng thái</strong>
                                            </td>
                                            <td>
                                                <?php
                                                $statusLabels = [
                                                    'published' => '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Đang hoạt động</span>',
                                                    'draft' => '<span class="badge bg-warning text-dark"><i class="fas fa-edit"></i> Bản nháp</span>',
                                                    'archived' => '<span class="badge bg-secondary"><i class="fas fa-archive"></i> Ngừng kinh doanh</span>'
                                                ];
                                                echo $statusLabels[$tour['status']] ?? $tour['status'];
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">
                                                <strong><i class="fas fa-money-bill-wave text-success"></i> Giá Tour</strong>
                                            </td>
                                            <td>
                                                <span class="fs-4 fw-bold text-success">
                                                    <?= number_format($tour['price'], 0, ',', '.') ?> VNĐ
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">
                                                <strong><i class="fas fa-clock text-primary"></i> Thời lượng</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary fs-6">
                                                    <?= $tour['duration_days'] ?> ngày
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">
                                                <strong><i class="fas fa-calendar-plus text-success"></i> Ngày tạo</strong>
                                            </td>
                                            <td>
                                                <?php if (!empty($tour['created_at'])): ?>
                                                    <?= date('d/m/Y H:i:s', strtotime($tour['created_at'])) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Chưa có thông tin</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>