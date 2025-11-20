<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chỉnh sửa Dịch vụ đi kèm</title>
    
    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 900px; }
        .form-label span { font-size: 0.9em; }
    </style>
</head>
<body>
    <?php

    // CSRF Token
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    // Dữ liệu cũ & lỗi (khi validate fail)
    $old   = $_SESSION['old'] ?? ($service ?? []);
    $error = $_SESSION['error'] ?? '';
    unset($_SESSION['old'], $_SESSION['error']);
    ?>

    <div class="container mt-5 pt-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0 text-center">
                    <i class="bi bi-bus-front-fill"></i> 
                    Chỉnh sửa Dịch vụ đi kèm
                </h3>
            </div>
            <div class="card-body p-5">

                <!-- Thông báo lỗi -->
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="index.php?act=servicesUpdate" method="POST" novalidate>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($old['id'] ?? '') ?>">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                    <!-- 1. Chuyến đi (departure_id) -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-primary">
                            <i class="bi bi-calendar-check"></i> Chuyến đi <span class="text-danger">*</span>
                        </label>
                        <select name="departure_id" class="form-select form-select-lg" required>
                            <option value="">-- Chọn chuyến đi --</option>
                            <?php 
                            // Giả sử bạn đã có $departures từ controller
                            foreach (($departures ?? []) as $dep): 
                                $selected = ($old['departure_id'] ?? '') == $dep['id'] ? 'selected' : '';
                                $tourName = $dep['tour_name'] ?? 'Tour ID: ' . $dep['tour_id'];
                                $display = $tourName . ' - ' . date('d/m/Y', strtotime($dep['departure_date'])) 
                                         . ' (' . ($dep['meeting_point'] ?? 'Không rõ điểm đón') . ')';
                            ?>
                                <option value="<?= $dep['id'] ?>" <?= $selected ?>>
                                    <?= htmlspecialchars($display) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 2. Loại dịch vụ -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-tag-fill"></i> Loại dịch vụ <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="service_name" class="form-control form-control-lg" 
                               value="<?= htmlspecialchars($old['service_name'] ?? '') ?>" 
                               placeholder="Ví dụ: Khách sạn, Xe du lịch, Nhà hàng, Vé tham quan..." required>
                    </div>

                    <!-- 3. Đối tác -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-building"></i> Đối tác / Nhà cung cấp <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="partner_name" class="form-control form-control-lg" 
                               value="<?= htmlspecialchars($old['partner_name'] ?? '') ?>" 
                               placeholder="Ví dụ: Ha Long Pearl Hotel, Xe City Phương Trang..." required>
                    </div>

                    <!-- 4. Trạng thái -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-check-circle"></i> Trạng thái
                        </label>
                        <select name="status" class="form-select form-select-lg">
                            <option value="pending"   <?= ($old['status'] ?? 'pending') === 'pending'   ? 'selected' : '' ?>>Chờ xác nhận</option>
                            <option value="confirmed" <?= ($old['status'] ?? '') === 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
                            <option value="cancelled" <?= ($old['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                        </select>
                    </div>

                    <!-- 5. Ghi chú -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-chat-dots"></i> Ghi chú / Yêu cầu đặc biệt
                        </label>
                        <textarea name="note" class="form-control" rows="5" 
                                  placeholder="Ví dụ: Đặt 10 phòng đôi + 2 phòng đơn, Xe 45 chỗ có điều hòa, Check-in lúc 6h sáng..."><?= htmlspecialchars($old['note'] ?? '') ?></textarea>
                    </div>

                    <!-- Nút hành động -->
                    <div class="d-grid d-md-flex justify-content-end gap-3 mt-5">
                        <a href="index.php?act=services" class="btn btn-secondary btn-lg">
                            <i class="bi bi-arrow-left"></i> Quay lại danh sách
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-save"></i> Cập nhật dịch vụ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>