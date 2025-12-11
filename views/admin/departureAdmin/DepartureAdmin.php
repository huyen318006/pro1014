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
        <a href="<?= BASE_URL . '?act=booking'  ?>"><i class="fas fa-receipt"></i><span>Quản lý Booking</span></a>
        <a href="<?= BASE_URL.'?act=adminJournals' ?>"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
        <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- Header -->
    <div class="header">
        <h5><i class="fas fa-cogs"></i> Bảng điều khiển quản trị</h5>
        <div class="user- info">
            <i class="fas fa-user-circle"></i>
            <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>

    <!-- Content -->
    <!-- Content -->
    <div class="content p-3 p-md-4" style="background: #f8fcfe; min-height: 100vh;">
        <div class="container-fluid">

            <!-- Header + Nút thêm -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-cyan mb-1">
                        <i class="fas fa-plane-departure me-3"></i>Lịch Khởi Hành
                    </h2>
                    <small class="text-muted">Tổng cộng: <?= count($departures) ?> lịch đang hoạt động</small>
                </div>
                <a href="<?= BASE_URL . '?act=addDepartureAdmin' ?>"
                    class="btn btn-cyan shadow-lg rounded-pill px-4 py-3 fw-bold">
                    <i class="fas fa-plus-circle me-2"></i>Thêm Lịch Mới
                </a>
            </div>

            <!-- Danh sách dạng Card dọc đẹp -->
            <div class="row g-3">
                <?php foreach ($departures as $d): ?>
                    <?php
                    $start = new DateTime($d['departure_date']);
                    $end   = clone $start;
                    $end->modify('+' . ($d['duration_days'] - 1) . ' days');
                    $startFmt = $start->format('d/m/Y');
                    $endFmt   = $end->format('d/m/Y');
                    ?>

                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-lift">
                            <div class="card-body p-4">
                                <div class="row align-items-center g-3">

                                    <!-- Tên tour -->
                                    <div class="col-lg-3 col-md-4">
                                        <h5 class="fw-bold text-cyan mb-1">
                                            <?= htmlspecialchars($d['tour_name']) ?>
                                        </h5>
                                        <small class="text-muted">
                                            <i class="fas fa-map-marked-alt me-1"></i>
                                            <?= htmlspecialchars($d['meeting_point']) ?>
                                        </small>
                                    </div>

                                    <!-- Ngày khởi hành + kết thúc -->
                                    <div class="col-lg-2 col-md-3 text-center">
                                        <div class="badge bg-primary text-white rounded-pill px-4 py-2 fw-bold">
                                            <?= $startFmt ?>
                                        </div>
                                        <div class="mt-2 text-muted small">→ <?= $endFmt ?></div>
                                    </div>

                                    <!-- Số chỗ -->
                                    <div class="col-lg-1 col-md-2 text-center">
                                        <div class="fw-bold text-danger fs-4"><?= $d['max_participants'] ?></div>
                                        <small class="text-muted">chỗ</small>
                                    </div>

                                    <!-- Giá tour -->
                                    <div class="col-lg-2 col-md-3 text-end">
                                        <div class="fw-bold text-success fs-5">
                                            <?= number_format($d['tour_price'], 0, ',', '.') ?>đ
                                        </div>
                                    </div>

                                    <!-- Ghi chú -->
                                    <div class="col-lg-2 col-6">
                                        <small class="text-muted">
                                            <?= $d['note'] ? htmlspecialchars(mb_substr($d['note'], 0, 40)) . '...' : '<em>Không có ghi chú</em>' ?>
                                        </small>
                                    </div>

                                    <!-- Trạng thái + Action -->
                                    <div class="col-lg-2 col-md-4 text-end">
                                        <?php if ($d['status'] == 'ready'): ?>
                                            <span class="badge bg-success rounded-pill px-4 py-2 fw-bold">Ready</span>
                                        <?php elseif ($d['status'] == 'cancelled'): ?>
                                            <span class="badge bg-danger rounded-pill px-4 py-2 fw-bold">Hủy</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark rounded-pill px-4 py-2 fw-bold">Chờ</span>
                                        <?php endif; ?>

                                        <div class="mt-2 d-inline-block">
                                            <?php if ($d['status'] !== 'ready'): ?>
                                                <a href="<?= BASE_URL . '?act=editDepartureAdmin&id=' . $d['id'] ?>"
                                                    class="btn btn-sm btn-outline-primary rounded-circle me-1" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= BASE_URL . '?act=deleteDepartureAdmin&id=' . $d['id'] ?>"
                                                    onclick="return confirm('Xóa lịch này vĩnh viễn?')"
                                                    class="btn btn-sm btn-outline-danger rounded-circle" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">
                                                    <i class="fas fa-lock"></i> Đã khởi hành
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Khi không có dữ liệu -->
                <?php if (empty($departures)): ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-calendar-times fa-5x text-muted mb-4 opacity-50"></i>
                        <h4 class="text-muted">Chưa có lịch khởi hành nào</h4>
                        <a href="<?= BASE_URL . '?act=addDepartureAdmin' ?>" class="btn btn-cyan btn-lg rounded-pill px-5 mt-3">
                            <i class="fas fa-plus me-2"></i> Tạo lịch đầu tiên
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
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

    .bg-cyan {
        background-color: var(--cyan) !important;
    }

    .btn-cyan {
        background: linear-gradient(135deg, #00bcd4, #0097a7);
        border: none;
        color: white !important;
    }

    .btn-cyan:hover {
        background: linear-gradient(135deg, #00acc1, #00838f);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 188, 212, 0.3) !important;
    }

    .card {
        transition: all 0.3s ease;
        border-left: 5px solid var(--cyan) !important;
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 188, 212, 0.15) !important;
    }

    .badge {
        font-size: 0.95rem !important;
    }

    /* Responsive siêu đẹp */
    @media (max-width: 768px) {
        .row>div>.card .row>div {
            text-align: center !important;
        }

        .row>div>.card .row>div:last-child {
            margin-top: 1rem;
        }

        .btn-sm {
            width: 40px;
            height: 40px;
        }
    }
</style>