<div class="container mt-4">
    <h3>Cập nhật chính sách</h3>

    <form method="POST" action="index.php?controller=policy&action=update">

        <input type="hidden" name="id" value="<?= $policy['id'] ?>">

        <label>Tour</label>
        <select name="tour_id" class="form-control">
            <?php foreach ($tours as $t): ?>
                <option value="<?= $t['id'] ?>" 
                    <?= $t['id'] == $policy['tour_id'] ? 'selected' : '' ?>>
                    <?= $t['name'] ?>
                </option>
            <?php endforeach ?>
        </select>

        <div class="mt-3">
            <label>Loại chính sách</label>
            <input type="text" name="policy_type" class="form-control"
                   value="<?= $policy['policy_type'] ?>" required>
        </div>

        <div class="mt-3">
            <label>Nội dung</label>
            <textarea name="content" class="form-control" rows="5" required><?= $policy['content'] ?></textarea>
        </div>

        <button class="btn btn-primary mt-3">Cập nhật</button>
    </form>
</div>
