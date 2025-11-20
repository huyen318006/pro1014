<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chỉnh sửa Dịch vụ | LOFT CITY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS Dashboard chính thức -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">

  <style>
    .form-control, .form-select { border-radius: 12px; }
    .btn-lg { border-radius: 50px; }
    .card { border-radius: 20px; overflow: hidden; }
  </style>
</head>
<body>

  <!-- SIDEBAR ĐẸP Y HỆT TRANG DASHBOARD -->
  <div class="sidebar">
    <div class="logo"><i class="fas fa-user-shield"></i></div>
    <h4>ADMIN</h4>
    <a href="index.php?act=home"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
    <a href="#"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
    <a href="index.php?act=listTours"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
    <a href="index.php?act=listSchedule"><i class="fas fa-calendar-alt"></i> <span>Quản lý Lịch Trình</span></a>
    <a href="index.php?act=services" class="active"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
    <a href="#"><i class="fas fa-tasks"></i> <span>Phân công HDV</span></a>
    <a href="#"><i class="fas fa-shopping-cart"></i> <span>Quản lý đơn đặt</span></a>
    <a href="#"><i class="fas fa-comments"></i> <span>Quản lý bình luận</span></a>
    <a href="#"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
  </div>

  <!-- HEADER ĐẸP NHƯ TRANG CHỦ -->
  <div class="header">
    <h5><i class="fas fa-cogs"></i> Bảng điều khiển quản trị</h5>
    <div class="user-info">
      <i class="fas fa-user-circle"></i>
      <span>Admin Chủ</span>
    </div>
  </div>

  <!-- NỘI DUNG CHÍNH -->
  <div class="content">
    <div class="container-fluid py-4">

      <!-- Tiêu đề trang -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
          <i class="fas fa-edit"></i> Chỉnh sửa Dịch vụ đi kèm
          <small class="text-muted d-block fs-5">ID: #<?= $service['id'] ?? '' ?> • <?= htmlspecialchars($service['service_name'] ?? '') ?></small>
        </h2>
        <a href="index.php?act=services" class="btn btn-secondary btn-lg">
          <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
      </div>

      <!-- Thông báo -->
      <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <?= $_SESSION['success']; unset($_SESSION['success']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Form chỉnh sửa -->
      <div class="table-card">
        <div class="card-body p-5">
          <form action="index.php?act=servicesUpdate" method="POST">
            <input type="hidden" name="id" value="<?= $service['id'] ?>">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <div class="row g-4">
              <!-- Chuyến đi -->
              <div class="col-lg-12">
                <label class="form-label fw-bold"><i class="fas fa-route"></i> Chuyến đi <span class="text-danger">*</span></label>
                <select name="departure_id" class="form-select form-select-lg" required>
                  <option value="">-- Chọn chuyến đi --</option>
                  <?php foreach($departures as $d): 
                    $selected = ($d['id'] == $service['departure_id']) ? 'selected' : '';
                    $display = htmlspecialchars($d['tour_name'] ?? 'Tour ID: '.$d['tour_id']);
                    $display .= ' - ' . $d['departure_date_formatted'];
                    $display .= !empty($d['meeting_point']) ? ' • ' . htmlspecialchars($d['meeting_point']) : '';
                  ?>
                    <option value="<?= $d['id'] ?>" <?= $selected ?>><?= $display ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Loại dịch vụ & Đối tác -->
              <div class="col-lg-6">
                <label class="form-label fw-bold"><i class="fas fa-concierge-bell"></i> Loại dịch vụ <span class="text-danger">*</span></label>
                <input type="text" name="service_name" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($service['service_name'] ?? '') ?>" required>
              </div>
              <div class="col-lg-6">
                <label class="form-label fw-bold"><i class="fas fa-building"></i> Đối tác <span class="text-danger">*</span></label>
                <input type="text" name="partner_name" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($service['partner_name'] ?? '') ?>" required>
              </div>

              <!-- Trạng thái -->
              <div class="col-lg-6">
                <label class="form-label fw-bold"><i class="fas fa-check-circle"></i> Trạng thái</label>
                <select name="status" class="form-select form-select-lg">
                  <option value="pending"   <?= ($service['status'] ?? 'pending')=='pending'?'selected':'' ?>>Chờ xử lý</option>
                  <option value="confirmed" <?= ($service['status'] ?? '')=='confirmed'?'selected':'' ?>>Đã xác nhận</option>
                  <option value="cancelled" <?= ($service['status'] ?? '')=='cancelled'?'selected':'' ?>>Đã hủy</option>
                </select>
              </div>

              <!-- Ghi chú -->
              <div class="col-lg-12">
                <label class="form-label fw-bold"><i class="fas fa-sticky-note"></i> Ghi chú</label>
                <textarea name="note" rows="5" class="form-control form-control-lg"><?= htmlspecialchars($service['note'] ?? '') ?></textarea>
              </div>
            </div>

            <div class="text-end mt-5">
              <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-save"></i> Cập nhật Dịch vụ
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>