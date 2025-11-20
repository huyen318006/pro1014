<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/guide.css">

 
</head>
<body>
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

    <h2>☰ TOUR Bạn Được Giao</h2>

<?php if (!empty($MyTour)): ?>
<table class="departure-table">
    <tr>
        <th>Tên TOUR</th>
        <th>Ngày khởi hành</th>
        <th>Điểm tập trung</th>
        <th>Số lượng tối đa</th>
        <th>Ghi chú</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($MyTour as $departure): ?>
    <tr>
        <td><?= htmlspecialchars($departure['tour_name'] ?? '') ?></td>
        <td><?= htmlspecialchars($departure['departure_date'] ?? '') ?></td>
        <td><?= htmlspecialchars($departure['meeting_point'] ?? '') ?></td>
        <td><?= htmlspecialchars($departure['max_participants'] ?? '') ?> người</td>
        <td><?= nl2br(htmlspecialchars($departure['note'] ?? '')) ?></td>
        <td>
            <strong class="status status-<?= $departure['status'] ?? 'unknown' ?>">
                <?= ucfirst($departure['status'] ?? '') ?: 'Chưa xác định' ?>
            </strong>
        </td>
        <td>
            <a href="index.php?act=showChecklistForGuide&departure_id=<?= $departure['id'] ?>" class="checklist-link">
                 <i class="fas fa-clipboard-check"></i> Checklist
            </a>
        </td>

    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p>Không có tour nào để hiển thị.   </p>
<?php endif; ?>
    </div>


<style>
.departure-table {
    width: 100%;
    max-width: 500px;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
    font-size: 15px;
}

.departure-table tr {
    border-bottom: 1px solid #eee;
}

.departure-table tr:last-child {
    border-bottom: none;
}

.departure-table td, .departure-table th {
    padding: 12px 15px;
    vertical-align: top;
}

.departure-table th {
    background-color: #f8f9fa;
    font-weight: bold;
}

.status {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: bold;
    text-transform: uppercase;
}
.status-open    { background: #d4edda; color: #155724; }
.status-full    { background: #f8d7da; color: #721c24; }
.status-cancelled { background: #fff3cd; color: #856404; }
.status-unknown { background: #e2e3e5; color: #383d41; }

/* CSS cho link checklist */
.departure-table a.checklist-link {
    display: inline-flex;
    align-items: center;
    gap: 6px; /* khoảng cách giữa icon và text */
    padding: 6px 12px;
    background-color: #007bff;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.3s, transform 0.2s;
}

.departure-table a.checklist-link i {
    font-size: 16px;
}

.departure-table a.checklist-link:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

</style>

    
</body>
</html>