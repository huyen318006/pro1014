<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Checklist Tour | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- CSS Guide -->
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/guide.css">
</head>
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
    <a href="guideDiary.php"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
    <a href="<?= BASE_URL.'?act=incident'?>"><i class="fas fa-exclamation-triangle"></i> <span>Báo cáo sự cố</span></a>
    <a href="<?= BASE_URL.'?act=logout' ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
</div>

<!-- HEADER -->
<div class="header">
    <h5><i class="fas fa-clipboard-check"></i> Checklist Tour</h5>

    <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span><?= $_SESSION['user']['fullname'] ?? '' ?></span>
    </div>
</div>

<!-- CONTENT -->
<div class="content">
    <h2 class="page-title mb-4">
        <i class="fas fa-clipboard-check"></i> Checklist Tour
    </h2>

    <!-- THÔNG TIN TOUR + HDV -->
    <div class="card p-3 mb-4" style="border-left: 4px solid var(--primary);">
        <h5 class="mb-2"><i class="fas fa-map-marked-alt"></i> Tour: 
            <span style="color: var(--primary);">
                <?= $departureInfo['tour_name'] ?>
            </span>
        </h5>

        <p class="mb-1">
            <i class="fas fa-calendar-alt"></i> 
            <strong>Ngày khởi hành:</strong> <?= $departureInfo['departure_date'] ?>
        </p>

        <p class="mb-0">
            <i class="fas fa-user-check"></i> 
            <strong>Hướng dẫn viên thực hiện:</strong> <?= $guideName ?>
        </p>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Đã lưu checklist thành công!
        </div>
    <?php endif; ?>

    <div class="table-card checklist-card p-4">
        <form method="POST" action="<?= BASE_URL ?>?act=saveChecklistForGuide">
            <input type="hidden" name="departure_id" value="<?= $_GET['departure_id'] ?? '' ?>">

            <?php foreach($checklistItems as $item): ?>
                <div class="form-check mb-2">
                    <input class="form-check-input"
                           type="checkbox"
                           name="checked[]"
                           id="item_<?= md5($item['item_name']) ?>"
                           value="<?= $item['item_name'] ?>"
                           <?= ($item['is_checked'] && $item['checked_by_name'] == ($_SESSION['user']['fullname'] ?? '')) ? 'checked' : '' ?>>

                    <label class="form-check-label" for="item_<?= md5($item['item_name']) ?>">
                        <?= $item['item_name'] ?>
                    </label>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="btn-save-checklist mt-3">
                <i class="fas fa-save"></i> Lưu checklist
            </button>
        </form>
    </div>
</div>


</body>
</html>
<style>
    /* ===== BUTTON LƯU CHECKLIST ===== */
.btn-save-checklist {
display: inline-flex;
align-items: center;
gap: 0.5rem;
padding: 0.5rem 1.3rem;
font-size: 0.95rem;
font-weight: 600;
color: #fff;
background: linear-gradient(135deg, var(--primary), var(--primary-dark));
border: none;
border-radius: 12px;
cursor: pointer;
transition: all 0.3s ease;
box-shadow: 0 4px 12px rgba(0,151,167,0.25);
}

.btn-save-checklist i {
font-size: 1rem;
}

/* Hover hiệu ứng */
.btn-save-checklist:hover {
background: linear-gradient(135deg, #00bcd4, #006978);
transform: translateY(-2px) scale(1.05);
box-shadow: 0 6px 16px rgba(0,151,167,0.35);
}

</style>

