<div class="container mt-4">
    <h3>Thêm chính sách mới</h3>

    <form method="POST" action="index.php?controller=policy&action=store">

        <label>Tour</label>
        <select name="tour_id" class="form-control" required>
            <?php foreach ($tours as $t): ?>
                <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
            <?php endforeach ?>
        </select>

        <div class="mt-3">
            <label>Loại chính sách</label>
            <input type="text" name="policy_type" class="form-control" required>
        </div>

        <div class="mt-3">
            <label>Nội dung</label>
            <textarea name="content" class="form-control" rows="5" required></textarea>
        </div>

        <button class="btn btn-success mt-3">Lưu</button>
    </form>
</div>
