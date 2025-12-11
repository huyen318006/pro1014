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
        <a href="?act=listAssignments"><i class="fas fa-user-secret"></i> <span>Phân công HDV</span></a>
        <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
        <a href="index.php?act=policies"><i class="fas fa-scroll"></i> <span>Quản lý Chính Sách</span></a>
        <a href="?act=incidents"><i class="fas fa-exclamation-triangle"></i><span>Danh sách báo cáo</span></a>
        <a href="<?= BASE_URL . '?act=DepartureAdmin' ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
        <a href="<?= BASE_URL . '?act=booking'  ?>"><i class="fas fa-receipt"></i><span>Quản lý Booking</span></a>
        <a href="<?= BASE_URL.'?act=adminJournals' ?>"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
        <a href="index.php?act=logout"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- Header -->
    <div class="header">
        <h5><i class="fas fa-cogs"></i> Bảng điều khiển lịch trình</h5>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-2">
                        <i class="fas fa-route text-primary me-2"></i>
                        Lịch trình: <?= htmlspecialchars($tour['name'] ?? 'Tour') ?>
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
                </div>
            </div>

            <div class="row g-4">
                <!-- Thông tin tour -->
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4">
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
                            <?php else: ?>
                                <p class="text-muted mb-0">Không tìm thấy thông tin tour tương ứng.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Danh sách HDV đã phân công -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-user-tie text-success me-2"></i>HDV đã phân công</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($assignedGuides)): ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach ($assignedGuides as $guide): ?>
                                        <div class="list-group-item px-0 py-3">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1"><?= htmlspecialchars($guide['fullname']) ?></h6>
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-envelope me-1"></i><?= htmlspecialchars($guide['email']) ?>
                                                    </small>
                                                    <?php if (!empty($guide['phone'])): ?>
                                                        <small class="text-muted d-block">
                                                            <i class="fas fa-phone me-1"></i><?= htmlspecialchars($guide['phone']) ?>
                                                        </small>
                                                    <?php endif; ?>
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="fas fa-calendar-check me-1"></i>
                                                        Ngày khởi hành: <?= date('d/m/Y', strtotime($guide['departure_date'])) ?>
                                                    </small>
                                                    <?php
                                                    $departureStatusLabels = [
                                                        'ready' => ['label' => 'Sẵn sàng', 'class' => 'bg-success'],
                                                        'pending' => ['label' => 'Chờ xử lý', 'class' => 'bg-warning text-dark'],
                                                        'completed' => ['label' => 'Hoàn thành', 'class' => 'bg-info'],
                                                        'cancelled' => ['label' => 'Đã hủy', 'class' => 'bg-danger']
                                                    ];
                                                    $depStatus = $departureStatusLabels[$guide['departure_status']] ?? ['label' => ucfirst($guide['departure_status']), 'class' => 'bg-secondary'];
                                                    ?>
                                                    <span class="badge <?= $depStatus['class'] ?> mt-2"><?= $depStatus['label'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0 text-center py-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Chưa có HDV nào được phân công cho tour này.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Danh sách lịch trình trong ngày -->
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-calendar-alt text-success me-2"></i>Danh sách lịch trình (<?= count($itineraries) ?> ngày)</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($itineraries as $index => $itinerary): ?>
                                <?php
                                $dayLabel = !empty($itinerary['day_number'])
                                    ? date('d/m/Y', strtotime($itinerary['day_number']))
                                    : 'Chưa cập nhật';
                                ?>
                                <div class="border rounded p-4 mb-3 <?= $index > 0 ? 'mt-3' : '' ?>">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="text-primary mb-1">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                <?= htmlspecialchars($itinerary['title']) ?>
                                            </h5>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                Ngày khởi hành: <?= $dayLabel ?>
                                            </small>
                                        </div>
                                        <?php if (empty($isLocked)): ?>
                                            <div class="btn-group">
                                                <a href="<?= BASE_URL ?>?act=editItinerary&id=<?= $itinerary['id'] ?>"
                                                    class="btn btn-sm btn-primary" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= BASE_URL ?>?act=deleteItinerary&id=<?= $itinerary['id'] ?>"
                                                    class="btn btn-sm btn-danger" title="Xoá"
                                                    onclick="return confirm('Bạn có chắc muốn xoá lịch trình này?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-success mb-2">
                                            <i class="fas fa-list-check me-2"></i>Hoạt động trong ngày
                                        </h6>
                                        <p class="mb-0" style="white-space: pre-line;"><?= nl2br(htmlspecialchars($itinerary['activities'])) ?></p>
                                    </div>

                                    <?php if (!empty($itinerary['notes'])): ?>
                                        <div>
                                            <h6 class="text-warning mb-2">
                                                <i class="fas fa-sticky-note me-2"></i>Ghi chú
                                            </h6>
                                            <p class="mb-0 text-muted" style="white-space: pre-line;"><?= nl2br(htmlspecialchars($itinerary['notes'])) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
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