<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Sinh CSRF token nếu chưa có
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>

<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chỉnh sửa Dịch vụ | LOFT CITY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + FontAwesome -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS Dashboard -->

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">

  <style>
    .form-control, .form-select { border-radius: 12px; }
    .btn-lg { border-radius: 50px; }
    .card { border-radius: 20px; overflow: hidden; }
  </style>

</head>
<body>

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
    <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
</div>

<div class="header">
  <h5><i class="fas fa-cogs"></i> Bảng điều khiển quản trị</h5>
  <div class="user-info"><i class="fas fa-user-circle"></i> <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span></div>
</div>

<div class="content">
<div class="container-fluid py-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary">
      <i class="fas fa-edit"></i> Chỉnh sửa Dịch vụ đi kèm
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
                <option value="">-- Chuyến đi --</option>
                <?php foreach($departures as $d): 
                    $selected = ($d['id'] == ($_SESSION['old']['departure_id'] ?? $service['departure_id'] ?? '')) ? 'selected' : '';
                    $display = $d['tour_name'] ?? 'Tour ID: '.$d['tour_id'];
                    $display .= ' - ' . $d['departure_date_formatted'];
                    $display .= !empty($d['meeting_point']) ? ' • ' . $d['meeting_point'] : '';
                ?>
                    <option value="<?= $d['id'] ?>" <?= $selected ?>><?= $display ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Loại dịch vụ & Đối tác -->
        <div class="col-lg-6">
            <label class="form-label fw-bold"><i class="fas fa-concierge-bell"></i> Loại dịch vụ <span class="text-danger">*</span></label>
            <input type="text" name="service_name" class="form-control form-control-lg" 
                   value="<?= $_SESSION['old']['service_name'] ?? $service['service_name'] ?? '' ?>" 
                   placeholder="VD: Khách sạn, Xe đưa đón, Nhà hàng..." required>
        </div>
        <div class="col-lg-6">
            <label class="form-label fw-bold"><i class="fas fa-building"></i> Đối tác <span class="text-danger">*</span></label>
            <input type="text" name="partner_name" class="form-control form-control-lg" 
                   value="<?= $_SESSION['old']['partner_name'] ?? $service['partner_name'] ?? '' ?>" 
                   placeholder="VD: Hotel Paradise, Xe Minh Tâm..." required>
        </div>

        <!-- Trạng thái -->
        <div class="col-lg-6">
            <label class="form-label fw-bold"><i class="fas fa-check-circle"></i> Trạng thái</label>
            <select name="status" class="form-select form-select-lg">
                <?php foreach($allowedStatus as $st): ?>
                    <option value="<?= $st ?>" <?= $currentStatus==$st?'selected':'' ?>>
                        <?php
                            if ($st=='pending') echo 'Chờ xử lý';
                            if ($st=='confirmed') echo 'Đã xác nhận';
                            if ($st=='cancelled') echo 'Đã hủy';
                        ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Ghi chú -->
        <div class="col-lg-12">
            <label class="form-label fw-bold"><i class="fas fa-sticky-note"></i> Ghi chú</label>
            <textarea name="note" rows="5" class="form-control form-control-lg"
                      placeholder="Thông tin bổ sung: số lượng phòng, loại xe, giờ đón..."><?= $_SESSION['old']['note'] ?? $service['note'] ?? '' ?></textarea>
        </div>
    </div>

    <div class="text-end mt-5">
        <button type="submit" class="btn btn-primary btn-lg px-5">
            <i class="fas fa-save"></i> Cập nhật Dịch vụ
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
