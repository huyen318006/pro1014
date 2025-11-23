<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/account.css">

</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-user-shield"></i>
        </div>
        <h4>ADMIN</h4>
        <a href="index.php?act=home" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a href="<?= BASE_URL . '?act=account' ?>"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
        <a href="index.php?act=listTours"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
        <a href="index.php?act=listItinerary"><i class="fas fa-route"></i> <span>Quản lý Lịch Trình</span></a>
        <a href="?act=listAssignments"><i class="fas fa-user-secret"></i> <span>Phân công HDV</span></a>
        <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
        <a href="index.php?act=policies"><i class="fas fa-scroll"></i> <span>Quản lý Chính Sách</span></a>
        <a href="?act=incidents"><i class="fas fa-exclamation-triangle"></i><span>Danh sách báo cáo</span></a>
        <a href="<?= BASE_URL . '?act=DepartureAdmin' ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
        <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- Header -->
    <div class="header">
        <h5><i class="fas fa-cogs"></i> Bảng điều khiển quản trị</h5>
        <div class="user- info">
            <i class="fas fa-user-circle"></i>
            <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>
    </div>

    <!-- Content -->
    <div class="content">
        <h1 class="bl-heading">Quản lý Tài Khoản</h1>

        <div class="table-wrapper">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><span class="masked-password">********</span></td>
                            <td><?php echo htmlspecialchars($user['address'] ?? ''); ?></td>
                            <td><?= $user['phone'] ?></td>
                            <td>
                                <form method="post" action="?act=change_role" style="margin:0;">
                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                    <select name="role" onchange="this.form.submit()">
                                        <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                                        <option value="guide" <?php if ($user['role'] == 'guide') echo 'selected'; ?>>Guide</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <?php if ($user['status'] == 0): ?>
                                    <span class="status locked">Đã khóa</span>
                                    <a href="?act=open_user&id=<?= $user['id'] ?>" class="btn-edit">Mở lại tk</a>
                                <?php else: ?>
                                    <span class="status active">Hoạt động</span>
                                    <a href="?act=block_user&id=<?= $user['id'] ?>" class="btn-edit">Khóa</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>