<?php $active = "profile"; include "layout_guide.php"; ?>

<h3 class="mb-4">Thông Tin Tài Khoản</h3>

<div class="table-card p-4">

    <form>
        <label class="form-label">Họ tên</label>
        <input type="text" class="form-control mb-3">

        <label class="form-label">Email</label>
        <input type="email" class="form-control mb-3">

        <label class="form-label">Số điện thoại</label>
        <input type="text" class="form-control mb-3">

        <label class="form-label">Mật khẩu mới</label>
        <input type="password" class="form-control mb-4">

        <button class="btn btn-primary">Cập nhật</button>
    </form>

</div>

<?php include "layout_guide_end.php"; ?>
