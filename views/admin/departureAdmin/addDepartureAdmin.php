<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-user-shield"></i>
        </div>
        <h4>ADMIN</h4>
        <a href="index.php?act=home" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        <a href="<?= BASE_URL . '?act=account' ?>"><i class="fas fa-users-cog"></i> <span>Quản lý tài khoản</span></a>
        <a href="index.php?act=listTours"><i class="fas fa-map-marked-alt"></i> <span>Quản lý Tour</span></a>
        <a href="index.php?act=listItinerary"><i class="fas fa-route"></i> <span>Quản lý Lịch Trình</span></a>
        <a href="?act=listAssignments"><i class="fas fa-user-secret"></i> <span>Phân công HDV</span></a>
        <a href="index.php?act=services"><i class="fas fa-concierge-bell"></i> <span>Quản lý Dịch Vụ</span></a>
        <a href="index.php?act=policies"><i class="fas fa-scroll"></i> <span>Quản lý Chính Sách</span></a>
        <a href="?act=incidents"><i class="fas fa-exclamation-triangle"></i><span>Danh sách báo cáo</span></a>
        <a href="<?= BASE_URL . '?act=DepartureAdmin' ?>"><i class="fas fa-plane-departure"></i> <span>Lịch khởi hành</span></a>
        <a href="<?= BASE_URL . '?act=booking'  ?>"><i class="fas fa-receipt"></i><span>Quản lý Booking</span></a>
        <a href="<?= BASE_URL.'?act=adminJournals' ?>"><i class="fas fa-book"></i> <span>Nhật ký tour</span></a>
        <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
    </div>

    <!-- Header -->
    <div class="header">
        <h5><i class="fas fa-cogs"></i> Bảng điều khiển quản trị</h5>
        <div class="user- info">
            <i class="fas fa-user-circle"></i>
            <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>

    <!-- Content -->
    <!-- Content -->
    <div class="content p-4 p-md-5">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-primary mb-0">
                    <i class="fas fa-plane-departure me-2"></i> Thêm Lịch Khởi Hành Mới
                </h3>
                <a href="<?= BASE_URL . '?act=DepartureAdmin' ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
                </a>
            </div>

            <!-- Card Form Hiện Đại -->
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9 col-md-10">

                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-header bg-gradient-primary text-white py-4">
                            <h4 class="mb-0 text-center text-white">
                                <i class="fas fa-calendar-plus me-2"></i>
                                Tạo lịch khởi hành mới
                            </h4>
                        </div>

                        <div class="card-body p-4 p-lg-5">

                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Lỗi!</strong> <?= $_SESSION['error'] ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                <?php unset($_SESSION['error']); ?>
                            <?php endif; ?>

                            <form id="addDepartureForm" action="<?= BASE_URL . '?act=addDepartureForm' ?>" method="post"onsubmit="return hanld()">

                                <div class="row g-4">
                                    <!-- Cột 1 -->
                                    <div class="col-lg-6">
                                        <label class="form-label fw-bold text-dark">Chọn Tour <span class="text-danger">*</span></label>
                                        <select id="tour_id" name="tour" class="form-select form-select-lg shadow-sm" required>
                                            <option value="">-- Chọn tour du lịch --</option>
                                            <?php foreach ($getAllTours as $tour): ?>
                                                <option value="<?= $tour['id'] ?>"><?= htmlspecialchars($tour['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label fw-bold text-dark">Ngày Khởi Hành <span class="text-danger">*</span></label>
                                        <input type="date" id="departure_date" name="departure_date"
                                            class="form-control form-control-lg shadow-sm"
                                            min="<?= date('Y-m-d') ?>" required>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label fw-bold text-dark">Điểm Tập Trung <span class="text-danger">*</span></label>
                                        <input type="text" name="meeting_point"
                                            class="form-control form-control-lg shadow-sm"
                                            placeholder="VD: Sân bay Tân Sơn Nhất - Cổng D3" required>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label fw-bold text-dark">Số Chỗ Tối Đa <span class="text-danger">*</span></label>
                                        <input type="number" id="max_participants" name="max_participants"
                                            class="form-control form-control-lg shadow-sm"
                                            min="1" max="50" placeholder="Tối đa 30" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark">Ghi Chú (nếu có)</label>
                                        <textarea name="note" rows="3" class="form-control shadow-sm"
                                            placeholder="Ví dụ: Xe đưa đón tận nơi, tặng nước suối..."></textarea>
                                    </div>

                                    <!-- Phân công HDV -->
                                    <div class="col-12">
                                        <div class="border rounded-3 p-4 bg-light-subtle">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-user-secret me-2"></i> Phân công Hướng dẫn viên
                                            </h5>
                                            <select name="guide_id" class="form-select form-select-lg shadow-sm" required>
                                                <option value="">-- Chọn hướng dẫn viên chính --</option>
                                                <?php foreach ($guides as $g): ?>
                                                    <option value="<?= $g['id'] ?>">
                                                        <?= htmlspecialchars($g['fullname']) ?>
                                                        <?php if (!empty($g['phone'])) echo ' - ' . $g['phone']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Nút submit -->
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit"
                                            class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg fw-bold">
                                            <i class="fas fa-plus-circle me-2"></i>
                                            Tạo Lịch Khởi Hành Ngay
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>




    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    const hanld = () => {
        const max_participants = document.getElementById('max_participants').value;

        // Ép kiểu sang số
        const seat = Number(max_participants);

        // Kiểm tra rỗng, không phải số, nhỏ hơn 1 hoặc lớn hơn 20
        if (isNaN(seat) || seat < 1 || seat > 30) {
            alert('Số ghế không hợp lệ! Chỉ được nhập từ 1 đến 30.');
            return false; // chặn submit
        }

        return true; // cho submit
    };
</script>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff, #0056b3) !important;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, .15);
    }

    /* Làm đẹp placeholder */
    ::placeholder {
        color: #adb5bd !important;
        opacity: 1;
    }

    /* Responsive tốt hơn */
    @media (max-width: 768px) {
        .content {
            padding: 1rem !important;
        }

        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>