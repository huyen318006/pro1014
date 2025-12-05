<?php
// File: views/admin/services/create_by_departure.php
$departure_id = $_GET['departure_id'] ?? null;

// Lấy thông tin departure và tour
$departure = (new Departures())->getAllDepartures($departure_id);
$tour = (new TourModel())->getTourById($departure['tour_id'] ?? 0);

// Danh sách dịch vụ mẫu (có thể thay bằng bảng service_types sau)
$servicesGroups = [
    'Khách sạn' => ['Hotel Paradise 4*', 'Hotel Luxury 5*', 'Hanoi Old Quarter Hotel', 'Sunrise Hotel'],
    'Xe đưa đón' => ['Xe Minh Tâm 16 chỗ', 'Xe Huyền Ngọc 29 chỗ', 'Xe Hoàng Long 45 chỗ', 'Limousine VIP 9 chỗ'],
    'Nhà hàng' => ['Nhà hàng Sen Vàng', 'Nhà hàng Bamboo', 'Nhà hàng Lotus', 'Sky View Restaurant'],
    'Vé tham quan' => ['Vịnh Hạ Long', 'Hồ Gươm', 'Lăng Bác', 'Văn Miếu Quốc Tử Giám']
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm dịch vụ • <?= htmlspecialchars($tour['name'] ?? '') ?> | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/trangchu.css">
    <style>
        .service-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.15)!important; }
        .btn-save { border-radius: 50px; padding: 15px 60px; font-size: 1.2rem; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><i class="fas fa-user-shield"></i></div>
        <h4>ADMIN</h4>
        <a href="index.php?act=home"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a href="index.php?act=services" class="active"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
        <a href="<?= BASE_URL ?>?act=DepartureAdmin"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
        <a href="<?= BASE_URL ?>?act=logout"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <div class="header">
        <h5><i class="fas fa-cogs"></i> Bảng điều khiển quản trị</h5>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-primary"><i class="fas fa-plus-circle"></i> Thêm dịch vụ</h2>
                </div>
                <a href="index.php?act=services" class="btn btn-secondary btn-lg"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="index.php?act=servicesStoreByDeparture" method="POST" class="card shadow">
                <input type="hidden" name="departure_id" value="<?= $departure_id ?>">
                <div class="card-body p-5">

                    <h4 class="text-center mb-5 text-success fw-bold">
                        <i class="fas fa-concierge-bell"></i> Chọn dịch vụ đi kèm
                    </h4>

                    <div class="row g-4">
                        <?php foreach ($servicesGroups as $group => $items): ?>
                            <div class="col-lg-6">
                                <div class="card service-card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-success text-white text-center fw-bold">
                                        <?= $group ?> (<?= count($items) ?>)
                                    </div>
                                    <div class="card-body">
                                        <?php foreach ($items as $svc): ?>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="services[]" value="<?= htmlspecialchars($svc) ?>" 
                                                       id="svc_<?= md5($svc) ?>">
                                                <label class="form-check-label" for="svc_<?= md5($svc) ?>">
                                                    <?= htmlspecialchars($svc) ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-success btn-save shadow-lg">
                            <i class="fas fa-save"></i> LƯU DỊCH VỤ
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>