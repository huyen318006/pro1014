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
        <a href="index.php?act=listTours"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
        <a href="index.php?act=listItinerary" class="active"><i class="fas fa-route"></i> <span>Quản lý Lịch Trình</span></a>
        <a href="?act=listAssignments"><i class="fas fa-map-marked-alt"></i> <span>Phân công HDV</span></a>
        <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
        <a href="#"><i class="fas fa-shopping-cart"></i> <span>Quản lý đơn đặt</span></a>
        <a href="#"><i class="fas fa-comments"></i> <span>Quản lý bình luận</span></a>
        <a href="<?= BASE_URL . '?act=DepartureAdmin'  ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
        <a href="index.php?act=logout"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- Header -->
    <div class="header">
        <h5><i class="fas fa-cogs"></i> Bảng điều khiển lịch trình</h5>
        <div class="user- info">
            <i class="fas fa-user-circle"></i>
            <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container-fluid">

            <?php
                $dayLabel = !empty($itinerary['day_number'])
                    ? date('d/m/Y', strtotime($itinerary['day_number']))
                    : 'Chưa cập nhật';
            ?>

            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-2">
                        <i class="fas fa-route text-primary me-2"></i>
                        <?= htmlspecialchars($itinerary['title']) ?>
                    </h2>
                    <?php if (!empty($isLocked)): ?>
                        <div class="alert alert-warning py-2 px-3 mb-0 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-lock"></i>
                            <span>Tour có lịch READY, không thể chỉnh sửa hoặc xoá lịch trình này.</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="<?= BASE_URL ?>?act=listItinerary" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
                    </a>
                    <?php if (empty($isLocked)): ?>
                        <a href="<?= BASE_URL ?>?act=editItinerary&id=<?= $itinerary['id'] ?>" class="btn btn-primary mt-2 mt-md-0">
                            <i class="fas fa-edit me-1"></i> Sửa lịch trình
                        </a>
                    <?php else: ?>
                        <button type="button" class="btn btn-secondary mt-2 mt-md-0" disabled>
                            <i class="fas fa-ban me-1"></i> Đã khoá (READY)
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white d-flex align-items-center justify-content-between">
                            <h5 class="mb-0"><i class="fas fa-plane-departure text-primary me-2"></i>Thông tin tour</h5>
                            <?php if (!empty($tour['status'])): ?>
                                <?php
                                    $statusLabels = [
                                        'published' => ['label' => 'Đang hoạt động', 'class' => 'bg-success'],
                                        'draft' => ['label' => 'Bản nháp', 'class' => 'bg-warning text-dark'],
                                        'archived' => ['label' => 'Ngừng kinh doanh', 'class' => 'bg-secondary']
                                    ];
                                    $statusMeta = $statusLabels[$tour['status']] ?? ['label' => ucfirst($tour['status']), 'class' => 'bg-secondary'];
                                ?>
                                <span class="badge <?= $statusMeta['class'] ?>"><?= $statusMeta['label'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($tour)): ?>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Mã tour</small>
                                    <strong>#<?= htmlspecialchars($tour['code']) ?></strong>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Tên tour</small>
                                    <span class="fw-bold"><?= htmlspecialchars($tour['name']) ?></span>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Điểm đến</small>
                                    <span><?= htmlspecialchars($tour['destination']) ?></span>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Thời lượng</small>
                                    <span><?= htmlspecialchars($tour['duration_days']) ?> ngày</span>
                                </div>
                                <?php if (!empty($tour['image'])): ?>
                                    <div class="mt-4">
                                        <img src="<?= BASE_URL . 'uploads/' . basename($tour['image']) ?>"
                                             class="img-fluid rounded shadow-sm w-100"
                                             alt="<?= htmlspecialchars($tour['name']) ?>"
                                             style="max-height: 280px; object-fit: cover;">
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-muted mb-0">Không tìm thấy thông tin tour tương ứng.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Thông tin lịch trình</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Ngày khởi hành</small>
                                    <span class="fw-bold"><?= $dayLabel ?></span>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Mã lịch trình</small>
                                    <span>#<?= $itinerary['id'] ?></span>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block">Tiêu đề</small>
                                    <span class="fw-bold"><?= htmlspecialchars($itinerary['title']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white d-flex align-items-center">
                            <h5 class="mb-0"><i class="fas fa-list-check text-success me-2"></i>Hoạt động trong ngày</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0" style="white-space: pre-line;"><?= nl2br(htmlspecialchars($itinerary['activities'])) ?></p>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex align-items-center">
                            <h5 class="mb-0"><i class="fas fa-sticky-note text-warning me-2"></i>Ghi chú</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($itinerary['notes'])): ?>
                                <p class="mb-0" style="white-space: pre-line;"><?= nl2br(htmlspecialchars($itinerary['notes'])) ?></p>
                            <?php else: ?>
                                <p class="text-muted mb-0">Không có ghi chú bổ sung.</p>
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