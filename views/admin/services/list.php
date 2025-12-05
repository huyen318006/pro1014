<?php
// Đặt biến để sidebar biết đang ở trang nào
$act = 'services';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Quản lý Dịch vụ đi kèm | LOFT CITY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS Dashboard đẹp y hệt trang chủ -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">

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

  <div class="content">
    <div class="container-fluid">

      <h2 class="fw-bold text-primary mb-4">
        Quản lý Dịch vụ đi kèm
        <small class="text-muted d-block fs-6">Nhà hàng • Khách sạn • Xe đưa đón • Vé tham quan...</small>
      </h2>

      <!-- Thông báo -->
      <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <?= $_SESSION['success']; unset($_SESSION['success']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Form lọc theo Tour -->
      <form method="post" class="mb-4">
        <div class="row g-3 align-items-end">
          <div class="col-auto">
            <label class="form-label fw-bold">Chọn Tour</label>
            <select name="tour_id" class="form-select" onchange="this.form.submit()">
              <option value="">-- Tất cả Tour --</option>
              <?php foreach ($tours as $t): ?>
                <option value="<?= $t['id'] ?>" <?= (isset($selectedTourId) && $selectedTourId == $t['id']) ? 'selected' : '' ?>>
                  [<?= $t['code'] ?? 'T00' . $t['id'] ?>] <?= htmlspecialchars($t['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-filter"></i> Lọc
            </button>
          </div>
        </div>
      </form>

      <!-- Nút thêm mới -->
      <div class="mb-3">
        <a href="index.php?act=servicesCreate" class="btn btn-success">
          <i class="fas fa-plus"></i> Thêm dịch vụ mới
        </a>
      </div>

      <!-- Bảng danh sách dịch vụ -->
      <div class="card shadow-sm">
        <div class="card-header bg-success text-white fw-bold">
          Danh sách Dịch vụ đi kèm
          <?php if ($selectedTourId): ?>
            <span class="badge bg-light text-dark ms-2">
              Tour: <?= htmlspecialchars($tours[array_search($selectedTourId, array_column($tours, 'id'))]['name'] ?? 'N/A') ?>
            </span>
          <?php endif; ?>
        </div>
        <div class="card-body p-0">
          <?php if (empty($services)): ?>
            <div class="text-center py-5 text-muted">
              <i class="fas fa-inbox fa-3x mb-3"></i>
              <p>Chưa có dịch vụ nào.<br>Nếu đã chọn Tour, có thể chưa có dịch vụ nào được thêm.</p>
            </div>
          <?php else: ?>
            <table class="table table-hover mb-0">
              <thead class="table-success">
                <tr>
                  <th width="80">#ID</th>
                  <th>Tên dịch vụ</th>
                  <th>Đối tác</th>
                  <th>Trạng thái</th>
                  <th>Ghi chú</th>
                  <th width="120">Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($services as $s): ?>
                  <tr>
                    <td><strong>#<?= $s['id'] ?></strong></td>
                    <td><strong><?= htmlspecialchars($s['service_name']) ?></strong></td>
                    <td><?= htmlspecialchars($s['partner_name'] ?? '-') ?></td>
                    <td>
                      <?php
                        $badge = $s['status'] == 'confirmed' ? 'success' : ($s['status'] == 'cancelled' ? 'danger' : 'warning');
                        $text  = $s['status'] == 'confirmed' ? 'Đã xác nhận' : ($s['status'] == 'cancelled' ? 'Đã hủy' : 'Chờ xác nhận');
                      ?>
                      <span class="badge bg-<?= $badge ?>"><?= $text ?></span>
                    </td>
                    <td>
                      <a href="index.php?act=servicesEdit&id=<?= $s['id'] ?>" class="btn btn-warning btn-sm" title="Sửa">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="index.php?act=servicesDelete&id=<?= $s['id'] ?>" 
                         class="btn btn-danger btn-sm" 
                         onclick="return confirm('Xóa dịch vụ \"<?= htmlspecialchars($s['service_name']) ?>
                         title="Xóa">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>