<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng Nhập | LOFT CITY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 + FontAwesome 6 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    :root {
      --primary: #00CED1;
      --primary-dark: #20B2AA;
      --light: #f8f9fa;
      --danger: #dc3545;
      --success: #28a745;
      --warning: #ffc107;
      --info: #17a2b8;
      --dark: #343a40;
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
      font-size: 1rem;
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

    .form-check-label {
      font-size: 0.9rem;
      color: #555;
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

  <div class="login-card">
    <div class="login-header">
      <div class="logo">
        <i class="fas fa-user-shield"></i>
      </div>
      <h3>LOFT CITY</h3>
      <p>Đăng nhập quản trị</p>
    </div>

    <div class="login-body">
      <form action="#" method="POST">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control" placeholder="admin@loft.com" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" id="password" placeholder="••••••••" required>
            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
              <i class="fas fa-eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember">
            <label class="form-check-label" for="remember">Ghi nhớ</label>
          </div>
          <a href="#" class="text-link">Quên mật khẩu?</a>
        </div>

        <button type="submit" class="btn btn-login">
          <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
        </button>
      </form>

      <div class="divider"><span>HOẶC</span></div>

      <div class="text-center">
        <p class="mb-0">Chưa có tài khoản? <a href="#" class="text-link">Đăng ký ngay</a></p>
      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const password = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      if (password.type === 'password') {
        password.type = 'text';
        eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        password.type = 'password';
        eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>