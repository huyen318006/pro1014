  <!DOCTYPE html>

  <html lang="vi">

  <head>
    <meta charset="UTF-8">
    <title>Phân công HDV | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 + FontAwesome -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/assignments.css">
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
      <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>>
    </div>
    <!-- Header -->

    <div class="header">
      <h5><i class="fas fa-cogs"></i> trang demo Phân công HDV</h5>
      <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
      </div>
    </div>

    <!-- Content -->

    <div class="content">
      <div class="table-card p-4">
        <?php if (isset($_SESSION['error'])) {
          echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
          unset($_SESSION['error']);
        } ?>
        <form method="POST" action="?act=storeAssignment">
          <div class="mb-3">
            <label class="form-label">Hướng dẫn viên</label>
            <select name="guide_id" class="form-select" required>
              <?php foreach ($guides as $g): ?>
                <option value="<?= $g['id'] ?>"><?= $g['fullname'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">

            <label class="form-label">Tour</label>
            <select name="booking_id" class="form-select" required>
              <?php foreach ($getallbooking as $d): ?>
                <option value="<?= $d['id'] ?>">
                  <?= htmlspecialchars($d['tour_name']) ?> - <?= htmlspecialchars($d['departure_date']) ?> (<?= htmlspecialchars($d['departure_status']) ?>)
                </option>
              <?php endforeach; ?>
            </select>



          </div>
          <button type="submit" class="btn btn-primary btn-add">Phân công</button>
        </form>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  </body>

  </html>