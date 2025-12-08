<?php
// views/admin/journals/index.php
?>
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
<style>
/* Bảng */
.table {
    border-collapse: separate;
    border-spacing: 0;
    width: 90%;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    border-radius: 8px;
    overflow: hidden;
    margin-left: 200px;
}

/* Header bảng */
.table thead {
    background-color: #f8f9fa;
}
.table thead th {
    font-weight: 600;
    color: #495057;
    text-align: center;
    vertical-align: middle;
}

/* Nội dung bảng */
.table tbody td {
    vertical-align: middle;
    text-align: center;
}

/* Ảnh thumbnail */
.thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #ddd;
}

/* Badge trạng thái gửi */
.badge-status {
    padding: 0.35em 0.6em;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 500;
    color: #fff;
    display: inline-block;
}
.bg-sent {
    background-color: #28a745;
}
.bg-not-sent {
    background-color: #dc3545;
}

/* Button hành động */
.btn-info {
    background-color: #0d6efd;
    border-color: #0d6efd;
}
.btn-info:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}

/* Hover trên hàng bảng */
.table tbody tr:hover {
    background-color: #f1f3f5;
    transition: background-color 0.2s ease-in-out;
}

/* Responsive */
@media (max-width: 768px) {
    .table thead {
        display: none;
    }
    .table, .table tbody, .table tr, .table td {
        display: block;
        width: 100%;
    }
    .table tr {
        margin-bottom: 15px;
        border-bottom: 2px solid #dee2e6;
    }
    .table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }
    .table td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        width: calc(50% - 30px);
        text-align: left;
        font-weight: 600;
        color: #495057;
    }
}
h3{
    margin-left: 200px;
}
</style>

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
    <a href="<?= BASE_URL.'?act=adminJournals' ?>" class="active"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
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

<div class="container mt-4">
    <h3><?= htmlspecialchars($title) ?></h3>

    <?php if(!empty($journals)): ?>
    <table class="table table-bordered table-hover mt-3 align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Hướng dẫn viên</th>
                <th>Ngày</th>
                <th>Giờ</th>
                <th>Tour</th>
                <th>Khách</th>
                <th>Tiêu đề</th>
                <th>Ảnh</th>
                <th>Gửi Admin</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($journals as $index => $j): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($j['guide_name']) ?></td>
                <td><?= htmlspecialchars($j['journal_date']) ?></td>
                <td><?= htmlspecialchars($j['journal_time']) ?></td>
                <td><?= htmlspecialchars($j['tour_name']) ?></td>
                <td><?= htmlspecialchars($j['customer_name'] ?? '-') ?></td>
                <td><?= htmlspecialchars($j['title']) ?></td>
                <td>
                    <?php if(!empty($j['photos'])): 
                        $photos = json_decode($j['photos'], true);
                        if(!empty($photos)):
                    ?>
                        <img src="<?= htmlspecialchars($photos[0]) ?>" class="thumbnail" alt="Ảnh">
                    <?php endif; endif; ?>
                </td>
                <td>
                    <?php if($j['sent_to_admin']): ?>
                        <span class="badge-status bg-sent">Đã gửi</span>
                    <?php else: ?>
                        <span class="badge-status bg-not-sent">Chưa gửi</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="?act=adminJournalsShow&id=<?= $j['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Xem</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Chưa có nhật ký nào.</p>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
