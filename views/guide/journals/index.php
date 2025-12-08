<?php
// views/guide/journals/index.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?> | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- CSS Guide -->
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/guide.css">
    <style>
         /* ===== MY TOUR TABLE ===== */
    .table-card table th {
        background-color: #dedfe0ff;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.88rem;
    }
    .table-card table td {
        font-size: 0.92rem;
        vertical-align: middle;
    }
    /* STATUS BADGE */
    .status-badge {
        display: inline-block;
        padding: 0.45em 0.9em;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 20px;
        text-transform: capitalize;
        color: #c45252ff;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .status-pending { background-color: #f7b456ff; }
    .status-confirmed { background-color: #28a745; }
    .status-cancelled { background-color: #dc3545; }
    .status-unknown { background-color: #6c757d; }
    .status-badge:hover { transform: scale(1.05); opacity: 0.9; }

    /* BUTTON XEM CHECKLIST */
    .btn-checklist {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.45rem 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #f8f8f5 !important;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(124, 215, 225, 0.25);
    }
    .btn-checklist:hover {
        background: linear-gradient(135deg, #00bcd4, #006978);
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 16px rgba(0,151,167,0.35);
    }

    /* ROW HOVER */
    .table-card table tbody tr:hover {
        background: #f4f9fa;
        transition: 0.25s;
    }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo"><i class="fas fa-hiking"></i></div>
    <h4>HƯỚNG DẪN VIÊN</h4>
    <a href="<?= BASE_URL.'?act=guideDashboard' ?>"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
    <a href="<?= BASE_URL.'?act=guideDepartures' ?>"><i class="fas fa-calendar-alt"></i> <span>Lịch khởi hành</span></a>
    <a href="<?= BASE_URL.'?act=MyTour' ?>"><i class="fas fa-map-marked-alt"></i> <span>Tour được giao</span></a>
    <a href="<?= BASE_URL.'?act=guideJournals' ?>" class="active"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
    <a href="<?= BASE_URL.'?act=incident'?>"><i class="fas fa-exclamation-triangle"></i> <span>Báo cáo sự cố</span></a>
    <a href="<?= BASE_URL.'?act=logout' ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
</div>
<div class="header">
    <h5><i class="fas fa-user-tie"></i> Tour Bạn Được Giao</h5>
    <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span><?= $_SESSION['user']['fullname'] ?? '' ?></span>
    </div>
</div>
<!-- CONTENT -->
<div class="content">
    <h2><?= htmlspecialchars($title) ?></h2>

    <!-- Thông báo -->
    <?php if(!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <a href="?act=guideJournalsCreate" class="btn btn-primary btn-new"><i class="fas fa-plus"></i> Viết nhật ký mới</a>

    <?php if(empty($journals)): ?>
        <div class="alert alert-info">Chưa có nhật ký nào.</div>
    <?php else: ?>
        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Ngày</th>
                            <th>Giờ</th>
                            <th>Tour</th>
                            <th>Khách</th>
                            <th>Tiêu đề</th>
                            <th>Địa điểm</th>
                            <th>Ảnh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($journals as $index => $j): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($j['journal_date']) ?></td>
                                <td><?= htmlspecialchars($j['journal_time']) ?></td>
                                <td><?= htmlspecialchars($j['tour_name']) ?></td>
                                <td><?= htmlspecialchars($j['customer_name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($j['title']) ?></td>
                                <td><?= htmlspecialchars($j['location'] ?? '-') ?></td>
                                <td>
                                    <?php if(!empty($j['photos'])): 
                                        $photos = json_decode($j['photos'], true);
                                        if(!empty($photos)):
                                    ?>
                                        <img src="<?= htmlspecialchars($photos[0]) ?>" alt="Ảnh" class="thumbnail">
                                    <?php endif; endif; ?>
                                </td>
                                <td>
                                    <a href="?act=guideJournalsEdit&id=<?= $j['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</a>
                                    <a href="?act=guideJournalsDelete&id=<?= $j['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa nhật ký này?');" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
