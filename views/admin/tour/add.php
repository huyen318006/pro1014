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
        <a href="index.php?act=home" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a href="<?= BASE_URL . '?act=account' ?>"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
        <a href="index.php?act=listTours"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
        <a href="index.php?act=listItinerary"><i class="fas fa-route"></i> <span>Quản lý Lịch Trình</span></a>
        <a href="?act=listAssignments"><i class="fas fa-user-secret"></i> <span>Phân công HDV</span></a>
        <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
        <a href="index.php?act=policies"><i class="fas fa-scroll"></i> <span>Quản lý Chính Sách</span></a>
        <a href="?act=incidents"><i class="fas fa-exclamation-triangle"></i><span>Danh sách báo cáo</span></a>
        <a href="<?= BASE_URL . '?act=DepartureAdmin' ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
        <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- Header -->
    <div class="header">
        <h5><i class="fas fa-cogs"></i> Bảng điều khiển tour</h5>
        <div class="user- info">
            <i class="fas fa-user-circle"></i>
            <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="form-container">
                    <h1 class="form-title">
                        <i class="bi bi-plus-circle"></i> Thêm Tour Mới
                    </h1>

                    <!-- Hiển thị lỗi validation -->
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> <strong>Lỗi!</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form thêm tour -->
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-row">
                            <!-- Cột trái -->
                            <div>
                                <!-- Mã Tour -->
                                <div class="form-group mb-3">
                                    <label for="code" class="form-label">Mã Tour <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="code" name="code"
                                        value="<?= $code ?? '' ?>"
                                        placeholder="VD: TOUR001" required>
                                    <small class="form-text text-muted">Mã tour duy nhất trong hệ thống</small>
                                </div>

                                <!-- Tên Tour -->
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Tên Tour <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="<?= $name ?? '' ?>"
                                        placeholder="VD: Đà Nẵng - Hội An 3 ngày" required>
                                </div>

                                <!-- Địa điểm -->
                                <div class="form-group mb-3">
                                    <label for="destination" class="form-label">Địa điểm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="destination" name="destination"
                                        value="<?= $destination ?? '' ?>"
                                        placeholder="VD: Đà Nẵng" required>
                                </div>
                            </div>

                            <!-- Cột phải -->
                            <div>
                                <!-- Loại Tour -->
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label">Loại Tour <span class="text-danger">*</span></label>
                                    <select id="category" name="category_id" class="form-select">
                                        <?php foreach ($categories as $cat){ ?>
                                            <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- Trạng thái -->
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                    <select class="form-select" id="status" name="status" required>
                                        <?php $currentStatus = $status ?? 'published'; ?>
                                        <option value="published" <?= $currentStatus === 'published' ? 'selected' : '' ?>>Hoạt động</option>
                                        <option value="draft" <?= $currentStatus === 'draft' ? 'selected' : '' ?>>Bản nháp</option>
                                        <option value="archived" <?= $currentStatus === 'archived' ? 'selected' : '' ?>>Ngừng kinh doanh</option>
                                    </select>
                                </div>

                                <!-- Giá -->
                                <div class="form-group mb-3">
                                    <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="price" name="price"
                                        value="<?= $price ?? '' ?>"
                                        placeholder="VD: 5000000" min="0" required>
                                </div>

                                <!-- Số ngày -->
                                <div class="form-group mb-3">
                                    <label for="duration_days" class="form-label">Số ngày <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="duration_days" name="duration_days"
                                        value="<?= $duration_days ?? '' ?>"
                                        placeholder="VD: 3" min="1" required>
                                </div>
                                <!-- Hình ảnh -->
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Hình ảnh <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="image" name="image" required>
                                </div>
                            </div>
                        </div>

                        <!-- Nút submit -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" name="submit" class="btn btn-primary btn-submit">
                                <i class="bi bi-check-circle"></i> Thêm Tour
                            </button>
                            <a href="<?= BASE_URL ?>?act=listTours" class="btn btn-secondary btn-back">
                                <i class="bi bi-x-circle"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>