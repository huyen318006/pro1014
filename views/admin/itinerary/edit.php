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
        <a href="#"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
        <a href="index.php?act=listTours"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
        <a href="index.php?act=listItinerary" class="active"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Lịch Trình</span></a>
        <a href="#"><i class="fas fa-shopping-cart"></i> <span>Quản lý đơn đặt</span></a>
        <a href="#"><i class="fas fa-comments"></i> <span>Quản lý bình luận</span></a>
        <a href="#"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
        <a href="index.php?act=logout"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- Header -->
    <div class="header">
        <h5><i class="fas fa-cogs"></i> Bảng điều khiển lịch trình</h5>
        <div class="user- info">
            <i class="fas fa-user-circle"></i>
            <span>Admin Chủ</span>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="form-container">
                    <h1 class="form-title">
                        <i class="bi bi-plus-circle"></i> Thêm Lịch Trình Mới
                    </h1>

                    <!-- Hiển thị thông báo lỗi từ session -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> <strong>Lỗi!</strong>
                            <?= htmlspecialchars($_SESSION['error']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <!-- Hiển thị lỗi validation -->
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> <strong>Lỗi!</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form thêm lịch trình -->
                    <form method="POST" action="">
                        <div class="row g-4">
                            <!-- Tour ID -->
                            <div class="form-group mb-3">
                                <label for="tour_id" class="form-label">Chọn Tour<span class="text-danger">*</span></label>
                                <select class="form-select" id="tour_id" name="tour_id" required>
                                    <option value="">-- Chọn tour --</option>
                                    <?php foreach ($tours as $tour): ?>
                                        <option value="<?= $tour['id'] ?>" <?= (isset($tour_id) && $tour_id == $tour['id']) ? 'selected' : '' ?>>
                                            #<?= $tour['id'] ?> - <?= htmlspecialchars($tour['name']) ?> (<?= htmlspecialchars($tour['destination']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Day number -->
                            <div class="form-group mb-3">
                                <label for="day_number" class="form-label">Ngày đi<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="day_number" name="day_number"
                                    value="<?= htmlspecialchars($day_number ?? '') ?>" required>
                            </div>

                            <!-- Title -->
                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Tiêu đề ngày <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="<?= htmlspecialchars($title ?? '') ?>"
                                    placeholder="VD: Khởi hành đến Đà Nẵng" maxlength="255" required>
                            </div>
                            <!-- Activities -->
                            <div class="form-group mb-3">
                                <label for="activities" class="form-label">Hoạt động trong ngày<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="activities" name="activities" rows="5"
                                    placeholder="Liệt kê các điểm tham quan, hoạt động chính" required><?= htmlspecialchars($activities ?? '') ?></textarea>
                            </div>

                            <!-- Notes -->
                            <div class="form-group mb-3">
                                <label for="notes" class="form-label">Ghi chú thêm (notes)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"
                                    placeholder="Ghi chú chuẩn bị, lưu ý đặc biệt"><?= htmlspecialchars($notes ?? '') ?></textarea>
                            </div>
                        </div>

                        <!-- Nút submit -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="bi bi-check-circle"></i> Thêm Lịch Trình
                            </button>
                            <a href="<?= BASE_URL ?>?act=listItinerary" class="btn btn-secondary btn-back">
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