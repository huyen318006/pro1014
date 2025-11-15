<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký tài khoản</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #7B5FFF, #4BA3FF);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: "Poppins", sans-serif;
    }
    .register-container {
      background: #fff;
      padding: 40px 50px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      width: 450px;
      animation: fadeIn 0.8s ease-in-out;
    }
    .register-container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #5e4eff;
      font-weight: 600;
    }
    .form-control:focus {
      border-color: #7B5FFF;
      box-shadow: 0 0 0 0.2rem rgba(123,95,255,0.25);
    }
    .btn-primary {
      background-color: #7B5FFF;
      border: none;
    }
    .btn-primary:hover {
      background-color: #5e4eff;
    }
    .text-center a {
      color: #7B5FFF;
      text-decoration: none;
    }
    .text-center a:hover {
      text-decoration: underline;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Đăng ký tài khoản</h2>
    <form action="<?= BASE_URL.'?act=formregister' ?>" method="post">
      <div class="mb-3">
        <label for="fullname" class="form-label">Họ và tên</label>
        <input type="text" class="form-control" id="fullname" name="fullname" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Số điện thoại</label>
        <input type="text" class="form-control" id="phone" name="phone" required pattern="[0-9]{10,11}" title="Nhập số điện thoại hợp lệ (10-11 số)">
      </div>

      <div class="mb-3">
        <label for="address" class="form-label">Địa chỉ</label>
        <input type="text" class="form-control" id="address" name="address" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" id="password" name="password" required minlength="6">
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Nhập lại mật khẩu</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="6">
      </div>

      <button type="submit" name="register" class="btn btn-primary w-100">Đăng ký</button>

      <div class="text-center mt-3">
        <p>Đã có tài khoản? <a href="<?= BASE_URL ?>">Đăng nhập</a></p>
      </div>
    </form>
  </div>
</body>
</html>
