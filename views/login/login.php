<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng Nhập</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Style -->
</head>

<style>
:root {
  --primary: #00CED1;
  --primary-dark: #20B2AA;
  --light: #f8f9fa;
  --danger: #dc3545;
}

body {
  font-family: 'Poppins', sans-serif !important;
  margin: 0;
  background: #e0f7fa;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

/* CARD LOGIN */
.login-card {
  background: white;
  border-radius: 24px;
  box-shadow: 0 20px 40px rgba(0, 206, 209, 0.2);
  overflow: hidden;
  width: 100%;
  max-width: 400px;
  border: none;
  padding: 0 !important;
}

/* HEADER xanh */
.login-header {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    padding: 25px 20px 35px;
    text-align: center;
    margin: 0;
}


/* Logo tròn */
.login-logo {
    width: 90px;
    height: 90px;
    margin: 0 auto 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
}
.login-logo i {
    font-size: 40px;
    color: #fff;
}

/* Chữ tiêu đề */
.login-title-header {
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff !important;
    margin-top: 10px;
}

/* FORM */
.form-label {
  font-weight: 600;
  color: #333;
  font-size: 0.95rem;
  margin-bottom: 8px;
}

.form-control {
  border-radius: 14px;
  padding: 12px 16px;
  font-size: 1rem;
  border: 1.5px solid #ddd;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 0.22rem rgba(0, 206, 209, 0.25);
}

.input-group-text {
  background: transparent;
  border-radius: 14px 0 0 14px;
  border: 1.5px solid #ddd;
  border-right: none;
  color: #666;
  font-size: 1.1rem;
}

.btn-login {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  color: white;
  border: none;
  border-radius: 14px;
  padding: 13px;
  font-weight: 600;
  font-size: 1.05rem;
  transition: all 0.3s ease;
  width: 100%;
}

.btn-login:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(0, 206, 209, 0.35);
}

.text-link {
  color: var(--primary);
  font-weight: 500;
  text-decoration: none;
  font-size: 0.95rem;
}

.text-link:hover {
  text-decoration: underline;
}

.alert {
  border-radius: 12px;
  font-size: 0.9rem;
}
</style>

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
