<?php $active = "incident"; include "layout_guide.php"; ?>

<h3 class="mb-4">Báo Cáo Sự Cố</h3>

<div class="table-card p-4">
    <form>
        <label class="form-label">Tên sự cố</label>
        <input type="text" class="form-control mb-3">

        <label class="form-label">Mô tả chi tiết</label>
        <textarea class="form-control mb-3" rows="5"></textarea>

        <label class="form-label">Mức độ</label>
        <select class="form-select mb-4">
            <option>Nhẹ</option>
            <option>Trung bình</option>
            <option>Nặng</option>
        </select>

        <button class="btn btn-danger">Gửi báo cáo</button>
    </form>
</div>

<?php include "layout_guide_end.php"; ?>
