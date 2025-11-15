<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* assets/css/login.css */
:root {
  --primary: #00CED1;
  --primary-dark: #20B2AA;
  --light: #f8f9fa;
  --danger: #dc3545;
}

body {
  font-family: 'Poppins', sans-serif !important;
  background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
  margin: 0;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-card {
  background: white;
  border-radius: 20px;
  box-shadow: 0 12px 30px rgba(0, 206, 209, 0.25);
  overflow: hidden;
  width: 100%;
  max-width: 420px;
  border: 1px solid #eee;
}

.login-header {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  color: white;
  padding: 28px;
  text-align: center;
}

.login-header .logo {
  width: 70px;
  height: 70px;
  background: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.login-header .logo i {
  font-size: 2rem;
  color: var(--primary-dark);
}

.login-header h3 {
  margin: 0;
  font-weight: 700;
  font-size: 1.5rem;
  letter-spacing: 0.5px;
}

.login-header p {
  margin: 8px 0 0;
  font-size: 0.95rem;
  opacity: 0.9;
}

.login-body {
  padding: 32px;
}

.form-label {
  font-weight: 600;
  color: #444;
  font-size: 0.95rem;
}

.form-control {
  border-radius: 12px;
  padding: 12px 16px;
  font-size: 0.95rem;
  border: 1.5px solid #ddd;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 0.2rem rgba(0, 206, 209, 0.25);
}

.input-group-text {
  background: transparent;
  border-radius: 12px 0 0 12px;
  border: 1.5px solid #ddd;
  border-right: none;
  color: #666;
}

.btn-login {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  color: white;
  border: none;
  border-radius: 12px;
  padding: 12px;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.3s ease;
  width: 100%;
}

.btn-login:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(0, 206, 209, 0.3);
}

.text-link {
  color: var(--primary);
  font-weight: 500;
  text-decoration: none;
}

.text-link:hover {
  text-decoration: underline;
}

.divider {
  text-align: center;
  margin: 20px 0;
  position: relative;
  color: #888;
  font-size: 0.9rem;
}

.divider::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 1px;
  background: #ddd;
  z-index: 0;
}

.divider span {
  background: white;
  padding: 0 12px;
  z-index: 1;
  position: relative;
}

@media (max-width: 576px) {
  .login-card { margin: 15px; }
  .login-body { padding: 24px; }
}
    </style>
</head>
<body>

    <div class="card p-4 shadow-lg login-card">
        <h3 class="text-center mb-4 login-title">Đăng nhập tài khoản</h3>

        <!-- Thông báo lỗi -->
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- SỬA CHỖ NÀY: bỏ ?act=formlogin -->
        <form action="<?= BASE_URL ?>" method="post">

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Nhập email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100 mb-2">Đăng nhập</button>

            <div class="d-flex justify-content-between mt-2">
                <a href="<?= BASE_URL ?>?act=forgotpassword">Quên mật khẩu?</a>
                <a href="<?= BASE_URL ?>?act=register">Đăng ký</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>