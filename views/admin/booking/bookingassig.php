<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Phân công HDV | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/trangchu.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/css/assignments.css">
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-user-shield"></i>
        </div>
        <h4>ADMIN</h4>

        <a href="?act=home" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="?act=account"><i class="fas fa-users-cog"></i> Quản lý tài khoản</a>
        <a href="?act=listTours"><i class="fas fa-map-marked-alt"></i> Quản lý Tour</a>
        <a href="?act=listItinerary"><i class="fas fa-route"></i> Quản lý Lịch trình</a>
        <a href="?act=listAssignments"><i class="fas fa-user-secret"></i> Phân công HDV</a>
        <a href="?act=services"><i class="fas fa-concierge-bell"></i> Quản lý Dịch vụ</a>
        <a href="?act=policies"><i class="fas fa-scroll"></i> Chính sách</a>
        <a href="?act=incidents"><i class="fas fa-exclamation-triangle"></i> Báo cáo sự cố</a>
        <a href="?act=DepartureAdmin"><i class="fas fa-plane-departure"></i> Lịch khởi hành</a>
        <a href="?act=booking"><i class="fas fa-receipt"></i> Booking</a>
        <a href="?act=logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
    </div>

    <!-- Header -->
    <div class="header d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-cogs"></i></h5>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>

    <!-- Main Content -->
    <!-- Main Content -->
    <div class="content p-4 p-md-5" style="background: linear-gradient(135deg, #f8fdff 0%, #f0f9ff 100%); min-height: 100vh;">
        <div class="container-fluid">

            <!-- Card chính - Form đặt tour -->
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-8 col-12">

                    <div class="card border-0 shadow-xl rounded-4 overflow-hidden">
                        <!-- Header card gradient -->
                        <div class="card-header text-white text-center py-5 position-relative overflow-hidden"
                            style="background: linear-gradient(135deg, #00bcd4, #0097a7);">
                            <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10">
                                <i class="fas fa-globe-americas position-absolute top-50 start-50 translate-middle fs-1"></i>
                            </div>
                            <h3 class="fw-bold mb-0 position-relative">
                                <i class="fas fa-ticket-alt me-3"></i>
                                Đặt Tour Du Lịch
                            </h3>
                            <p class="mb-0 mt-2 opacity-90">Vui lòng điền đầy đủ thông tin để hoàn tất đặt chỗ</p>
                        </div>

                        <div class="card-body p-4 p-lg-5">

                            <!-- Thông tin Tour (readonly) -->
                            <div class="bg-light-subtle rounded-4 p-4 mb-4 border-start border-5 border-primary">
                                <h5 class="text-primary fw-bold mb-4">
                                    <i class="fas fa-info-circle me-2"></i>Thông tin Tour
                                </h5>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-secondary">Tên tour</label>
                                        <input type="text" class="form-control form-control-lg bg-white"
                                            value="<?= $departuer['tour_name'] ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-secondary">Giá tour</label>
                                        <input type="text" class="form-control form-control-lg bg-white text-success fw-bold"
                                            value="<?= number_format($departuer['tour_price'], 0, ',', '.') ?> ₫" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-secondary">Ngày khởi hành</label>
                                        <input type="text" class="form-control form-control-lg bg-white"
                                            value="<?= date('d/m/Y', strtotime($departuer['departure_date'])) ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-secondary">Số ghế còn lại</label>
                                        <input type="text" id="max_participants" class="form-control form-control-lg bg-white text-danger fw-bold"
                                            value="<?= $departuer['max_participants'] ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Form thông tin khách hàng -->
                            <form action="<?= BASE_URL . '?act=addbooking' ?>" method="POST" class="needs-validation" novalidate>

                                <input type="hidden" name="departure_id" value="<?= $departuer['id'] ?>">

                                <h5 class="text-primary fw-bold mb-4">
                                    <i class="fas fa-user-circle me-2"></i>Thông tin khách hàng
                                </h5>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Họ tên <span class="text-danger">*</span></label>
                                        <input type="text" name="customer_name" class="form-control form-control-lg" required>
                                        <div class="invalid-feedback">Vui lòng nhập họ tên</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" name="customer_phone" class="form-control form-control-lg" required>
                                        <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="customer_email" class="form-control form-control-lg" required>
                                        <div class="invalid-feedback">Email không hợp lệ</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Số lượng vé <span class="text-danger">*</span></label>
                                        <input type="number" id="quantity" name="quantity" min="1"
                                            max="<?= $departuer['max_participants'] ?>"
                                            class="form-control form-control-lg" required>
                                        <div class="invalid-feedback">Vui lòng chọn số lượng hợp lệ</div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Ghi chú (nếu có)</label>
                                        <textarea name="note" class="form-control" rows="3"
                                            placeholder="Yêu cầu đặc biệt, trẻ em, người lớn tuổi..."></textarea>
                                    </div>
                                </div>

                                <!-- Nút submit -->
                                <div class="d-grid mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-lg fw-bold py-3 fs-5">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Xác nhận đặt tour ngay
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const quantity = parseInt(document.getElementById('quantity').value) || 0;
            const max = parseInt(document.getElementById('max_participants').value) || 0;

            if (quantity > max) {
                e.preventDefault(); // chặn submit
                alert(`Chỉ còn ${max} chỗ trống! Vui lòng giảm số lượng vé.`);
            }
            // Không hiện alert "thành công" nữa → để PHP lo
        });
    </script>


</body>

</html>

<style>
    :root {
        --primary: #00bcd4;
        --primary-dark: #0097a7;
    }

    .text-primary {
        color: var(--primary) !important;
    }

    .bg-primary {
        background-color: var(--primary) !important;
    }

    .card {
        box-shadow: 0 15px 35px rgba(0, 188, 212, 0.15) !important;
        transition: all 0.4s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 188, 212, 0.25) !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
        border: none !important;
        font-weight: 600;
        transition: all 0.4s ease;
    }

    .btn-primary:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 15px 35px rgba(0, 188, 212, 0.4) !important;
    }

    .form-control,
    textarea {
        border-radius: 12px !important;
        padding: 12px 16px !important;
        font-size: 1rem;
        border: 1.5px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    textarea:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 4px rgba(0, 188, 212, 0.15) !important;
        background-color: #fff !important;
    }

    input[readonly] {
        background-color: #f8fdff !important;
        color: #2c3e50 !important;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content {
            padding: 1rem !important;
        }

        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>