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
            <h2 class="title">Booking</h2>
            <div class="departure-cards">
                <?php foreach ($departures as $d):
                    $today = date('Y-m-d');

                    // Chỉ hiển thị tour có ngày >= hôm nay và trạng thái = 'planned'
                    if ($d['departure_date'] < $today || $d['status'] != 'planned') continue;

                ?>
                    <div class="departure-card">
                        <!-- Ảnh tour (nếu có) -->
                        <div class="card-image">
                            <img src="<?= BASE_URL . 'uploads/' . basename($d['image'] ?? 'default-tour.jpg') ?>" alt="<?= $d['tour_name'] ?>">
                        </div>

                        <!-- Nội dung tour -->
                        <div class="card-content">
                            <h3 class="tour-name"><?= $d['tour_name'] ?></h3>
                            <p class="departure-date">📅 <?= $d['departure_date'] ?></p>
                            <p class="meeting-point">📍 <?= $d['meeting_point'] ?></p>
                            <p class="price"><?= number_format($d['tour_price'], 0, ',', '.') ?> VND</p>

                            <!-- Badge trạng thái -->
                            <?php if ($d['status'] == 'planned'): ?>
                                <span class="badge badge-ready">Sẵn sàng</span>
                            <?php else: ?>
                                <span class="badge badge-planned"><?= ucfirst($d['status']) ?></span>
                            <?php endif; ?>

                            <!-- Nút đặt tour -->
                            <a href="<?= BASE_URL . '?act=bookingassig&id=' . $d['id'] ?>" class="btn-book">Đặt tour</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
            .departure-cards {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
            }

            .departure-card {
                width: 220px;
                background: #fff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                transition: transform 0.2s;
            }

            .departure-card:hover {
                transform: translateY(-5px);
            }

            .card-image img {
                width: 100%;
                height: 140px;
                object-fit: cover;
            }

            .card-content {
                padding: 10px;
                text-align: center;
            }

            .card-content h3 {
                font-size: 1.1em;
                margin: 5px 0;
            }

            .card-content p {
                font-size: 0.9em;
                margin: 3px 0;
            }

            .badge {
                display: inline-block;
                padding: 3px 6px;
                border-radius: 4px;
                font-size: 0.75em;
                margin: 5px 0;
            }

            .badge-ready {
                background-color: #28a745;
                color: #fff;
            }

            .badge-planned {
                background-color: #ffc107;
                color: #fff;
            }

            .btn-book {
                display: inline-block;
                margin-top: 8px;
                padding: 6px 10px;
                background-color: #007bff;
                color: #fff;
                border-radius: 5px;
                text-decoration: none;
                font-size: 0.9em;
            }

            .btn-book:hover {
                background-color: #0056b3;
            }
        </style>



    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>