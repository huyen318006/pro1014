<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Guide Dashboard | LOFT CITY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS chung với admin -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/guide.css"> <!-- màu mới -->

</head>

<body>

  <!-- SIDE BAR GUIDE -->
  <div class="sidebar">
    <div class="logo">
      <i class="fas fa-hiking"></i>
    </div>

    <h4>HƯỚNG DẪN VIÊN</h4>

    <a href="<?=  BASE_URL.'?act=guideDashboard' ?>" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>  </a>

    <a href="<?= BASE_URL.'?act=guideDepartures' ?>"><i class="fas fa-calendar-alt"></i> <span>Lịch khởi hành</span></a>

    <a href="<?= BASE_URL.'?act=MyTour' ?>"><i class="fas fa-map-marked-alt"></i> <span>Tour được giao</span></a>

    <a href="guideChecklist.php"><i class="fas fa-clipboard-check"></i> <span>Checklist</span></a>

    <a href="guideDiary.php"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>

    <a href="guideReport.php"><i class="fas fa-exclamation-triangle"></i> <span>Báo cáo sự cố</span></a>

    <a href="guideStatistic.php"><i class="fas fa-chart-line"></i> <span>Thống kê</span></a>
    <a href="<?= BASE_URL.'?act=logout' ?>">
      <i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span>
    </a>

  </div>

  <!-- HEADER -->
  <div class="header">
    <h5><i class="fas fa-user-tie"></i> Bảng điều khiển Hướng Dẫn Viên</h5>

    <div class="user-info">
      <i class="fas fa-user-circle"></i>
      <span><?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="content">

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">

      <div class="col-md-3 col-6">
        <div class="stat-card">
          <h6>Tour Tháng Này</h6>
          <h3>12</h3>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="stat-card">
          <h6>Tour Đã Hoàn Thành</h6>
          <h3>48</h3>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="stat-card">
          <h6>Đánh Giá TB</h6>
          <h3>4.8 ⭐</h3>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="stat-card">
          <h6>Khách Hài Lòng</h6>
          <h3>96%</h3>
        </div>
      </div>

    </div>

    <!-- TOUR SẮP KHỞI HÀNH -->
    <div class="table-card">

      <div class="card-header">
        <h5>Tour Sắp Khởi Hành</h5>
        <button class="btn-add"><i class="fas fa-plus"></i> Ghi chú nhanh</button>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Ảnh</th>
                <th>Tên Tour</th>
                <th>Ngày đi</th>
                <th>Số khách</th>
                <th>Trạng thái</th>
              </tr>
            </thead>

            <tbody>

              <tr>
                <td><img src="https://via.placeholder.com/58" class="tour-img"></td>
                <td><strong>Đà Lạt 3N2Đ</strong></td>
                <td>20/11/2025</td>
                <td>24</td>
                <td><span class="badge bg-warning">Chuẩn bị</span></td>
              </tr>

              <tr>
                <td><img src="https://via.placeholder.com/58" class="tour-img"></td>
                <td><strong>Nha Trang 4N3Đ</strong></td>
                <td>28/11/2025</td>
                <td>32</td>
                <td><span class="badge bg-success">Sẵn sàng</span></td>
              </tr>

            </tbody>

          </table>
        </div>
      </div>

    </div>

  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
