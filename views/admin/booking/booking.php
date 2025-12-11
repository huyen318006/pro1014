<!DOCTYPE html>

<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Phân công HDV | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 + FontAwesome -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/assignments.css">
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
        <a href="<?= BASE_URL . '?act=booking'  ?>"><i class="fas fa-receipt"></i><span>Quản lý Booking</span></a>
        <a href="<?= BASE_URL.'?act=adminJournals' ?>"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
        <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- Header -->

    <div class="header">
        <h5><i class="fas fa-cogs"></i></h5>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>
    <!-- Main Content -->
    <!-- Content -->
    <div class="content p-4" style="background: linear-gradient(135deg, #f8fdff 0%, #f0f9ff 100%); min-height: 100vh;">
        <div class="container-fluid">

            <!-- Tiêu đề chính -->
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary mb-3">
                    <i class="fas fa-ticket-alt me-3"></i>Đặt Tour Du Lịch
                </h2>
                <p class="text-muted fs-5">Chọn lịch khởi hành phù hợp cho khách hàng</p>
            </div>

            <!-- Danh sách tour theo nhóm - giữ nguyên PHP 100% -->
            <?php foreach ($TourModel as $t): ?>
                <h4 class="text-primary fw-bold mt-5 mb-4 d-flex align-items-center gap-3">
                    <i class="fas fa-route text-cyan"></i>
                    <?= htmlspecialchars($t['name']) ?>
                </h4>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    <?php $hasTour = false; ?>
                    <?php foreach ($departures as $d):
                        if ($d['tour_id'] != $t['id']) continue;
                        if ($d['departure_date'] < date('Y-m-d') || $d['status'] != 'planned' || $d['max_participants'] <= 0) continue;
                        $hasTour = true;
                        $end_date = date('Y-m-d', strtotime($d['departure_date'] . ' + ' . ($d['duration_days'] - 1) . ' days'));
                    ?>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden tour-card">
                                <!-- Ảnh tour -->
                                <div class="position-relative">
                                    <img src="<?= BASE_URL . 'uploads/' . basename($d['image'] ?? 'default-tour.jpg') ?>"
                                        class="card-img-top"
                                        alt="<?= htmlspecialchars($d['tour_name']) ?>"
                                        style="height: 160px; object-fit: cover;">
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-success text-white px-3 py-2 rounded-pill shadow-sm">
                                            Sẵn sàng
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body p-3 d-flex flex-column">
                                    <h6 class="card-title fw-bold text-primary mb-2">
                                        <?= htmlspecialchars($d['tour_name']) ?>
                                    </h6>

                                    <div class="small text-muted mb-3">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="fas fa-calendar-alt text-cyan"></i>
                                            <span><?= date('d/m/Y', strtotime($d['departure_date'])) ?></span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="fas fa-calendar-check text-success"></i>
                                            <span><?= date('d/m/Y', strtotime($end_date)) ?></span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 text-truncate">
                                            <i class="fas fa-map-marker-alt text-danger"></i>
                                            <span><?= htmlspecialchars($d['meeting_point']) ?></span>
                                        </div>
                                    </div>

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-end mb-3">
                                            <div>
                                                <div class="text-success fw-bold fs-5">
                                                    <?= number_format($d['tour_price'], 0, ',', '.') ?>đ
                                                </div>
                                                <small class="text-muted">Còn <?= $d['max_participants'] ?> chỗ</small>
                                            </div>
                                        </div>

                                        <a href="<?= BASE_URL . '?act=bookingassig&id=' . $d['id'] ?>"
                                            class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm">
                                            Đặt tour
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if (!$hasTour): ?>
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted fs-5">Không có lịch khởi hành nào khả dụng</p>
                                        <a href="<?= BASE_URL ?>?act=DepartureAdmin" class="btn btn-outline-primary rounded-pill px-5 mt-3">
                                            Xem tất cả lịch
                                        </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<style>
    :root {
        --cyan: #00bcd4;
        --cyan-dark: #0097a7;
    }

    .text-cyan {
        color: var(--cyan) !important;
    }

    .text-primary {
        color: var(--cyan) !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--cyan), var(--cyan-dark)) !important;
        border: none !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 188, 212, 0.35) !important;
    }

    .tour-card {
        transition: all 0.35s ease;
        border: 1px solid #e8f5f9 !important;
    }

    .tour-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 188, 212, 0.18) !important;
        border-color: var(--cyan) !important;
    }

    .tour-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-img-top {
        transition: transform 0.4s ease;
    }

    .badge {
        font-size: 0.8rem !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content {
            padding: 1rem !important;
        }

        .card-body {
            padding: 1rem !important;
        }

        h6.card-title {
            font-size: 1rem;
        }
    }
</style>