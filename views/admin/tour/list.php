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
    <a href="index.php?act=home"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
    <a href="<?= BASE_URL . '?act=account' ?>"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
    <a href="index.php?act=listTours" class="active"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
    <a href="index.php?act=listItinerary"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Lịch Trình</span></a>
    <a href="?act=listAssignments"><i class="fas fa-map-marked-alt"></i> <span>Phân công HDV</span></a>
    <a href="#"><i class="fas fa-shopping-cart"></i> <span>Quản lý đơn đặt</span></a>
    <a href="#"><i class="fas fa-comments"></i> <span>Quản lý bình luận</span></a>
    <a href="<?= BASE_URL . '?act=DepartureAdmin'  ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
    <a href="index.php?act=logout"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
  </div>

  <!-- Header -->
  <div class="header">
    <h5><i class="fas fa-cogs"></i> Bảng điều khiển tour</h5>
    <div class="user- info">
      <i class="fas fa-user-circle"></i>
      <span>Admin Chủ</span>
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="table-card">
      <div class="card-header">
        <h5>Quản lý Tour</h5>
        <a href="index.php?act=addTourForm" class="btn btn-add"><i class="fas fa-plus"></i> Thêm Tour</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Mã Tour</th>
                <th>Tên Tour</th>
                <th>Điểm Đến</th>
                <th>Loại</th>
                <th>Trạng Thái</th>
                <th>Giá</th>
                <th>Số Ngày</th>
                <th>Ngày Tạo</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tours as $item) { ?>
                <tr>
                  <td><?= $item["id"] ?></td>
                  <td><?= $item["code"] ?></td>
                  <td><strong><?= $item["name"] ?></strong></td>
                  <td><?= $item["destination"] ?></td>
                  <?php
                  $typeMap = [
                    'in_country' => 'Trong nước',
                    'abroad' => 'Nước ngoài',
                    'adventure' => 'Phiêu lưu',
                    'luxury' => 'Sang trọng',
                    'family' => 'Gia đình',
                  ];
                  $typeValue = $item["type"] ?? '';
                  $typeLabel = $typeMap[$typeValue] ?? ucwords(str_replace('_', ' ', $typeValue));
                  ?>
                  <td><?= $typeLabel ?></td>
                  <td>
                    <?php
                    $statusMap = [
                      'published' => ['label' => 'Hoạt động', 'class' => 'bg-success'],
                      'draft' => ['label' => 'Bản nháp', 'class' => 'bg-warning text-dark'],
                      'archived' => ['label' => 'Ngừng kinh doanh', 'class' => 'bg-secondary']
                    ];
                    $statusValue = $item["status"] ?? 'draft';
                    $statusMeta = $statusMap[$statusValue] ?? [
                      'label' => ucfirst($statusValue),
                      'class' => 'bg-secondary'
                    ];
                    ?>
                    <span class="badge <?= $statusMeta['class'] ?>"><?= $statusMeta['label'] ?></span>
                  </td>
                  <td><?= number_format($item["price"], 0, ',', '.') ?>đ</td>
                  <td><?= $item["duration_days"] ?></td>
                  <td><?= date('d/m/Y', strtotime($item["created_at"])) ?></td>
                  <td>
                    <a href="index.php?act=detailTour&id=<?= $item["id"] ?>" class="btn btn-info btn-action"><i class="fas fa-eye"></i></a>
                    <a href="index.php?act=editTourForm&id=<?= $item["id"] ?>" class="btn btn-primary btn-action"><i class="fas fa-edit"></i></a>
                    <a href="index.php?act=deleteTour&id=<?= $item["id"] ?>" class="btn btn-danger btn-action" onclick="return confirm('Bạn có chắc muốn xoá tour này?');"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>