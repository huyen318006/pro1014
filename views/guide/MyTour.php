<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tour Được Giao | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- CSS giao diện Guide -->
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

    <a href="guideDiary.php"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>

    <a href="create.php"><i class="fas fa-exclamation-triangle"></i> <span>Báo cáo sự cố</span></a>

    <a href="guideStatistic.php"><i class="fas fa-chart-line"></i> <span>Thống kê</span></a>
    <a href="<?= BASE_URL.'?act=logout' ?>">
      <i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span>
    </a>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-hiking"></i>
        </div>

        <h4>HƯỚNG DẪN VIÊN</h4>

        <a href="<?= BASE_URL.'?act=guideDashboard' ?>"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a href="<?= BASE_URL.'?act=guideDepartures' ?>"><i class="fas fa-calendar-alt"></i> <span>Lịch khởi hành</span></a>
        <a href="<?= BASE_URL.'?act=MyTour' ?>" class="active"><i class="fas fa-map-marked-alt"></i> <span>Tour được giao</span></a>
        <a href="guideChecklist.php"><i class="fas fa-clipboard-check"></i> <span>Checklist</span></a>
        <a href="guideDiary.php"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
        <a href="guideReport.php"><i class="fas fa-exclamation-triangle"></i> <span>Báo cáo sự cố</span></a>
        <a href="guideStatistic.php"><i class="fas fa-chart-line"></i> <span>Thống kê</span></a>
        <a href="<?= BASE_URL.'?act=logout' ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- HEADER -->
    <div class="header">
        <h5><i class="fas fa-user-tie"></i> Tour Bạn Được Giao</h5>

        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span><?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <h2 class="page-title"><i class="fas fa-map-marked-alt"></i> Danh sách tour bạn phụ trách</h2>

        <?php if (!empty($MyTour)): ?>

        <div class="table-card">
            <div class="card-header">
                <h5><i class="fas fa-list"></i> Tour được giao</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tên Tour</th>
                                <th>Ngày khởi hành</th>
                                <th>Điểm tập trung</th>
                                <th>Số lượng tối đa</th>
                                <th>Ghi chú</th>
                                <th>Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($MyTour as $departure): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($departure['tour_name'] ?? '') ?></strong></td>
                                <td><?= htmlspecialchars($departure['departure_date'] ?? '') ?></td>
                                <td><?= htmlspecialchars($departure['meeting_point'] ?? '') ?></td>
                                <td><?= htmlspecialchars($departure['max_participants'] ?? '') ?> người</td>
                                <td><?= nl2br(htmlspecialchars($departure['note'] ?? '')) ?></td>

                                <td>
                                    <span class="badge status-badge status-<?= $departure['status'] ?? 'unknown' ?>">
                                        <?= ucfirst($departure['status'] ?? '') ?: 'Chưa xác định' ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="index.php?act=showChecklistForGuide&departure_id=<?= $departure['id'] ?>"
                                    class="btn-checklist">
                                    <i class="fas fa-clipboard-check"></i> Xem Checklist
                                    </a>
                                </td>

                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <?php else: ?>
            <div class="alert alert-info mt-4">
                <i class="fas fa-info-circle"></i> Bạn chưa được giao tour nào.
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
<style>
    /* ===== MY TOUR TABLE ===== */
.departure-table th {
background: linear-gradient(135deg, var(--primary), var(--primary-dark));
color: white;
text-transform: uppercase;
letter-spacing: 0.5px;
font-size: 0.88rem;
}

.departure-table td {
font-size: 0.92rem;
vertical-align: middle;
}

/* ===== STATUS BADGE ===== */
.status-badge {
display: inline-block;
padding: 0.45em 0.9em;
font-size: 0.85rem;
font-weight: 600;
border-radius: 20px;
text-transform: capitalize;
color: #e1d030ff;
transition: all 0.3s ease;
box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

/* Các trạng thái */
.status-pending { background-color: #f7b456ff; }   /* Chờ xử lý */
.status-confirmed { background-color: #28a745; } /* Xác nhận */
.status-cancelled { background-color: #dc3545; } /* Hủy */
.status-unknown { background-color: #6c757d; }   /* Chưa xác định */

/* Hover hiệu ứng */
.status-badge:hover {
transform: scale(1.05);
opacity: 0.9;
}

/* ===== BUTTON XEM CHECKLIST ===== */
.btn-checklist {
display: inline-flex;
align-items: center;
gap: 0.5rem;
padding: 0.45rem 1rem;
font-size: 0.9rem;
font-weight: 600;
color: #f8f8f5ff !important;
background: linear-gradient(135deg, var(--primary), var(--primary-dark));
border-radius: 12px;
text-decoration: none;
transition: all 0.3s ease;
box-shadow: 0 4px 12px rgba(124, 215, 225, 0.25);
}

.btn-checklist i {
font-size: 1rem;
}

/* Hover hiệu ứng cho button */
.btn-checklist:hover {
background: linear-gradient(135deg, #00bcd4, #006978);
transform: translateY(-2px) scale(1.05);
box-shadow: 0 6px 16px rgba(0,151,167,0.35);
}

/* ===== ROW HOVER ===== */
.departure-table tr:hover {
background: #f4f9fa;
transition: 0.25s;
}

</style>