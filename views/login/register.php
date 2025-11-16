<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký tài khoản</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS ĐĂNG KÝ - ĐỒNG BỘ VỚI LOGIN -->
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/register.css">
</head>
<body>

  <div class="register-card">

    <!-- HEADER -->
    <div class="register-header">
      <div class="register-logo">
        <i class="fa-solid fa-user-plus"></i>
      </div>
      <h3 class="register-title-header">Tạo tài khoản mới</h3>
    </div>

    <div class="p-4">

      <!-- THÔNG BÁO LỖI -->
      <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
          <?= $_SESSION['error'] ?>
          <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <!-- THÀNH CÔNG -->
      <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
          <?= $_SESSION['success'] ?>
          <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <!-- FORM ĐĂNG KÝ -->
      <form action="<?= BASE_URL ?>?act=formregister" method="post">

        <!-- Họ tên -->
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-user"></i> Họ và tên
          </label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" name="fullname" class="form-control" placeholder="Nguyễn Văn A" required>
          </div>
        </div>

        <!-- Email -->
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-envelope"></i> Email
          </label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
          </div>
        </div>

        <!-- Số điện thoại -->
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-phone"></i> Số điện thoại
          </label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-phone"></i></span>
            <input type="text" name="phone" class="form-control" placeholder="0901234567" 
                   pattern="[0-9]{10,11}" title="Số điện thoại 10-11 chữ số" required>
          </div>
        </div>

        <!-- Địa chỉ -->
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-map-marker-alt"></i> Địa chỉ
          </label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
            <input type="text" name="address" class="form-control" placeholder="123 Đường ABC, Quận 1" required>
          </div>
        </div>

        <!-- Mật khẩu -->
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-lock"></i> Mật khẩu
          </label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control" 
                   placeholder="Ít nhất 6 ký tự" minlength="6" required>
            <button type="button" class="btn btn-eye" onclick="togglePassword('password', this)">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <!-- Nhập lại mật khẩu -->
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-lock"></i> Nhập lại mật khẩu
          </label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-redo"></i></span>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" 
                   placeholder="Nhập lại mật khẩu" minlength="6" required>
            <button type="button" class="btn btn-eye" onclick="togglePassword('confirm_password', this)">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <!-- Nút đăng ký -->
        <button type="submit" name="register" class="btn btn-register w-100">
          Đăng ký ngay
        </button>

        <!-- Đăng nhập -->
        <div class="text-center mt-3">
          <p class="mb-0">Đã có tài khoản? 
            <a href="<?= BASE_URL ?>" class="text-link">Đăng nhập</a>
          </p>
        </div>

      </form>
    </div>
  </div>

  <!-- JS: Toggle mật khẩu + Tự tắt alert -->
  <script>
    function togglePassword(id, btn) {
      const input = document.getElementById(id);
      const icon = btn.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }

    // Tự động ẩn alert
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
          alert.style.transition = 'opacity 0.5s ease';
          alert.style.opacity = '0';
          setTimeout(() => alert.remove(), 500);
        }, 4000);
      });
    });
  </script>

</body>
</html>