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
    <a href="<?= BASE_URL.'?act=adminJournals' ?>"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
    <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
  </div>

  <!-- Header -->
  <div class="header">
    <h5><i class="fas fa-cogs"></i> Bảng điều khiển lịch trình</h5>
    <div class="user-info">
      <i class="fas fa-user-circle"></i>
      <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="table-card">
      <div class="card-header">
        <h5>Quản lý Lịch Trình</h5>
        <a href="index.php?act=addItineraryForm" class="btn btn-add"><i class="fas fa-plus"></i> Thêm Lịch Trình</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Tên Tour</th>
                <th>Ảnh Tour</th>
                <th>Số lịch trình</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($itineraries)): ?>
                <?php foreach ($itineraries as $item):
                  $isLocked = !empty($item['has_ready_departure']);
                ?>
                  <tr>
                    <td>
                      <strong><?= htmlspecialchars($item["tour_name"] ?? 'Không xác định') ?></strong>
                      <?php if (!empty($item['tour_code'])): ?>
                        <div class="text-muted small">Mã tour: <?= htmlspecialchars($item["tour_code"]) ?></div>
                      <?php endif; ?>
                      <?php if ($isLocked): ?>
                        <span class="badge bg-warning text-dark mt-2">Có tour READY</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if (!empty($item["tour_image"])): ?>
                        <img src="<?= BASE_URL . 'uploads/' . basename($item["tour_image"]) ?>"
                          alt="<?= htmlspecialchars($item["tour_name"] ?? 'Tour') ?>"
                          class="img-thumbnail"
                          style="width: 160px; height: 120px; object-fit: cover;">
                      <?php else: ?>
                        <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded"
                          style="width: 160px; height: 120px;">
                          Chưa có ảnh
                        </div>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="badge bg-info"><?= $item['itinerary_count'] ?? 0 ?> lịch trình</span>
                    </td>
                    <td>
                      <a href="index.php?act=detailItinerary&tour_id=<?= $item["tour_id"] ?>" class="btn btn-info btn-action" title="Xem chi tiết">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center text-muted py-4">Chưa có lịch trình nào</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>