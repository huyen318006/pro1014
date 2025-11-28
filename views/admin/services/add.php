<?php
$departure_id = $_GET['departure_id'] ?? null;
$servicesGroups = [
    'Khách sạn' => ['Hotel Paradise', 'Hotel Luxury', 'Hotel Hanoi'],
    'Xe đưa đón' => ['Xe Minh Tâm', 'Xe Huyền Ngọc', 'Xe Hoàng Long'],
    'Nhà hàng' => ['Nhà hàng Sen', 'Nhà hàng Bamboo', 'Nhà hàng Lotus'],
    'Vé tham quan' => ['Vịnh Hạ Long', 'Hồ Gươm', 'Lăng Bác']
];
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Thêm Dịch vụ mới | LOFT CITY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS Dashboard chính thức -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">

  <style>
    .form-control,
    .form-select {
      border-radius: 12px;
    }

    .btn-lg {
      border-radius: 50px;
    }

    .card {
      border-radius: 20px;
      overflow: hidden;
    }
  </style>
</head>

<body>

  <!-- SIDEBAR ĐẸP Y HỆT TRANG DASHBOARD -->
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

  <!-- HEADER ĐẸP NHƯ TRANG CHỦ -->
  <div class="header">
    <h5><i class="fas fa-cogs"></i> Bảng điều khiển quản trị</h5>
    <div class="user-info">
      <i class="fas fa-user-circle"></i>
      <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
    </div>
  </div>

  <!-- NỘI DUNG CHÍNH -->
  <div class="content">
    <div class="container-fluid py-4">

      <!-- Tiêu đề trang -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
          <i class="fas fa-plus-circle"></i> Thêm Dịch vụ đi kèm mới
          <small class="text-muted d-block fs-5">Đi ăn • Xe đưa đón • Nhà hàng • Vé tham quan...</small>
        </h2>
        <a href="index.php?act=services" class="btn btn-secondary btn-lg">
          <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
      </div>

      <!-- Thông báo -->
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <?= $_SESSION['success'];
          unset($_SESSION['success']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <?= $_SESSION['error'];
          unset($_SESSION['error']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Form dịch vụ -->
      <div class="table-card">
        <div class="card-body p-5">
          <form action="index.php?act=servicesStore" method="POST">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">


            <div class="row g-4">
              <!-- Dịch vụ -->
              <div class="col-lg-12">
                <label class="form-label fw-bold"><i class="fas fa-route"></i> Dịch vụ <span class="text-danger">*</span></label>
                <div class="row g-3">
                <div class="col-md-6">
                  <a href="index.php?act=servicesAdd&type=hotel&departure_id=<?= $departure_id ?>" 
                    class="btn btn-lg btn-outline-primary w-100">🏨 Khách sạn</a>
                </div>

                <div class="col-md-6">
                  <a href="index.php?act=servicesAdd&type=car&departure_id=<?= $departure_id ?>" 
                    class="btn btn-lg btn-outline-secondary w-100">🚐 Xe đưa đón</a>
                </div>

                <div class="col-md-6">
                  <a href="index.php?act=servicesAdd&type=restaurant&departure_id=<?= $departure_id ?>" 
                    class="btn btn-lg btn-outline-success w-100">🍽️ Nhà hàng</a>
                </div>

                <div class="col-md-6">
                  <a href="index.php?act=servicesAdd&type=ticket&departure_id=<?= $departure_id ?>" 
                    class="btn btn-lg btn-outline-warning w-100">🎟️ Vé tham quan</a>
                </div>
              </div>

            <div class="text-end mt-5">
              <button type="submit" class="btn btn-success btn-lg px-5">
                <i class="fas fa-save"></i> Lưu Dịch vụ
              </button>
            </div>

          </form>
          <?php unset($_SESSION['old']); ?>

        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>