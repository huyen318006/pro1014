<div class="sidebar">
    <h3>NHÂN VIÊN</h3>

    <a href="#" class="active">🏠 Dashboard</a>
    <a href="#">📅 Lịch khởi hành</a>
    <a href="#">🧾 Tour được giao</a>
    <a href="#">📋 Checklist</a>
    <a href="#">📓 Nhật ký tour</a>
    <a href="#">⚠️ Báo cáo sự cố</a>
    <a href="#">📊 Thống kê</a>
    <a href="#">⚙️ Tài khoản</a>
    <a href="#">🚪 Đăng xuất</a>
</div>

<!-- CONTENT -->

</body>
<style>
/* SIDEBAR */
.content {
    margin-left: 260px;   /* ĐẨY CONTENT RA KHỎI SIDEBAR */
    padding: 30px 40px;   /* THÊM KHOẢNG CÁCH CHO ĐẸP */
}

.sidebar {
    width: 260px;
    height: 100vh;
    background: #2c3e50;
    color: white;
    padding: 25px 20px;
    position: fixed;
    top: 0;
    left: 0;
}

.sidebar h3 {
    color: white;
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    font-size: 17px;
    padding: 10px 12px;
    border-radius: 6px;
    margin-bottom: 10px;
    transition: 0.2s;
}

/* hover */
.sidebar a:hover {
    background: #1abc9c;
}

/* đang chọn */
.sidebar a.active {
    background: #16a085;
}

/* CONTENT */
.content {
    margin-left: 260px;
    padding: 30px;
}

</style>