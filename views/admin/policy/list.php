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
    <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
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
      </div>

          <div class="container py-5">
        <div class="policy-box p-4 shadow rounded bg-white">
            <h2 class="mb-4 text-primary"><i class="fas fa-scroll"></i> Chính Sách Tour Du Lịch</h2>

            <h4 class="mt-4 text-dark">1. Chính sách đặt tour</h4>
            <p>- Khách hàng cung cấp thông tin cá nhân chính xác khi đặt tour.<br>
              - Xác nhận đặt tour qua email hoặc số điện thoại.<br>
              - Giá tour có thể thay đổi tùy thời điểm.</p>

            <h4 class="mt-4 text-dark">2. Chính sách thanh toán</h4>
            <p>- Thanh toán qua chuyển khoản hoặc trực tiếp tại văn phòng.<br>
              - Yêu cầu đặt cọc theo từng tour.<br>
              - Phần còn lại cần thanh toán trước ngày khởi hành.</p>

            <h4 class="mt-4 text-dark">3. Chính sách hủy tour & hoàn tiền</h4>
            <p>- Hủy trước ≥10 ngày: hoàn 80% giá tour.<br>
              - Hủy 5–9 ngày: hoàn 50%.<br>
              - Hủy dưới 5 ngày: không hoàn tiền.<br>
              - Nếu công ty hủy tour: hoàn tiền 100% hoặc đổi tour khác.</p>

            <h4 class="mt-4 text-dark">4. Chính sách thay đổi dịch vụ</h4>
            <p>- Cho phép thay đổi thông tin trước ngày khởi hành (có thể tính phí).<br>
              - Dịch vụ như vé máy bay/khách sạn sẽ theo quy định từ nhà cung cấp.</p>

            <h4 class="mt-4 text-dark">5. Chính sách dành cho trẻ em</h4>
            <p>- Trẻ < 2 tuổi: miễn phí hoặc phí thấp theo tour.<br>
              - Trẻ 2–11 tuổi: tính 50–75% giá tour.<br>
              - Trẻ ≥ 12 tuổi: tính như người lớn.</p>

            <h4 class="mt-4 text-dark">6. Khách sạn & lưu trú</h4>
            <p>- Nhận phòng sau 14:00 theo quy định.<br>
              - Phòng đơn phụ thu thêm.<br>
              - Nếu hết phòng, khách sạn tương đương sẽ được bố trí.</p>

            <h4 class="mt-4 text-dark">7. Phương tiện di chuyển</h4>
            <p>- Xe du lịch đời mới, máy lạnh.<br>
              - Tour có máy bay sẽ theo quy định vé của hãng.<br>
              - Khách đến trễ giờ khởi hành tự chịu trách nhiệm.</p>

            <h4 class="mt-4 text-dark">8. Bảo mật thông tin</h4>
            <p>- Chúng tôi cam kết bảo mật thông tin khách hàng.<br>
              - Không chia sẻ cho bên thứ ba ngoài đối tác cung cấp dịch vụ tour.<br>
              - Dữ liệu chỉ được dùng phục vụ chuyến đi.</p>

            <h4 class="mt-4 text-dark">9. Điều khoản chung</h4>
            <p>- Việc đặt tour nghĩa là bạn đồng ý với các chính sách nêu trên.<br>
              - Chính sách có thể thay đổi mà không cần báo trước.<br>
              - Liên hệ hotline khi cần hỗ trợ.</p>
        </div>
    </div>


    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>