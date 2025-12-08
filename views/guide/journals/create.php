<?php
// views/guide/journals/create.php
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
/* ===== SIDEBAR ===== */
body {
    display: flex;
    min-height: 100vh;
}

/* ===== CONTENT ===== */
.content {
    margin-left: 250px;
    padding: 2rem;
    width: 100%;
}

/* ===== EXISTING STYLES ===== */
.table-card table th { background-color: #dedfe0ff; color:white; text-transform:uppercase; font-size:0.88rem; }
.table-card table td { font-size:0.92rem; vertical-align:middle; }
.status-badge { display:inline-block; padding:0.45em 0.9em; font-size:0.85rem; font-weight:600; border-radius:20px; text-transform:capitalize; color:#c45252ff; transition:all 0.3s ease; box-shadow:0 2px 6px rgba(0,0,0,0.15); }
.status-pending { background-color:#f7b456ff; }
.status-confirmed { background-color:#28a745; }
.status-cancelled { background-color:#dc3545; }
.status-unknown { background-color:#6c757d; }
.status-badge:hover { transform: scale(1.05); opacity:0.9; }
.table-card table tbody tr:hover { background:#f4f9fa; transition:0.25s; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo"><i class="fas fa-hiking"></i></div>
    <h4>HƯỚNG DẪN VIÊN</h4>
    <a href="<?= BASE_URL.'?act=guideDashboard' ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="<?= BASE_URL.'?act=guideDepartures' ?>"><i class="fas fa-calendar-alt"></i> Lịch khởi hành</a>
    <a href="<?= BASE_URL.'?act=MyTour' ?>"><i class="fas fa-map-marked-alt"></i> Tour được giao</a>
    <a href="<?= BASE_URL.'?act=guideJournalsCreate' ?>" class="active"><i class="fas fa-book"></i> Viết nhật ký</a>
    <a href="<?= BASE_URL.'?act=incident' ?>"><i class="fas fa-exclamation-triangle"></i> Báo cáo sự cố</a>
    <a href="<?= BASE_URL.'?act=logout' ?>"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
</div>
<!-- CONTENT -->
<div class="content">
    <h2><?= htmlspecialchars($title) ?></h2>

    <?php if(!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="?act=guideJournalsStore" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="assignment_id" class="form-label">Chọn phân công</label>
            <select name="assignment_id" id="assignment_id" class="form-select" required>
                <option value="">-- Chọn assignment --</option>
                <?php foreach($assignments as $a): ?>
                    <option value="<?= $a['assignment_id'] ?>">
                        <?= htmlspecialchars($a['tour_name']) ?> - <?= htmlspecialchars($a['departure_date']) ?> - <?= htmlspecialchars($a['customer_name'] ?? '-') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="journal_date" class="form-label">Ngày</label>
            <input type="date" name="journal_date" id="journal_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="journal_time" class="form-label">Giờ</label>
            <input type="time" name="journal_time" id="journal_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Địa điểm</label>
            <input type="text" name="location" id="location" class="form-control">
        </div>

        <div class="mb-3">
            <label for="incident" class="form-label">Sự cố / Ghi chú</label>
            <textarea name="incident" id="incident" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="extra_cost" class="form-label">Chi phí phát sinh</label>
            <input type="number" step="0.01" name="extra_cost" id="extra_cost" class="form-control">
        </div>

        <div class="mb-3">
            <label for="photos" class="form-label">Ảnh (có thể chọn nhiều ảnh)</label>
            <input type="file" name="photos[]" id="photos" class="form-control" multiple accept="image/*">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="sent_to_admin" id="sent_to_admin" class="form-check-input">
            <label for="sent_to_admin" class="form-check-label">Gửi cho admin</label>
        </div>

        <button type="submit" class="btn btn-success">Lưu nhật ký</button>
        <a href="?act=guideJournals" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
