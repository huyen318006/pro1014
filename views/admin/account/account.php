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
        <a href="<?= BASE_URL . '?act=booking'  ?>"><i class="fas fa-receipt"></i><span>Quản lý Booking</span></a>
        <a href="<?= BASE_URL.'?act=adminJournals' ?>"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
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
    <!-- Content -->
    <div class="content p-4 p-md-5" style="background: #f8fdff; min-height: 100vh;">
        <div class="container-fluid">

            <!-- Tiêu đề đẹp -->
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    Quản lý Tài Khoản Người Dùng
                </h1>
                <p class="text-muted fs-5">Danh sách tất cả tài khoản </p>
            </div>

            <!-- Bảng đẹp + hiện đại -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-white text-center" style="background: linear-gradient(135deg, #00bcd4, #0097a7);">
                                <tr></tr>
                                    <th class="py-4">Họ tên</th>
                                    <th class="py-4">Email</th>
                                    <th class="py-4">Mật khẩu</th>
                                    <th class="py-4">Địa chỉ</th>
                                    <th class="py-4">SĐT</th>
                                    <th class="py-4">Trạng thái</th>
                                    <th class="py-4">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php foreach ($users as $user): ?>
                                    <?php if ($user['role'] === 'admin') continue; ?>
                                    <tr class="text-center border-bottom">
                                        <td class="fw-medium"><?= htmlspecialchars($user['fullname']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><span class="text-muted fw-bold">••••••••</span></td>
                                        <td><?= htmlspecialchars($user['address'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($user['phone'] ?? '—') ?></td>
                                        <td>
                                            <?php if ($user['status'] == 0): ?>
                                                <span class="badge bg-danger text-white px-3 py-2 rounded-pill">Đã khóa</span>
                                            <?php else: ?>
                                                <span class="badge bg-success text-white px-3 py-2 rounded-pill">Hoạt động</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($user['status'] == 0): ?>
                                                <a href="?act=open_user&id=<?= $user['id'] ?>"
                                                    class="btn btn-success btn-sm rounded-pill px-4 shadow-sm">
                                                    Mở khóa
                                                </a>
                                            <?php else: ?>
                                                <a href="?act=block_user&id=<?= $user['id'] ?>"
                                                    class="btn btn-warning btn-sm rounded-pill px-4 shadow-sm text-dark">
                                                    Khóa
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Khi không có user nào (trừ admin) -->
                    <?php if (empty(array_filter($users, fn($u) => $u['role'] !== 'admin'))): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users-slash fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted">Chưa có tài khoản khách hàng nào</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<style>
    :root {
        --cyan: #00bcd4;
        --cyan-dark: #0097a7;
    }

    .content {
        background: #f8fdff;
    }

    .card {
        border-radius: 1.5rem !important;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0, 188, 212, 0.15) !important;
        transition: all 0.4s ease;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0, 188, 212, 0.25) !important;
    }

    .table th {
        font-weight: 600;
        letter-spacing: 0.8px;
        font-size: 0.95rem;
    }

    .table tbody tr:hover {
        background: #f0faff !important;
    }

    .badge {
        font-size: 0.9rem;
        min-width: 90px;
    }

    .btn-sm {
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-sm:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 188, 212, 0.3) !important;
    }

    /* Responsive bảng */
    @media (max-width: 768px) {
        .content {
            padding: 1rem !important;
        }

        .table thead {
            display: none;
        }

        .table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e0f7fa;
            border-radius: 1rem;
            padding: 1rem;
            background: white;
        }

        .table td {
            display: flex;
            justify-content: space-between;
            text-align: right;
            padding: 0.5rem 0;
            border: none;
        }

        .table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--cyan);
            text-align: left;
        }

        .table td:last-child {
            justify-content: center;
            gap: 10px;
        }
    }
</style>