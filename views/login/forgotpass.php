<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Khôi phục mật khẩu</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS ĐỒNG BỘ -->
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/forgotpassword.css">
</head>
<body>

  <div class="forgot-card">

    <!-- HEADER -->
    <div class="forgot-header">
      <div class="forgot-logo">
        <i class="fa-solid fa-key"></i>
      </div>
      <h3 class="forgot-title-header">Khôi phục mật khẩu</h3>
      <p class="forgot-subtitle">Nhập thông tin để đặt lại mật khẩu</p>
    </div>

    <div class="p-4">

      <!-- THÔNG BÁO -->
      <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
          <?= $_SESSION['error'] ?>
          <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
          <?= $_SESSION['success'] ?>
          <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <!-- FORM KHÔI PHỤC -->
      <form action="<?= BASE_URL ?>?act=formforgotpassword" method="post">

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
            <input type="tel" name="phone" class="form-control" placeholder="0901234567" 
                   pattern="[0-9]{10,11}" title="10-11 chữ số" required>
          </div>
        </div>

        <!-- Mật khẩu mới -->
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-lock"></i> Mật khẩu mới
          </label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="newpassword" id="newpassword" class="form-control" 
                   placeholder="Ít nhất 6 ký tự" minlength="6" required>
            <button type="button" class="btn btn-eye" onclick="togglePassword('newpassword', this)">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <!-- Xác nhận mật khẩu -->
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-redo"></i> Xác nhận mật khẩu
          </label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-redo"></i></span>
            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" 
                   placeholder="Nhập lại mật khẩu" minlength="6" required>
            <button type="button" class="btn btn-eye" onclick="togglePassword('confirmpassword', this)">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <!-- NÚT GỬI -->
        <button type="submit" name="submit" class="btn btn-recover w-100">
          Đặt lại mật khẩu
        </button>

        <!-- QUAY LẠI -->
        <div class="text-center mt-3">
          <a href="<?= BASE_URL ?>" class="text-link">
            <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
          </a>
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

    // Tự động ẩn alert sau 4s
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