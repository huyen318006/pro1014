<?php
// Xác định trang active cho sidebar
$active = $active ?? 'dashboard';

// Include layout đầu (head, sidebar, header)
include __DIR__ . '/layout_guide_start.php';
?>

<!-- CONTENT -->
<div class="content">
    <?php
    // Nơi đặt nội dung từng trang
    if ($active === 'dashboard') {
        echo "<h3>Chào mừng " . ($_SESSION['guide_name'] ?? 'Hướng dẫn viên' ) . "!</h3>";
        echo "<p>Đây là dashboard của bạn.</p>";
    }elseif ($active === 'tours') {
        echo "<h3>Quản lý Tour</h3>";
        echo "<p>Danh sách các tour bạn đang hướng dẫn.</p>";
    }elseif ($active === 'bookings') {
        echo "<h3>Quản lý Đặt chỗ</h3>";
        echo "<p>Danh sách các đặt chỗ của khách hàng.</p>";
    }elseif ($active === 'profile') {
        echo "<h3>Hồ sơ cá nhân</h3>"; 
        echo "<p>Thông tin cá nhân của bạn.</p>";
    } else {
        echo "<h3>Trang không tồn tại</h3>";
        echo "<p>Vui lòng chọn một mục hợp lệ từ menu bên trái.</p>";
    }
    ?>
</div>
<?php
// Include layout cuối (JS, đóng body/html)
include __DIR__ . '/layout_guide_end.php';
?>
