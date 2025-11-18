!<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Guide Dashboard | LOFT CITY</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- CSS chung với admin -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/guide.css"> <!-- màu mới -->

</head>

<body>

  <!-- SIDE BAR GUIDE -->
  <div class="sidebar">
    <div class="logo">
      <i class="fas fa-hiking"></i>
    </div>

    <h4>HƯỚNG DẪN VIÊN</h4>

    <a href="<?=  BASE_URL.'?act=guideDashboard' ?>" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>  </a>

    <a href="<?= BASE_URL.'?act=guideDepartures' ?>"><i class="fas fa-calendar-alt"></i> <span>Lịch khởi hành</span></a>

    <a href="<?= BASE_URL.'?act=MyTour' ?>"><i class="fas fa-map-marked-alt"></i> <span>Tour được giao</span></a>

    <a href="guideChecklist.php"><i class="fas fa-clipboard-check"></i> <span>Checklist</span></a>

    <a href="guideDiary.php"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>

    <a href="guideReport.php"><i class="fas fa-exclamation-triangle"></i> <span>Báo cáo sự cố</span></a>

    <a href="guideStatistic.php"><i class="fas fa-chart-line"></i> <span>Thống kê</span></a>
    <a href="<?= BASE_URL.'?act=logout' ?>">
      <i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span>
    </a>

  </div>

  <!-- HEADER -->
  <div class="header">
    <h5><i class="fas fa-user-tie"></i> Bảng điều khiển Hướng Dẫn Viên</h5>

    <div class="user-info">
      <i class="fas fa-user-circle"></i>
      <span><?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
    </div>
  </div>



  <!-- CONTENT -->
  <div class="content">

   <div class="departure-container">
    <h2 class="title">📅 Lịch Khởi Hành</h2>

    <table class="departure-table">
        <thead>
            <tr>
                <th>Tên Tour</th>
                <th>Ngày Khởi Hành</th>
                <th>Ngày Kết Thúc</th>
                <th>Số Chỗ</th>
                <th>Giá Tour</th>
                <th>Hướng Dẫn Viên</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($departures as $departure): ?>
            <tr>
                <td><?= htmlspecialchars($departure['tour_name'] ?? '') ?></td>
                <td><?= htmlspecialchars($departure['departure_date'] ?? '') ?></td>
                <td><?= htmlspecialchars(date('Y-m-d', strtotime($departure['departure_date'] . ' + ' . ($departure['duration_days'] - 1) . ' days')) ?? '') ?></td>
                <td><?= htmlspecialchars($departure['max_participants'] ?? '') ?></td>
                <td><?= htmlspecialchars(number_format($departure['tour_price'] ?? 0, 0, ',', '.') . ' VND') ?></td>
                <td><?= htmlspecialchars($departure['guide_name'] ?? 'Chưa phân công') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<style>
    .departure-container {
    max-width: 1000px;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.1);
    font-family: "Segoe UI", Arial, sans-serif;
}

.title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 26px;
    color: #2c3e50;
}

.departure-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 16px;
}

.departure-table thead {
    background: #3498db;
    color: white;
}

.departure-table th, 
.departure-table td {
    padding: 14px;
    border: 1px solid #ddd;
    text-align: center;
}

.departure-table tr:nth-child(even) {
    background: #f7f9fa;
}

.departure-table tr:hover {
    background: #dfeffc;
    transition: 0.3s;
}

</style>