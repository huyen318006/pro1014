<?php
// File: views/admin/services/edit.php
// Lấy dữ liệu từ controller
$service    = $GLOBALS['service'] ?? null;
$departure  = $GLOBALS['departure'] ?? null;
$tour       = $GLOBALS['tour'] ?? null;

if (!$service) {
    echo "<div class='alert alert-danger text-center'>Không tìm thấy dịch vụ!</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa dịch vụ #<?= $service['id'] ?> | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/trangchu.css">
</head>
<body>
    <div class="content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-edit text-warning"></i> Sửa dịch vụ #<?= $service['id'] ?>
                </h2>
                <a href="index.php?act=services" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <!-- Thông báo -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Hiển thị thông tin tour + ngày -->
            <?php if ($tour && $departure): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Thuộc tour:</strong> <?= htmlspecialchars($tour['name'] ?? 'N/A') ?>
                    <?php if (!empty($tour['code'])) echo " <small>[" . htmlspecialchars($tour['code']) . "]</small>"; ?>
                    — <strong>Ngày khởi hành:</strong> 
                    <?= !empty($departure['departure_date']) ? date('d/m/Y', strtotime($departure['departure_date'])) : 'Chưa xác định' ?>
                </div>
            <?php endif; ?>

            <!-- Form sửa dịch vụ -->
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <form action="index.php?act=servicesUpdate" method="POST">
                        <input type="hidden" name="id" value="<?= $service['id'] ?>">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tên dịch vụ <span class="text-danger">*</span></label>
                                <input type="text" name="service_name" class="form-control form-control-lg" 
                                       value="<?= htmlspecialchars($service['service_name']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Đối tác</label>
                                <input type="text" name="partner_name" class="form-control" 
                                       value="<?= htmlspecialchars($service['partner_name'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                                <i class="fas fa-save me-3"></i> CẬP NHẬT DỊCH VỤ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>