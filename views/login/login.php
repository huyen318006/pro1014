<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng Nhập</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/login.css">
  <!-- Style -->
</head>

<body>
  
  <div class="card shadow-lg login-card">

    <!-- HEADER -->
    <div class="login-header">
        <div class="login-logo">
            <i class="fa-solid fa-user"></i>
        </div>
        <h3 class="login-title-header">Đăng nhập tài khoản</h3>
    </div>

    <div class="p-4">

      <!-- Lỗi -->
      <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <?= $_SESSION['error'] ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <!-- FORM -->
      <form action="<?= BASE_URL ?>" method="post">

        <div class="mb-3">
          <label class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" class="form-control" id="password" placeholder="Nhập mật khẩu" required>
            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
              <i class="fas fa-eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <button type="submit" name="login" class="btn btn-login w-100 mb-2">
          Đăng nhập
        </button>

        <div class="d-flex justify-content-between mt-2">
          <a href="<?= BASE_URL ?>?act=forgotpassword" class="text-link">Quên mật khẩu?</a>
          <a href="<?= BASE_URL ?>?act=register" class="text-link">Đăng ký</a>
        </div>

      </form>

    </div>
  </div>

  <script>
    function togglePassword() {
      const p = document.getElementById('password');
      const i = document.getElementById('eyeIcon');
      if (p.type === 'password') {
        p.type = 'text';
        i.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        p.type = 'password';
        i.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
