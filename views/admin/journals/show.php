<?php
// views/admin/journals/show.php
$photos = $journal['photos'] ? json_decode($journal['photos'], true) : [];
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

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Hướng dẫn viên:</strong> <?= htmlspecialchars($journal['guide_name']) ?></p>
            <p><strong>Ngày:</strong> <?= htmlspecialchars($journal['journal_date']) ?></p>
            <p><strong>Giờ:</strong> <?= htmlspecialchars($journal['journal_time']) ?></p>
            <p><strong>Tour:</strong> <?= htmlspecialchars($journal['tour_name']) ?></p>
            <p><strong>Khách:</strong> <?= htmlspecialchars($journal['customer_name'] ?? '-') ?></p>
            <p><strong>Tiêu đề:</strong> <?= htmlspecialchars($journal['title']) ?></p>
            <p><strong>Nội dung:</strong> <?= nl2br(htmlspecialchars($journal['content'])) ?></p>
            <p><strong>Địa điểm:</strong> <?= htmlspecialchars($journal['location'] ?? '-') ?></p>
            <p><strong>Sự cố/Ghi chú:</strong> <?= htmlspecialchars($journal['incident'] ?? '-') ?></p>
            <p><strong>Chi phí phát sinh:</strong> <?= htmlspecialchars($journal['extra_cost'] ?? 0) ?></p>
            <p><strong>Gửi admin:</strong> <?= $journal['sent_to_admin'] ? 'Đã gửi' : 'Chưa gửi' ?></p>
            <?php if(!empty($photos)): ?>
                <p><strong>Ảnh:</strong></p>
                <div class="d-flex flex-wrap">
                    <?php foreach($photos as $p): ?>
                        <img src="<?= htmlspecialchars($p) ?>" class="thumbnail" alt="Ảnh">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <a href="?act=adminJournals" class="btn btn-secondary">Quay lại</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<style>
/* Container */
.container {
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 40px;
}

/* Card chi tiết */
.card {
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border: none;
}

.card-body p {
    font-size: 1rem;
    margin-bottom: 0.7rem;
    line-height: 1.5;
}

.card-body p strong {
    width: 150px;
    display: inline-block;
    color: #495057;
}

/* Ảnh thumbnail trong chi tiết */
.thumbnail {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #ddd;
    margin-right: 10px;
    margin-bottom: 10px;
}

/* Badge trạng thái gửi */
.badge-status {
    padding: 0.35em 0.75em;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #fff;
}
.bg-sent {
    background-color: #28a745;
}
.bg-not-sent {
    background-color: #dc3545;
}

/* Button quay lại */
.btn-secondary {
    margin-top: 20px;
    background-color: #6c757d;
    border-color: #6c757d;
}
.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}

/* Header trang */
h3 {
    margin-bottom: 20px;
    color: #343a40;
}

/* Sidebar padding fix */
body {
    background-color: #f8f9fa;
}

/* Responsive */
@media (max-width: 768px) {
    .card-body p strong {
        display: block;
        margin-bottom: 5px;
    }
    .thumbnail {
        width: 80px;
        height: 80px;
    }
}
</style>

</html>
