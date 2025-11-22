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
        <a href="index.php?act=listItinerary"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Lịch Trình</span></a>
        <a href="?act=listAssignments"><i class="fas fa-map-marked-alt"></i> <span>Phân công HDV</span></a>
        <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
        <a href="#"><i class="fas fa-shopping-cart"></i> <span>Quản lý đơn đặt</span></a>
        <a href="#"><i class="fas fa-comments"></i> <span>Quản lý bình luận</span></a>
        <a href="<?= BASE_URL . '?act=DepartureAdmin'  ?>" class="active"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
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
                        <tr>
                            <td><?= $departure['tour_name'] ?? '' ?></td>
                            <td><?= $departure['departure_date'] ?? '' ?></td>
                            <td><?= $departure['meeting_point'] ?? '' ?></td>

                            <td><?= $departure['max_participants'] ?? '' ?></td>
                            <td><?= number_format($departure['tour_price'] ?? 0, 0, ',', '.') . ' VND' ?></td>
                            <td><?= $departure['note'] ?></td>
                            <td><?= $departure['status'] ?></td>
                            <td>
                                <a href="<?= BASE_URL . '?act=editDepartureAdmin&id=' . $departure['id'] ?>"><i class="fas fa-edit" title="Sửa lịch khởi hành"></i></a>
                                <a href="<?= BASE_URL . '?act=deleteDepartureAdmin&id=' . $departure['id'] ?>"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa lịch khởi hành này không?')">
                                    <i class="fas fa-trash" title="Xóa"></i>
                                </a>

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
    /* ==================== LỊCH KHỞI HÀNH - ĐẸP & CHUYÊN NGHIỆP ==================== */
    .departure-container {
        max-width: 1200px;
        margin: 30px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid #e0e6ed;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .departure-container .title {
        text-align: center;
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 12px;
    }

    .departure-container .title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #3498db, #2980b9);
        border-radius: 2px;
    }

    /* Bảng */
    .departure-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 15.5px;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .departure-table thead {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: #ffffff;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 0.8px;
    }

    .departure-table th {
        padding: 18px 15px;
        text-align: center;
        font-weight: 600;
    }

    .departure-table td {
        padding: 16px 15px;
        text-align: center;
        vertical-align: middle;
        border-bottom: 1px solid #eef2f7;
        color: #34495e;
    }

    .departure-table tbody tr {
        transition: all 0.3s ease;
    }

    .departure-table tbody tr:nth-child(even) {
        background-color: #f8fbff;
    }

    .departure-table tbody tr:hover {
        background: linear-gradient(to right, #ebf3fd, #f0f7ff);
        transform: scale(1.01);
        box-shadow: 0 8px 20px rgba(52, 152, 219, 0.15);
        z-index: 1;
        position: relative;
    }

    /* Cột trạng thái "Chưa phân công" */
    .departure-table td:contains('Chưa phân công') {
        color: #e67e22 !important;
        font-weight: 600;
    }

    /* Responsive cho mobile */
    @media (max-width: 768px) {
        .departure-container {
            margin: 15px;
            padding: 20px;
            border-radius: 12px;
        }

        .departure-container .title {
            font-size: 24px;
        }

        .departure-table {
            font-size: 14px;
        }

        .departure-table thead {
            display: none;
        }

        .departure-table tbody tr {
            display: block;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .departure-table td {
            display: block;
            text-align: right;
            padding: 8px 0;
            position: relative;
            padding-left: 50%;
            border: none;
        }

        .departure-table td::before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            width: 45%;
            font-weight: 600;
            color: #3498db;
            text-align: left;
        }

        /* Container link */
        a {
            text-decoration: none;
            /* bỏ gạch chân */
            margin: 0 5px;
            /* khoảng cách giữa các icon */
            display: inline-block;
        }

        /* Icon chung */
        a i.fas {
            font-size: 18px;
            /* kích thước icon */
            color: #555;
            /* màu mặc định */
            transition: color 0.3s, transform 0.2s;
            /* hiệu ứng khi hover */
        }

        /* Hover đổi màu và nhẹ phóng to */
        a i.fas:hover {
            color: #007bff;
            /* đổi màu xanh khi hover */
            transform: scale(1.2);
            /* phóng to 20% */
        }

        /* Icon riêng biệt nếu muốn màu khác nhau */
        a i.fa-edit {
            color: #28a745;
            /* màu xanh lá cho sửa */
        }

        a i.fa-trash {
            color: #dc3545;
            /* màu đỏ cho xóa */
        }

    }
</style>