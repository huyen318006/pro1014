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
    <div class="logo"><i class="fas fa-user-shield"></i></div>
    <h4>ADMIN</h4>
    <a href="index.php?act=home"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
    <a href="#"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
    <a href="index.php?act=listTours"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
    <a href="index.php?act=listSchedule"><i class="fas fa-calendar-alt"></i> <span>Quản lý Lịch Trình</span></a>
    <a href="?act=listAssignments"><i class="fas fa-map-marked-alt"></i> <span>Phân công HDV</span></a>
    <a href="index.php?act=services" class="active"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
    <a href="#"><i class="fas fa-shopping-cart"></i> <span>Quản lý đơn đặt</span></a>
    <a href="#"><i class="fas fa-comments"></i> <span>Quản lý bình luận</span></a>
    <a href="<?= BASE_URL . '?act=DepartureAdmin'  ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
    <a href="#"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
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
    <div class="container-fluid">

      <!-- Tiêu đề + Nút thêm -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
          <i class="fas fa-concierge-bell"></i> Quản lý Dịch vụ đi kèm
          <small class="text-muted d-block fs-6">Khách sạn • Xe đưa đón • Nhà hàng • Vé tham quan...</small>
        </h2>
        <a href="index.php?act=servicesCreate" class="btn btn-success btn-lg shadow">
          <i class="fas fa-plus-circle"></i> Thêm Dịch vụ
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

      <!-- Bảng danh sách -->
      <div class="table-card">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-primary">
                <tr>
                  <th width="5%">#ID</th>
                  <th width="25%">Chuyến đi</th>
                  <th width="15%">Loại dịch vụ</th>
                  <th width="20%">Đối tác</th>
                  <th width="10%">Trạng thái</th>
                  <th>Ghi chú</th>
                  <th width="10%">Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($services)): ?>
                  <?php foreach ($services as $s): ?>
                    <tr class="<?= $s['status'] == 'confirmed' ? 'status-confirmed' : ($s['status'] == 'pending' ? 'status-pending' : 'status-cancelled') ?>">
                      <td class="fw-bold"><?= $s['id'] ?></td>

                      <td>
                        <?php if (!empty($s['tour_name'])): ?>
                          <div class="fw-bold text-primary"><?= htmlspecialchars($s['tour_name']) ?></div>
                          <small class="text-muted">
                            <i class="fas fa-calendar"></i> <?= $s['departure_date_formatted'] ?? 'Chưa có ngày' ?>
                            <?php if (!empty($s['meeting_point'])): ?>
                              <br><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($s['meeting_point']) ?>
                            <?php endif; ?>
                          </small>
                        <?php else: ?>
                          <span class="text-danger fst-italic">Chưa gắn chuyến</span>
                        <?php endif; ?>
                      </td>

                      <td>
                        <span class="badge bg-info fs-6">
                          <?= ucfirst($s['service_name']) ?>
                        </span>
                      </td>

                      <td class="fw-bold"><?= $s['partner_name'] ?></td>

                      <td>
                        <?php
                        $statusClass = $s['status'] == 'confirmed' ? 'success' : ($s['status'] == 'pending' ? 'warning' : 'danger');
                        $statusText  = $s['status'] == 'confirmed' ? 'Đã xác nhận' : ($s['status'] == 'pending' ? 'Chờ xử lý' : 'Đã hủy');
                        ?>
                        <span class="badge bg-<?= $statusClass ?> fs-6">
                          <?= $statusText ?>
                        </span>
                      </td>

                      <td><small><?= nl2br($s['note'] ?? '-') ?></small></td>

                      <td>
                        <div class="btn-group" role="group">
                          <a href="index.php?act=servicesEdit&id=<?= $s['id'] ?>"
                            class="btn btn-sm btn-warning" title="Sửa">
                            <i class="fas fa-edit"></i>
                          </a>
                          <a href="index.php?act=servicesDelete&id=<?= $s['id'] ?>" 
                             class="btn btn-sm btn-danger" 
                             onclick="return confirm('Xóa dịch vụ này?\n\nĐối tác: <?= htmlspecialchars($s['partner_name']) ?>');"
                             title="Xóa">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                      <i class="fas fa-inbox fa-3x mb-3"></i><br>
                      Chưa có dịch vụ nào được thêm
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>