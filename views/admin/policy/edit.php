<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Cập nhật chính sách | LOFT CITY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS chung + CSS riêng cho trang chính sách -->
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/trangchu.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/policy.css">
</head>
<body>

  <!-- SIDEBAR - ACTIVE ĐÚNG MỤC CHÍNH SÁCH -->
  <div class="sidebar">
    <div class="logo"><i class="fas fa-user-shield"></i></div>
    <h4>ADMIN</h4>
    <a href="index.php?act=home" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
    <a href="<?= BASE_URL . '?act=account' ?>"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
    <a href="index.php?act=listTours"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
    <a href="index.php?act=listItinerary"><i class="fas fa-route"></i> <span>Quản lý Lịch Trình</span></a>
    <a href="?act=listAssignments"><i class="fas fa-user-secret"></i> <span>Phân công HDV</span></a>
    <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
    <a href="index.php?act=policies"><i class="fas fa-scroll"></i> <span>Quản lý Chính Sách</span></a>
    <a href="?act=incidents"><i class="fas fa-exclamation-triangle"></i><span>Danh sách báo cáo</span></a>
    <a href="#"><i class="fas fa-comments"></i> <span>Quản lý bình luận</span></a>
    <a href="<?= BASE_URL . '?act=DepartureAdmin' ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
    <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
  </div>

  <!-- HEADER -->
  <div class="header">
    <h5><i class="fas fa-scroll"></i> Cập nhật chính sách tour</h5>
    <div class="user-info">
      <i class="fas fa-user-circle"></i>
      <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
    </div>
  </div>

  <!-- NỘI DUNG CHÍNH -->
  <div class="content">
    <div class="container-fluid mt-4">

      <!-- Thông báo -->
      <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <i class="fas fa-check-circle"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Card form sửa -->
      <div class="policy-card p-4 p-md-5">
        <h3 class="mb-4 text-primary">
          <i class="fas fa-edit"></i> Cập nhật chính sách #<?= $policy['id'] ?>
        </h3>

        <form method="POST" action="<?= BASE_URL ?>?act=policiesUpdate">
          <input type="hidden" name="id" value="<?= $policy['id'] ?>">

          <div class="row g-4">
            <div class="col-12 col-lg-6">
              <label class="form-label fw-bold text-primary"><i class="fas fa-map-marked-alt"></i> Chọn Tour</label>
              <select name="tour_id" class="form-select form-select-lg" required>
                <option value="">-- Chọn tour --</option>
                <?php foreach($tours as $t): ?>
                  <option value="<?= $t['id'] ?>" 
                    <?= $t['id'] == $policy['tour_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-12 col-lg-6">
              <label class="form-label fw-bold text-primary"><i class="fas fa-tag"></i> Loại chính sách</label>
              <input type="text" name="policy_type" class="form-control form-control-lg" 
                     value="<?= htmlspecialchars($policy['policy_type']) ?>" 
                     placeholder="Ví dụ: Hủy tour, Trẻ em..." required>
            </div>

            <div class="col-12">
              <label class="form-label fw-bold text-primary"><i class="fas fa-file-alt"></i> Nội dung chính sách</label>
              <textarea name="content" class="form-control" rows="10" required><?= htmlspecialchars($policy['content']) ?></textarea>
            </div>

            <div class="col-12 text-end">
              <a href="<?= BASE_URL ?>?act=policies" class="btn btn-secondary btn-lg me-3">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách
              </a>
              <button type="submit" name="submit" class="btn btn-add-policy btn-lg">
                <i class="fas fa-save"></i> Cập nhật chính sách
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>