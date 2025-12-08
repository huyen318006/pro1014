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
        <a href="<?= BASE_URL . '?act=DepartureAdmin'  ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
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

            <!-- Overall Progress Card -->
            <?php
            // Calculate overall progress
            $totalCheckpoints = 0;
            $completedCheckpoints = 0;
            foreach ($itineraries as $itinerary) {
                $activities = array_filter(array_map('trim', explode("\n", $itinerary['activities'] ?? '')));
                $activityCheckpoints = $itinerary['activity_checkpoints'] ?? [];
                $totalCheckpoints += count($activities);
                foreach ($activityCheckpoints as $idx => $checkpoint) {
                    if ($idx > 0) $completedCheckpoints++;
                }
            }
            $overallProgress = $totalCheckpoints > 0 ? round(($completedCheckpoints / $totalCheckpoints) * 100) : 0;
            ?>
            <?php if ($totalCheckpoints > 0): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">
                                <i class="fas fa-tasks text-primary me-2"></i>Tiến Độ Tổng Quan
                            </h6>
                            <span class="badge bg-primary">
                                <?= $completedCheckpoints ?>/<?= $totalCheckpoints ?> hoạt động
                            </span>
                        </div>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: <?= $overallProgress ?>%;"
                                aria-valuenow="<?= $overallProgress ?>"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                <?= $overallProgress ?>%
                            </div>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle"></i> Tiến độ hoàn thành các hoạt động của hướng dẫn viên
                        </small>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Thông tin tour -->
                <div class="col-lg-4">
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
                                    <small class="text-muted d-block">Thời lượng</small>
                                    <span><?= htmlspecialchars($tour['duration_days']) ?> ngày</span>
                                </div>

                                <!-- Thông tin hướng dẫn viên -->
                                <?php if (!empty($itineraries)): ?>
                                    <?php
                                    $guideName = $itineraries[0]['guide_name'] ?? '';
                                    $guideEmail = $itineraries[0]['guide_email'] ?? '';
                                    $guidePhone = $itineraries[0]['guide_phone'] ?? '';
                                    ?>
                                    <?php if (!empty($guideName)): ?>
                                        <div class="mt-4 p-3 bg-light rounded border">
                                            <h6 class="text-success mb-3">
                                                <i class="fas fa-user-tie me-2"></i>Hướng Dẫn Viên
                                            </h6>
                                            <div class="d-flex flex-column gap-2">
                                                <div>
                                                    <i class="fas fa-user text-success me-2"></i>
                                                    <strong>Tên:</strong> <?= htmlspecialchars($guideName) ?>
                                                </div>
                                                <?php if (!empty($guideEmail)): ?>
                                                    <div>
                                                        <i class="fas fa-envelope text-success me-2"></i>
                                                        <strong>Email:</strong>
                                                        <a href="mailto:<?= htmlspecialchars($guideEmail) ?>" class="text-decoration-none">
                                                            <?= htmlspecialchars($guideEmail) ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($guidePhone)): ?>
                                                    <div>
                                                        <i class="fas fa-phone text-success me-2"></i>
                                                        <strong>SĐT:</strong>
                                                        <a href="tel:<?= htmlspecialchars($guidePhone) ?>" class="text-decoration-none">
                                                            <?= htmlspecialchars($guidePhone) ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-muted mb-0">Không tìm thấy thông tin tour tương ứng.</p>
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

                                    <?php
                                    // Parse activities
                                    $activities = array_filter(array_map('trim', explode("\n", $itinerary['activities'] ?? '')));
                                    $activityCheckpoints = $itinerary['activity_checkpoints'] ?? [];

                                    // Count checked activities
                                    $checkedCount = 0;
                                    foreach ($activityCheckpoints as $idx => $checkpoint) {
                                        if ($idx > 0) $checkedCount++; // Skip index 0 (whole day)
                                    }
                                    $totalActivities = count($activities);
                                    $progressPercent = $totalActivities > 0 ? round(($checkedCount / $totalActivities) * 100) : 0;
                                    ?>

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-success mb-0">
                                                <i class="fas fa-list-check me-2"></i>Hoạt động trong ngày
                                            </h6>
                                            <?php if ($totalActivities > 0): ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-check-circle text-success"></i>
                                                    <?= $checkedCount ?>/<?= $totalActivities ?> hoàn thành
                                                </small>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($totalActivities > 0): ?>
                                            <!-- Progress bar -->
                                            <div class="progress mb-3" style="height: 20px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: <?= $progressPercent ?>%;"
                                                    aria-valuenow="<?= $progressPercent ?>"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    <?= $progressPercent ?>%
                                                </div>
                                            </div>

                                            <!-- Activity checkboxes (read-only) -->
                                            <div class="list-group list-group-flush">
                                                <?php foreach ($activities as $activityIndex => $activity):
                                                    $realIndex = $activityIndex + 1;
                                                    $isChecked = isset($activityCheckpoints[$realIndex]);
                                                    $checkedAt = $isChecked ? $activityCheckpoints[$realIndex]['checked_at'] : null;
                                                ?>
                                                    <div class="list-group-item px-0 py-2 border-0">
                                                        <div class="form-check d-flex align-items-start">
                                                            <input class="form-check-input me-3 mt-1"
                                                                type="checkbox"
                                                                <?= $isChecked ? 'checked' : '' ?>
                                                                disabled
                                                                style="width: 1.25rem; height: 1.25rem;">
                                                            <label class="form-check-label flex-grow-1">
                                                                <span class="<?= $isChecked ? 'text-decoration-line-through text-muted' : '' ?>">
                                                                    <i class="fas fa-chevron-right text-primary me-2"></i><?= htmlspecialchars($activity) ?>
                                                                </span>
                                                                <?php if ($isChecked && $checkedAt): ?>
                                                                    <br><small class="text-success">
                                                                        <i class="fas fa-check-circle"></i>
                                                                        Hoàn thành: <?= date('d/m/Y H:i', strtotime($checkedAt)) ?>
                                                                    </small>
                                                                <?php endif; ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="mb-0 text-muted">Chưa có hoạt động nào</p>
                                        <?php endif; ?>
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