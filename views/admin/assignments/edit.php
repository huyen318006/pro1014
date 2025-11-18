<h2>Sửa phân công</h2>

<form method="POST" action="?act=updateAssignment">
    <input type="hidden" name="id" value="<?= $assign['id'] ?>">

    <label>Hướng dẫn viên:</label>
    <select name="guide_id" required>
        <?php foreach ($guides as $g): ?>
            <option value="<?= $g['id'] ?>" <?= $g['id'] == $assign['guide_id'] ? 'selected' : '' ?>>
                <?= $g['fullname'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Tour:</label>
    <select name="departure_id" required>
        <?php foreach ($departures as $d): ?>
            <option value="<?= $d['id'] ?>" <?= $d['id'] == $assign['departure_id'] ? 'selected' : '' ?>>
                <?= $d['tour_id'] ?> - <?= $d['departure_date'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Thời gian phân công:</label>
    <input type="text" name="assigned_at" value="<?= $assign['assigned_at'] ?>" required><br><br>

    <button type="submit">Cập nhật</button>
</form>