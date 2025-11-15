<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quên mật khẩu</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="max-width: 420px; width: 100%;">
      <h4 class="text-center text-primary mb-3">Khôi phục mật khẩu</h4>
      <p class="text-center text-muted">Vui lòng nhập thông tin để xác minh tài khoản của bạn.</p>

      <form action="<?= BASE_URL.'?act=formforgotpassword' ?>" method="POST">
        <div class="mb-3">
          <label for="fullname" class="form-label">Họ và tên</label>
          <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập họ tên đầy đủ" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Địa chỉ Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email đã đăng ký" required>
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Số điện thoại</label>
          <input type="tel" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại đã đăng ký" required>
        </div>

        <div class="mb-3">
          <label for="newpassword" class="form-label">Mật khẩu mới</label>
          <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Nhập mật khẩu mới" required>
        </div>

        <div class="mb-4">
          <label for="confirmpassword" class="form-label">Xác nhận mật khẩu mới</label>
          <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Nhập lại mật khẩu mới" required>
        </div>

        <button type="submit" class="btn btn-primary w-100" name="submit">Đặt lại mật khẩu</button>

        <div class="text-center mt-3">
          <a href="<?=BASE_URL ?>" class="text-decoration-none">← Quay lại đăng nhập</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
