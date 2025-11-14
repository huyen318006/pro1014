<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        body {
            background: #f8f9fa;
        }
        .login-container {
            margin-top: 80px;
            max-width: 400px;
            padding: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 25px rgba(0,0,0,0.1);
        }
        .login-container h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #00CED1;
        }
        .btn-login {
            background-color: #00CED1;
            color: #fff;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #007b7f;
            color: #fff;
        }
        .form-link {
            text-align: center;
            margin-top: 15px;
        }
        .form-link a {
            color: #00CED1;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="login-container">
            <h2>Đăng Nhập</h2>
            <form action="" method="">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>
                <button type="submit" class="btn btn-login">Đăng Nhập</button>
            </form>
        </div>
    </div>

</body>
</html>
