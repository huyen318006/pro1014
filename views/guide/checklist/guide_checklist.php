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

        <a href="<?= BASE_URL . '?act=guideDashboard' ?>"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a href="<?= BASE_URL . '?act=guideDepartures' ?>"><i class="fas fa-calendar-alt"></i> <span>Lịch khởi hành</span></a>
        <a href="<?= BASE_URL . '?act=MyTour' ?>" class="active"><i class="fas fa-map-marked-alt"></i> <span>Tour được giao</span></a>
        <a href="guideDiary.php"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
        <a href="<?= BASE_URL . '?act=incident' ?>"><i class="fas fa-exclamation-triangle"></i> <span>Báo cáo sự cố</span></a>
        <a href="<?= BASE_URL . '?act=logout' ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
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

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> Đã lưu checklist thành công!
            </div>
        <?php endif; ?>


        <!-- FORM CHECKLIST -->
        <div class="table-card checklist-card p-4 mb-5">
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

                <button type="submit" class="btn-save-checklist mt-3">
                    <i class="fas fa-save"></i> Lưu checklist
                </button>
            </form>
        </div>



        <!-- ========================= -->
        <!--      ĐIỂM DANH KHÁCH      -->
        <!-- ========================= -->

        <h3 class="mb-3">
            <i class="fa-solid fa-users"></i> Điểm danh khách
        </h3>

        <form method="POST" action="<?= BASE_URL ?>?act=saveAttendance">
            <input type="hidden" name="departure_id" value="<?= $_GET['departure_id'] ?>">

            <table class="table table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Tên khách</th>
                        <th>SĐT</th>
                        <th>Số lượng</th>
                        <th>Có mặt</th>
                        <th>Vắng</th>
                        <th>Trễ</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($getkhachhang as $index => $kh): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($kh['customer_name']) ?></td>
                            <td><?= htmlspecialchars($kh['customer_phone']) ?></td>
                            <td><?= $kh['quantity'] ?></td>

                            <td>
                                <input type="number" name="form_present[]" min="0" max="<?= $kh['quantity'] ?>" value="0" placeholder="Số người có mặt">
                            </td>

                            <td>
                                <input type="number" name="form_absent[]" min="0" max="<?= $kh['quantity'] ?>" value="0" placeholder="Số người vắng">
                            </td>

                            <td>
                                <input type="number" name="form_late[]" min="0" max="<?= $kh['quantity'] ?>" value="0" placeholder="Số người trễ">
                            </td>

                            <td>
                                <input type="text" name="form_note[]" placeholder="Ghi chú...">
                            </td>
                        </tr>

                        <input type="hidden" name="form_departure_id[]" value="<?= $kh['departure_id'] ?>">
                        <input type="hidden" name="form_booking_id[]" value="<?= $kh['id'] ?>">
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-end">
                <button class="btn btn-success mt-3">
                    <i class="fa-solid fa-save"></i> Lưu điểm danh
                </button>
            </div>
        </form>


    </div>



</body>

</html>
<style>
    /* ROOT */
    :root {
        --primary: #00bcd4;
        --primary-dark: #006978;
        --bg-soft: #f6fafb;
    }

    /* BACKGROUND CONTENT */
    body {
        background: #f4f7fa;
    }

    /* CARD STYLE */
    .card,
    .checklist-card {
        border-radius: 18px;
        background: white;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    /* TITLE */
    .page-title {
        font-weight: 700;
        color: #222;
    }

    /* ===== CHECKLIST ===== */
    .form-check {
        background: var(--bg-soft);
        border-radius: 10px;
        padding: 10px 14px 10px 38px;
        transition: 0.25s;
        border: 1px solid #eef2f5;
    }

    .form-check:hover {
        background: #eaf8fb;
        transform: translateX(5px);
    }

    .form-check-input {
        width: 1.2rem;
        height: 1.2rem;
        cursor: pointer;
    }

    .form-check-label {
        font-weight: 500;
    }

    /* ===== TABLE (ĐIỂM DANH) ===== */
    .table {
        background: white;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
    }

    .table th {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff !important;
        text-align: center;
        vertical-align: middle;
        font-weight: 600;
    }

    .table td {
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f6fbff;
    }

    /* ===== INPUT ===== */
    .table input[type="number"],
    .table input[type="text"] {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 6px 10px;
        width: 100%;
        font-size: 0.85rem;
    }

    .table input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(0, 188, 212, .2);
    }

    /* CĂN GIỮA INPUT NUMBER */
    .table input[type="number"] {
        text-align: center;
    }

    /* ===== BUTTON CHECKLIST ===== */
    .btn-save-checklist {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.55rem 1.4rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 14px;
        border: none;
        transition: 0.3s;
    }

    .btn-save-checklist:hover {
        transform: translateY(-2px) scale(1.05);
    }

    /* ===== BUTTON SAVE ATTENDANCE ===== */
    .btn-success {
        background: linear-gradient(135deg, #4caf50, #2e7d32);
        border: none;
        border-radius: 14px;
        padding: 0.5rem 1.6rem;
        transition: 0.3s;
    }

    .btn-success:hover {
        transform: translateY(-2px) scale(1.06);
    }
</style>