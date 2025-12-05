<?php $act = 'services'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm dịch vụ mới | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/trangchu.css">
</head>
<body>
    <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo"><i class="fas fa-user-shield"></i></div>
    <h4>ADMIN</h4>
    <a href="index.php?act=home"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
    <a href="<?= BASE_URL . '?act=account' ?>"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
    <a href="index.php?act=listTours"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
    <a href="index.php?act=listItinerary"><i class="fas fa-route"></i> <span>Quản lý Lịch Trình</span></a>
    <a href="?act=listAssignments"><i class="fas fa-user-secret"></i> <span>Phân công HDV</span></a>
    <a href="index.php?act=services" class="active"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
    <a href="index.php?act=policies"><i class="fas fa-scroll"></i> <span>Quản lý Chính Sách</span></a>
    <a href="?act=incidents"><i class="fas fa-exclamation-triangle"></i><span>Danh sách báo cáo</span></a>
    <a href="<?= BASE_URL . '?act=DepartureAdmin' ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
    <a href="<?= BASE_URL . '?act=booking' ?>"><i class="fas fa-receipt"></i><span>Quản lý Booking</span></a>
    <a href="<?= BASE_URL . '?act=logout' ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
  </div>

  <!-- Header -->
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
                <h2 class="fw-bold text-primary">Thêm dịch vụ mới</h2>
                <a href="index.php?act=services" class="btn btn-secondary btn-lg">Quay lại</a>
            </div>

            <form action="index.php?act=servicesQuickStore" method="POST" class="card shadow p-5">
                <!-- CHỌN TOUR TRONG FORM -->
                <div class="mb-4">
                    <label class="form-label fw-bold fs-5 text-primary">Chọn Tour</label>
                    <select name="tour_id" class="form-select form-select-lg" required>
                        <option value="">-- Chọn tour --</option>
                        <?php foreach ((new TourModel())->getAllTours() as $t): ?>
                            <option value="<?= $t['id'] ?>">
                                [<?= htmlspecialchars($t['code'] ?? 'T' . $t['id']) ?>] <?= htmlspecialchars($t['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- DANH SÁCH DỊCH VỤ -->
                <div class="mb-5">
                    <label class="form-label fw-bold fs-5 text-success">Chọn dịch vụ đi kèm</label>
                    <?php
                    $dichvu = [
                        'Khách sạn 4 sao', 'Khách sạn 5 sao', 'Xe 16 chỗ', 'Xe 29 chỗ', 'Xe 45 chỗ',
                        'Nhà hàng Sen Vàng', 'Nhà hàng Bamboo', 'Nhà hàng Lotus',
                        'Vé Vịnh Hạ Long', 'Vé Hồ Gươm', 'Vé Lăng Bác'
                    ];
                    ?>
                    <div class="row g-3">
                        <?php foreach ($dichvu as $i => $dv): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]" value="<?= htmlspecialchars($dv) ?>" id="dv<?= $i ?>">
                                    <label class="form-check-label fw-medium" for="dv<?= $i ?>"><?= $dv ?></label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                    LƯU TOÀN BỘ DỊCH VỤ
                </button>
            </form>
        </div>
    </div>
</body>
</html>