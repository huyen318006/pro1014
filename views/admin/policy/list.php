<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Quản lý Chính sách Tour | LOFT CITY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- 2 file CSS: trangchu.css (layout) + policy.css (riêng cho trang này) -->
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/trangchu.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/policy.css">
</head>

<body>

  <!-- ========== SIDEBAR - ĐÃ SỬA LINK ĐÚNG + ACTIVE ========== -->
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
    <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>>
  </div>

  <!-- ========== HEADER ========== -->
  <div class="header">
    <h5><i class="fas fa-scroll"></i> Quản lý Chính sách Tour</h5>
    <div class="user-info">
      <i class="fas fa-user-circle"></i>
      <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'Guest') ?></span>
    </div>
  </div>

  <!-- ========== NỘI DUNG CHÍNH ========== -->
  <div class="content">
    <div class="container-fluid mt-4">

      <!-- Thông báo -->
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <i class="fas fa-check-circle"></i> <?= $_SESSION['success'];
                                              unset($_SESSION['success']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error'];
                                                    unset($_SESSION['error']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Tiêu đề + Nút thêm -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-primary"><i class="fas fa-file-contract"></i> Danh sách chính sách Tour</h3>
        <a href="<?= BASE_URL ?>?act=policiesCreate" class="btn btn-add-policy">
          <i class="fas fa-plus-circle"></i> Thêm chính sách mới
        </a>
      </div>

      <!-- Bảng dữ liệu -->
      <div class="table-card">
        <div class="table-responsive">
          <table class="table table-hover align-middle policy-table">
            <thead class="table-dark">
              <tr>
                <th width="80">ID</th>
                <th>Tour</th>
                <th>Loại chính sách</th>
                <th>Nội dung tóm tắt</th>
                <th width="170" class="text-center">Hành động</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($policies)): ?>
                <tr>
                  <td colspan="5" class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                    Chưa có chính sách nào
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($policies as $p): ?>
                  <tr>
                    <td class="text-center fw-bold">#<?= $p['id'] ?></td>
                    <td><strong><?= htmlspecialchars($p['tour_name'] ?? 'Chưa xác định') ?></strong></td>
                    <td>
                      <span class="badge policy-type-badge badge-chung">
                        <?= htmlspecialchars($p['policy_type']) ?>
                      </span>
                    </td>
                    <td class="content-preview">
                      <?= htmlspecialchars(mb_substr(strip_tags($p['content']), 0, 100)) ?>...
                    </td>
                    <td class="text-center">
                      <a href="<?= BASE_URL ?>?act=policiesEdit&id=<?= $p['id'] ?>"
                        class="btn btn-policy-edit btn-sm" title="Sửa">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="<?= BASE_URL ?>?act=policiesDelete&id=<?= $p['id'] ?>"
                        class="btn btn-policy-delete btn-sm" title="Xóa"
                        onclick="return confirm('Xóa chính sách này?\nHành động không thể hoàn tác!')">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>