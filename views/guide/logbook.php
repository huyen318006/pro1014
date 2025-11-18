<?php $active = "logbook"; include "layout_guide.php"; ?>

<h3 class="mb-4">Nhật Ký Tour</h3>

<div class="table-card p-4">
    <form>
        <label class="form-label">Ngày</label>
        <input type="date" class="form-control mb-3">

        <label class="form-label">Nội dung</label>
        <textarea class="form-control mb-3" rows="5"></textarea>

        <button class="btn btn-primary">Lưu nhật ký</button>
    </form>
</div>

<?php include "layout_guide_end.php"; ?>
