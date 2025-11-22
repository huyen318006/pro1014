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
    <a href="index.php?act=listItinerary"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Lịch Trình</span></a>
    <a href="?act=listAssignments"><i class="fas fa-map-marked-alt"></i> <span>Phân công HDV</span></a>
    <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
    <a href="index.php?act=policies"><i class="fas fa-scroll"></i> <span>Quản lý Chính Sách</span></a>
    <a href="?act=incidents"><i class="fas fa-list"></i><span>Danh sách báo cáo</span></a>
    <a href="#"><i class="fas fa-comments"></i> <span>Quản lý bình luận</span></a>
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
<body>
    <div class="container mt-4">
    <h3 class="mb-3">Danh sách chính sách Tour</h3>

   <a href="<?= BASE_URL ?>?act=policiesCreate" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Thêm chính sách</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tour</th>
                <th>Loại chính sách</th>
                <th>Nội dung</th>
                <th width="150">Hành động</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($policies as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['tour_name'] ?></td>
                    <td><?= $p['policy_type'] ?></td>
                    <td><?= mb_substr($p['content'], 0, 80) ?>...</td>
                    <td>
                        <a href="<?= BASE_URL ?>?act=policiesEdit&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</a>
                        <a href="<?= BASE_URL ?>?act=policiesDelete&id=<?= $p['id'] ?>" class="btn btn-danger btn-sm"onclick="return confirm('Bạn có chắc chắn muốn xóa chính sách này?')"><i class="fas fa-trash"></i> Xóa</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
