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
    <div class="content">

        <!-- FORM ĐẶT TOUR -->
        <div class="p-4 shadow rounded bg-white mb-5" style="max-width: 650px; margin: auto;">
            <h3 class="text-primary mb-4"><i class="fas fa-ticket-alt"></i> Đặt Tour</h3>

            <form action="<?= BASE_URL . '?act=addbooking' ?>" method="POST">

                <h5 class="text-secondary mb-3">Thông tin Tour</h5>

                <div class="mb-3">
                    <label class="form-label">Tên tour</label>
                    <input type="text" class="form-control" value="<?= $departuer['tour_name'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá tour</label>
                    <input type="text" class="form-control" value="<?= $departuer['tour_price'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày khởi hành</label>
                    <input type="text" class="form-control" value="<?= $departuer['departure_date'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số ghế còn lại</label>
                    <input type="text" id="max_participants" class="form-control" value="<?= $departuer['max_participants'] ?>" readonly>
                </div>

                <input type="hidden" name="departure_id" value="<?= $departuer['id'] ?>">

                <hr>

                <h5 class="text-secondary mb-3">Thông tin khách hàng</h5>

                <div class="mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="customer_phone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="customer_email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số lượng vé</label>
                    <input type="number" id="quantity" name="quantity" min="1" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note" class="form-control" rows="3"></textarea>
                </div>


                <!-- Phân công hướng dẫn viên -->
                <div class="p-4 shadow rounded bg-white mb-5" style="max-width: 650px; margin: auto;">
                    <h3 class="text-primary mb-4"><i class="fas fa-user-secret"></i> Phân công Hướng dẫn viên</h3>

                    <?php if (isset($_SESSION['error'])): ?>
                        <p class="text-danger fw-bold"><?= $_SESSION['error'] ?></p>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <select name="guide_id" class="form-select" required>
                        <option value="">-- Chọn hướng dẫn viên --</option>
                        <?php foreach ($guides as $g): ?>
                            <option value="<?= $g['id'] ?>"><?= $g['fullname'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn btn-primary w-100">Đặt tour</button>

            </form>
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

    <style>
        /* ===== CONTENT BACKGROUND ===== */
        .content {
            padding: 30px 15px;
            background: #f4f7fb;
        }

        /* ===== FORM CARD ===== */
        .content>div {
            border-radius: 20px !important;
            background: white !important;
            padding: 26px !important;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08) !important;
        }

        /* ===== TITLE ===== */
        .content h3 {
            font-weight: 700;
            color: #00bcd4 !important;
        }

        .content h5 {
            font-weight: 600;
        }

        /* ===== LABEL ===== */
        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #444;
        }

        /* ===== INPUT ===== */
        .form-control,
        .form-select,
        textarea {
            border-radius: 12px;
            padding: 10px 12px;
            font-size: 0.9rem;
            border: 1px solid #ddd;
            transition: 0.25s;
        }

        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 0 2px rgba(0, 188, 212, .15);
        }

        /* ===== FIELD SPACING ===== */
        .mb-3 {
            margin-bottom: 1rem !important;
        }

        /* ===== READONLY STYLE ===== */
        input[readonly] {
            background: #f7fafc !important;
            color: #555;
            font-weight: 500;
        }

        /* ===== INNER BOX (HDV SELECT) ===== */
        .content .p-4.shadow.rounded.bg-white {
            background: #f9fcfd !important;
            border-radius: 16px !important;
            border-left: 4px solid #00bcd4;
            box-shadow: none !important;
            margin-top: 20px;
        }

        /* ===== BUTTON MAIN ===== */
        .btn-primary {
            background: linear-gradient(135deg, #00bcd4, #006978);
            border: none;
            border-radius: 16px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: .4px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-3px) scale(1.03);
            background: linear-gradient(135deg, #00d5f1, #007688);
        }

        /* ===== ALERT ERROR ===== */
        .text-danger {
            background: #ffe5e5;
            border-left: 4px solid #dc3545;
            padding: 8px 10px;
            border-radius: 10px;
            font-size: 0.9rem;
        }

        /* ===== SMOOTHER ANIMATION ===== */
        .content * {
            transition: .2s;
        }
    </style>




</body>

</html>