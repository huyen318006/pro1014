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
    <div class="content">
        <div class="departure-container">
            <h2 class="title mb-4">Booking</h2>
            <?php foreach ($TourModel as $t): ?>
                <h4 class="text-danger fw-bold mt-5 mb-3"><?= htmlspecialchars($t['name']) ?></h4>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                    <?php $hasTour = false; ?>
                    <?php foreach ($departures as $d):
                        if ($d['tour_id'] != $t['id']) continue;
                        if ($d['departure_date'] < date('Y-m-d') || $d['status'] != 'planned' || $d['max_participants'] <= 0) continue;
                        $hasTour = true;
                        $end_date = date('Y-m-d', strtotime($d['departure_date'] . ' + ' . ($d['duration_days'] - 1) . ' days'));
                    ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm rounded-3 hover-scale">
                                <img src="<?= BASE_URL . 'uploads/' . basename($d['image'] ?? 'default-tour.jpg') ?>" class="card-img-top" alt="<?= $d['tour_name'] ?>">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= $d['tour_name'] ?></h5>
                                    <p class="mb-1"><span class="badge bg-light text-dark border">📅 <?= date('d/m/Y', strtotime($d['departure_date'])) ?></span></p>
                                    <p class="mb-1"><span class="badge bg-light text-dark border">⏳ <?= date('d/m/Y', strtotime($end_date)) ?></span></p>
                                    <p class="mb-1">📍 <?= $d['meeting_point'] ?></p>
                                    <p class="fw-bold"><?= number_format($d['tour_price'], 0, ',', '.') ?> VND</p>
                                    <span class="badge <?= $d['status'] == 'planned' ? 'bg-success' : 'bg-secondary' ?> rounded-pill mb-2"><?= $d['status'] == 'planned' ? 'Sẵn sàng' : 'Hết chỗ' ?></span>
                                    <a href="<?= BASE_URL . '?act=bookingassig&id=' . $d['id'] ?>" class="btn btn-primary mt-auto w-100">Đặt tour</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (!$hasTour): ?>
                        <div class="w-100 text-center py-4" style="font-size:18px; color:#555;">Không có lịch nào</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>






    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<style>
    /* ====== Vùng content ====== */
    .content {
        margin-left: 230px;
        padding: 30px;
        background: #f5f7fa;
        min-height: 100vh;
    }

    /* ====== Tiêu đề ====== */
    .content .title {
        font-weight: 700;
        font-size: 28px;
        color: #006978;
        border-left: 4px solid #006978;
        padding-left: 12px;
    }

    /* ====== Card của từng lịch khởi hành ====== */
    .hover-scale {
        transition: all 0.25s ease;
        border: 1px solid #e1e1e1;
    }

    .hover-scale:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    /* Ảnh tour */
    .card-img-top {
        height: 170px;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }

    /* Tiêu đề trong card */
    .card-title {
        font-size: 18px;
        font-weight: 600;
        color: #003c46;
    }

    /* Badge ngày tháng */
    .badge.border {
        font-size: 13px;
        background: #e6f9fb !important;
        border: 1px solid #c6e8ec !important;
        color: #004b56 !important;
    }

    /* Badge trạng thái ("Sẵn sàng") */
    .bg-success {
        background: #28a745 !important;
    }

    .bg-secondary {
        background: #6c757d !important;
    }

    /* Giá tour */
    .card-body p.fw-bold {
        font-size: 18px;
        color: #006978;
    }

    /* Nút đặt tour */
    .btn-primary {
        background: #006978;
        border: none;
        padding: 10px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 8px;
    }

    .btn-primary:hover {
        background: #0097A7;
        transform: translateY(-2px);
    }

    /* Khi list "Không có lịch nào" */
    .no-schedule {
        font-size: 18px;
        color: #555;
        padding: 20px;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .content {
            margin-left: 0;
            padding: 20px;
        }

        .card-img-top {
            height: 150px;
        }
    }
</style>