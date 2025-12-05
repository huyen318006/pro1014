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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">

  <style>
    .hover-shadow-lg:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }
  </style>
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

  <!-- Nội dung chính -->
  <div class="content">
    <div class="container-fluid">

      <h2 class="fw-bold text-primary mb-4">
        <i class="fas fa-concierge-bell"></i> Quản lý Dịch vụ đi kèm
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
          <div class="col-md-5">
            <label class="form-label fw-bold">Chọn Tour để xem dịch vụ</label>
            <select name="tour_id" class="form-select" onchange="this.form.submit()">
              <option value="">-- Tất cả Tour --</option>
              <?php foreach ($tours as $t): ?>
                <option value="<?= $t['id'] ?>" <?= (isset($selectedTourId) && $selectedTourId == $t['id']) ? 'selected' : '' ?>>
                  [<?= htmlspecialchars($t['code'] ?? 'T' . $t['id']) ?>] <?= htmlspecialchars($t['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
              <i class="fas fa-filter"></i> Lọc
            </button>
          </div>
        </div>
      </form>

      <!-- Nút thêm mới -->
      <div class="mb-3 text-end">
        <?php if ($selectedTourId): ?>
          <button type="button" class="btn btn-success btn-lg shadow" data-bs-toggle="modal" data-bs-target="#departureModal">
            <i class="fas fa-plus"></i> Thêm dịch vụ mới
          </button>
        <?php else: ?>
          <div class="alert alert-info d-inline-block">
            <i class="fas fa-info-circle"></i> Vui lòng <strong>chọn Tour</strong> trước khi thêm dịch vụ.
          </div>
        <?php endif; ?>
      </div>

      <!-- Bảng danh sách -->
      <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
          <strong><i class="fas fa-list"></i> Danh sách Dịch vụ đi kèm</strong>
          <?php if ($selectedTourId): ?>
            <?php 
              $currentTour = null;
              foreach ($tours as $t) {
                if ($t['id'] == $selectedTourId) { $currentTour = $t; break; }
              }
            ?>
            <span class="badge bg-light text-dark fs-6">
              Tour: <?= htmlspecialchars($currentTour['name'] ?? 'Không xác định') ?>
            </span>
          <?php endif; ?>
        </div>

        <div class="card-body p-0">
          <?php if (empty($services)): ?>
            <div class="text-center py-5 text-muted">
              <i class="fas fa-inbox fa-4x mb-3"></i>
              <p class="fs-5">
                <?php if ($selectedTourId): ?>
                  Tour này chưa có dịch vụ nào được thêm.
                <?php else: ?>
                  Vui lòng chọn một Tour để xem danh sách dịch vụ.
                <?php endif; ?>
              </p>
            </div>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table table-hover mb-0 align-middle">
                <thead class="table-success">
                  <tr>
                    <th width="70" class="text-center">#ID</th>
                    <th>Tên dịch vụ</th>
                    <th>Đối tác</th>
                    <th width="130" class="text-center">Hành động</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($services as $s): ?>
                    <tr>
                      <td class="text-center fw-bold">#<?= $s['id'] ?></td>
                      <td>
                        <strong><?= htmlspecialchars($s['service_name']) ?></strong>
                        <?php if (!empty($s['departure_date_formatted'])): ?>
                          <br><small class="text-muted">Ngày khởi hành: <?= $s['departure_date_formatted'] ?></small>
                        <?php endif; ?>
                      </td>
                      <td><?= htmlspecialchars($s['partner_name'] ?? '<em class="text-muted">Chưa có</em>') ?></td>
                      <td class="text-center">
                        <a href="index.php?act=servicesEdit&id=<?= $s['id'] ?>" class="btn btn-warning btn-sm" title="Sửa">
                          <i class="fas fa-edit"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Modal chọn lịch khởi hành -->
      <?php if ($selectedTourId): ?>
      <div class="modal fade" id="departureModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title">
                <i class="fas fa-calendar-alt me-2"></i> Chọn lịch khởi hành để thêm dịch vụ
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <?php
              $departureModel = new Departures();
              $departures = $departureModel->getAllDepartures($selectedTourId);
              ?>
              <?php if (empty($departures)): ?>
                <div class="text-center py-5">
                  <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                  <p class="text-muted fs-5">Tour này <strong>chưa có lịch khởi hành nào</strong>.</p>
                  <a href="<?= BASE_URL ?>?act=DepartureAdmin" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-plus"></i> Tạo lịch khởi hành mới
                  </a>
                </div>
              <?php else: ?>
                <div class="row g-3">
                  <?php foreach ($departures as $d): ?>
                    <div class="col-md-6 col-lg-4">
                      <a href="index.php?act=servicesCreateByDeparture&departure_id=<?= $d['id'] ?>"
                         class="btn btn-outline-success w-100 p-4 text-start hover-shadow-lg"
                         style="border-radius: 15px; height: 100%;">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <div class="fw-bold fs-5">
                              <?= date('d/m/Y', strtotime($d['departure_date'])) ?>
                            </div>
                            <small class="text-muted">
                              <?= htmlspecialchars($d['meeting_point'] ?? 'Chưa có điểm đón') ?>
                            </small>
                          </div>
                          <i class="fas fa-arrow-right fs-3 text-success"></i>
                        </div>
                      </a>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="modal-footer bg-light">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>