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

        <!-- Nút thêm lịch khởi hành -->
        <div class="mb-3 text-end">
            <a href="<?= BASE_URL . '?act=addDepartureAdmin' ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm Lịch Khởi Hành
            </a>
        </div>

        <div class="departure-container">
            <h2 class="title">📅 Lịch Khởi Hành</h2>

            <table class="departure-table">
                <thead>
                    <tr>
                        <th>Tên Tour</th>
                        <th>Ngày Khởi Hành</th>
                        <th>Ngày kết thúc</th>
                        <th>Điểm Đón</th>
                        <th>Số Chỗ</th>
                        <th>Giá Tour</th>
                        <th>Ghi Chú</th>
                        <th>Trạng thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($departures as $departure): ?>
                        <?php
                        $day = $departure['duration_days']; // số ngày tour
                        $start_date = $departure['departure_date']; // dạng YYYY-mm-dd

                        // Ngày kết thúc = ngày khởi hành + (duration_days - 1)
                        $end_date = date('Y-m-d', strtotime($start_date . ' + ' . ($day - 1) . ' days'));


                        ?>
                        <tr>
                            <td><?= $departure['tour_name'] ?? '' ?></td>
                            <td><?= $departure['departure_date'] ?? '' ?></td>
                            <th><?= $end_date  ?></th>
                            <td><?= $departure['meeting_point'] ?? '' ?></td>

                            <td><?= $departure['max_participants'] ?? '' ?></td>
                            <td><?= number_format($departure['tour_price'] ?? 0, 0, ',', '.') . ' VND' ?></td>
                            <td><?= $departure['note'] ?></td>
                            <td><?= $departure['status'] ?></td>
                            <!-- Phầm kiểm tra trạng thái  xem nếu trạng thái danh sách lịch trình nếu đã sẵn sàng xuất phát  thì ko thể xóa -->
                            <td>
                                <?php if ($departure['status'] !== 'ready'): ?>
                                    <a href="<?= BASE_URL . '?act=editDepartureAdmin&id=' . $departure['id'] ?>">
                                        <i class="fas fa-edit" title="Sửa lịch khởi hành"></i>
                                    </a>
                                    <a href="<?= BASE_URL . '?act=deleteDepartureAdmin&id=' . $departure['id'] ?>"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa lịch khởi hành này không?')">
                                        <i class="fas fa-trash" title="Xóa"></i>
                                    </a>
                                <?php else: ?>
                                    <!-- Khi trạng thái là ready, dùng onclick alert -->
                                    <a href="javascript:void(0);" onclick="alert('Không thể sửa khi trạng thái tour đã  Ready!');">
                                        <i class="fas fa-edit text-secondary" title="Không thể sửa"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="alert('Không thể xóa khi trạng thái tour đã Ready!');">
                                        <i class="fas fa-trash text-secondary" title="Không thể xóa"></i>
                                    </a>
                                <?php endif; ?>
                            </td>


                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<style>
    /* ================= ROOT ================= */
    :root {
        --main: #00acc1;
        --dark: #007c91;
    }

    /* ================= CONTENT ================= */
    .content {
        padding: 30px 20px;
        background: #f5f8fc;
    }

    /* ================= CARD ================= */
    .departure-container {
        max-width: 1200px;
        margin: auto;
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 28px rgba(0, 0, 0, .08);
    }

    /* ================= TITLE ================= */
    .title {
        text-align: center;
        font-weight: 800;
        color: #222;
        margin-bottom: 25px;
        position: relative;
    }

    .title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--main), var(--dark));
    }

    /* ================= TABLE ================= */
    .departure-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 6px 16px rgba(0, 0, 0, .05);
    }

    /* HEADER */
    .departure-table thead {
        background: linear-gradient(135deg, var(--main), var(--dark));
    }

    .departure-table th {
        color: #f7fbff;
        /* chữ trắng dịu */
        font-weight: 700;
        letter-spacing: 0.4px;
        text-align: center;
        padding: 16px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, .15);
    }

    /* BODY */
    .departure-table td {
        text-align: center;
        padding: 14px;
        vertical-align: middle;
        border-top: 1px solid #eef2f6;
    }

    .departure-table tbody tr {
        transition: .25s;
    }

    .departure-table tbody tr:hover {
        background: #e9faff;
    }

    /* ================= STATUS ================= */
    .departure-table td:nth-child(8) {
        font-weight: 700;
        color: #444;
    }

    /* ================= ICON ================= */
    a {
        text-decoration: none;
    }

    a i {
        font-size: 17px;
        margin: 0 4px;
        transition: .2s;
    }

    a i:hover {
        transform: scale(1.2);
    }

    /* edit */
    .fa-edit {
        color: #28a745;
    }

    /* delete */
    .fa-trash {
        color: #dc3545;
    }

    /* ================= BUTTON ================= */
    .btn-success {
        border: none;
        border-radius: 14px;
        padding: 10px 16px;
        background: linear-gradient(135deg, #4caf50, #2e7d32);
        font-weight: 600;
        transition: .25s;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #52d15d, #185e1f);
    }

    /* ================= RESPONSIVE ================= */
    @media(max-width:768px) {

        .departure-container {
            padding: 20px;
        }

        .departure-table thead {
            display: none;
        }

        .departure-table tbody tr {
            display: block;
            margin-bottom: 14px;
            border-radius: 12px;
            background: #fff;
            padding: 16px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .06);
        }

        .departure-table td {
            display: flex;
            justify-content: space-between;
            border: none;
            padding: 8px 0;
        }

        .departure-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--main);
        }

    }
</style>