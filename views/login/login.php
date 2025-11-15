<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 380px;
            border-radius: 18px;
        }

        .login-title {
            font-size: 26px;
            font-weight: 600;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #667eea;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="card p-4 shadow-lg login-card">
        <h3 class="text-center mb-4 login-title">Đăng nhập tài khoản</h3>

        <form action="<?= BASE_URL.'?act=formlogin' ?>" method="post">

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
                <a href="<?= BASE_URL.'?act=forgotpassword' ?>">Quên mật khẩu?</a>
                <a href="<?= BASE_URL.'?act=register' ?>">Đăng ký</a>
            </div>

        </form>
    </div>

</body>
</html>
