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


            <!-- Tour Title and Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-2">
                                <i class="fas fa-map-marked-alt text-primary"></i>
                                <?= htmlspecialchars($tour['name']) ?>
                            </h2>
                            <p class="text-muted mb-0">
                                <span class="badge bg-secondary me-2"><?= htmlspecialchars($tour['code']) ?></span>
                                <?php
                                $statusLabels = [
                                    'published' => '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Hoạt động</span>',
                                    'draft' => '<span class="badge bg-warning text-dark"><i class="fas fa-edit"></i> Bản nháp</span>',
                                    'archived' => '<span class="badge bg-secondary"><i class="fas fa-archive"></i> Ngừng kinh doanh</span>'
                                ];
                                echo $statusLabels[$tour['status']] ?? htmlspecialchars($tour['status']);
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Cột trái - Thông tin chính -->
                <div class="col-lg-8">

                    <!-- Gallery Ảnh -->
                    <?php if (!empty($tour['images']) && count($tour['images']) > 0): ?>
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-images text-primary"></i> Thư viện ảnh Tour</h5>
                            </div>
                            <div class="card-body">
                                <div id="tourCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <?php foreach ($tour['images'] as $index => $image): ?>
                                            <button type="button" data-bs-target="#tourCarousel"
                                                data-bs-slide-to="<?= $index ?>"
                                                <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?>
                                                aria-label="Slide <?= $index + 1 ?>"></button>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="carousel-inner">
                                        <?php foreach ($tour['images'] as $index => $image): ?>
                                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                                <img src="<?= BASE_URL . htmlspecialchars($image['image_path']) ?>"
                                                    class="d-block w-100"
                                                    alt="<?= htmlspecialchars($image['image_title'] ?? 'Tour image') ?>"
                                                    style="height: 400px; object-fit: cover;">
                                                <?php if (!empty($image['image_title'])): ?>
                                                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                                                        <p class="mb-0"><?= htmlspecialchars($image['image_title']) ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if (count($tour['images']) > 1): ?>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#tourCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#tourCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <div class="row mt-3 g-2">
                                    <?php foreach ($tour['images'] as $index => $image): ?>
                                        <div class="col-3">
                                            <img src="<?= BASE_URL . htmlspecialchars($image['image_path']) ?>"
                                                class="img-thumbnail cursor-pointer"
                                                alt="Thumbnail"
                                                style="height: 80px; width: 100%; object-fit: cover;"
                                                data-bs-target="#tourCarousel"
                                                data-bs-slide-to="<?= $index ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Thông tin cơ bản -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle text-primary"></i> Thông tin cơ bản</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="info-item">
                                        <label><i class="fas fa-map-marker-alt text-danger"></i> Điểm đến</label>
                                        <p class="fw-bold"><?= htmlspecialchars($tour['destination']) ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-item">
                                        <label><i class="fas fa-list-alt text-info"></i> Loại Tour</label>
                                        <p>
                                            <?php
                                            $typeLabels = [
                                                'in_country' => '<span class="badge bg-info"><i class="fas fa-flag"></i> Trong nước</span>',
                                                'abroad' => '<span class="badge bg-warning text-dark"><i class="fas fa-globe"></i> Nước ngoài</span>',
                                                'adventure' => '<span class="badge bg-danger"><i class="fas fa-mountain"></i> Phiêu lưu</span>',
                                                'luxury' => '<span class="badge bg-dark"><i class="fas fa-gem"></i> Sang trọng</span>',
                                                'family' => '<span class="badge bg-success"><i class="fas fa-users"></i> Gia đình</span>'
                                            ];
                                            echo $typeLabels[$tour['type']] ?? htmlspecialchars($tour['type']);
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-item">
                                        <label><i class="fas fa-clock text-primary"></i> Thời gian</label>
                                        <p class="fw-bold"><?= htmlspecialchars($tour['duration_days']) ?> ngày</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-item">
                                        <label><i class="fas fa-money-bill-wave text-success"></i> Giá Tour</label>
                                        <p class="fw-bold text-success fs-5"><?= number_format($tour['price'], 0, ',', '.') ?> VNĐ</p>
                                    </div>
                                </div>
                                <?php if (isset($tour['max_participants'])): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-item">
                                            <label><i class="fas fa-user-friends text-warning"></i> Số người tối đa</label>
                                            <p class="fw-bold"><?= htmlspecialchars($tour['max_participants']) ?> người</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($tour['min_participants'])): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-item">
                                            <label><i class="fas fa-user text-secondary"></i> Số người tối thiểu</label>
                                            <p class="fw-bold"><?= htmlspecialchars($tour['min_participants']) ?> người</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Mô tả chi tiết -->
                    <?php if (!empty($tour['description'])): ?>
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-file-alt text-primary"></i> Mô tả chi tiết</h5>
                            </div>
                            <div class="card-body">
                                <div class="tour-description">
                                    <?= nl2br(htmlspecialchars($tour['description'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Điểm nổi bật -->
                    <?php if (!empty($tour['highlights'])): ?>
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-star text-warning"></i> Điểm nổi bật</h5>
                            </div>
                            <div class="card-body">
                                <div class="tour-highlights">
                                    <?= nl2br(htmlspecialchars($tour['highlights'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Chính sách hủy/đổi -->
                    <?php if (!empty($tour['cancellation_policy'])): ?>
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-exchange-alt text-danger"></i> Chính sách hủy/đổi</h5>
                            </div>
                            <div class="card-body">
                                <div class="cancellation-policy bg-light p-3 rounded">
                                    <?= nl2br(htmlspecialchars($tour['cancellation_policy'])) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Cột phải - Thông tin phụ -->
                <div class="col-lg-4">

                    <!-- Tags -->
                    <?php if (!empty($tour['tags']) && count($tour['tags']) > 0): ?>
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-tags text-primary"></i> Thẻ Tag</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($tour['tags'] as $tag): ?>
                                        <span class="badge bg-primary fs-6 px-3 py-2">
                                            <i class="fas fa-tag"></i> <?= htmlspecialchars($tag['tag_name']) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Lịch khởi hành sắp tới -->
                    <?php if (!empty($tour['schedules']) && count($tour['schedules']) > 0): ?>
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-calendar-check text-primary"></i> Lịch khởi hành</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    <?php foreach ($tour['schedules'] as $schedule): ?>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">
                                                        <i class="fas fa-plane-departure text-primary"></i>
                                                        <?= date('d/m/Y', strtotime($schedule['departure_date'])) ?>
                                                    </h6>
                                                    <small class="text-muted">
                                                        <i class="fas fa-plane-arrival"></i>
                                                        <?= date('d/m/Y', strtotime($schedule['return_date'])) ?>
                                                    </small>
                                                    <br>
                                                    <small>
                                                        <i class="fas fa-chair text-success"></i>
                                                        Còn <?= $schedule['available_seats'] ?> chỗ
                                                    </small>
                                                    <?php if (!empty($schedule['guide_name'])): ?>
                                                        <br>
                                                        <small>
                                                            <i class="fas fa-user-tie text-info"></i>
                                                            <?= htmlspecialchars($schedule['guide_name']) ?>
                                                        </small>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-end">
                                                    <p class="mb-1 fw-bold text-success">
                                                        <?= number_format($schedule['price'], 0, ',', '.') ?> ₫
                                                    </p>
                                                    <?php
                                                    $statusScheduleLabels = [
                                                        'available' => '<span class="badge bg-success">Còn chỗ</span>',
                                                        'full' => '<span class="badge bg-danger">Hết chỗ</span>',
                                                        'cancelled' => '<span class="badge bg-secondary">Đã hủy</span>',
                                                        'completed' => '<span class="badge bg-info">Hoàn thành</span>'
                                                    ];
                                                    echo $statusScheduleLabels[$schedule['status']] ?? '';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Thông tin bổ sung -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-cog text-primary"></i> Thông tin quản lý</h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <label><i class="fas fa-key text-secondary"></i> ID Tour</label>
                                <p><code class="bg-light p-2 rounded">#<?= htmlspecialchars($tour['id']) ?></code></p>
                            </div>
                            <?php if (!empty($tour['created_at'])): ?>
                                <div class="info-item mb-3">
                                    <label><i class="fas fa-calendar-plus text-success"></i> Ngày tạo</label>
                                    <p><?= date('d/m/Y H:i', strtotime($tour['created_at'])) ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($tour['updated_at'])): ?>
                                <div class="info-item">
                                    <label><i class="fas fa-calendar-edit text-warning"></i> Cập nhật lần cuối</label>
                                    <p><?= date('d/m/Y H:i', strtotime($tour['updated_at'])) ?></p>
                                </div>
                            <?php endif; ?>
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