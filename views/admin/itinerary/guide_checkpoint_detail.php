<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết Checkpoint HDV | LOFT CITY</title>
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
        <a href="index.php?act=listItinerary"><i class="fas fa-route"></i> <span>Quản lý Lịch Trình</span></a>
        <a href="?act=listAssignments" class="active"><i class="fas fa-user-secret"></i> <span>Phân công HDV</span></a>
        <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
        <a href="index.php?act=policies"><i class="fas fa-scroll"></i> <span>Quản lý Chính Sách</span></a>
        <a href="?act=incidents"><i class="fas fa-exclamation-triangle"></i><span>Danh sách báo cáo</span></a>
        <a href="<?= BASE_URL . '?act=DepartureAdmin' ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
        <a href="<?= BASE_URL . '?act=booking'  ?>"><i class="fas fa-receipt"></i><span>Quản lý Booking</span></a>
        <a href="<?= BASE_URL.'?act=adminJournals' ?>"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
        <a href="index.php?act=statistics"><i class="fas fa-chart-bar"></i> <span>Thống Kê</span></a>
        <a href="index.php?act=logout"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- Header -->
    <div class="header">
        <h5><i class="fas fa-tasks"></i> Chi tiết Checkpoint HDV</h5>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container-fluid">

            <!-- Back Button -->
            <div class="mb-3">
                <a href="<?= BASE_URL ?>?act=listAssignments" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách phân công
                </a>
            </div>

            <!-- Tour & Guide Info -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="<card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> Thông tin chuyến đi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Tour:</strong> <?= htmlspecialchars($info['tour_name']) ?></p>
                                    <p class="mb-2"><strong>Mã tour:</strong> <code><?= htmlspecialchars($info['tour_code']) ?></code></p>
                                    <p class="mb-2"><strong>Ngày khởi hành:</strong> <?= date('d/m/Y', strtotime($info['departure_date'])) ?></p>
                                    <p class="mb-0"><strong>Thời lượng:</strong> <?= $info['duration_days'] ?> ngày</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Hướng dẫn viên:</strong> <?= htmlspecialchars($info['guide_name']) ?></p>
                                    <p class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($info['guide_email']) ?></p>
                                    <p class="mb-0"><strong>Số điện thoại:</strong> <?= htmlspecialchars($info['guide_phone'] ?? 'N/A') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Tiến độ</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <h2 class="text-success mb-0"><?= $progress_percent ?>%</h2>
                                <small class="text-muted">Hoàn thành</small>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                    style="width: <?= $progress_percent ?>%;" 
                                    aria-valuenow="<?= $progress_percent ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?= $completed_activities ?>/<?= $total_activities ?>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <?= $completed_activities ?> / <?= $total_activities ?> hoạt động
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Itinerary Checkpoints -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-list-check text-success"></i> Chi tiết các hoạt động đã check</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($itineraries)): ?>
                        <?php foreach ($itineraries as $index => $itinerary): 
                            $dayNumber = $itinerary['day_number'];
                            $activities = array_filter(array_map('trim', explode("\n", $itinerary['activities'] ?? '')));
                            $activityCheckpoints = $itinerary['activity_checkpoints'] ?? [];
                            
                            // Count checked activities
                            $checkedCount = 0;
                            foreach ($activityCheckpoints as $idx => $checkpoint) {
                                if ($idx > 0) $checkedCount++; // Skip index 0
                            }
                            
                            $isCompleted = ($checkedCount == count($activities) && count($activities) > 0);
                        ?>
                            <div class="card mb-3 border-start border-3 <?= $isCompleted ? 'border-success' : 'border-secondary' ?>">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">
                                            <i class="fas fa-calendar-day text-primary"></i>
                                            <?= htmlspecialchars($itinerary['title']) ?>
                                            <small class="text-muted">(Ngày <?= $dayNumber ?>)</small>
                                        </h6>
                                        <span class="badge <?= $isCompleted ? 'bg-success' : 'bg-secondary' ?>">
                                            <?= $checkedCount ?>/<?= count($activities) ?> hoạt động
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($activities)): ?>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($activities as $actIdx => $activity): 
                                                $activityIndex = $actIdx + 1;
                                                $isChecked = isset($activityCheckpoints[$activityIndex]);
                                                $checkpoint = $activityCheckpoints[$activityIndex] ?? null;
                                            ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center">
                                                            <?php if ($isChecked): ?>
                                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                            <?php else: ?>
                                                                <i class="far fa-circle text-muted me-2"></i>
                                                            <?php endif; ?>
                                                            <span class="<?= $isChecked ? 'text-decoration-line-through text-muted' : '' ?>">
                                                                <?= htmlspecialchars($activity) ?>
                                                            </span>
                                                        </div>
                                                        <?php if ($isChecked && !empty($checkpoint['notes'])): ?>
                                                            <small class="text-muted ms-4">
                                                                <i class="fas fa-sticky-note"></i>
                                                                Ghi chú: <?= htmlspecialchars($checkpoint['notes']) ?>
                                                            </small>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if ($isChecked): ?>
                                                        <small class="text-muted">
                                                            <i class="fas fa-clock"></i>
                                                            <?= date('d/m/Y H:i', strtotime($checkpoint['checked_at'])) ?>
                                                        </small>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="text-muted mb-0"><i>Không có hoạt động nào</i></p>
                                    <?php endif; ?>

                                    <?php if (!empty($itinerary['notes'])): ?>
                                        <div class="alert alert-info mt-3 mb-0">
                                            <strong><i class="fas fa-info-circle"></i> Ghi chú:</strong>
                                            <?= nl2br(htmlspecialchars($itinerary['notes'])) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted text-center py-4">
                            <i class="fas fa-info-circle"></i> Chưa có lịch trình nào
                        </p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

