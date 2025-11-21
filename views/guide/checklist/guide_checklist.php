<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist Tour</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- CSS riêng cho Guide -->
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/guide.css">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo">
        <i class="fas fa-hiking"></i>
    </div>

    <h4>HƯỚNG DẪN VIÊN</h4>

    <a href="<?= BASE_URL ?>?act=guideDashboard"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>

    <a href="<?= BASE_URL ?>?act=guideDepartures"><i class="fas fa-calendar-alt"></i> <span>Lịch khởi hành</span></a>

    <a href="<?= BASE_URL ?>?act=MyTour"><i class="fas fa-map-marked-alt"></i> <span>Tour được giao</span></a>

    <a class="active" href="<?= BASE_URL ?>?act=guideChecklist">
        <i class="fas fa-clipboard-check"></i> <span>Checklist</span>
    </a>

    <a href="<?= BASE_URL ?>?act=guideDiary"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>

    <a href="<?= BASE_URL ?>?act=guideReport"><i class="fas fa-exclamation-triangle"></i> <span>Báo cáo sự cố</span></a>

    <a href="<?= BASE_URL ?>?act=guideStatistic"><i class="fas fa-chart-line"></i> <span>Thống kê</span></a>

    <a href="<?= BASE_URL ?>?act=logout"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
</div>

<!-- HEADER -->
<div class="header">
    <h5><i class="fas fa-user-tie"></i> Checklist Tour</h5>

    <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span><?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
    </div>
</div>

<!-- CONTENT -->
<div class="content">

    <h2 class="mb-4">Checklist Tour</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Đã lưu checklist thành công!</div>
    <?php endif; ?>

    <div class="table-card p-4">
        <form method="POST" action="<?= BASE_URL ?>?act=saveChecklistForGuide">
            <input type="hidden" name="departure_id" value="<?= $_GET['departure_id'] ?? '' ?>">

            <?php foreach ($checklistItems as $item): ?>
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

            <button type="submit" class="btn btn-success mt-3">Lưu checklist</button>
        </form>
    </div>

</div>

</body>
</html>
