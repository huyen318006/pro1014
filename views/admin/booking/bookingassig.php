<!DOCTYPE html>

<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Phân công HDV | LOFT CITY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 + FontAwesome -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/trangchu.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>asset/css/assignments.css">
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
        <a href="<?= BASE_URL . '?act=logout'  ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>>
    </div>
    <!-- Header -->

    <div class="header">
        <h5><i class="fas fa-cogs"></i></h5>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span>Admin <?= htmlspecialchars($_SESSION['user']['fullname'] ?? '') ?></span>
        </div>
    </div>
    <div class="content">
        <div class="departure-container">
            <form action="<?= BASE_URL . '?act=addbooking' ?>" method="POST" class="p-4 shadow rounded bg-white" style="max-width: 600px; margin: auto; " onsubmit="return showSuccessAlert()">

                <h4 class="mb-3 text-primary">Thông tin Tour</h4>

                <!-- Thông tin tour (readonly) -->
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
                    <label class="form-label">Số lượng vé còn </label>
                    <input type="text" id="max_participants" class="form-control" value="<?= $departuer['max_participants'] ?>" readonly>
                </div>

                <input type="hidden" name="departure_id" value="<?= $departuer['id'] ?>">

                <hr>

                <h4 class="mb-3 text-primary">Thông tin khách hàng</h4>

                <div class="mb-3">
                    <label class="form-label">Họ tên khách hàng</label>
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

                <button type="submit" class="btn btn-primary w-100">Đặt tour</button>

            </form>



        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    function showSuccessAlert() {
        //số vẽ khách nhập
        const quantity = parseInt(document.getElementById('quantity').value);
        // Lấy số vé còn
        const max = parseInt(document.getElementById('max_participants').value);

        if (quantity > max) {
            alert(`Số lượng vé không được vượt quá ${max} vé còn!`);
            return false; // ngăn form submit
        }
        alert("Đặt tour thành công!");
        return true; // cho phép form submit tiếp tục
    }
</script>