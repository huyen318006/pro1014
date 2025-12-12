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
        <a href="index.php?act=statistics"><i class="fas fa-chart-bar"></i> <span>Thống Kê</span></a>
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
    <div class="content">

        <div class="container mt-5">
            <h2 class="text-center mb-4">Chỉnh sửa Lịch Khởi Hành</h2>

            <form action="<?= BASE_URL . '?act=updateDeparture' ?>" method="post" class="p-4 shadow rounded bg-white" style="max-width:600px;margin:auto;">

                <!-- Chọn loại tour -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Chọn loại tour</label>
                    <select name="tour_id" class="form-select" required>

                        <?php foreach ($getAllTours as $tour): ?>
                            <option value="<?= $tour['id'] ?>"><?= $tour['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Ngày khởi hành -->
                <?php
                foreach ($departures as $vl) { ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ngày khởi hành</label>
                        <input type="date" name="departure_date" class="form-control" value="<?= $vl['departure_date'] ?>" required>
                    </div>

                    <!-- Điểm tập trung -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Điểm tập trung</label>
                        <input type="text" name="meeting_point" class="form-control" value="<?= $vl['meeting_point'] ?>" required>
                    </div>

                    <!-- Số chỗ -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Số chỗ</label>
                        <input type="number" name="max_participants" class="form-control" value="<?= $vl['max_participants'] ?>" required>
                    </div>

                    <!-- Ghi chú -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ghi chú</label>
                        <input type="text" name="note" class="form-control" value="<?= $vl['note'] ?>">
                    </div>
                <?php

                }
                ?>

                <!-- Ẩn ID để update -->
                <input type="hidden" name="departure_id" value="<?= $vl['id'] ?>">

                <button type="submit" name="updateDeparture" class="btn btn-primary w-100">Cập nhật</button>
            </form>
        </div>

    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

    <style>
    /* ================= CONTENT ONLY ================= */
    /* Use global color variables from asset/css/trangchu.css - removed local overrides */

    /* KHU CONTENT */
    .content {
        padding: 40px 20px;
    }

    /* TITLE */
    .content h2 {
        font-weight: 800;
        color: #2c3e50;
    }

    /* FORM CARD */
    .content form {
        background: #ffffff;
        border-radius: 18px;
        padding: 25px;
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.08);
    }

    /* LABEL */
    .content .form-label {
        font-weight: 600;
        color: #34495e;
    }

    /* INPUT / SELECT */
    .content .form-control,
    .content .form-select {
        border-radius: 10px;
        padding: 10px 14px;
        border: 1px solid #dde6ee;
        transition: 0.25s ease;
    }

    /* FOCUS */
    .content .form-control:focus,
    .content .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.18);
    }

    /* BUTTON */
    .content .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        border-radius: 16px;
        padding: 12px;
        font-weight: 600;
        transition: 0.25s ease;
    }

    .content .btn-primary:hover {
        background: linear-gradient(135deg, #00d5f1, #007688);
        transform: scale(1.04);
    }

    /* MOBILE */
    @media(max-width:768px) {
        .content {
            padding: 20px 14px;
        }

        .content form {
            padding: 18px;
        }

        .content h2 {
            font-size: 22px;
            margin-bottom: 18px;
        }
    }
</style>

